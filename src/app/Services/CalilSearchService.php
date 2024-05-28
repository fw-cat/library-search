<?php

namespace App\Services;

/**
 * Calilを用いた検索サービス
 */
class CalilSearchService {

  private $base_url = 'https://api.calil.jp';
  private $appKey = "";

  public function __construct() {
    $this->appKey = config("calil.app_key");
  }

  public function address(array $addrs): bool | array
  {
    $city = $this->removeCityAfter($addrs['address1']);
    $targetUrl = "{$this->base_url}/library?appKey={$this->appKey}&pref={$addrs['prefecture']}&city={$city}&format=json&callback=";
    $responce = file_get_contents($targetUrl);
    $responce = json_decode($responce, true);
    return $responce;
  }

  public function geolocation(string $geolocation)
  {
    $targetUrl = "{$this->base_url}/library?appKey={$this->appKey}&geocode={$geolocation}&format=json&callback=";
    $responce = file_get_contents($targetUrl);
    $responce = json_decode($responce, true);
    return $responce;
  }

  public function books(array $books, string $system_id, string $libkey): bool | array
  {
    $isbn = [];
    foreach ($books as $book) {
      // ISBNコードがある数だけ
      if (!empty($book['isbn'])) {
        $isbn[] = $book['isbn'];
      }
    }
    $isbn = implode(',', $isbn);

    $targetUrl = "{$this->base_url}/check?appKey={$this->appKey}&isbn={$isbn}&systemid={$system_id}&format=json&callback=no";
    $polling = 0;
    // ポーリングのチェック
    do {
      $responce = file_get_contents($targetUrl);
      $responce = json_decode($responce, true);
      $polling = intval($responce['continue']);
    } while($polling);

    foreach ($responce['books'] as $isbn => $book) {
      $index = array_search($isbn, $books);
      if (empty($book[$system_id])) {
        $books[$index]["status"] = "不明";
      } else {
        $books[$index]["status"] = "不明2";
      }
    }
    return $books;
  }

  private function removeCityAfter(string $city): string
  {
    $position = mb_strpos($city, '市');
    if ($position !== false) {
        return mb_substr($city, 0, $position + 1);
    }
    return $city;
  }
}
