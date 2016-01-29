<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name') }} - @yield('title')</title>

        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-194x194.png') }}" sizes="194x194">
        <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-96x96.png') }}" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ asset('favicons/android-chrome-192x192.png') }}" sizes="192x192">
        <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-16x16.png') }}" sizes="16x16">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <link rel="mask-icon" href="{{ asset('favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="{{ asset('favicons/mstile-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">

        {!! HTML::style('css/sweetalert.css') !!}
        {!! HTML::style('css/app.css') !!}
        {!! HTML::style('css/espresso-theme.css') !!}
    </head>
    <body>
        <nav class="top-bar" data-topbar role="navigation">
            <ul class="title-area">
                <li class="name">
                    <h1><a href="{{ route('home') }}">{{ config('app.name') }}</a></h1>
                </li>
                <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                {{--<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>--}}
            </ul>
            <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                    @if(\Auth::user()->hasRight(\App\Right::PROJECT_SUBSCRIBE))
                    <li class="{{ \App\Helpers\ActiveRoute::is_active('subscriptions') }}"><a href="{{ route('subscriptions.index') }}"><span class="fi-eye-open" title="subscriptions" aria-hidden="true"></span> Subscriptions</a></li>
                    @endif
                    <li class="{{ \App\Helpers\ActiveRoute::is_active('user/'.Auth::user()->id) }}"><a href="{{ route('user.show', Auth::user()->id) }}"><span class="fi-person-genderless" title="user" aria-hidden="true"></span> Profile</a></li>
                    @if(\Auth::user()->hasRight(\App\Right::ACCESS_ADMIN))
                    <li class="active"><a href="{{ route('admin') }}"><span class="fi-shield" title="admin" aria-hidden="true"></span> Admin</a></li>
                    @endif
                    <li class="align-right"><a href="{{ route('auth.logout') }}"><span class="fi-account-logout" title="logout" aria-hidden="true"></span> Log out</a></li>
                </ul>

                <!-- Left Nav Section -->
                <ul class="left">
                    <li class="{{ \App\Helpers\ActiveRoute::is_active('/') }}"><a href="{{ route('home') }}"><span class="fi-home" title="home" aria-hidden="true"></span> Home</a></li>
                    <li class="has-dropdown {{ \App\Helpers\ActiveRoute::is_active('client') }}">
                        <a href="#"><span class="fi-briefcase" title="clients" aria-hidden="true"></span> Clients</a>
                        <ul class="dropdown">
                            @if (Session::has('clients'))
                                @foreach (session('clients') as $client)
                                    <li class="{{ \App\Helpers\ActiveRoute::is_active('client/'.$client->id) }}"><a href="{{ route('client.show', $client->id) }}">{{ $client->name }}</a></li>
                                @endforeach
                            @endif
                            @if(\Auth::user()->hasRight(\App\Right::CLIENT_CREATE))
                                <li class="action {{ \App\Helpers\ActiveRoute::is_active('client/create') }}"><a href="{{ route('client.create') }}">Add client</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="has-dropdown {{ \App\Helpers\ActiveRoute::is_active('project') }}"><a href="#"><span class="fi-grid-three-up" title="grid three up" aria-hidden="true"></span> Projects</a>
                        <ul class="dropdown">
                            @if (Session::has('projects'))
                                @foreach (session('projects') as $project)
                                    <li class="{{ \App\Helpers\ActiveRoute::is_active('project/'.$project->id) }}"><a href="{{ route('project.show', $project->id) }}">{{ $project->name }}</a></li>
                                @endforeach
                            @endif
                            @if(\Auth::user()->hasRight(\App\Right::PROJECT_CREATE))
                                <li class="action {{ \App\Helpers\ActiveRoute::is_active('project/create') }}"><a href="{{ route('project.create') }}">Create new project</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="{{ \App\Helpers\ActiveRoute::is_active('user') }}"><a href="{{ route('user.index') }}"><span class="fi-people" title="users" aria-hidden="true"></span> Users</a></li>
                </ul>
            </section>
        </nav>
        @yield('page')
        {!! HTML::script('js/vendor/jquery.js') !!}
        {!! HTML::script('js/foundation.min.js') !!}
        {!! HTML::script('js/iconic.min.js') !!}
        {!! HTML::script('js/sweetalert.min.js') !!}
        {!! HTML::script('js/rainbow.min.js') !!}
        {!! HTML::script('js/rainbow-generic.js') !!}
        {!! HTML::script('js/rainbow-css.js') !!}
        {!! HTML::script('js/zeroclipboard/ZeroClipboard.js') !!}
        <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
        <script>
            tinymce.init({
                selector: '#tinycontent'
            });
        </script>
        <script type="text/javascript">
            $(document).foundation();
            $(document).ready(function(){
                // Clipboard for file's paths
                var client = new ZeroClipboard( $(".copy-button") );

                client.on( "ready", function( readyEvent ) {
                    client.on( "aftercopy", function( event ) {
                        swal({
                            title: "Path copied!",
                            text: "The path is in your clipboard.<br/><br/>" +
                            "Select the Finder (Mac Application)<br/>" +
                            "Click on <em>Go</em> (<em>Aller</em>) in the menu<br/>" +
                            "Click on <em>Connect to server...</em> (<em>Se connecter au serveur...</em>)<br/>" +
                            "Past the path.<br/>" +
                            "You're in!",
                            html: true,
                            type: "info"
                        });
                    } );
                } );

                // Changing versions in File Create
                $('.changeFileVersion').on('click', function(){
                    var v1 = $(this).data('version1');
                    var v2 = $(this).data('version2');
                    $('#version1').val(v1);
                    $('#version2').val(v2);
                });

                // Confirm to delete an element (project, copydeck, file, etc.)
                $('.deleteEl').on('click', function(){
                    var token = $(this).data('token');
                    var route = $(this).data('route');
                    var redirect = $(this).data('redirect');
                    var type = $(this).data('type');

                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover every data linked to this "+type+"!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }, function(){
                        $.ajax({
                            url: route,
                            type: 'post',
                            data: {_method: 'delete', _token: token},
                            success: function (msg) {
                                swal("Deleted!", "Your "+type+" has been deleted. You will be redirected in 5 seconds.", "success");
                                setTimeout(window.location.replace(redirect), 5000);
                            }
                        });
                    });
                });

                // Popup to explain how to get the path
                $('.findPath').on('click', function(){
                    swal({
                        title: "How to get file path on servers",
                        text: "Right click on the file<br/>" +
                        "Select <em>Get info</em> (<em>Lire les informations</em>)<br/>" +
                        "In General, select and copy the path in <em>Server</em> (<em>Serveur</em>)<br/><br/>" +
                        "<strong>Tips:</strong> You can use this link in emails!<br/>Just remove the filename at the end (after the last '/')",
                        html: true,
                        type: "info"
                    });
                });
            });
        </script>
    </body>
</html>