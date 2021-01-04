<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenjemputanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'telpon' => $this->telpon,
            'status' => $this->status,
            'penjemput_id' => $this->penjemput_id,
            'nama_penjemput' => $this->penjemput->name,
            'alamat_penjemput' => $this->penjemput->alamat,
            'telpon_penjemput' => $this->penjemput->telpon,
            'foto_penjemput' => $this->penjemput->foto,
            'user_id' => $this->user->id,
            'tanggal' =>$this->created_at, 
            'updated_at' =>$this->updated_at, 
        ];


        // return parent::toArray($request);
    }
}
