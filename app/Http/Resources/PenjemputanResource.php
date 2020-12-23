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
            'nama' => $this->user->name,
            'alamat' => $this->alamat,
            'telpon' => $this->telpon,
            'foto_penjemput' => $this->penjemput->foto,
            'telpon_penjemput' => $this->penjemput->telpon,
            'status' => $this->status,
            'user_id' => $this->user->id,
            'penjemput_id' => $this->penjemput_id,
            'tanggal' =>$this->created_at, 
            'updated_at' =>$this->updated_at, 
        ];


        // return parent::toArray($request);
    }
}
