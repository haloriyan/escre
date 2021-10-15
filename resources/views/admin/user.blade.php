@extends('layouts.admin')

@section('title', "Users")

@php
    $roles = ["assistant","headship"];
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <div class="bagi desktop lebar-40">
            <form id="searchName">
                <div class="mt-2">Cari Nama :</div>
                <input type="text" class="box" name="name" value="{{ $request->name }}">
            </form>
        </div>
        <div class="bagi desktop lebar-20"></div>
        <div class="bagi desktop lebar-40">
            <div class="mt-2">Role :</div>
            <select name="role" class="box" onchange="changeRole(this.value)">
                <option value="">Semua Role</option>
                @foreach ($roles as $role)
                    @php
                        $isSelected = $request->role == $role ? "selected='selected'" : "";
                    @endphp
                    <option {{ $isSelected }} value="{{ $role }}">{{ ucwords($role) }}</option>
                @endforeach
            </select>
        </div>
        <br />
        <table class="mt-4">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ ucwords($user->role) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    let url = new URL(document.URL);
    const changeRole = role => {
        url.searchParams.set('role', role);
        window.location = url.toString();
    }

    select("#searchName").onsubmit = function (e) {
        let name = select("#searchName input").value;
        url.searchParams.set('name', name);
        window.location = url.toString();
        e.preventDefault();
    }
</script>
@endsection