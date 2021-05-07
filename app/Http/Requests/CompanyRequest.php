<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirect = 'company';

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
            'name' => 'required|string',
            'email' => 'exclude_if:email,null|present|string|email',
            'logo' => 'exclude_if:logo,null|present|image|dimensions:min_width=100,min_height=100',
            'website' => 'exclude_if:website,null|present|string|url',
        ];
    }
}
