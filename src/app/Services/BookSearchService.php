<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\Book\Search\ResultRequest;

/**
 * 書籍検索サービス
 */
class BookSearchService {

  private $base_url = 'https://ndlsearch.ndl.go.jp';

  public function searchBooks(ResultRequest $request): array|bool
  {
    $books = [];
    // ISBNコード
    $isbn = $request->input('isbn');
    if (!empty($isbn)) {
      // TODO: ISBNから書籍情報を取得
      $isbns[] = $isbn;
    }

    // 書籍名
    $book_name = $request->input('book_name');
    if (!empty($book_name)) {
      // 検索URLを生成
      $searchUrl = "{$this->base_url}/api/opensearch?title={$book_name}&cnt=20";
      $response = Http::get($searchUrl);
      if (!$response->successful()) {
        return false;
      }
      $xml = simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);
      foreach($xml->channel->item as $item) {
        $book = [
          'title' => $item->title,
          'author' => $item->author,
          'published' => $item->pubDate,
        ];
        foreach($item->children('http://purl.org/dc/elements/1.1/')->identifier as $identifier) {
          $attrs = $identifier->attributes('xsi', true);
          foreach($attrs as $key => $attr) {
            if ($attr->__toString() === "dcndl:ISBN") {
              $book['isbn'] = $identifier->__toString();
            }
            if ($attr->__toString() === "dcndl:ISBN13") {
              $book['isbn'] = $identifier->__toString();
            }
          }
        }
        $books[] = $book;
      }
    }

    return $books;
  }

  public function image(string $isbn): array
  {
    $imageUrl = "{$this->base_url}/thumbnail/{$isbn}.jpg";
    $response = Http::get($imageUrl);
    if ($response->successful()) {
      return [
        'content' => $response->body(),
        'type' => $response->header('Content-Type'),
      ];
    }

    $imagePath = storage_path('app/public/noimage.png');
    if (!file_exists($imagePath)) {
        abort(404, 'No image found and no fallback image available.');
    }
    $imageContent = file_get_contents($imagePath);
    $contentType = 'image/png';
    return [
      'content' => $imageContent,
      'type' => $contentType,
    ];
  }
}
