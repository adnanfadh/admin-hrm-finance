<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'kode_supplier'     => 'required|string',
            'nama_supplier'     => 'required|string',
            'email_supplier'        => 'required|email',
            'alamat_supplier'       => 'required|string',
            'kontak_supplier'       => 'required|string',
        ];
    }
}
