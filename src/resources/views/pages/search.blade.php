@extends('layouts.base')

@section('page-title')
蔵書の検索
@endsection

@section('page-content')
<div class="row justify-content-center">
  <div class="col-6">
    <div class="card">
      <div class="card-header">
        蔵書の検索フォーム
      </div>
      <div class="card-body">
        <form class="form" method="post" action="{{ route('search.book.result', $params) }}">
          @csrf
          <div class="row mb-3">
            <label for="isbn" class="col-3 col-form-label">ISBNコード</label>
            <div class="col-9">
              <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn') }}">
            </div>
          </div>

          <div class="row mb-3">
            <label for="book_name" class="col-3 col-form-label">書籍名</label>
            <div class="col-9">
              <input type="text" class="form-control" id="book_name" name="book_name" value="{{ old('book_name') }}">
            </div>
          </div>

          <div class="row justify-content-center mb-3">
            <div class="col-6">
              <button type="submit" class="btn btn-info w-100"><i class="fa-solid fa-magnifying-glass"></i>検索</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="m-3 w-100"></div>
  @if(!empty($search_word))
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">蔵書の検索結果</h5>
        <p><strong>{{ $search_word }}</strong>の蔵書を検索</p>
      </div>
      @if(!empty($books))
      <div class="row gy-5">
        @foreach($books as $book)
          <div class="col-6">
            <div class="card">
              <img src="{{ route('book.image', ['isbn' => $book['isbn'] ?? 'noimage']) }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $book['title'] }}</h5>
                <p class="card-text">著者：{{ $book['author'] }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      @else
      <div class="card-body">
        <div class="alert alert-warning" role="alert">
          <i class="fa-regular fa-face-sad-tear"></i>
          対象の図書館に蔵書はありませんでした。
        </div>
      </div>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection