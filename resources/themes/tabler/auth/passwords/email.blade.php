{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.auth')

@section('title')
    Forgot Password
@endsection

@section('content')
<div class="row">
    <div class="col-sm-offset-3 col-xs-offset-1 col-sm-6 col-xs-10 mx-auto">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @lang('auth.auth_error')<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                @lang('auth.email_sent')
            </div>
        @endif
    </div>
</div>
          <div class="row">
            <div class="col col-login mx-auto">
              <form class="card" id="resetForm" action="{{ route('auth.password') }}" method="post">
                <div class="card-body p-6">
                  <div class="card-title">@lang('auth.request_reset')</div>
                  <div class="form-group">
                    <label class="form-label">@lang('strings.email')</label>
                    <input type="email" name="email" class="form-control input-lg" value="{{ old('email') }}" required placeholder="@lang('strings.email')" autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block text-red small">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                  </div>
                  <div class="form-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary btn-block g-recaptcha pterodactyl-login-button--main" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('auth.request_reset')</button>
                      <a href="{{ route('auth.password') }}" class="float-right small">I remembered my details</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
@endsection

@section('scripts')
    @parent
    @if(config('recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
        function onSubmit(token) {
            document.getElementById("resetForm").submit();
        }
        </script>
     @endif
@endsection
