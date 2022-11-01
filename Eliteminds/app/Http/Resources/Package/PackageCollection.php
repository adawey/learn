<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\Resource;

class PackageCollection extends Resource
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
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description, 
            'details' => [
                'link' => route('APIpackage.show', $this->id)
            ],
            'buyer_link' => route('public.package.view', [$this->id]),
        ];
    }
}
