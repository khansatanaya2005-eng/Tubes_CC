<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Menu Kuliner') }}</span>
            <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest bg-luxury-gold/10 px-4 py-1.5 rounded-full border border-luxury-gold/20">
                {{ session('nama_pelanggan', 'TAMU') }} - Meja {{ session('nomor_meja', '') }}
            </span>
        </div>
    </x-slot>

    <!-- Hero Banner -->
    <div class="relative w-full h-[240px] md:h-[320px] rounded-3xl overflow-hidden mb-12 shadow-2xl">
        <div class="absolute inset-0 bg-luxury-charcoal">
            <!-- Subtle pattern overlay -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent bg-[length:20px_20px]"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        <div class="absolute inset-0 p-8 md:p-12 flex flex-col justify-end">
            <span class="text-luxury-gold text-xs font-bold uppercase tracking-[0.3em] mb-3">Selamat Datang di TraciF</span>
            <h2 class="text-3xl md:text-5xl font-sans font-bold text-white tracking-[-0.02em] leading-tight mb-2">Pengalaman Kuliner<br>Istimewa</h2>
            <p class="text-white/70 text-sm md:text-base max-w-xl">Menu musiman pilihan yang disiapkan dengan bahan-bahan terbaik oleh koki ahli kami.</p>
        </div>
        <div class="absolute top-8 right-8">
            <span class="inline-flex items-center space-x-2 bg-black/40 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full text-white shadow-xl">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-widest">{{ session('nama_pelanggan', 'TAMU') }} - Meja {{ session('nomor_meja', '') }}</span>
            </span>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="mb-8">
        <h3 class="text-2xl font-sans font-bold text-luxury-charcoal">Pilihan Menu</h3>
    </div>

    @php
        $defaultDescriptions = [
            'Coffee' => 'Kopi pilihan dari biji kopi panggang terbaik, diseduh sempurna untuk menghadirkan aroma pekat dan rasa yang khas.',
            'Non Coffee' => 'Pilihan minuman segar tanpa kafein yang dibuat dari paduan bahan-bahan premium untuk melepas dahaga Anda.',
            'Tea' => 'Seduhan teh artisan murni dengan aroma menenangkan, memberikan sensasi relaksasi di setiap tegukan.',
            'Signature' => 'Kreasi eksklusif TraciF dengan racikan rahasia koki, memadukan cita rasa unik yang tidak terlupakan.',
            'Mocktails' => 'Kombinasi buah segar dan soda premium yang diracik secara estetik untuk sensasi kesegaran maksimal.',
            'Main Course' => 'Hidangan utama berkelas yang dimasak dengan teknik kuliner modern dan bumbu rempah pilihan yang kaya rasa.',
            'Dessert' => 'Pencuci mulut manis nan lembut dengan tekstur yang lumer di mulut, menutup momen bersantap Anda dengan sempurna.',
            'Snack' => 'Camilan ringan dengan tekstur renyah dan rasa gurih yang dibuat fresh untuk teman bersantai Anda.',
            'Appetizer' => 'Hidangan pembuka porsi pas yang diracik khusus untuk memanjakan dan menggugah selera makan Anda.',
            'Lainnya' => 'Sajian istimewa yang diolah dengan bahan-bahan pilihan terbaik, menghadirkan cita rasa yang memanjakan lidah Anda.'
        ];
    @endphp

    @forelse($produksGrouped as $kategori => $produks)
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-bold text-luxury-gold uppercase tracking-widest">{{ $kategori }}</h4>
                <div class="h-px flex-1 bg-slate-200 mx-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach($produks as $produk)
                    <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8 flex flex-col justify-between group hover:shadow-[0_8px_30px_-10px_rgba(184,148,91,0.15)] hover:border-luxury-gold/30 transition-all duration-300 relative overflow-hidden">
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-luxury-gold/10 to-transparent rounded-bl-[40px] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        <div class="mb-8">
                            <div class="flex flex-col mb-3">
                                <h3 class="text-xl font-sans font-bold text-luxury-charcoal group-hover:text-luxury-gold transition-colors duration-300 mb-1.5 leading-snug">{{ $produk->nama_produk }}</h3>
                                <span class="text-lg font-bold text-luxury-gold">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-12 h-0.5 bg-luxury-gold/30 mb-4 group-hover:w-20 transition-all duration-500"></div>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $produk->deskripsi_produk ?? ($defaultDescriptions[$kategori] ?? $defaultDescriptions['Lainnya']) }}</p>
                        </div>

                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                                Tersedia
                            </div>

                            <div x-data="{ 
                                jumlah: 1, 
                                submitting: false,
                                addToCart() {
                                    if(this.submitting) return;
                                    this.submitting = true;
                                    fetch('{{ route('pelanggan.cart.add', $produk->id_produk) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({ jumlah: this.jumlah })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if(data.success) {
                                            window.dispatchEvent(new CustomEvent('notify', { detail: data.message }));
                                        }
                                    })
                                    .finally(() => {
                                        this.submitting = false;
                                        this.jumlah = 1; // Reset jumlah setelah berhasil
                                    });
                                }
                            }">
                                <div class="flex items-center space-x-3">
                                    <input type="number" x-model="jumlah" min="1" class="w-20 h-12 text-center border-slate-200 rounded-xl focus:ring-luxury-gold focus:border-luxury-gold bg-slate-50 text-luxury-charcoal font-bold outline-none transition-all">
                                    <button @click="addToCart()" :disabled="submitting" :class="{'opacity-70 cursor-not-allowed': submitting}" class="flex-1 h-12 bg-luxury-charcoal hover:bg-black text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md flex items-center justify-center space-x-2">
                                        <span x-show="!submitting">Pesan Sekarang</span>
                                        <span x-show="submitting" x-cloak>Memproses...</span>
                                        <svg x-show="!submitting" class="w-4 h-4 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <svg x-show="submitting" x-cloak class="w-4 h-4 text-luxury-gold animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-12 text-slate-500">
            <p>Menu saat ini sedang tidak tersedia. Silakan periksa kembali nanti.</p>
        </div>
    @endforelse
</x-app-layout>
