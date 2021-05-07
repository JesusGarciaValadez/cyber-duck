<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirect = 'employee';

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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'required|exists:App\Models\Company,id',
            'email' => 'exclude_if:email,null|present|string|email',
            'phone' => 'exclude_if:phone,null|present|regex:/^([0-9\s\-\+\.\(\)]*)$/|min:10',
        ];
    }
}
