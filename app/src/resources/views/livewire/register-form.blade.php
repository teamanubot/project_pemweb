<style>
    body {
        background-color: black !important;
    }
</style>

<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow" style="background-color: #f8f9fa; border-radius: 12px;">
                <div class="card-body p-5">
                    <h3 class="mb-4 text-center fw-bold">Formulir Pendaftaran</h3>

                    <form wire:submit.prevent="register">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" wire:model.defer="name"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" wire:model.defer="email"
                                    placeholder="Alamat email aktif">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" class="form-control" wire:model.defer="phone_number"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" wire:model.defer="nik"
                                    placeholder="Nomor Induk Kependudukan">
                                @error('nik')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" wire:model.defer="address" rows="2" placeholder="Alamat lengkap"></textarea>
                                @error('address')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pilih Course</label>
                                <select class="form-select" wire:model.defer="course_id">
                                    <option value="">-- Pilih Course --</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-5 py-2">
                                Daftar & Bayar Sekarang
                            </button>
                        </div>
                    </form>
                    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
                        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

                    <script>
                        window.addEventListener('open-midtrans-snap', function(event) {
                            const snapToken = event.detail.token;

                            snap.pay(snapToken, {
                                onSuccess: function(result) {
                                    alert("Pembayaran berhasil!");
                                    console.log(result);
                                    // TODO: redirect ke halaman sukses jika mau
                                },
                                onPending: function(result) {
                                    alert("Transaksi belum dibayar.");
                                    console.log(result);
                                },
                                onError: function(result) {
                                    alert("Pembayaran gagal.");
                                    console.error(result);
                                },
                                onClose: function() {
                                    alert("Popup ditutup tanpa menyelesaikan pembayaran.");
                                }
                            });
                        });
                    </script>


                </div>
            </div>

        </div>
    </div>
</div>
