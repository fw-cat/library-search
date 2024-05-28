<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\Book\Search\ResultRequest;

/**
 * 書籍検索サービス
 */
class BookSearchService {

  private $base_url = 'https://ndlsearch.ndl.go.jp';

  public function search2isbn(ResultRequest $request): array|bool
  {
    return false;
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
