<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamanRequest extends FormRequest
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
            'pegawai_id'           => 'required|integer',
            'tanggal_pinjam'        => 'required|date',
            'jumlah_pinjam'         => 'required|integer',
            'angsuran'              => 'required|integer',
            'alasan'                => 'required|string',
        ];
    }
}
