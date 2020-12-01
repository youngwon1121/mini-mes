<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessSetFlow extends FormRequest
{
    public function rules()
    {
        return [
            'next' => [
                'bail',
                'required',
                'array',
                function ($attribute, $value, $fail)
                {
                    if (in_array(request()->process->id, $value)) {
                        $fail("can't set itself to next");
                    }
                }
            ]
        ];
    }
}
