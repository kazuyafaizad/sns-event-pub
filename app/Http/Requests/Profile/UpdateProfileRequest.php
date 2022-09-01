<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $registrationRequest = new RegisterRequest();
        $rules = $registrationRequest->rules();

        return [
            'fullname' => ['required', 'string', 'max:255'],
            'address1' => ['string', 'max:255'],
            'address2' => ['string', 'max:255'],
            'postcode' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'state' => ['string', 'max:255'],
            'mobile_number' => ['required', 'digits:11'],
            'email' => [
                'string', 'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('id', '!=', Auth::user()->id);
                }),
            ],
        ];
    }
}
