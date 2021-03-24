<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data'                   => 'required|array',
            'data.type'              => 'required|in:reviews',
            'data.attributes'        => 'required|array',
            'data.attributes.review' => 'required|string',
        ];
    }
}
