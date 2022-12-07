<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class BiayaRequest extends FormRequest
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
            'tanggal_transaksi'     => 'required|date',
            'no_biaya'              => 'required',
            'metode_pembayaran'     => 'required|string',
            'alamat_penagihan'      => 'required|string',
            'sub_total'             => 'required',
            'total_global'          => 'required',
            'grand_total'           => 'required',
            'sisa_tagihan'          => 'required',
        ];
    }
}
