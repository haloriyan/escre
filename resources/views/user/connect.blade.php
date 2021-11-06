@extends('layouts.user')

@section('title', "Connect")

@php
    $relations = explode(".", $relation);
    function displayRelation($relation) {
        return config('dictionary')[$relation];
    }
@endphp

@section('head.dependencies')
<style>
    .photo {
        display: inline-block;
        width: 130px;
        height: 130px;
    }
</style>
@endsection

@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <form>
            <div class="mt-2">Cari {{ displayRelation($relations[0]) }} :</div>
            <input type="text" class="box" name="username" value="{{ $request->username }}" placeholder="masukkan username dan tekan enter untuk mencari...">
        </form>
    </div>
</div>

<div class="bg-putih rounded bayangan-5 smallPadding mt-5">
    <div class="wrap">
    @if ($request->username == "")
        <h2>Koneksi Saya</h2>
        @if ($user->{$relation}) == 0)
            <p>Tidak ada data</p>
        @else
            @foreach ($user->{$relations[0]} as $item)
                @php
                    $search = $item->{$relations[1]};
                    $photo = $search->photo == null ? "images/default.png" : "storage/user_photos/".$search->photo;
                @endphp
                <div class="bagi bagi-2 desktop connection-item rata-tengah bordered rounded">
                    <div class="wrap super">
                        <div class="photo rounded-circle" bg-image="{{ asset($photo) }}"></div>
                        <h3>{{ $search->name }}</h3>
                        <div class="mt-1"><i class="fas fa-phone-alt mr-1"></i> {{ $search->phone }}</div>
                        <div class="mt-1"><i class="fas fa-envelope mr-1"></i> {{ $search->email }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    @else
        <h2>Mencari {{ displayRelation($relations[0]) }} "{{$request->username }}"</h2>
        @if ($errors->count() != 0)
            @foreach ($errors->all() as $err)
                <div class="bg-merah-transparan rounded p-2 mb-3">
                    {{ $err }}
                </div>
            @endforeach
        @endif
        @if ($search == "" || $search->count() == 0)
            <p>Tidak ada data</p>
        @else
            <div class="rata-tengah mt-5">
                @php
                    $photo = $search->photo == null ? "images/default.png" : "storage/user_photos/".$search->photo;
                    $whosAdding = $relation == "headships" ? "assistant" : "headship";
                @endphp
                <div class="photo rounded-circle" bg-image="{{ asset($photo) }}"></div>
                <h3 class="teks-besar mb-0">{{ $search->name }}</h3>
                <p>{{ $search->email }}</p>

                <form action="{{ route('user.connect.add') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="userID" value="{{ $search->id }}">
                    <input type="hidden" name="whosAdding" value="{{ $whosAdding }}">
                    <button class="primer">
                        <i class="fas fa-plus mr-2 teks-kecil"></i> Tambahkan
                    </button>
                </form>
            </div>
        @endif
    @endif
</div>
@endsection