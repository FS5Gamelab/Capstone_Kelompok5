<a href="{{ route('dashboard.user') }}"> <- Back to Dashboard </a>
        <div>Total Bayar: Rp. {{ number_format($cart->cart_total, 0, ',', '.') }}</div>
        @if ($cart->is_paid == false)
            <button id="pay-button">Pilih Metode Pembayaran</button>
        @endif

        <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function() {
                // SnapToken acquired from previous step
                snap.pay('{{ $cart->snap_token }}', {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        window.location.href = '{{ route('success', $cart->id) }}';
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                    },
                    onClose: function() {
                        /* You may add your own implementation here */
                        alert('you closed the popup without finishing the payment');
                    }
                });
            };
        </script>
