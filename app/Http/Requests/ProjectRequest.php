<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'client_id'     => 'required|integer',
            'title'     => 'required|string',
            'prioritas'     => 'required|string',
            'start_date'        => 'required|date',
            'end_date'      => 'required|date',
            'ringkasan_project'     => 'required|string',
            'pegawai_id'      => 'required|integer',
            'description'       => 'required|string',
            'status_project'        => 'required|integer'
        ];
    }
}
