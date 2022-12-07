<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class AccountBankRequest extends FormRequest
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
            'nama'  => 'required|string',
            'nomor' => 'required|string',
            'category'  => 'required|string',
            'details'   => 'required|string',
            'pajak_id' => 'required|integer',
            'deskripsi' => 'required|string',
        ];
    }
}
