@extends('layouts.user')

@section('title', "Buat Schedule")

@section('head.dependencies')
<link rel="stylesheet" href="{{ asset('js/flatpickr/dist/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/flatpickr/dist/themes/material_blue.css') }}">
<style>
    .box[readonly] {
        background-color: #fff;
    }
</style>
@endsection
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        @if (!$canCreateSchedule)
            <div class="rata-tengah">
                <h2>Anda mencapai batas maksimum untuk membuat schedule baru</h2>
                <p>Tingkatkan ke premium untuk membuat schedule tanpa batas</p>
            </div>
        @endif
        <form action="{{ route('user.schedule.store') }}" method="POST" class="{{ $canCreateSchedule ? '' : 'd-none' }}">
            {{ csrf_field() }}
            <div class="mt-2">Pilih Koneksi :</div>
            <select name="connect_id" class="box" required>
                <option value="">-- PILIH --</option>
                @foreach ($user->{$relations[0]} as $item)
                    <option value="{{ $item->id }}">{{ $item->{$relations[1]}->name }}</option>
                @endforeach
            </select>
            <div class="mt-2">Nama Kegiatan :</div>
            <input type="text" class="box" name="title" required>
            <div class="bagi bagi-3">
                <div class="mt-2">Tanggal :</div>
                <input type="text" class="box" name="date" id="date" required>
            </div>
            <div class="bagi bagi-3">
                <div class="mt-2">Waktu :</div>
                <input type="text" class="box" name="time" id="time" required>
            </div>
            <div class="bagi bagi-3">
                <div class="mt-2">Durasi (jam) :</div>
                <input type="number" class="box" name="duration" required>
            </div>

            <div class="mt-2">Tempat Kegiatan :</div>
            <div class="mt-2">
                <select name="place_type" class="box" required onchange="changePlaceType(this.value)">
                    <option value="maps">Google Maps</option>
                    <option value="zoom">Zoom</option>
                </select>
            </div>
            <div class="mt-2">
                <div class="wrap">
                    <div id="mapArea" class="placeTypeArea">
                        <input type="text" class="box" id="placeSearch">
                        <div id="map" class="tinggi-300"></div>
                    </div>
                    <div id="zoomArea" class="placeTypeArea d-none">
                        <div class="mt-2">Link zoom meeting :</div>
                        <input type="text" class="box" name="place" id="placeInput" required>
                    </div>
                </div>
            </div>

            <div class="mt-2">Catatan :</div>
            <textarea name="notes" class="box"></textarea>

            <button class="lebar-100 mt-3 primer">Tambahkan</button>
        </form>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/flatpickr/dist/flatpickr.min.js') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiX4DuzinqgbzRWhn60HEPLdFmBNmpp2E&callback=initMap&v=weekly&libraries=places"
    async
></script>
<script>
    flatpickr("#date", {
        minDate: "{{ date('Y-m-d') }}",
        dateFormat: 'Y-m-d'
    });

    flatpickr("#time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i'
    });

    let map;
    let mapData;
    let mapArea = select("#map");

    function initMap() {
        map = new google.maps.Map(mapArea, {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });

        const input = select("#placeSearch");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) return;

            markers.forEach((marker) => marker.setMap(null));
            markers = [];

            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                mapData = [place.name, place.url];

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location
                    })
                );

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });

            map.fitBounds(bounds);
            select("#placeInput").value = mapData.join('|');
        });
    }

    const changePlaceType = type => {
        selectAll(".placeTypeArea").forEach(area => area.classList.add('d-none'));
        let area = type == "maps" ? "#mapArea" : "#zoomArea";
        select(area).classList.remove('d-none');
    }
</script>
@endsection 