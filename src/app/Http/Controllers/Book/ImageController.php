<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\BookSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function image(string $isbn, BookSearchService $service)
    {
        $image = $service->image($isbn);
        return response($image['content'], 200)->header('Content-Type', $image['type']);
    }
}
