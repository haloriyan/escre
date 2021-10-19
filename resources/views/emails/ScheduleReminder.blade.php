@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $date = Carbon::parse($schedule->date);
@endphp
<div style="background-color: #ecf0f1;padding: 20px 35px;">
    <div style="background-color: #fff;border: 1px solid #ddd;border-radius: 6px;padding: 20px;">
        <p>Halo, {{ $user->name }}</p>
        <p style="margin-top: 25px;">Schedule Anda <b>{{ $schedule->title }}</b> akan segera dimulai pada {{ $date->format('H:i') }}. Pastikan Anda telah menyiapkan segala keperluannya agar tidak terlambat.</p>

        <p style="margin-top: 25px">Terima kasih</p>
    </div>
</div>