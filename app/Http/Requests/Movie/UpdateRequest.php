<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'data'                            => 'required|array',
            'data.id'                         => 'required|string',
            'data.type'                       => 'required|in:movies',
            'data.attributes'                 => 'required|array',
            'data.attributes.title'           => 'required|string|max:255',
            'data.attributes.storyline'       => 'required|string|max:550',
            'data.attributes.genre'           => 'required|string|max:255',
            'data.attributes.release_year'    => 'required|integer',
            'data.attributes.runtime'         => 'required|integer',
        ];
    }
}
