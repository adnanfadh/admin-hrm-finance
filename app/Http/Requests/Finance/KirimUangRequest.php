<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class KirimUangRequest extends FormRequest
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
            'account_pembayar'         => 'required',
            'penerima'                  => 'required',
            'tanggal_transaksi'         => 'required|date',
            'akun_tujuan'         => 'required',
            'deskripsi'            => 'required',
            'jumlah'            => 'required',
        ];
    }
}
