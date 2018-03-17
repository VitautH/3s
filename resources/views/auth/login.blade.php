@extends('layouts.enter')

@section('content')

    <div class="wrapper">
        <div class="container-fluid main">
            <div class="container ">
                <div class="row ">
                    <div class="col-md-12 ">
                        <img src="images/logo.png" class="logo_image center-block">
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row form_login center-block">
                    <div class="col-md-12">

                        <form class="center-block" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="text" class="form-control" name="login"
                                       value="{{ old('login') }}" required autofocus placeholder="email">
                                @if ($errors->has('login'))
                                    <span class="alert alert-danger help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" required
                                       placeholder="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary center-block">
                                    Log in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <p class="main_copyright_text">
                <span>&copy; Softera Solutions LLC, {{date('Y')}}</span>
            </p>
        </div>
    </div>
@endsection
