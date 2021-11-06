@extends('layouts.user')

@section('title', "Profile")

@section('head.dependencies')
<style>
    .photo {
        width: 150px;
        height: 150px;
        border-radius: 900px;
        display: inline-block;
    }
</style>
@endsection

@php
    $photo = $myData->photo == null ? "images/default.png" : "storage/user_photos/".$myData->photo;
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="rata-tengah">
                <input type="file" class="box withPreview" name="photo" onchange="inputFile(this, '.photo')">
                <div class="photo uploadArea" bg-image="{{ asset($photo) }}"></div>

                <div class="mt-1 pointer" onclick="salin('{{ $myData->username }}')">
                    {{ "@".$myData->username }} <i class="fas fa-copy teks-kecil"></i>
                </div>
                <div class="bg-hijau-transparan rounded p-1 mt-1 teks-kecil d-none bagi" id="copyAlert">
                    Username berhasil disalin
                </div>
            </div>
            @if ($message != "")
                <div class="bg-hijau-transparan rounded p-2 mt-3">
                    {{ $message }}
                </div>
            @endif
            <div class="mt-2">Nama :</div>
            <input type="text" class="box" name="name" value="{{ $myData->name }}" required>
            <div class="mt-2">Email :</div>
            <input type="email" class="box" name="email" value="{{ $myData->email }}" required>
            <div class="mt-2">Telepon :</div>
            <input type="text" class="box" name="phone" value="{{ $myData->phone }}" required>
            
            <button class="lebar-100 mt-3 primer">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const salin = teks => {
        copyText(teks, () => {
            select("#copyAlert").classList.remove('d-none');
            setTimeout(() => {
                select("#copyAlert").classList.add('d-none');
            }, 1400);
        });
    }
</script>
@endsection