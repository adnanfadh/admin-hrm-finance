<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
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
            'kode_pegawai'           => 'required|string|max:16',
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat'        => 'required|string',
            'status'        => 'required|string',
            'tlp'           => 'required|string',
            'bidang_id'     => 'required|integer',
            'jabatan_id'     => 'required|integer',
            'shift_id'     => 'required|integer',
        ];
    }
}
