{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ijendev | Register') }} — Register</title>

    {{-- Google Fonts: Nunito (SB Admin 2) --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="{{ asset('assets_dashboard/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('assets_dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets_dashboard/img/favicon.png') }}">
</head>
<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">

                    <div class="p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets_dashboard/img/a.png') }}" alt="Logo" style="height:56px">
                        </div>

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-3">Buat Akun Baru</h1>
                            <p class="mb-4 text-muted">Daftar untuk mengakses dashboard.</p>
                        </div>

                        {{-- Notifikasi sukses --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="user" method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Name --}}
                            <div class="form-group">
                                <label for="name" class="small text-muted">Nama</label>
                                <input id="name" type="text"
                                       class="form-control form-control-user @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autofocus
                                       placeholder="Nama lengkap">
                                @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email" class="small text-muted">Email</label>
                                <input id="email" type="email"
                                       class="form-control form-control-user @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required
                                       placeholder="nama@domain.com">
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group">
                                <label for="password" class="small text-muted">Kata Sandi</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                           class="form-control form-control-user @error('password') is-invalid @enderror"
                                           name="password" required minlength="6"
                                           placeholder="••••••••">
                                    <div class="input-group-append">
                                        <button class="btn btn-light border" type="button" id="togglePassword">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <small class="form-text text-muted">Minimal 6 karakter.</small>
                            </div>

                            {{-- Password Confirmation --}}
                            <div class="form-group">
                                <label for="password-confirm" class="small text-muted">Konfirmasi Kata Sandi</label>
                                <input id="password-confirm" type="password"
                                       class="form-control form-control-user"
                                       name="password_confirmation" required
                                       placeholder="Ketik ulang kata sandi">
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-user-plus mr-1"></i> Daftar
                            </button>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
                        </div>

                        <div class="text-center mt-3">
                            <span class="small text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Core JS --}}
<script src="{{ asset('assets_dashboard/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets_dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

{{-- SB Admin 2 JS --}}
<script src="{{ asset('assets_dashboard/js/sb-admin-2.min.js') }}"></script>

{{-- Toggle show/hide password --}}
<script>
    (function () {
        const btn = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        if (btn && input) {
            btn.addEventListener('click', function () {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    })();
</script>

</body>
</html>
