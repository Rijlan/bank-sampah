<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestsPenjualan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_pengepul' => ['required', 'string'],
            'alamat' => ['required'],
            'telpon' => ['required'],
            'jenis_sampah_id' => ['required'],
            'berat' => ['required'],
        ];
    }
}
