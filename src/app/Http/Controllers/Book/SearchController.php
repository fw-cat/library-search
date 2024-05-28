<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\Search\ResultRequest;
use App\Services\BookSearchService;
use App\Services\CalilSearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(string $system_id, string $libkey, string $libname, Request $request)
    {
        return view($this->viewName("search"), [
            'params' => [
                'system_id' => $system_id,
                'libkey'    => $libkey,
                'libname'   => $libname,
            ],
        ]);
    }

    public function result(string $system_id, string $libkey, string $libname, ResultRequest $request, BookSearchService $service, CalilSearchService $calilService)
    {
        $request->session()->put([
            '_old_input' => [
                'isbn'      => $request->input('isbn'),
                'book_name' => $request->input('book_name'),
            ]
        ]);
        $books = $service->searchBooks($request);
        if ($books) {
            $books = $calilService->books($books, $system_id, $libkey);
        }

        return view($this->viewName("search"), [
            'search_word' => $libname,
            'books' => $books,
            'params' => [
                'system_id' => $system_id,
                'libkey'    => $libkey,
                'libname'   => $libname,
            ],
        ]);
    }
}
