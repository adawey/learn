<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\Resource;

class UserPackageCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'package_id'=> $this->package_id,
            'details' => [
                'link' => route('APIpackage.show', $this->package_id)
            ]
        ];
    }
}
