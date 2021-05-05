<?php

namespace App\Http\Requests\Api;

class ResourceStorageRequest extends FormRequest
{
    public function rules(): array
    {

        switch (request()->route()->getActionMethod()) {
            case 'coverSign':
                return [
                    'path'     => 'required|string',
                ];
            default:
                return [];
        }
    }

    public function attributes(): array
    {
        return [
            'path'         => '存储路径',
        ];
    }
}
