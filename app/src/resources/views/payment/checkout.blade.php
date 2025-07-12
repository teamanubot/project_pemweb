<!DOCTYPE html>
<html>
<head>
    <title>Payment Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
</head>
<body>
    <h1>Loading payment...</h1>

    <script type="text/javascript">
        window.onload = function () {
            snap.pay('{{ $token }}', {
                onSuccess: function(result) {
                    alert("Pembayaran sukses!");
                    console.log(result);
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran...");
                    console.log(result);
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                    console.log(result);
                },
                onClose: function() {
                    alert("Popup ditutup tanpa menyelesaikan pembayaran");
                }
            });
        };
    </script>
</body>
</html>