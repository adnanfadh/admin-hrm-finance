<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LemburRequest extends FormRequest
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
            'pegawai_id'        => 'integer',
            'tanggal'          => 'required|date',
            'jam_masuk_lembur'          => 'required',
            'jam_keluar_lembur'          => 'required',
            'pekerjaan'          => 'required|string',
            'uraian_pekerjaan'          => 'required|string',
            'status_lembur'          => 'integer'
        ];
    }
}
