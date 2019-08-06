{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Pterodactyl') }} - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="_token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0e4688">

        @include('layouts.scripts')

        @section('scripts')

            {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
            {!! Theme::css('assets/css/dashboard.css?t={cache-version}') !!}


            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        @show
    </head>
  <body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="{{route('index')}}">
                    <img src="https://beefbytes.github.io/Assets/BeefBytes/logos/svg/horizontal_text_optimized.svg" width="200">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}</span>
					                              @if(Auth::user()->root_admin)
                      <small class="text-muted d-block mt-1">Administrator</small>
                                                  @else
                      <small class="text-muted d-block mt-1">User</small>
                                                  @endif
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    @if(Auth::user()->root_admin)
                    <a class="dropdown-item" href="{{ route('admin.index') }}">
                      <i class="dropdown-icon fa fa-cogs"></i> @lang('strings.admin_cp')
                    </a>
					@endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">
                      <i class="dropdown-icon fa fa-sign-out-alt"></i> @lang('strings.logout')
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                <li class="nav-item">
                  <a href="{{route('index')}}" class="nav-link {{ Route::currentRouteName() !== 'index' ?: 'active' }}"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="dropdown nav-item">
                  <a href="#" class="nav-link" data-toggle="dropdown">
                    <i class="dropdown-icon fa fa-bars"></i> <span>{{ucwords(strtolower(trans('navigation.account.header')))}}</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ route('account') }}">
                      <i class="dropdown-icon fa fa-user"></i> @lang('navigation.account.my_account')
                    </a>
                    <a class="dropdown-item" href="{{ route('account.security') }}">
                      <i class="dropdown-icon fa fa-lock"></i> @lang('navigation.account.security_controls')
                    </a>
                    <a class="dropdown-item" href="{{ route('account.api') }}">
                      <i class="dropdown-icon fa fa-code"></i> @lang('navigation.account.api_access')
                    </a>
                  </div>
				  </li>
                  @if (isset($server->name) && isset($node->name))
				<li class="nav-item">
                  <a href="{{ route('server.index', $server->uuidShort) }}" class="nav-link {{ !starts_with(Route::currentRouteName(), 'server.index') ?: 'active' }}"><i class="fa fa-terminal"></i> @lang('navigation.server.console')</a>
				</li>
                  @can('list-files', $server)
				<li class="nav-item">
                  <a href="{{ route('server.files.index', $server->uuidShort) }}" class="nav-link {{ !starts_with(Route::currentRouteName(), 'server.files') ?: 'active' }}"><i class="fa fa-copy"></i> @lang('navigation.server.file_management')</a>
                </li>
				  @endcan
                  @can('list-subusers', $server)
				<li class="nav-item">
                  <a href="{{ route('server.subusers', $server->uuidShort) }}" class="nav-link {{ !starts_with(Route::currentRouteName(), 'server.subusers') ?: 'active' }}"><i class="fa fa-user"></i> @lang('navigation.server.subusers')</a>
                </li>
				  @endcan
                  @can('list-schedules', $server)
				<li class="nav-item">
                  <a href="{{ route('server.schedules', $server->uuidShort) }}" class="nav-link {{ !starts_with(Route::currentRouteName(), 'server.schedules') ?: 'active' }}"><i class="fa fa-clock"></i> @lang('navigation.server.schedules')</a>
                </li>
				  @endcan
                  @can('view-databases', $server)
				<li class="nav-item">
                  <a href="{{ route('server.databases.index', $server->uuidShort) }}" class="nav-link {{ !starts_with(Route::currentRouteName(), 'server.databases') ?: 'active' }}"><i class="fa fa-database"></i> @lang('navigation.server.databases')</a>
                </li>
				  @endcan
                @if(Gate::allows('view-startup', $server) || Gate::allows('access-sftp', $server) ||  Gate::allows('view-allocations', $server))
                <li class="dropdown nav-item">
                  <a href="#" class="nav-link  {{ !starts_with(Route::currentRouteName(), 'server.settings') ?: 'active' }}" data-toggle="dropdown">
                    <i class="dropdown-icon fa fa-cogs"></i> <span>{{ucwords(strtolower(trans('navigation.server.configuration')))}}</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ route('server.settings.name', $server->uuidShort) }}">
                      <i class="dropdown-icon fa fa-id-card"></i> @lang('navigation.server.server_name')
                    </a>
                    <a class="dropdown-item" href="{{ route('server.settings.allocation', $server->uuidShort) }}">
                      <i class="dropdown-icon fa fa-ethernet"></i> @lang('navigation.server.port_allocations')
                    </a>
                    <a class="dropdown-item" href="{{ route('server.settings.sftp', $server->uuidShort) }}">
                      <i class="dropdown-icon fa fa-plug"></i> @lang('navigation.server.sftp_settings')
                    </a>
                    <a class="dropdown-item" href="{{ route('server.settings.startup', $server->uuidShort) }}">
                      <i class="dropdown-icon fa fa-toolbox"></i> @lang('navigation.server.startup_parameters')
                    </a>
                  </div>
				  </li>
			      @endif
                  @if(Auth::user()->root_admin)
				<li class="nav-item">
                  <a href="{{ route('admin.servers.view', $server->id) }}" target="_blank" class="nav-link"><i class="fa fa-sitemap"></i> @lang('navigation.server.admin')</a>
                </li>
			      @endif
			      @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
                @yield('content-header')					
            </div>
                    <div class="row">
                        <div class="col-xs-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @lang('base.validation_error')<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @foreach (Alert::getMessages() as $type => $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                                        {!! $message !!}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @yield('content')					
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <div class="col-auto">
                  <ul class="list-inline list-inline-dots mb-0">
                    <strong><i class="fa fa-fw {{ $appIsGit ? 'fa-git-square' : 'fa-code-branch' }}"></i></strong> {{ $appVersion }}<br />
                  </ul>
                </div>
                <div class="col-auto">
                    <strong><i class="fa fa-fw fa-clock"></i></strong> {{ round(microtime(true) - LARAVEL_START, 3) }}s
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                Copyright &copy; BeefBytes
            </div>
          </div>
        </div>
      </footer>
    </div>
@section('footer-scripts')
            {!! Theme::js('js/keyboard.polyfill.js?t={cache-version}') !!}
            <script>keyboardeventKeyPolyfill.polyfill();</script>

            {!! Theme::js('js/laroute.js?t={cache-version}') !!}
            {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap/bootstrap.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/socketio/socket.io.v203.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
            {!! Theme::js('js/autocomplete.js?t={cache-version}') !!}

            @if(Auth::user()->root_admin)
                <script>
                    $('#logoutButton').on('click', function (event) {
                        event.preventDefault();
                        var that = this;
                        swal({
                            title: 'Do you want to log out?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d9534f',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Log out'
                        }, function () {
                            window.location = $(that).attr('href');
                        });
                    });
                </script>
            @endif
        @show
  </body>
</html>
