<?php

return [

    /*
     * Project`s id
     */
    'project_id' => env('FREEKASSA_PROJECT_ID', ''),

    /*
     * First project`s secret key
     */
    'secret_key' => env('FREEKASSA_SECRET_KEY', ''),

    /*
     * Second project`s secret key
     */
    'secret_key_second' => env('FREEKASSA_SECRET_KEY_SECOND', ''),

    /*
     * Locale for payment form
     */
    'locale' => 'ru',  // ru || en

    /*
     * Allowed currenc'ies https://www.free-kassa.ru/docs/api.php#ex_currencies
     *
     * If currency = null, that parameter doesn`t be setted
     */
    'currency' => null,

    /*
     * Allowed ip's https://www.free-kassa.ru/docs/api.php#step3
     */
    'allowed_ips' => [
        '136.243.38.147',
        '136.243.38.149',
        '136.243.38.150',
        '136.243.38.151',
        '136.243.38.189',
        '88.198.88.98',
        '136.243.38.108',
    ],

    /*
     *  SearchOrder
     *  Search order in the database and return order details
     *  Must return array with:
     *
     *  _orderStatus
     *  _orderSum
     */
    'searchOrder' => null, //  'App\Http\Controllers\FreeKassaController@searchOrder',

    /*
     *  PaidOrder
     *  If current _orderStatus from DB != paid then call PaidOrderFilter
     *  update order into DB & other actions
     */
    'paidOrder' => null, //  'App\Http\Controllers\FreeKassaController@paidOrder',

    /*
     * Customize error messages
     */
    'errors' => [
        'validateOrderFromHandle' => 'Validate Order Error',
        'searchOrder' => 'Search Order Error',
        'paidOrder' => 'Paid Order Error',
    ],

    /*
     * Url to init payment on FreeKassa
     * https://www.free-kassa.ru/docs/api.php#step2
     */
    'pay_url' => 'http://www.free-kassa.ru/merchant/cash.php',
];
