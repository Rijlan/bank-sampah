<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CatatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'foto_sampah' => $this->jenisSampah->foto,
            'jenis_sampah' => $this->jenisSampah->jenis,
            'harga_sampah' => $this->total,
            'keterangan' => $this->keterangan,
            'berat' => $this->berat,
            'user_id' => $this->user_id,
            'created_at' =>$this->created_at, 
            'updated_at' =>$this->updated_at, 
        ];

    }
}
