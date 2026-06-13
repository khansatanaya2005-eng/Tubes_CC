<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Pembayaran QRIS') }}</span>
            <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest bg-luxury-gold/10 px-4 py-1.5 rounded-full border border-luxury-gold/20">
                {{ session('nama_pelanggan', 'TAMU') }} - Meja {{ session('nomor_meja', '') }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto" x-data="{
        timeLeft: 60,
        timer: null,
        init() {
            this.timer = setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                } else {
                    clearInterval(this.timer);
                    window.location.href = '{{ route('pelanggan.orders') }}';
                }
            }, 1000);
        },
        get formattedTime() {
            const minutes = Math.floor(this.timeLeft / 60);
            const seconds = this.timeLeft % 60;
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    }">
        <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden flex flex-col md:flex-row">
            
            <!-- Order Details Section -->
            <div class="p-8 md:p-12 md:w-1/2 border-b md:border-b-0 md:border-r border-slate-100 bg-slate-50/50">
                <h4 class="text-2xl font-sans font-bold text-luxury-charcoal mb-2">Rincian Pesanan</h4>
                <p class="text-slate-500 text-sm mb-8">Mohon periksa kembali pesanan Anda sebelum melakukan pembayaran.</p>

                <div class="space-y-4 mb-8 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse ($myOrders as $transaksi)
                        @foreach($transaksi->detailPenjualans as $detail)
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="font-bold text-slate-800">{{ $detail->produk->nama_produk ?? 'Hidangan Tidak Dikenal' }}</h5>
                                    <p class="text-xs text-slate-500">{{ $detail->jumlah_produk }}x @ Rp {{ number_format($detail->harga_satuan_saat_transaksi, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-medium text-slate-700">Rp {{ number_format($detail->subtotal_produk, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @empty
                        <p class="text-slate-500 italic text-sm">Tidak ada pesanan.</p>
                    @endforelse
                </div>

                <div class="pt-6 border-t border-slate-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-slate-600">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-luxury-gold">Rp {{ number_format($totalPayment, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- QRIS Section -->
            <div class="p-8 md:p-12 md:w-1/2 flex flex-col items-center justify-center text-center">
                <div class="mb-6 w-full max-w-[240px] bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-xl relative group">
                    <!-- Dummy QR Code SVG -->
                    <svg class="w-full h-auto text-luxury-charcoal" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10 10h30v30H10V10zm5 5v20h20V15H15zM60 10h30v30H60V10zm5 5v20h20V15H65zM10 60h30v30H10V60zm5 5v20h20V65H15zM20 20h10v10H20V20zm50 0h10v10H70V20zm-50 50h10v10H20V70zm40-20h10v10H60V50zm10 10h10v10H70V60zm-10 10h10v10H60V70zm20-20h10v10H80V50zm0 20h10v10H80V70zm-10 10h10v10H70V80z"/>
                      <rect x="45" y="45" width="10" height="10" fill="currentColor"/>
                      <rect x="80" y="80" width="10" height="10" fill="currentColor"/>
                      <rect x="45" y="80" width="10" height="10" fill="currentColor"/>
                    </svg>
                    <div class="absolute inset-0 bg-white/60 backdrop-blur-sm rounded-3xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-600">Scan via E-Wallet/M-Banking</span>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-luxury-charcoal mb-2">Scan QRIS untuk Membayar</h3>
                <p class="text-sm text-slate-500 mb-8 max-w-xs">Silakan scan kode QR di atas menggunakan aplikasi E-Wallet atau M-Banking Anda.</p>

                <div class="flex items-center space-x-3 mb-8">
                    <svg class="w-5 h-5 text-luxury-gold animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-medium text-slate-600">Batas Waktu: <span class="font-bold text-rose-500 text-lg ml-1" x-text="formattedTime">01:00</span></span>
                </div>
                
                <form action="{{ route('pelanggan.qris.pay') }}" method="POST" class="w-full mb-3">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-emerald-500 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/30 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Simulasi Bayar QRIS</span>
                    </button>
                </form>

                <a href="{{ route('pelanggan.orders') }}" class="w-full py-4 bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-colors text-center inline-block">
                    Batalkan & Kembali
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
