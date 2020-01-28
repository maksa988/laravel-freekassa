<?php

namespace Maksa988\FreeKassa\Test;

use Illuminate\Http\Request;
use Maksa988\FreeKassa\Exceptions\InvalidPaidOrder;
use Maksa988\FreeKassa\Exceptions\InvalidSearchOrder;
use Maksa988\FreeKassa\Test\Fake\Order;

class FreeKassaTest extends TestCase
{
    /** @test */
    public function test_env()
    {
        $this->assertEquals('testing', $this->app['env']);
    }

    /**
     * Create test request with custom method and add signature.
     *
     * @param bool $signature
     * @return Request
     */
    protected function create_test_request($signature = false)
    {
        $params = [
            'MERCHANT_ID' => '12345',
            'AMOUNT' => '100',
            'intid' => '11',
            'MERCHANT_ORDER_ID' => '10',
        ];

        if ($signature === false) {
            $params['SIGN'] = $this->freekassa->getSignature($params['MERCHANT_ID'], $params['AMOUNT'], $this->app['config']->get('freekassa.secret_key_second'), $params['MERCHANT_ORDER_ID']);
        } else {
            $params['SIGN'] = $signature;
        }

        $request = new Request($params);

        return $request;
    }

    /** @test */
    public function check_if_allow_remote_ip()
    {
        $this->assertTrue(
            $this->freekassa->allowIP('127.0.0.1')
        );

        $this->assertFalse(
            $this->freekassa->allowIP('0.0.0.0')
        );
    }

    /** @test */
    public function compare_form_signature()
    {
        $this->assertEquals(
            'e9759d5cbc80ceb8716d06d7e2adc348',
            $this->freekassa->getFormSignature('12345', '100', 'secret_key', '10')
        );
    }

    /** @test */
    public function compare_signature()
    {
        $this->assertEquals(
            '7f590bc40563dc9ff96269e586ba6e65',
            $this->freekassa->getSignature('12345', '100', 'secret_key_second', '10')
        );
    }

    /** @test */
    public function generate_pay_url()
    {
        $url = $this->freekassa->getPayUrl(100, 10, 'example@gmail.com');

        $this->assertStringStartsWith($this->app['config']->get('freekassa.pay_url'), $url);
    }

    /** @test */
    public function compare_request_signature()
    {
        $params = [
            'MERCHANT_ID' => '12345',
            'AMOUNT' => '100',
            'MERCHANT_ORDER_ID' => '10',
        ];

        $this->assertEquals(
            '7f590bc40563dc9ff96269e586ba6e65',
            $this->freekassa->getSignature($params['MERCHANT_ID'], $params['AMOUNT'], $this->app['config']->get('freekassa.secret_key_second'), $params['MERCHANT_ORDER_ID'])
        );
    }

    /** @test */
    public function pay_order_form_validate_request()
    {
        $request = $this->create_test_request();
        $this->assertTrue($this->freekassa->validate($request));
    }

    /** @test */
    public function validate_signature()
    {
        $request = $this->create_test_request();
        $this->assertTrue($this->freekassa->validate($request));
        $this->assertTrue($this->freekassa->validateSignature($request));

        $request = $this->create_test_request('invalid_signature');
        $this->assertTrue($this->freekassa->validate($request));
        $this->assertFalse($this->freekassa->validateSignature($request));
    }

    /** @test */
    public function test_order_need_callbacks()
    {
        $request = $this->create_test_request();
        $this->expectException(InvalidSearchOrder::class);
        $this->freekassa->callSearchOrder($request);

        $request = $this->create_test_request();
        $this->expectException(InvalidPaidOrder::class);
        $this->freekassa->callPaidOrder($request, ['order_id' => '12345']);
    }

    /** @test */
    public function search_order_has_callbacks_fails()
    {
        $this->app['config']->set('freekassa.searchOrder', [Order::class, 'SearchOrderFilterFails']);
        $request = $this->create_test_request();
        $this->assertFalse($this->freekassa->callSearchOrder($request));
    }

    /** @test */
    public function paid_order_has_callbacks()
    {
        $this->app['config']->set('freekassa.searchOrder', [Order::class, 'SearchOrderFilterPaid']);
        $this->app['config']->set('freekassa.paidOrder', [Order::class, 'PaidOrderFilter']);
        $request = $this->create_test_request();
        $this->assertTrue($this->freekassa->callPaidOrder($request, ['order_id' => '12345']));
    }

    /** @test */
    public function paid_order_has_callbacks_fails()
    {
        $this->app['config']->set('freekassa.paidOrder', [Order::class, 'PaidOrderFilterFails']);
        $request = $this->create_test_request();
        $this->assertFalse($this->freekassa->callPaidOrder($request, ['order_id' => '12345']));
    }

    /** @test */
    public function payOrderFromGate_SearchOrderFilter_fails()
    {
        $this->app['config']->set('freekassa.searchOrder', [Order::class, 'SearchOrderFilterFails']);
        $request = $this->create_test_request('error');
        $request->server->set('REMOTE_ADDR', '127.0.0.1');
        $this->assertEquals($this->app['config']->get('freekassa.errors.validateOrderFromHandle'), $this->freekassa->handle($request));
    }

    /** @test */
    public function payOrderFromGate_method_pay_SearchOrderFilterPaid()
    {
        $this->app['config']->set('freekassa.searchOrder', [Order::class, 'SearchOrderFilterPaidforPayOrderFromGate']);
        $this->app['config']->set('freekassa.paidOrder', [Order::class, 'PaidOrderFilter']);
        $request = $this->create_test_request();

        $request->server->set('REMOTE_ADDR', '127.0.0.1');
        $this->assertEquals('YES', $this->freekassa->handle($request));
    }
}
