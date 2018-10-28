<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function __construct () {
        $this->sortable = ['order_column', 'createdAt', 'updatedAt'];
        $this->sortBy = 'order_column';
        $this->sortOrder = 'asc';
        $this->perPage = 10;
    }

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

    public function validatePagination () {
        return [
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ];
    }

    public function validateSorting () {
        return [
            'sortBy' => [Rule::In($this->sortable)],
            'sortOrder' => [Rule::In(['asc', 'desc']),],
        ];
    }

    public function validateBoth () {
        return array_merge($this->validatePagination(), $this->validateSorting());
    }
}
