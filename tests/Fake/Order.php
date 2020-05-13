<?php

namespace Maksa988\FreeKassa\Test\Fake;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        '_orderSum',
        '_orderCurrency',
        '_orderStatus',
    ];

    /**
     * Order constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return bool
     */
    public static function SearchOrderFilterFails(Request $request, $order_id)
    {
        return false;
    }

    /**
     * @param Request $request
     * @param $order_id
     * @param string $orderStatus
     * @param string $orderSum
     * @param string $orderCurrency
     * @return Order
     */
    public static function SearchOrderFilterPaidforPayOrderFromGate(Request $request, $order_id, $orderStatus = 'paid', $orderSum = '1', $orderCurrency = '1')
    {
        $order = new self([
            '_orderSum' =>  $orderSum,
            '_orderCurrency' => $orderCurrency,
            '_orderStatus' => $orderStatus,
        ]);

        return $order;
    }

    /**
     * @param Request $request
     * @param $order_id
     * @param string $orderStatus
     * @param string $orderSum
     * @param string $orderCurrency
     * @return Order
     */
    public static function SearchOrderFilterPaid(Request $request, $order_id, $orderStatus = 'paid', $orderSum = '12345', $orderCurrency = 'RUB')
    {
        $order = new self([
            '_orderSum' =>  $orderSum,
            '_orderCurrency' => $orderCurrency,
            '_orderStatus' => $orderStatus,
        ]);

        return $order;
    }

    /**
     * @param Request $request
     * @param $order_id
     * @param string $orderStatus
     * @param string $orderSum
     * @param string $orderCurrency
     * @return Order
     */
    public static function SearchOrderFilterNotPaid(Request $request, $order_id, $orderStatus = 'no_paid', $orderSum = '', $orderCurrency = 'RUB')
    {
        $order = new self([
            '_orderSum' =>  $orderSum,
            '_orderCurrency' => $orderCurrency,
            '_orderStatus' => $orderStatus,
        ]);

        return $order;
    }

    /**
     * @param Request $request
     * @param $order
     * @return bool
     */
    public static function PaidOrderFilterFails(Request $request, $order)
    {
        return false;
    }

    /**
     * @param Request $request
     * @param $order
     * @return bool
     */
    public static function PaidOrderFilter(Request $request, $order)
    {
        return true;
    }
}
