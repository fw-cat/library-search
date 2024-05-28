<?php

namespace App\Services;

use App\Http\Requests\Search\ZipRequest;

/**
 * zip cloudを用いた郵便番号検索サービス
 */
class ZipcodeSearchService {

  private $base_url = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=';

  public function search(string $zip_code): bool | array
  {
    $json = file_get_contents($this->base_url . $zip_code);
    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $json = json_decode($json, true);
    if ($json['results'] === null) {
      return false;
    }
    $addrs = [];

    if (!empty($arr['message'])) {
      return false;
    }

    $addrs['prefecture'] = $json['results'][0]['address1'];
    $addrs['address1'] = $json['results'][0]['address2'];
    $addrs['address2'] = $json['results'][0]['address3'];

    return $addrs;
  }
}
