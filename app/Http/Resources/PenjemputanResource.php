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
            'alamat' => $this->alamat,
            'telpon' => $this->telpon,
            'nama' => $this->user->name,
            'penjemput' => $this->penjemput->name,
            'created_at' =>$this->created_at, 
            'updated_at' =>$this->updated_at, 
        ];


        // return parent::toArray($request);
    }
}
