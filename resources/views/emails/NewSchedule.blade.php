<div style="background-color: #ecf0f1;padding: 20px 35px;">
    <div style="background-color: #fff;border: 1px solid #ddd;border-radius: 6px;padding: 20px;">
        <h2>Schedule {{ $schedule->title }}</h2>

        <p>Anda diundang untuk schedule "{{ $schedule->title }}". <a href="{{ route('user.loginPage') }}">Login</a> untuk melihat informasi lengkap</p>
    </div>
</div>