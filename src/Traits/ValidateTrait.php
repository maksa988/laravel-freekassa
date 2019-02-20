<?php

namespace Maksa988\FreeKassa\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidateTrait
{
    /**
     * @param Request $request
     * @return bool
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MERCHANT_ID' => 'required',
            'AMOUNT' => 'required',
            'intid' => 'required',
            'MERCHANT_ORDER_ID' => 'required',
            'SIGN' => 'required',
        ]);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateSignature(Request $request)
    {
        $sign = $this->getSignature(config('freekassa.project_id'), $request->input('AMOUNT'), config('freekassa.secret_key_second'), $request->input('MERCHANT_ORDER_ID'));

        if ($request->input('SIGN') != $sign) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateOrderFromHandle(Request $request)
    {
        return $this->AllowIP($request->ip())
                    && $this->validate($request)
                    && $this->validateSignature($request);
    }
}
