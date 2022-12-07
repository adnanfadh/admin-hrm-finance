<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GajiRequest extends FormRequest
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
            'pegawai_id'        => 'required|integer',
            'tanggal_awal'         => 'required|date',
            'tanggal_akhir'        => 'required|date',
            // 'jumlah_gaji'       => 'required|integer',
            // 'jumlah_lembur'     => 'required|integer',
            // 'potongan_bpjs'     => 'required|integer',
            // 'total_gaji'        => 'required|integer',
        ];
    }
}
