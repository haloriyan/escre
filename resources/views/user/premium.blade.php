@extends('layouts.user')

@section('title', "Menjadi Premium")

@php
    $whatsappMessage = "Halo, saya ".$myData->name." ingin menjadi user premium di E-Secre.id, bagaimana caranya?";
    $whatsappMessage = urlencode($whatsappMessage);
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <p>
            Untuk menjadi premium, silahkan hubungi <a href="https://wa.me/6288228565311?text={{ $whatsappMessage }}" target="_blank">Admin Ailsa melalui Whatsapp</a>
        </p>
    </div>
</div>
@endsection