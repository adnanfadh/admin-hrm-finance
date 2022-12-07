<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SppdRequest extends FormRequest
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
            'no_surat'      => 'required|string',
            'pegawai_id'    => 'required|integer',
            'perihal'       => 'required|string',
            'tujuan'       => 'required|string',
            'kendaraan'       => 'required|string',
            'akomodasi'    => 'required|integer',
            'tanggal_tugas' => 'required|date',
            'tanggal_selesai'   => 'required|date',
            'tanggal_surat'   => 'required|date'
        ];
    }
}
