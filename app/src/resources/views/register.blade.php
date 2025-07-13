{{-- resources/views/register.blade.php --}}
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
            background-image: url('/front/assets/img/hero-carousel/hero-carousel-4.jpg');
            background-size: cover;
            background-position: center;
        }

        .custom-eye {
            top: 10%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .popup-container {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            max-width: 400px;
            width: 90%;
            background-color: #fff;
            border: 1px solid #dee2e6;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            animation: fadeInDown 0.5s ease;
        }

        .popup-box strong {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }

        .popup-box p {
            margin: 0;
            color: #555;
        }

        .popup-container.error {
            border-left: 5px solid #dc3545;
        }

        .popup-container.success {
            border-left: 5px solid #28a745;
        }

        .popup-container.warning {
            border-left: 5px solid #ffc107;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
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
                                    <input type="password" id="password" class="form-control pe-5" required>
                                    <span class="toggle-password position-absolute custom-eye" data-target="password">
                                        <img src="/front/images/eye-open.svg" alt="Lihat password" width="20" />
                                    </span>
                                </div>

                                <div class="col-md-6 position-relative">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" class="form-control pe-5"
                                        required>
                                    <span class="toggle-password position-absolute custom-eye"
                                        data-target="password_confirmation">
                                        <img src="/front/images/eye-open.svg" alt="Lihat password" width="20" />
                                    </span>
                                    <small id="password-match-error" class="text-danger d-none mt-1">Password tidak
                                        sesuai</small>
                                </div>
                                <div class="col-md-6">
                                    <label>No. HP</label>
                                    <input type="text" id="phone_number" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Kode OTP (via WhatsApp)</label>
                                    <div class="input-group">
                                        <input type="text" id="otp" class="form-control"
                                            placeholder="Masukkan OTP" required>
                                        <button type="button" id="generate-otp"
                                            class="btn btn-outline-secondary">Kirim OTP</button>
                                    </div>
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

                            <br>
                            <div class="form-group mb-4 position-relative">
                                <label id="captcha-question">Human Verification (Generate Verify terlebih
                                    dahulu)</label>
                                <input type="number" name="captcha" id="captcha" required
                                    class="form-control pe-5" placeholder="Masukkan jawaban">
                                <div id="captcha-error" class="text-danger mt-1" style="display:none;"></div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="button" id="verify-button"
                                    class="btn btn-secondary px-4 py-2">Generate Verify</button>
                            </div>
                            <br>

                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="send_invoice_checkbox">
                                    <label class="form-check-label" for="send_invoice_checkbox">
                                        Butuh Invoice?
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 mt-2 d-none" id="invoice_email_container">
                                <label>Email</label>
                                <input type="email" id="invoice_email" class="form-control"
                                    placeholder="contoh@gmail.com">
                                <small class="text-danger d-none" id="invalid-invoice-email">Email harus diisi dan
                                    diakhiri @gmail.com</small>
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

    <!-- <footer id="footer" class="footer dark-background">
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
    </footer> -->

    <div id="custom-popup" class="popup-container d-none">
        <div class="popup-box">
            <strong id="popup-title">Judul</strong>
            <p id="popup-message">Pesan konten popup.</p>
        </div>
    </div>

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
        let captchaA = 0;
        let captchaB = 0;

        function generateNewCaptcha() {
            captchaA = Math.floor(Math.random() * 10) + 1;
            captchaB = Math.floor(Math.random() * 10) + 1;

            document.getElementById('captcha-question').innerText = `What is ${captchaA} + ${captchaB}?`;
            document.getElementById('captcha').value = '';
            document.getElementById('captcha-error').style.display = 'none';
        }

        document.getElementById('verify-button').addEventListener('click', function() {
            generateNewCaptcha();
        });

        function isCaptchaCorrect() {
            const userAnswer = parseInt(document.getElementById('captcha').value);
            const expected = captchaA + captchaB;

            if (isNaN(userAnswer) || userAnswer !== expected) {
                const errorDiv = document.getElementById('captcha-error');
                errorDiv.innerText = 'Jawaban salah. Soal diganti, silakan coba lagi.';
                errorDiv.style.display = 'block';

                // 🎯 GANTI soal baru jika salah
                generateNewCaptcha();

                errorDiv.innerText = 'Jawaban salah. Soal diganti, silakan coba lagi.';
                errorDiv.style.display = 'block';

                return false;
            }

            document.getElementById('captcha-error').style.display = 'none';
            return true;
        }
    </script>

    <script>
        const checkbox = document.getElementById('send_invoice_checkbox');
        const emailContainer = document.getElementById('invoice_email_container');
        const invoiceEmailInput = document.getElementById('invoice_email');
        const invalidEmailText = document.getElementById('invalid-invoice-email');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                emailContainer.classList.remove('d-none');
            } else {
                emailContainer.classList.add('d-none');
                invoiceEmailInput.value = '';
                invalidEmailText.classList.add('d-none');
            }
        });
    </script>

    <script>
        document.getElementById('generate-otp').addEventListener('click', function() {
            const phoneNumber = document.getElementById('phone_number').value;

            if (!phoneNumber) {
                showPopup('warning', 'Kolom Nomor HP', 'Harap masukkan nomor HP sebelum mengirim OTP.');
                return;
            }

            fetch("{{ route('otp.generate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        phone_number: phoneNumber
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        showPopup('error', 'OTP Gagal', data.error);
                    } else {
                        showPopup('success', 'OTP Terkirim', 'OTP telah dikirim ke WhatsApp Anda.');
                    }
                })
                .catch(() => {
                    showPopup('error', 'OTP Gagal', 'Terjadi kesalahan saat mengirim OTP.');
                });
        });

        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const img = this.querySelector('img');

                if (input.type === 'password') {
                    input.type = 'text';
                    img.src = '/front/images/eye-striked.svg';
                    img.alt = 'Sembunyikan password';
                } else {
                    input.type = 'password';
                    img.src = '/front/images/eye-open.svg';
                    img.alt = 'Lihat password';
                }
            });
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirm = this.value;
            const error = document.getElementById('password-match-error');

            if (confirm && confirm !== password) {
                error.classList.remove('d-none');
            } else {
                error.classList.add('d-none');
            }
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
            if (!isCaptchaCorrect()) {
                return;
            }
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (password !== passwordConfirmation) {
                showPopup('warning', 'Password Tidak Cocok', 'Password dan konfirmasi password tidak cocok.');
                return;
            }

            const sendInvoice = document.getElementById('send_invoice_checkbox').checked;
            const invoiceEmail = document.getElementById('invoice_email').value.trim();

            // validasi hanya jika checkbox dicentang
            if (sendInvoice) {
                if (!invoiceEmail || !invoiceEmail.endsWith('@gmail.com')) {
                    document.getElementById('invalid-invoice-email').classList.remove('d-none');
                    return;
                }
            } else {
                // kalau tidak diceklis, pastikan warning disembunyikan
                document.getElementById('invalid-invoice-email').classList.add('d-none');
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
                send_invoice_to: sendInvoice ? invoiceEmail : null,
                otp: document.getElementById('otp').value,
            };

            if (!data.course_id) {
                showPopup('warning', 'Kolom Course', 'Silakan pilih course terlebih dahulu.');
                return;
            }

            for (const key in data) {
                // Abaikan validasi send_invoice_to jika tidak diceklis
                if (key === 'send_invoice_to' && !sendInvoice) continue;

                if (!data[key]) {
                    showPopup('warning', `Kolom ${key.replace('_', ' ')}`, `Harap isi ${key.replace('_', ' ')} terlebih dahulu.`);
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
                        showPopup('error', 'Kesalahan', errorData.error || 'Terjadi kesalahan.');
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
                                        showPopup('success', 'Pembayaran Berhasil', 'Anda telah berhasil mendaftar dan melakukan pembayaran.');
                                    });
                            },
                            onError: function(result) {
                                alert('Terjadi error.');
                                showPopup('error', 'Pembayaran', 'Terjadi kesalahan saat memproses pembayaran.');
                            },
                            onClose: function() {
                                showPopup('warning', 'Pembayaran', 'Pembayaran dibatalkan karena popup ditutup.');
                            }
                        });
                    }
                });
        });

        function showPopup(type = 'success', title = 'Info', message = '', duration = 4000) {
            const popup = document.getElementById('custom-popup');
            const titleEl = document.getElementById('popup-title');
            const messageEl = document.getElementById('popup-message');

            // Bersihkan class sebelumnya
            popup.className = 'popup-container';

            if (['success', 'error', 'warning'].includes(type)) {
                popup.classList.add(type);
            }

            titleEl.textContent = title;
            messageEl.textContent = message;
            popup.classList.remove('d-none');

            // Auto close after `duration` ms
            setTimeout(() => {
                popup.classList.add('d-none');
            }, duration);
        }
    </script>

</body>

</html>
