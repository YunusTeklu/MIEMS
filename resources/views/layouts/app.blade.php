<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}" ></script>
    <script src="{{ asset('js/DataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/DataTables/dataTables.bootstrap4.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js" ></script>
    <script src="http://cdn.jsdelivr.net/g/filesaver.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/cyborg.css') }}" rel="stylesheet">
    <link href="{{ asset('css/DataTables/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body id="siteBody">
    <div id="app">
        @auth
            <div id="wrapper">
                
                <div id="sidebar-wrapper" class="bg-light">
                    <div class="py-5 px-1">
                        <img src="{{asset('/storage/images/Picture3.png')}}" class="img-fluid">
                    </div>
                    
                    <ul id="sidebar-nav">
                        <li><a href="{{asset('/message/compose')}}">
                            <span><i class="fas fa-envelope"></i></span>  Compose Message</a></li>
                        <li><a href="{{asset('/message/inbox')}}">
                            <span><i class="fas fa-envelope-open"></i></span>  Inbox</a></li>
                        <li><a href="{{asset('/message/sent')}}">
                            <span><i class="fas fa-paper-plane"></i></span>  Sent</a></li>
                        <li><a href="{{asset('/users')}}">
                            <span><i class="fas fa-users"></i></span>  Users</a></li>
                        <li><a href="/miems/public/users/detail/{{Auth::user()->id}}">
                            <span><i class="fas fa-user"></i></span>  My Profile</a></li>
                        <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                             <span><i class="fas fa-sign-out-alt"></i></span>  {{ __('Logout') }}
                         </a></li>
                    </ul>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
        
                <main id="main-wrapper" class="bodyTheme py-4 container-fluid">
                    <div class="row">
                        <div class="col text-left">
                            <div id="sidebarToggler" class="toggle-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="col text-right">
                            <a href="/miems/public/users/detail/{{Auth::user()->id}}">
                                @if(Auth::user()->photo==null)
                                    <img src="/miems/public/storage/images/emptyperson.png" class="img-fluid" style="height: 50px; width: 50px; border-radius: 50%; border:2px solid grey;">
                                @else
                                    <img src="/miems/public/storage/images/{{Auth::user()->photo}}" class="img-fluid" style="height: 50px; width: 50px; border-radius: 50%; border:2px solid grey;">
                                @endif
                            </a>

                            <a id="dropdownLogout" class="btn btn-link tex-md-right" href="/miems/public/users/detail/{{Auth::user()->id}}">{{Auth::user()->name}}</a>
                            
                        </div>
                    </div>
                    @yield('content')
                    <br>
                    <footer class="text-center bg-light py-2">
                        <p>Copyright @ {{ now()->year }}: MIEMS</p>
                    </footer>
                </main>
                
            </div>
        @else
            <main class="bodyTheme py-4">
                @yield('content')
            </main>
        @endauth
    </div>

    <script>
        $(function(){
            $("#sidebarToggler").click(function (e) {
                e.preventDefault();
                $("#wrapper").toggleClass("menuDisplayed");
                
            });
        });
    </script>
</body>
</html>
