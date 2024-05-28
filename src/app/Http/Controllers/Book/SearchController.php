<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\Search\ResultRequest;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(string $system_id, string $libkey, Request $request)
    {
        return view($this->viewName("search"), [
            'params' => [
                'system_id' => $system_id,
                'libkey'    => $libkey,
            ],
        ]);
    }

    public function result(string $system_id, string $libkey, ResultRequest $request)
    {
        $request->session()->put([
            '_old_input' => [
                'isbn'      => $request->input('isbn'),
                'book_name' => $request->input('book_name'),
            ]
        ]);

        return view($this->viewName("search"), [
            'search_word' => "aaa",
            'books' => [],
            'params' => [
                'system_id' => $system_id,
                'libkey'    => $libkey,
            ],
        ]);
    }
}
