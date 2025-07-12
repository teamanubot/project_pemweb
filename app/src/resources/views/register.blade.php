{{-- resources/views/demo.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - UEU Bootcamp</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <!-- Styles -->
    <link rel="icon" href="{{ asset('front/assets/img/Ueu Bootcamp Web icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('front/assets/img/apple-touch-icon.png') }}">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Poppins&family=Raleway&display=swap"
        rel="stylesheet">

    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/global.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: orange !important;
        }
    </style>
</head>

<body>

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <img src="{{ asset('front/assets/img/logo.png') }}" alt="">
                </a>
                <div class="login-mobile" style="margin-left: 20px;">
                    <ul class="login-mobile-btn">
                        <a href="{{ url('/sso') }}" class="login-btn-mobile" style="padding: 10px 30px;">Masuk</a>
                    </ul>
                </div>
            </div>
            <nav id="navmenu" class="navmenu">
                <ul class="desktop">
                    <li><a href="{{ url('/') }}" class="active">Home</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                    <a href="{{ url('/sso') }}" class="login-btn" style="padding: 10px 30px;">Masuk</a>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <div class="container mt-5 pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow" style="background-color: #f8f9fa; border-radius: 12px;">
                    <div class="card-body p-5">
                        <h3 class="mb-4 text-center fw-bold">Formulir Pendaftaran & Pembayaran</h3>

                        {{-- === FORM START === --}}
                        <form id="register-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>Nama Depan</label>
                                    <input type="text" id="nama_depan" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Belakang</label>
                                    <input type="text" id="nama_belakang" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label>Email</label>
                                    <input type="email" id="email" class="form-control" required>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <label>Password</label>
                                    <input type="password" id="password" class="form-control" required>
                                    <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor:pointer;">👁️</span>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" class="form-control" required>
                                    <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor:pointer;">👁️</span>
                                </div>
                                <div class="col-md-6">
                                    <label>No. HP</label>
                                    <input type="text" id="phone_number" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>NIK</label>
                                    <input type="text" id="nik" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label>Alamat</label>
                                    <input type="text" id="address" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="course_id">Pilih Course</label>
                                    <select id="course_id" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Course --</option>
                                        @foreach (\App\Models\Course::where('is_active', true)->get() as $course)
                                            <option value="{{ $course->id }}">
                                                {{ $course->name }} - {{ $course->title }}
                                                (Rp{{ number_format($course->price, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="button" id="pay-button" class="btn btn-primary px-5 py-2">Bayar
                                    Sekarang</button>
                            </div>
                        </form>
                        {{-- === FORM END === --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer" class="footer dark-background">
        <div class="container footer-top">
            <div class="row gy-4" style="display: flex; justify-content: space-between;">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">UEU Bootcamp</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Citra Raya Boulevard No.01 BlokS No.25, Panongan, Kec. Panongan</p>
                        <p>Kabupaten Tangerang, Banten 15711</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62 123 456 78</span></p>
                        <p><strong>Email:</strong> <span>ueubootcamp@mail.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 ms-auto kanan footer-links">
                    <h4>Useful Links</h4>
                    <ul class="list-unstyled likekanan">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <div class="credits">
                Designed By UEUBootcamp With <i class="bi bi-heart-fill" style="color: green;"></i>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>

    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    this.textContent = "🙈";
                } else {
                    input.type = "password";
                    this.textContent = "👁️";
                }
            });
        });

        function generateEmail() {
            const first = document.getElementById('nama_depan').value.trim();
            const last = document.getElementById('nama_belakang').value.trim();
            if (first && last) {
                const email = `${first.toLowerCase()}${last.toLowerCase()}@student.bootcamp.com`;
                document.getElementById('email').value = email;
            }
        }

        document.getElementById('nama_depan').addEventListener('input', generateEmail);
        document.getElementById('nama_belakang').addEventListener('input', generateEmail);

        document.getElementById('pay-button').addEventListener('click', function() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (password !== passwordConfirmation) {
                alert('Password tidak sama!');
                return;
            }

            const data = {
                nama_depan: document.getElementById('nama_depan').value,
                nama_belakang: document.getElementById('nama_belakang').value,
                email: document.getElementById('email').value,
                phone_number: document.getElementById('phone_number').value,
                address: document.getElementById('address').value,
                nik: document.getElementById('nik').value,
                course_id: document.getElementById('course_id').value,
                password: password,
            };

            if (!data.course_id) {
                alert('Silakan pilih course terlebih dahulu.');
                return;
            }

            for (const key in data) {
                if (!data[key]) {
                    alert(`Harap isi ${key.replace('_', ' ')} terlebih dahulu.`);
                    return;
                }
            }

            fetch("{{ route('register.token') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(data)
                })
                .then(async res => {
                    if (!res.ok) {
                        const errorData = await res.json();
                        alert(errorData.error || 'Terjadi kesalahan.');
                        return;
                    }
                    return res.json();
                })
                .then(res => {
                    if (res?.token) {
                        snap.pay(res.token, {
                            onSuccess: function(result) {
                                fetch("{{ route('register.callback') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        },
                                        body: JSON.stringify({
                                            ...data,
                                            midtrans_result: result
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        alert(
                                            'Terima kasih telah mendaftar! Pembayaran berhasil.');
                                    });
                            },
                            onError: function(result) {
                                alert('Terjadi error.');
                                console.log(result);
                            },
                            onClose: function() {
                                alert('Popup ditutup.');
                            }
                        });
                    }
                });
        });
    </script>

</body>

</html>
