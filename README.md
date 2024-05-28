# 図書館蔵書検索サイト

## Outline
全国の図書館の蔵書を検索するサイトです。  
（授業課題として、参考に作ったサイトになります）

## Structure
* Docker

  | 技術 | コンテナ名 | サービス名 |
  |-------------|-------------------|------------|
  | PHP+Apache  | web | web |

* PHP
  * Laravel 11.8

* HTML
  * Bootstrap5.3

## Reference
* 図書館検索情報 カーリル  
[https://calil.jp/](https://calil.jp/)

* ISBN検索  国立国会図書館サーチ  
[https://ndlsearch.ndl.go.jp/](https://ndlsearch.ndl.go.jp/)

## 初期設定
~~~sh
## composerのインストール 
$ composer install
## Laravelのセットアップ
$ cp -rip .env.example .env
$ php artisan key:generate
~~~
### envファイルの修正
* DB設定を削除
* 下記環境を追加
  * SESSION_DRIVER=file
  * CALIL_APP_KEY= カーリルから発行されたAPIキーを指定
  * GOOGLE_APP_API= Google Map API（Map for javaScript）が使えるAPIキーを指定
