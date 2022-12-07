<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BpjsRequest extends FormRequest
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
            'kode_bpjs'     => 'required|string',
            'pegawai_id'    => 'required|integer|unique:bpjs',
            'jumlah_iuran'  => 'required|integer'
        ];
    }
}
