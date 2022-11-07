<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BooksCollection;
use App\Models\Book;
use App\Traits\ResponseData;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    use ResponseData;


    // Get All Books / Search Book
    public function index()
    {
        $search = ['name','country','publisher','released'];

        try
        {
            $book = Book::allBooks($search);

            $bookData = new BooksCollection($book);

            if($book->isNotEmpty())
            {
                return $this->sendResponse(Response::HTTP_OK,'success',$bookData);
            }

            return $this->sendResponse(Response::HTTP_NOT_FOUND,'404 not found',$bookData);
        }
        catch(\Exception)
        {
            return $this->sendResponse(Response::HTTP_INTERNAL_SERVER_ERROR,'Server Error');
        }

    }


    // Get A Book by ID
    public function getById($id)
    {

       try {
            $book = Book::findorfail($id);

            $bookData = $this->resourceWithId($book, new BookResource($book));

            return $this->sendResponse(Response::HTTP_OK,'success',$bookData);

        } catch (ModelNotFoundException $e) {

            return $this->sendResponse(Response::HTTP_NOT_FOUND,'404 not found');
        }
    }


    // Create Book
    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
               return $this->sendResponse(Response::HTTP_UNPROCESSABLE_ENTITY,'Validation Error',$validator->errors());
            }

            $book = Book::create($request->all());
            $bookData = new BookResource($book);

            return $this->sendResponse(Response::HTTP_CREATED,'success',['book' => $bookData]);
        }
        catch(\Exception)
        {
            return $this->sendResponse(Response::HTTP_INTERNAL_SERVER_ERROR,'Server Error');
        }


    }


    // Update Book
    public function update(Request $request,$id)
    {
        try {
            $book = Book::findorfail($id);
            $book->update($request->except('_method'));
            $bookData = $this->resourceWithId($book, new BookResource($book));
            return $this->sendResponse(Response::HTTP_CREATED,'The book '."'" .$book->name. "'".' was updated successfully',$bookData);
        } catch (ModelNotFoundException $e) {

            return $this->sendResponse(Response::HTTP_NOT_FOUND,'404 not found');
        }
    }


    // Delete Book
    public function destroy($id)
    {

       try {
            $book = Book::findorfail($id);
            $book->delete();
            return $this->sendDeleteResponse(Response::HTTP_NO_CONTENT,'success','The book '."'" .$book->name. "'".' was deleted successfully');
        } catch (ModelNotFoundException $e) {

            return $this->sendResponse(Response::HTTP_NOT_FOUND,'404 not found');
        }
    }


    // Validate Input Fields
    protected function rules()
    {
        return [
                "name" => 'required',
                "isbn" => 'required',
                "authors" => 'required',
                "number_of_pages" =>  'required',
                "publisher" => 'required',
                "country" =>  'required',
                "release_date" => 'required',
        ];
    }


    protected function resourceWithId($bookModel,$bookResource)
    {
        $bookDataArr = json_decode(json_encode($bookResource), true);
        return array_merge(['id' => $bookModel->id,...$bookDataArr]);
    }


}
