<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class TerimaUangRequest extends FormRequest
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
            'account_setor'         => 'required',
            'pengirim'                  => 'required',
            'tanggal_transaksi'         => 'required|date',
            'akun_pengirim'         => 'required',
            'deskripsi'            => 'required',
            'jumlah'            => 'required',
        ];
    }
}
