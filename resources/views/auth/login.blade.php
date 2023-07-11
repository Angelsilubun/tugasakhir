@extends('layouts_user.navbar')

@section('title', 'Login')

@section('container')
    <main id="main">
        <section id="contact" class="contact mt-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="card mt-5 shadow-lg p-3 bg-body rounded" style="max-width: 1000px;">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/img/logoo.png') }}" class="img-fluid" alt=""
                                    style="width: 350px">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body mt-3">
                                    <h3 class="card-title"><strong>Login</strong></h3>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email"
                                                class="col-form-label text-md-end">{{ __('Email') }}</label>

                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password"
                                                class="col-form-label text-md-end">{{ __('Password') }}</label>

                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="row mb-0">
                                            <div class="d-grid gap-2 mt-3">
                                                <button type="submit" class="btn" style="background-color: #ff6781; color:white">
                                                    {{ __('Login') }}
                                                </button>
                                            </div>
                                            <div class="col-12 mt-3 mb-3">
                                                @if (Route::has('register'))
                                                    <span class="msg">Belum Memiliki Akun ?</span>
                                                    <a href="{{ route('register') }}" class="link"
                                                        style="color:#ff6781">{{ __('Buat Akun') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
{{-- <div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="text-center">
            <img src="{{ asset('assets/img/logoo.png') }}" class="img-fluid" alt="" style="width: 250px">
        </div>
        <div class="mb-3">
            <label for="email" class="col-form-label text-md-end">{{ __('Email') }}</label>
            
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row mb-0">
            <div class="col-6 text-end">
                @if (Route::has('register'))
                    <a class="btn btn-link" href="{{ route('register') }}">
                        {{ __('Belum punya akun?') }}
                    </a>
                @endif
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>
            
        </div>
    </form>
</div> --}}
