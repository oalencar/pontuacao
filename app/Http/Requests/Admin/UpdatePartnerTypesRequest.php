<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnerTypesRequest extends FormRequest
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

            'description' => 'min:3|required',
            'company_id' => 'required',
            'awards.*.title' => 'required',
            'awards.*.goal' => 'max:2147483647|required|numeric',
        ];
    }
}
