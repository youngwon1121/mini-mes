<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessStore extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
