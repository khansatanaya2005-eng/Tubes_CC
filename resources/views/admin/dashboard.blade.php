<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end">
            <div>
                @if($role === 'pelanggan')
                    <span class="text-sm font-sans font-medium text-slate-500 uppercase tracking-widest mb-1 block">Customer Portal</span>
                    <span class="text-4xl font-sans font-bold text-luxury-charcoal tracking-[-0.02em]">Selamat datang kembali, Pelanggan</span>
                    <p class="text-sm font-sans text-slate-500 mt-2">Berikut adalah ringkasan pesanan dan riwayat transaksi Anda.</p>
                @else
                    <span class="text-sm font-sans font-medium text-slate-500 uppercase tracking-widest mb-1 block">Dashboard</span>
                    <span class="text-4xl font-sans font-bold text-luxury-charcoal tracking-[-0.02em]">Selamat datang kembali, {{ $adminName }}</span>
                    <p class="text-sm font-sans text-slate-500 mt-2">Berikut ringkasan performa bisnis Anda hari ini.</p>
                @endif
            </div>
            
            <div class="hidden md:flex items-center space-x-3">
                @if($role === 'kasir')
                    <!-- Category Dropdown Form -->
                    <form action="{{ route('dashboard') }}" method="GET" class="relative">
                        <div class="flex items-center space-x-2 bg-white border border-slate-200 rounded-lg px-3 py-2 shadow-sm cursor-pointer hover:border-luxury-gold transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            <select name="filter" onchange="this.form.submit()" class="text-sm font-sans font-medium text-luxury-charcoal bg-transparent border-none focus:ring-0 cursor-pointer pr-6 py-0 appearance-none outline-none">
                                <option value="" disabled {{ !$filterCategoryVal ? 'selected' : '' }}>Filter Kategori</option>
                                <option value="today" {{ $filterCategoryVal == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="yesterday" {{ $filterCategoryVal == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                                <option value="this_week" {{ $filterCategoryVal == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="this_month" {{ $filterCategoryVal == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="this_year" {{ $filterCategoryVal == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                                <option value="all_time" {{ $filterCategoryVal == 'all_time' ? 'selected' : '' }}>Semua Waktu</option>
                            </select>
                        </div>
                    </form>

                    <div class="text-slate-300 font-bold">|</div>

                    <!-- Specific Date Form -->
                    <form action="{{ route('dashboard') }}" method="GET" class="relative">
                        <div class="flex items-center space-x-2 bg-white border border-slate-200 rounded-lg px-3 py-2 shadow-sm cursor-pointer hover:border-luxury-gold transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <input type="date" name="filter_date" value="{{ $filterDateVal ?? '' }}" onchange="this.form.submit()" class="text-sm font-sans font-medium text-luxury-charcoal bg-transparent border-none focus:ring-0 cursor-pointer p-0 m-0 outline-none">
                        </div>
                    </form>
                @else
                    <div class="flex items-center space-x-2 bg-white border border-slate-200 rounded-lg px-4 py-2 shadow-sm">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-sans font-medium text-luxury-charcoal">{{ now()->translatedFormat('d M Y') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <!-- ADMIN & KASIR VIEW -->
    @if($role === 'admin' || $role === 'kasir')
        
        <!-- 4 KPI CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Revenue Today / Processed Orders -->
            <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex items-start space-x-4 hover:shadow-[0_8px_30px_-10px_rgba(184,148,91,0.15)] transition-all duration-300">
                <div class="w-14 h-14 rounded-full bg-luxury-charcoal flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-6 h-6 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    @if($role === 'admin')
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pendapatan Hari Ini</h4>
                        <p class="text-2xl font-sans font-bold text-luxury-charcoal mb-2">Rp {{ number_format($penghasilanHariIni ?? 0, 0, ',', '.') }}</p>
                    @else
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Diproses ({{ $filterLabel ?? 'Hari Ini' }})</h4>
                        <p class="text-2xl font-sans font-bold text-luxury-charcoal mb-2">{{ $pesananDiproses ?? 0 }}</p>
                    @endif
                    <div class="flex items-center text-[11px] font-medium">
                        <span class="text-emerald-600 flex items-center"><svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Orders Today -->
            <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex items-start space-x-4 hover:shadow-[0_8px_30px_-10px_rgba(184,148,91,0.15)] transition-all duration-300">
                <div class="w-14 h-14 rounded-full bg-luxury-charcoal flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-6 h-6 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    @if($role === 'admin')
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Hari Ini</h4>
                    @else
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pesanan ({{ $filterLabel ?? 'Hari Ini' }})</h4>
                    @endif
                    <p class="text-2xl font-sans font-bold text-luxury-charcoal mb-2">{{ $pesananHariIni ?? 0 }}</p>
                    <div class="flex items-center text-[11px] font-medium">
                        <span class="text-emerald-600 flex items-center"><svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Products Sold -->
            <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex items-start space-x-4 hover:shadow-[0_8px_30px_-10px_rgba(184,148,91,0.15)] transition-all duration-300">
                <div class="w-14 h-14 rounded-full bg-luxury-charcoal flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-6 h-6 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Produk</h4>
                    <p class="text-2xl font-sans font-bold text-luxury-charcoal mb-2">{{ $totalProducts ?? 0 }}</p>
                    <div class="flex items-center text-[11px] font-medium">
                        <span class="text-emerald-600 flex items-center"><svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> Tersedia</span>
                        <span class="text-slate-400 ml-1">di katalog</span>
                    </div>
                </div>
            </div>

            <!-- New Customers -->
            <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex items-start space-x-4 hover:shadow-[0_8px_30px_-10px_rgba(184,148,91,0.15)] transition-all duration-300">
                <div class="w-14 h-14 rounded-full bg-luxury-charcoal flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-6 h-6 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pelanggan</h4>
                    <p class="text-2xl font-sans font-bold text-luxury-charcoal mb-2">{{ $totalCustomers ?? 0 }}</p>
                    <div class="flex items-center text-[11px] font-medium">
                        <span class="text-emerald-600 flex items-center"><svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> 4.2%</span>
                        <span class="text-slate-400 ml-1">dari kemarin</span>
                    </div>
                </div>
            </div>
        </div>

        @if($role === 'admin')
        <!-- ROW 1: 3 COLUMNS -->
        <div class="grid grid-cols-12 gap-6 mb-8">
            <!-- Chart (col-span-6) -->
            <div class="col-span-12 lg:col-span-6 bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-sans font-bold text-lg text-luxury-charcoal">Grafik Pendapatan</h3>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 flex items-center text-xs font-medium text-slate-600 cursor-pointer">
                        7 Hari Terakhir
                        <svg class="w-3 h-3 ml-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <div class="relative flex-1 min-h-[250px]"> 
                    <canvas id="grafikPenghasilan"></canvas>
                </div>
            </div>

            <!-- Top Products (col-span-3) -->
            <div class="col-span-12 lg:col-span-3 bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-sans font-bold text-lg text-luxury-charcoal">Top Produk</h3>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-[10px] font-medium text-slate-600">7 Hari</div>
                </div>
                <div class="space-y-4 flex-1">
                    @forelse($topProducts ?? [] as $idx => $prod)
                        <div class="flex items-center space-x-3 group">
                            <!-- Placeholder Image / Initial -->
                            <div class="w-10 h-10 rounded-lg bg-luxury-ivory border border-luxury-gold/30 flex items-center justify-center text-luxury-gold font-bold font-sans shadow-sm">
                                {{ substr($prod->nama_produk, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between mb-1">
                                    <h4 class="text-sm font-bold text-luxury-charcoal leading-tight truncate group-hover:text-luxury-gold transition-colors">{{ $prod->nama_produk }}</h4>
                                </div>
                                <div class="text-xs text-slate-500 font-medium">{{ $prod->total_terjual }} porsi</div>
                                <!-- Progress Bar mimic -->
                                <div class="w-full bg-slate-100 rounded-full h-1 mt-1.5">
                                    <div class="bg-luxury-gold h-1 rounded-full" style="width: {{ min(($prod->total_terjual / 100) * 100, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-slate-400">
                            <svg class="w-12 h-12 mb-2 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="text-sm font-medium">Belum ada data tersedia.</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities (col-span-3) -->
            <div class="col-span-12 lg:col-span-3 bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-sans font-bold text-lg text-luxury-charcoal">Aktivitas Terbaru</h3>
                </div>
                <div class="space-y-5 flex-1 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    
                    @forelse($transaksiTerbaru->take(4) as $idx => $trx)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <!-- Icon -->
                            <div class="flex items-center justify-center w-8 h-8 rounded-full border border-white bg-emerald-100 text-emerald-600 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                <svg class="fill-current w-3 h-3" viewBox="0 0 12 12"><path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"></path></svg>
                            </div>
                            <!-- Card -->
                            <div class="w-[calc(100%-3rem)] md:w-[calc(50%-2rem)]">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-luxury-charcoal">Pembayaran diterima</span>
                                    <span class="text-[10px] text-slate-500 font-medium truncate">#{{ str_pad($trx->id_penjualan, 5, '0', STR_PAD_LEFT) }}</span>
                                    <time class="text-[9px] text-slate-400 font-medium">{{ $trx->waktu_transaksi->diffForHumans() }}</time>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-sm font-medium text-slate-400">Belum ada aktivitas.</div>
                    @endforelse
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.riwayatpenjualan.index') }}" class="text-xs font-bold text-luxury-gold hover:text-luxury-charcoal transition-colors">Lihat semua aktivitas &rarr;</a>
                </div>
            </div>
        </div>

        <!-- ROW 2: TABLE & HEALTH -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Table (col-span-8) -->
            <div class="col-span-12 lg:col-span-8 bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-sans font-bold text-lg text-luxury-charcoal">Ringkasan Penjualan</h3>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Search..." class="pl-9 pr-4 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold outline-none w-48 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-luxury-ivory/50">
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 sticky top-0">ID Transaksi</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 sticky top-0">Waktu</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 sticky top-0">Pelanggan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 sticky top-0">Status</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right sticky top-0">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($transaksiTerbaru as $transaksi)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4 text-sm font-bold text-luxury-charcoal">
                                        <a href="{{ route('admin.riwayatpenjualan.show', $transaksi->id_penjualan) }}" class="hover:text-luxury-gold transition-colors">
                                            #{{ str_pad($transaksi->id_penjualan, 5, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500 font-medium">{{ $transaksi->waktu_transaksi->format('d M, H:i') }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-luxury-charcoal">{{ $transaksi->pelanggan->nama_pelanggan ?? 'Walk-in' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-luxury-charcoal text-right">Rp {{ number_format($transaksi->total_harga_penjualan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm font-medium text-slate-400">Belum ada transaksi terbaru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                    <!-- Pagination mock -->
                    <div class="flex items-center space-x-2">
                        <button class="w-7 h-7 rounded bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-luxury-charcoal shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <span class="text-xs font-bold text-luxury-charcoal px-2">1 / 1</span>
                        <button class="w-7 h-7 rounded bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-luxury-charcoal shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                    </div>
                </div>
            </div>

            <!-- System Health (col-span-4) -->
            <div class="col-span-12 lg:col-span-4 bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-6 flex flex-col" x-data="healthMonitor()" x-init="checkHealth()">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-sans font-bold text-lg text-luxury-charcoal">System Health Monitor</h3>
                </div>
                
                <div class="space-y-4 flex-1">
                    <!-- App Status -->
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                        <span class="text-xs font-bold text-slate-600">Application Status</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Healthy</span>
                            <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)] animate-pulse"></div>
                        </div>
                    </div>
                    
                    <!-- Database -->
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                        <span class="text-xs font-bold text-slate-600">Database Connection</span>
                        <div class="flex items-center space-x-2" :class="dbStatus === 'connected' ? 'text-emerald-600' : 'text-red-500'">
                            <span class="text-[10px] font-bold uppercase tracking-wider" x-text="dbStatus === 'connected' ? 'Healthy' : 'Error'"></span>
                            <div class="w-2 h-2 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.8)]" :class="dbStatus === 'connected' ? 'bg-emerald-500 animate-pulse' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.8)]'"></div>
                        </div>
                    </div>

                    <!-- Cache -->
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                        <span class="text-xs font-bold text-slate-600">Cache (Redis/File)</span>
                        <div class="flex items-center space-x-2" :class="cacheStatus === 'connected' ? 'text-emerald-600' : 'text-red-500'">
                            <span class="text-[10px] font-bold uppercase tracking-wider" x-text="cacheStatus === 'connected' ? 'Healthy' : 'Error'"></span>
                            <div class="w-2 h-2 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.8)]" :class="cacheStatus === 'connected' ? 'bg-emerald-500 animate-pulse' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.8)]'"></div>
                        </div>
                    </div>
                    
                    <!-- Storage -->
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                        <span class="text-xs font-bold text-slate-600">Storage System</span>
                        <div class="flex items-center space-x-2" :class="storageStatus === 'writable' ? 'text-emerald-600' : 'text-amber-500'">
                            <span class="text-[10px] font-bold uppercase tracking-wider" x-text="storageStatus === 'writable' ? 'Healthy' : 'Warning'"></span>
                            <div class="w-2 h-2 rounded-full" :class="storageStatus === 'writable' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]' : 'bg-amber-500'"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="#" class="text-xs font-bold text-luxury-gold hover:text-luxury-charcoal transition-colors">Lihat detail system health &rarr;</a>
                </div>
            </div>
        </div>
        @endif
    @endif

    <!-- PELANGGAN VIEW -->
    @if($role === 'pelanggan')
        <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-12 flex flex-col items-center justify-center text-center mt-8">
            <div class="w-20 h-20 bg-luxury-ivory rounded-full flex items-center justify-center mb-6 text-luxury-gold">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
            <h3 class="text-2xl font-sans font-bold text-luxury-charcoal mb-4">Mulai Pesanan Anda</h3>
            <p class="text-slate-500 mb-8 max-w-md font-sans">Silakan masukkan nomor meja Anda untuk mulai memilih menu fine dining kami dan melakukan pemesanan.</p>
            
            @if(session()->has('nomor_meja'))
                <a href="{{ route('pelanggan.katalog') }}" class="px-8 py-4 bg-luxury-gold text-white text-sm font-sans font-bold uppercase tracking-widest rounded-xl hover:bg-yellow-600 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Lanjutkan Pesanan (Meja {{ session('nomor_meja') }})
                </a>
            @else
                <a href="{{ route('pelanggan.meja') }}" class="px-8 py-4 bg-luxury-charcoal text-white text-sm font-sans font-bold uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Masukkan Nomor Meja
                </a>
            @endif
        </div>
    @endif

    @push('scripts')
    @if($role === 'admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        function healthMonitor() {
            return {
                dbStatus: 'checking',
                cacheStatus: 'checking',
                storageStatus: 'checking',
                checkHealth() {
                    fetch('/health')
                        .then(res => res.json())
                        .then(data => {
                            this.dbStatus = data.database;
                            this.cacheStatus = data.cache;
                            this.storageStatus = data.storage;
                        })
                        .catch(() => {
                            this.dbStatus = 'disconnected';
                            this.cacheStatus = 'disconnected';
                            this.storageStatus = 'unwritable';
                        });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const chartDataJson = {!! $chartData ?? '{}' !!};
            const chartData = typeof chartDataJson === 'string' ? JSON.parse(chartDataJson) : chartDataJson;
            
            // Premium Palette
            const gold = '#B8945B';
            const gridColor = '#F1F5F9';

            function createChart(ctxId, type, label, data, color) {
                const ctx = document.getElementById(ctxId);
                if(!ctx) return;
                
                // Create gradient for line chart
                let bgGradient = 'rgba(184, 148, 91, 0.1)';
                if(type === 'line') {
                    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(184, 148, 91, 0.2)');
                    gradient.addColorStop(1, 'rgba(184, 148, 91, 0.0)');
                    bgGradient = gradient;
                }

                new Chart(ctx.getContext('2d'), {
                    type: type,
                    data: {
                        labels: chartData.labels || [],
                        datasets: [{
                            label: label,
                            data: data || [],
                            backgroundColor: bgGradient,
                            borderColor: color,
                            borderWidth: 2,
                            pointBackgroundColor: '#FFFFFF',
                            pointBorderColor: color,
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.4,
                            fill: type === 'line'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { 
                                grid: { color: gridColor, drawBorder: false }, 
                                ticks: { color: '#94a3b8', font: { family: 'Inter', size: 10 } } 
                            },
                            x: { 
                                type: 'time', 
                                time: { unit: 'day', displayFormats: { day: 'd MMM' } },
                                grid: { display: false, drawBorder: false }, 
                                ticks: { color: '#94a3b8', font: { family: 'Inter', size: 10 } } 
                            }
                        }
                    }
                });
            }

            if (chartData.labels && chartData.penghasilan.length > 0) {
                createChart('grafikPenghasilan', 'line', 'Revenue', chartData.penghasilan, gold);
            }
        });
    </script>
    @endif
    @endpush
</x-app-layout>
