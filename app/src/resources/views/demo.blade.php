<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Midtrans Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
    <div class="container">
        <h3 class="mb-4">Demo Midtrans Snap</h3>
        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    </div>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            fetch("{{ route('demo.token') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.token) {
                    snap.pay(data.token, {
                        onSuccess: function(result) {
                            alert('Pembayaran sukses!');
                            console.log(result);
                        },
                        onPending: function(result) {
                            alert('Transaksi pending.');
                            console.log(result);
                        },
                        onError: function(result) {
                            alert('Terjadi error saat pembayaran.');
                            console.log(result);
                        },
                        onClose: function() {
                            alert('Popup ditutup tanpa menyelesaikan pembayaran.');
                        }
                    });
                } else {
                    alert("Token tidak ditemukan.");
                }
            });
        });
    </script>
</body>
</html>