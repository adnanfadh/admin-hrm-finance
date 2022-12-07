<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'nama_product'      => 'required|string',
            'gambar'        => 'image',
            'qty'       => 'required|integer',
            'satuan'        => 'required|string',
            'harga_satuan'      => 'required|integer',
            'category'      => 'required|integer',
        ];
    }
}
