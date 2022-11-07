<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;


class BooksCollection extends ResourceCollection
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
                "id" => $item['id'],
                "name" => $item['name'],
                "isbn" => $item['isbn'],
                "authors" => explode(',',$item['authors']),
                "number_of_pages" =>  $item['number_of_pages'],
                "publisher" => $item['publisher'],
                "country" =>  $item['country'],
                "release_date" => Carbon::parse($item['release_date'])->format('Y-m-d')
            ];
        });



    }


}
