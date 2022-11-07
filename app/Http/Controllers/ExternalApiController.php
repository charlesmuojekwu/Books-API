<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BooksCollection;
use App\Http\Resources\ExternalApiCollection;
use App\Traits\ResponseData;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ExternalApiController extends Controller
{
    use ResponseData;

    public function searchByName()
    {
        try
        {
            if(request()->has('name'))
            {
                $requestUrl = 'https://www.anapioficeandfire.com/api/books';
                $requestParams = '?name='.request('name');


                $response = Http::get($requestUrl.$requestParams)->collect();

                if($response->isNotEmpty())
                {
                    $bookResponse = new ExternalApiCollection($response->all());
                    return $this->sendResponse(Response::HTTP_OK,'success',$bookResponse);
                }

                return response()->json([
                    'status_code' => Response::HTTP_NOT_FOUND,
                    'status' => 'not found',
                    'data' => [],
                ],Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ],Response::HTTP_UNPROCESSABLE_ENTITY);

        }
        catch(\Exception $e)
        {

            return response()->json([
                'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
