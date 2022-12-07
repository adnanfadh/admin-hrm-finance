<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_company'                  => 'required|unique:company',
            'nama_company'                  => 'required',
            'email_company'                 => 'required',
            'npwp_company'                  => 'required',
            'telpon_company'                => 'required',
            'alamat_company'                => 'required',
            'logo_company'                  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_company.reuired' => 'Kode company tidak boleh kosong',
            'kode_company.reuired' => 'kode company sudah ada',
            'nama_company.reuired' => 'nama company tidak boleh kosong',
            'email_company.reuired' => 'email company tidak boleh kosong',
            'npwp_company.reuired' => 'npwp company tidak boleh kosong',
            'telpon_company.reuired' => 'telpon company tidak boleh kosong',
            'alamat_company.reuired' => 'alamat company tidak boleh kosong',
            'logo_company.reuired' => 'logo company tidak boleh kosong',
        ];
    }
}
