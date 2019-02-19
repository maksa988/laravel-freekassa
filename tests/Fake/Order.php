<?php

namespace Maksa988\FreeKassa\Test\Fake;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        '_orderSum',
        '_orderCurrency',
        '_orderStatus',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function SearchOrderFilterFails(Request $request, $order_id)
    {
        return false;
    }

    public static function SearchOrderFilterPaidforPayOrderFromGate(Request $request, $order_id, $orderStatus = 'paid', $orderSum = '1', $orderCurrency = '1')
    {
        $order = new self([
            '_orderSum' =>  $orderSum,
            '_orderCurrency' => $orderCurrency,
            '_orderStatus' => $orderStatus,
        ]);

        return $order;
    }

    public static function SearchOrderFilterPaid(Request $request, $order_id, $orderStatus = 'paid', $orderSum = '12345', $orderCurrency = 'RUB')
    {
        $order = new self([
            '_orderSum' =>  $orderSum,
            '_orderCurrency' => $orderCurrency,
            '_orderStatus' => $orderStatus,
        ]);

        return $order;
    }

    public static function SearchOrderFilterNotPaid(Request $request, $order_id, $orderStatus = 'no_paid', $orderSum = '', $orderCurrency = 'RUB')
    {
        $order = new self([
            '_orderSum' =>  $orderSum,
            '_orderCurrency' => $orderCurrency,
            '_orderStatus' => $orderStatus,
        ]);

        return $order;
    }

    public static function PaidOrderFilterFails(Request $request, $order)
    {
        return false;
    }

    public static function PaidOrderFilter(Request $request, $order)
    {
        return true;
    }

    /**
     * Get the relationships for the entity.
     *
     * @return array
     */
    public function getQueueableRelations()
    {
        // TODO: Implement getQueueableRelations() method.
    }

    /**
     * Get the connection of the entity.
     *
     * @return string|null
     */
    public function getQueueableConnection()
    {
        // TODO: Implement getQueueableConnection() method.
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        // TODO: Implement resolveRouteBinding() method.
    }
}