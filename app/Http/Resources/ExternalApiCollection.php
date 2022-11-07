<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ExternalApiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                "name" => $item['name'],
                "isbn" => $item['isbn'],
                "authors" => $item['authors'],
                "number_of_pages" =>  $item['numberOfPages'],
                "publisher" =>  $item['publisher'],
                "country" =>  $item['country'],
                "release_date" => Carbon::parse($item['released'])->format('Y-m-d')
            ];
        });



    }
}
