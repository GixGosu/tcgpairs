<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function errors ($v, $code = 400) {
        return response()
            ->json([
                'success' => false,
                'errors' => $v->errors()->all(),
                'data' => [],
            ])
            ->setStatusCode($code);
    }

    public function customErrors($message, $code = 409) {
        return response()
            ->json([
                'success' => false,
                'errors' => array_merge([],$message),
                'data' => [],
            ])
            ->setStatusCode($code);
    }
}
