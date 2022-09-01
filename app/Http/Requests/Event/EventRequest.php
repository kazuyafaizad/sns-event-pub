<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required | max:255',
            'content' => 'required',
            'visibility' => 'public',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'venue' => 'required',
            'type' => 'required',
            'image' => array_merge((new UploadImageRequest)->rules()['image'], ['sometimes', 'nullable']),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function messages()
    {
        return [
            'image' => 'Image must be of the following file type (jpeg,png,jpg)',
        ];
    }
}
