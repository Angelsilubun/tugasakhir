@extends('layouts_user.navbar')

@section('title', 'Register')

@section('container')
    <main id="main">
        <section id="contact" class="contact mt-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="card mt-5 shadow-lg p-3 bg-body rounded" style="max-width: 1000px;">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="card-body mt-3">
                                <div class="row g-0">
                                    <h3 class="card-title"><strong>Register</strong></h3>
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label for="staticEmail"
                                                class="col-sm-2 col-form-label">{{ __('Nama') }}</label>
                                            <div class="col-sm-9">
                                                <input id="name" type="name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="mb-3 row">
                                            <label for="staticEmail"
                                                class="col-sm-2 col-form-label">{{ __('Nama') }}</label>
                                            <div class="col-sm-9">
                                                <input id="name" type="name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="mb-3 row">
                                            <label for="staticEmail"
                                                class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                            <div class="col-sm-9">
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="umur"
                                                class="col-sm-2 col-form-label">{{ __('Umur') }}</label>
                                            <div class="col-sm-9">
                                                <input id="umur" type="umur"
                                                    class="form-control @error('umur') is-invalid @enderror" name="umur"
                                                    value="{{ old('umur') }}" required autocomplete="umur" autofocus>

                                                @error('umur')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="alamat"
                                                class="col-sm-2 col-form-label">{{ __('Alamat') }}</label>
                                            <div class="col-sm-9">
                                                <textarea type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                                    value="{{ old('alamat') }}" required autocomplete="alamat" id="alamat" rows="3" autofocus></textarea>

                                                @error('alamat')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label for="alamat"
                                                class="col-sm-4 col-form-label">{{ __('Jenis Kelamin') }}</label>
                                            <div class="col-sm-8">
                                                <select name="jenis_kelamin" class="form-select"
                                                    aria-label="Default select example" required autocomplete="jenis_kelamin" autofocus>
                                                    <option value="" selected>- Pilih Jenis Kelamin -</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                </select>

                                                @error('jenis_kelamin')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="mb-3 row">
                                            <label for="alamat"
                                                class="col-sm-4 col-form-label">{{ __('Password') }}</label>
                                            <div class="col-sm-8">

                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="mb-3 row">
                                            <label for="password"
                                                class="col-sm-4 col-form-label">{{ __('Password') }}</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="current-password" autofocus>
                                                    <button type="button" id="togglePassword"
                                                        class="btn btn-outline-secondary">
                                                        <i id="toggleIcon" class="bi bi-eye-slash"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="mb-3 row">
                                            <label for="alamat"
                                                class="col-sm-4 col-form-label">{{ __('Confirm') }}</label>
                                            <div class="col-sm-8">

                                                <input id="password-confirm" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div> --}}
                                        <div class="mb-3 row">
                                            <label for="password-confirm"
                                                class="col-sm-4 col-form-label">{{ __('Confirm') }}</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="password-confirm" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password_confirmation" required autocomplete="new-password" autofocus>
                                                    <button type="button" id="toggleConfirmPassword"
                                                        class="btn btn-outline-secondary">
                                                        <i id="toggleConfirmIcon" class="bi bi-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="d-grid gap-2 mt-3">
                                                <button type="submit" class="btn"
                                                    style="background-color: #ff6791; color:white">
                                                    {{ __('Register') }}
                                                </button>
                                            </div>
                                            <div class="col-12 mt-3 mb-3">
                                                @if (Route::has('register'))
                                                    <span class="msg">Sudah Punya Akun?</span>
                                                    <a href="{{ route('login') }}" class="link"
                                                        style="color:#ff6791">{{ __('Login') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                togglePassword.querySelector('#toggleIcon').classList.toggle('bi-eye');
                togglePassword.querySelector('#toggleIcon').classList.toggle('bi-eye-slash');
            });
        </script>
        <script>
            const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
            const confirmPassword = document.querySelector('#password-confirm');

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                toggleConfirmPassword.querySelector('#toggleConfirmIcon').classList.toggle('bi-eye');
                toggleConfirmPassword.querySelector('#toggleConfirmIcon').classList.toggle('bi-eye-slash');
            });
        </script>
    @endpush
@endsection
{{-- <div class="card-body">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="text-center">
            <img src="{{ asset('assets/img/logoo.png') }}" class="img-fluid" alt="" style="width: 250px">
        </div>

        <div class="mb-3">
            <label for="name" class="col-form-label text-md-end">{{ __('Nama') }}</label>

            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="col-form-label text-md-end">{{ __('Email') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="umur" class="col-form-label text-md-end">{{ __('Umur') }}</label>

            <input id="umur" type="umur" class="form-control @error('umur') is-invalid @enderror" name="umur"
                value="{{ old('umur') }}" required autocomplete="umur">

            @error('umur')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="col-form-label text-md-end">{{ __('Alamat') }}</label>

            <textarea type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                value="{{ old('alamat') }}" required autocomplete="alamat" id="alamat" rows="3"></textarea>

            @error('alamat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="jenis_kelamin">{{ __('Jenis Kelamin') }}</label>
            <select name="jenis_kelamin" class="form-select" aria-label="Default select example">
                <option value="" selected>- Pilih Jenis Kelamin -</option>
                <option value="Perempuan">Perempuan</option>
                <option value="Laki-laki">Laki-laki</option>
            </select>

            @error('jenis_kelamin')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="col-form-label text-md-end">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div> --}}
{{-- <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-8">
        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
    </div>
</div>
<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword">
    </div>
</div> --}}
