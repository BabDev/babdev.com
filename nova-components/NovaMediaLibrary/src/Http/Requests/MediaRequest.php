<?php

namespace BabDev\NovaMediaLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collection' => 'required|string',
            'page' => 'nullable|numeric',
            'per_page' => 'nullable|numeric',
        ];
    }
}
