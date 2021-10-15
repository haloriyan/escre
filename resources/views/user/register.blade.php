@extends('layouts.auth')

@section('title', "Register")

@section('head.dependencies')
<style>
    .role-option {
        background-color: #ddd;
        padding: 20px 0px;
        cursor: pointer;
    }
    .role-option.active {
        background-color: #2ecc71;
        color: #fff;
    }
</style>
@endsection

@section('content')
<form method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="role" id="role">
    <div class="wrap super">
        <div class="mt-2">Nama :</div>
        <input type="text" class="box" name="name" required>
        <div class="mt-2">Email :</div>
        <input type="email" class="box" name="email" required>
        <div class="mt-2">Telepon :</div>
        <input type="text" class="box" name="phone" required>
        <div class="mt-2">Password :</div>
        <input type="password" class="box" name="password" required>

        <div class="mt-2">Daftar sebagai :</div>
        <div onclick="chooseRole(this)" value="assistant" class="bagi bagi-2 role-option corner-top-left corner-bottom-left mt-2 rata-tengah">Sekretaris</div>
        <div onclick="chooseRole(this)" value="headship" class="bagi bagi-2 role-option corner-top-right corner-bottom-right mt-2 rata-tengah">Pimpinan</div>

        <button class="lebar-100 mb-3 mt-3 primer">Register</button>
        
        <div class="bagi bagi-2">
            sudah punya akun? <a href="{{ route('user.loginPage') }}">login</a>
        </div>
    </div>
</form>

<div class="desktop tinggi-70"></div>
@endsection

@section('javascript')
<script>
    const chooseRole = btn => {
        let role = btn.getAttribute('value');
        select("form #role").value = role;
        selectAll(".role-option").forEach(opt => opt.classList.remove('active'));
        btn.classList.add('active');
    }
</script>
@endsection