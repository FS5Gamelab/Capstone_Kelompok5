@extends('layouts.app-user', ['title' => 'Blog'])

@section('main-content')
<div class="card mb-3">
  <img src="" class="card-img-top" alt="gambar">
  <div class="card-body">
    <h5 class="card-title">Restoran sushi terbaik</h5>
    <p class="card-text">Restoran sushi kami, masuk kedalam kategori restoran sushi terbaik yang ada di tokyo</p>
    <button type="button" onclick="window.location.href='https://www.byfood.com/blog/tokyo/best-sushi-in-tokyo'">Selengkapnya</button>
  </div>
</div>

<div class="card mb-3">
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">masuk restoran 10 terbaik</h5>
      <p class="card-text">restoran kami juga pernah mendapatkan penghargaan sebagai salah satu restoran terbaik menurut data michelin guide tahun 2021</p>
      <button type="button" onclick="window.location.href='https://www.kompas.com/food/read/2021/12/26/194619575/10-restoran-masakan-indonesia-terbaik-di-dunia-menurut-michelin-guide'">Selengkapnya</button>
    </div>
  </div>

@endsection
