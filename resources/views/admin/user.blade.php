@extends('layouts.admin')

@section('title', "Users")

@section('head.dependencies')
<link rel="stylesheet" href="{{ asset('js/flatpickr/dist/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/flatpickr/dist/themes/material_blue.css') }}">
<style>
    .box[readonly] {
        background-color: #fff;
    }
</style>
@endsection

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $roles = ["assistant","headship"];

    function isPremium($date) {
        $due = Carbon::parse($date);
        $now = Carbon::now();
        return $due >= $now ? true : false;
    }
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
        @if ($message != "")
            <div class="bg-hijau-transparan rounded p-2 mb-1 mt-4">
                {{ $message }}
            </div>
        @endif
        <table class="mt-4">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @php
                        $premiumDate = $user->premium_until;
                    @endphp
                    <tr>
                        <td>
                            {{ $user->name }}
                            @if (isPremium($user->premium_until))
                                <br />
                                <div class="teks-kecil bagi bg-kuning p-1 rounded mt-1">
                                    Premium hingga {{ Carbon::parse($user->premium_until)->isoFormat('DD MMMM') }}
                                </div>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ ucwords($user->role) }}</td>
                        <td>
                            <span class="bg-hijau-transparan rounded p-1 pl-2 pr-2 pointer" onclick="edit('{{ $user }}')">
                                <i class="fas fa-edit"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="editUser">
    <div class="popup">
        <div class="wrap">
            <h3>Edit User
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#editUser')"></i>
            </h3>
            <form action="{{ route('admin.user.update') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="mt-2">Premium hingga tanggal :</div>
                <input type="text" class="box" name="premium_until" id="premium_until">

                <button class="lebar-100 mt-3 primer">Simpan perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/flatpickr/dist/flatpickr.min.js') }}"></script>
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

    const edit = data => {
        data = JSON.parse(data);
        munculPopup("#editUser");
        select("#editUser #id").value = data.id;
        select("#editUser #premium_until").value = data.premium_until;

        flatpickr("#editUser #premium_until", {
            dateFormat: 'Y-m-d',
            minDate: "{{ date('Y-m-d') }}"
        });
    }
</script>
@endsection