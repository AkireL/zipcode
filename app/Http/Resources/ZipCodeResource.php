<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ZipCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'zip_code' => $this->zip_code,
            'locality' => Str::upper($this->locality),
            'federal_entity' => new FederalEntityResource($this->federalEntity),
            'settlements' => SettlementResource::collection($this->settlements),
            'municipality' => new MunicipalityResource($this->municipality),
        ];
    }
}
