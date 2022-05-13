<?php

namespace App\Http\Controllers;

use App\Http\Resources\ZipCodeResource;
use App\Models\ZipCode;

class ZipCodeController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZipCode  $zipCode
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ZipCode $zipCode)
    {
        return new ZipCodeResource($zipCode->load([
            'municipality',
            'settlements',
            'settlements.settlementType',
            'federalEntity',
        ]));
    }
}
