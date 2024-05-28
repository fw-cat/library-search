@extends('layouts.base')

@section('page-title')
図書館の検索
@endsection

@section('page-content')
<div class="row justify-content-center">
  <div class="col-6">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="true">住所検索</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map" type="button" role="tab" aria-controls="map" aria-selected="false">現在位置から</a>
      </li>
    </ul>
    <div class="tab-content p-3 border border-top-0 rounded-bottom">
      <div class="tab-pane active" id="address" role="tabpanel" aria-labelledby="address-tab" tabindex="0">
        <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ route('search.zip') }}">
          <div class="col-12">
            <div class="input-group">
              <span class="input-group-text" id="zip-mark">〒</span>
              <input type="text" class="form-control" name="zip_code" placeholder="郵便番号を入力してください" aria-label="zip_code" aria-describedby="basic-addon1" value="{{ old('zip_code') }}">
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">検索</button>
          </div>
        </form>
      </div>
      <div class="tab-pane" id="map" role="tabpanel" aria-labelledby="map-tab" tabindex="0">
        <button type="button" class="btn btn-info" id="get-point">現在位置を取得</button>
        <div id="map-view" class="mt-2 w-100" style="height: 50vh;"></div>
      </div>
    </div>
  </div>
  <div class="m-3 w-100"></div>
  @if(!empty($search_word))
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">検索結果</h5>
        <p>{{ $search_word }}の付近を検索</p>
      </div>
      @if(!empty($libraies))
      <div class="list-group list-group-flush">
        @foreach($libraies as $library)
        <a href="{{ route('search.book', ['system_id' => $library['systemid'], 'libkey' => $library['libkey'], 'libname' => $library['formal']]) }}" class="list-group-item">
          {{ $library['formal'] }}
        </a>
        @endforeach
      </div>
      @else
      <div class="card-body">
        <div class="alert alert-warning" role="alert">
          付近に図書館はありませんでした。
        </div>
      </div>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection

@section('inline-script')
<script async src="https://maps.googleapis.com/maps/api/js?key={{ config('google.app_key') }}&libraries=marker"></script>
<script>
  var marker = [], infoWindow = [];

  markerEvent = (i) => {
    marker[i].addListener('click', () => { // マーカーをクリックしたとき
      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
    });
  }
  $("#get-point").click(() => {
    navigator.geolocation.getCurrentPosition((position) => {
      console.log(position)
      $.ajax({
        url: "{{ route('api.geolocation.get') }}",
        type: "GET",
        data: {
          'lat': position.coords.latitude,
          'lon': position.coords.longitude,
        }
      }).done((data) => {
        console.log(data, position)
        const myLatLng = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        const map = new google.maps.Map(document.getElementById("map-view"), {
          zoom: 15,
          center: myLatLng,
          disableDefaultUI: true,
          zoomControl: false,
          scaleControl: false,
        });
        new google.maps.Marker({
          position: myLatLng,
          map,
          title: "検索マップ",
        });
        // マーカー毎の処理
        for (var i = 0; i < data.libraies.length; i++) {
          var library = data.libraies[i]
          var geocodes = library['geocode'].split(",")

          markerLatLng = new google.maps.LatLng({
            lng: parseFloat(geocodes[0]),
            lat: parseFloat(geocodes[1]),
          }); // 緯度経度のデータ作成
          marker[i] = new google.maps.Marker({ // マーカーの追加
            position: markerLatLng,
            map: map,
            icon: "https://developers.google.com/maps/documentation/javascript/examples/full/images/library_maps.png",
          });
          infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
            content: `
<div class="box">
  <p>施設名：<strong>${library['formal']}</strong></p>
  <a href="/system/${library['systemid']}/libary/${library['libkey']}/${library['formal']}/book">ここを選択</a>
</div>`
          });

          markerEvent(i);
        }
      });
    })
  })
</script>
@endsection