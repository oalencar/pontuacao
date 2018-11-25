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
            
            'description' => 'min:3|required|unique:partner_types,description,'.$this->route('partner_type'),
            'company_id' => 'required',
            'premiacaos.*.title' => 'required',
            'premiacaos.*.goal' => 'max:2147483647|required|numeric',
        ];
    }
}
