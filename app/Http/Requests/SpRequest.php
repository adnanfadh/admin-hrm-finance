<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpRequest extends FormRequest
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
            'no_surat'   => 'required|string',
            'pegawai_id'    => 'required|integer',
            'pelanggaran'   => 'required|string',
            'tanggal'       => 'required|date',
            'sangsi'   => 'required|string',
            'masa_berlaku'    => 'required|integer',
        ];
    }
}
