<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProcessStore;

class ProcessController extends Controller
{
    public function store(ProcessStore $request) {
        $response = [
            'result' => 'SUCCESS',
            'data' => [
                'name' => $request->name
            ]
        ];

        return $response;
    }
}
