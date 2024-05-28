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
    @if (!empty($books))
    @else
    <div class="alert alert-warning" role="alert">
      <i class="fa-regular fa-face-sad-tear"></i>書籍がヒットしませんでした
    </div>
    @endif
  </div>
  @endif
</div>
@endsection