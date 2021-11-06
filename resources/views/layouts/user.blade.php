<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
<header>
    <h1>@yield('title')</h1>
    <div class="mobile ke-kanan" onclick="toggleMenu()" id="tblMenu"><i class="fas fa-bars"></i></div>
    <nav>
        <a href="{{ route('user.schedule.add') }}">
            <li class="item circle">
                <i class="fas fa-plus"></i>
            </li>
        </a>
        <a href="{{ route('user.notification') }}">
            <li class="item circle">
                <i class="fas fa-bell"></i>
                @if ($myData->notifications->count() != 0)
                    <div class="counter">{{ $myData->notifications->count() }}</div>
                @endif
            </li>
        </a>
        <a href="{{ route('user.profile') }}">
            <li class="item circle">
                <i class="fas fa-user"></i>
            </li>
            <li class="item text">
                Halo, {{ $myData->first_name }}
            </li>
        </a>
    </nav>
</header>

<nav class="menu rounded">
    <a href="{{ route('user.home') }}">
        <li class="corner-top-left corner-top-right {{ Route::currentRouteName() == 'user.home' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-home"></i></div>
            <div class="text">Home</div>
        </li>
    </a>
    <a href="{{ route('user.schedule') }}">
        <li class="{{ Route::currentRouteName() == 'user.schedule' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-calendar"></i></div>
            <div class="text">Schedule</div>
        </li>
    </a>
    <a href="{{ route('user.history') }}">
        <li class="{{ Route::currentRouteName() == 'user.history' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-history"></i></div>
            <div class="text">History</div>
        </li>
    </a>
    <a href="{{ route('user.connect') }}">
        <li class="{{ Route::currentRouteName() == 'user.connect' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-users"></i></div>
            <div class="text">Connects</div>
        </li>
    </a>
    <a href="{{ route('user.logout') }}">
        <li class="corner-top-left corner-top-right">
            <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="text">Logout</div>
        </li>
    </a>
</nav>

<div class="content">
    <input type="hidden" id="myData" value="{{ $myData }}">
    @yield('content')
</div>

<script src="{{ asset('js/base.js') }}"></script>
<script>
    let swRegistration = null;
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        console.log('supported');
        
        navigator.serviceWorker.register("{{ asset('js/sw.js') }}")
        .then(swReg => {
            console.log('sw registered', swReg);
            swRegistration = swReg;
        })
        .catch(err => {
            console.log("sw error", err);
        })
    } else {
        console.log('not supported');
    }

    let myData = JSON.parse(select("input#myData").value);
    let push = {
        publicKey: "BNjnxNlldlMeh9jWqFkgBPII2U9_WttBijMnbOi41-fJZCV6DuXIfywRuXNAO7ZBddP-7EzRg7vA4lJQhOsiHMg",
        privateKey: "2LLW9bvzRdkg9Ak_D3IcrovCKRDTy8zaCq5AgFcERgU",
        isSubscribed: null
    }

    function initializeUI() {
        if (push.isSubscribed) {
            // unsub
            // unsubscribeUser();
        } else {
            subscribeUser();
        }
        swRegistration.pushManager.getSubscription()
        .then(subscription => {
            push.isSubscribed = !(subscription === null);
            if (push.isSubscribed) {
                console.log('is subscribed');
            } else {
                console.log('not subscribed');
            }
        });
    }

    setTimeout(() => {
        initializeUI();
    }, 1000);

    function subscribeUser() {
        const serverKey = urlB64ToUint8Array(push.publicKey);
        swRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: serverKey
        })
        .then(subscription => {
            console.log('user subscribed', subscription);
            let pushData = btoa(JSON.stringify(subscription));
            let req = post("{{ route('api.user.updateWebpushData') }}", {
                id: myData.id,
                webpush_data: pushData
            })
            .then(res => {
                console.log(res);
            });

            push.isSubscribed = true;
        })
        .catch(err => console.log(err));
    }

    function unsubscribeUser() {
        swRegistration.pushManager.getSubscription()
        .then(subscription => {
            if (subscription) {
                return subscription.unsubscribe();
            }
        })
        .catch(err => console.log(err))
        .then(() => {
            console.log('user is unsubscribed');
            push.isSubscribed = false;
        });
    }

    const toggleMenu = () => {
        select("nav.menu").classList.toggle('active');
    }
</script>
@yield('javascript')

</body>
</html>