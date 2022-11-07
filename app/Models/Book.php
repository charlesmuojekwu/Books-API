<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "name" ,
        "isbn" ,
        "authors" ,
        "number_of_pages" ,
        "publisher"  ,
        "country" ,
        "release_date"
    ];

    protected $hidden = ['updated_at','created_at'];

    protected $casts = ['number_of_pages' => 'int'];

    public static function allBooks($searchArray)
    {
        $query = Book::query();

        foreach($searchArray as $search){
            if(request()->has($search))
            {
                $query->where($search, request()->input($search));

            }
        }

        return $query->get();
    }
}
