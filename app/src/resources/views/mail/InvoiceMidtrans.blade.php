@component('mail::message')
# Invoice Pembelian Kursus

Halo **{{ $user->name }}**,

Terima kasih telah melakukan pembelian kursus **"{{ $course->name }}"**. Pembayaran Anda telah berhasil diproses.

Berikut adalah detail transaksi Anda:

-   **Order ID:** {{ $transaction->midtrans_order_id }}
-   **ID Transaksi Midtrans:** {{ $transaction->midtrans_transaction_id }}
-   **Nama Kursus:** {{ $course->name }}
-   **Harga:** Rp {{ number_format($transaction->amount, 0, ',', '.') }}
-   **Metode Pembayaran:** {{ $transaction->payment_method }}
-   **Status Transaksi:** {{ $transaction->transaction_status }}
-   **Waktu Transaksi:** {{ \Carbon\Carbon::parse($transaction->transaction_time)->format('d F Y H:i:s') }}

Anda sekarang memiliki akses penuh ke kursus **"{{ $course->name }}"**.

@component('mail::button', ['url' => url('/sso/login')])
Akses Kursus Anda
@endcomponent

Terima kasih,
{{ config('app.name') }}
@endcomponent