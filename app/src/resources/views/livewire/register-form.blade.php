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
                                <textarea class="form-control" wire:model.defer="address" rows="2"
                                    placeholder="Alamat lengkap"></textarea>
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

                        <button type="submit" class="btn-submit"
                            style="padding: 8px 28px; color: white; background-color: #18d26e; border: 2px solid #18d26e; border-radius: 9px;">
                            Daftar & Bayar Sekarang
                        </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

{{-- Snap.js Midtrans --}}
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    window.addEventListener('open-midtrans-snap', function (event) {
        snap.pay(event.detail.token, {
            onSuccess: function (result) {
                Livewire.emit('paymentSuccess', result);
            },
            onPending: function (result) {
                alert("Transaksi masih pending.");
            },
            onError: function (result) {
                alert("Pembayaran gagal.");
            },
            onClose: function () {
                alert("Popup ditutup tanpa menyelesaikan pembayaran.");
            }
        });
    });
</script>