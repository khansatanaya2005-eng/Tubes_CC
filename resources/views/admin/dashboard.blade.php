<x-app-layout>
    <x-slot name="header">
        @if($role === 'admin')
            {{ __('Executive Boardroom') }}
        @elseif($role === 'kasir')
            {{ __('Cashier Desk') }}
        @else
            {{ __('Customer Portal') }}
        @endif
    </x-slot>

    <!-- Welcome Card -->
    <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl shadow-[0_4px_20px_-4px_rgba(200,169,107,0.15)] mb-8 p-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-luxury-ivory to-transparent opacity-50"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h3 class="text-3xl font-serif font-bold text-luxury-charcoal tracking-wide mb-2">
                    Welcome back, {{ $adminName }}
                </h3>
                <p class="text-slate-500 font-medium">Here's what's happening with your account today.</p>
            </div>
            
            @if($role === 'admin')
            <!-- Health Monitoring Widget -->
            <div x-data="healthMonitor()" x-init="checkHealth()" class="hidden md:flex flex-col items-end">
                <span class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-2">System Health</span>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-1" :class="dbStatus === 'connected' ? 'text-luxury-emerald' : 'text-red-500'">
                        <div class="w-2 h-2 rounded-full" :class="dbStatus === 'connected' ? 'bg-luxury-emerald animate-pulse' : 'bg-red-500'"></div>
                        <span class="text-xs font-bold uppercase" x-text="dbStatus === 'connected' ? 'DB OK' : 'DB ERR'"></span>
                    </div>
                    <div class="flex items-center space-x-1" :class="cacheStatus === 'connected' ? 'text-luxury-emerald' : 'text-red-500'">
                        <div class="w-2 h-2 rounded-full" :class="cacheStatus === 'connected' ? 'bg-luxury-emerald animate-pulse' : 'bg-red-500'"></div>
                        <span class="text-xs font-bold uppercase" x-text="cacheStatus === 'connected' ? 'CACHE OK' : 'CACHE ERR'"></span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- ADMIN VIEW -->
    @if($role === 'admin')
        <!-- Executive KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Revenue Today -->
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Revenue Today</h4>
                    <div class="p-2 bg-luxury-gold/10 rounded-lg text-luxury-gold group-hover:bg-luxury-gold group-hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                </div>
                <p class="text-3xl font-serif font-bold text-luxury-charcoal">Rp {{ number_format($penghasilanHariIni, 0, ',', '.') }}</p>
            </div>
            <!-- Orders Today -->
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Orders Today</h4>
                    <div class="p-2 bg-luxury-gold/10 rounded-lg text-luxury-gold group-hover:bg-luxury-gold group-hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></div>
                </div>
                <p class="text-3xl font-serif font-bold text-luxury-charcoal">{{ $pesananHariIni }}</p>
            </div>
            <!-- Revenue Month -->
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Monthly Revenue</h4>
                    <div class="p-2 bg-luxury-gold/10 rounded-lg text-luxury-gold group-hover:bg-luxury-gold group-hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                </div>
                <p class="text-3xl font-serif font-bold text-luxury-charcoal">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
            </div>
            <!-- Orders Month -->
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Monthly Orders</h4>
                    <div class="p-2 bg-luxury-gold/10 rounded-lg text-luxury-gold group-hover:bg-luxury-gold group-hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                </div>
                <p class="text-3xl font-serif font-bold text-luxury-charcoal">{{ $monthlyOrders }}</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="mb-6 bg-luxury-pearl p-4 rounded-xl shadow-sm border border-luxury-gold/30">
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <label for="period_days" class="text-xs font-bold text-slate-500 uppercase tracking-widest">Timeframe:</label>
                <select name="period_days" id="period_days" class="block w-48 border-luxury-gold/50 focus:border-luxury-gold focus:ring-luxury-gold rounded-lg shadow-sm text-sm text-luxury-charcoal bg-transparent py-2">
                    <option value="7" {{ ($currentPeriodDays ?? 7) == 7 ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ ($currentPeriodDays ?? 7) == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ ($currentPeriodDays ?? 7) == 90 ? 'selected' : '' }}>Last 90 Days</option>
                </select>
                <button type="submit" class="px-5 py-2 bg-luxury-charcoal text-luxury-ivory text-xs font-bold tracking-widest uppercase rounded-lg hover:bg-black transition-colors shadow-md">
                    Filter
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-luxury-pearl p-6 rounded-2xl shadow-sm border border-luxury-gold/30">
                <h4 class="text-xl font-serif font-bold text-luxury-charcoal mb-6 border-b border-luxury-gold/20 pb-2">Revenue Growth</h4>
                <div class="relative h-80"> 
                    <canvas id="grafikPenghasilan"></canvas>
                </div>
            </div>
            <div class="bg-luxury-pearl p-6 rounded-2xl shadow-sm border border-luxury-gold/30">
                <h4 class="text-xl font-serif font-bold text-luxury-charcoal mb-6 border-b border-luxury-gold/20 pb-2">Transaction Volume</h4>
                <div class="relative h-80">
                    <canvas id="grafikJumlahPesanan"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Products & Recent Transactions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-luxury-pearl rounded-2xl shadow-sm border border-luxury-gold/30 overflow-hidden">
                <div class="p-6 border-b border-luxury-gold/20">
                    <h4 class="text-xl font-serif font-bold text-luxury-charcoal">Recent Transactions</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-luxury-gold/20">
                        <thead class="bg-luxury-ivory/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Order ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Time</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Customer</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-luxury-pearl divide-y divide-luxury-gold/10">
                            @forelse ($transaksiTerbaru as $transaksi)
                                <tr class="hover:bg-luxury-ivory/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-luxury-gold">
                                        <a href="{{ route('admin.riwayatpenjualan.show', $transaksi->id_penjualan) }}">#{{ str_pad($transaksi->id_penjualan, 5, '0', STR_PAD_LEFT) }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $transaksi->waktu_transaksi->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-medium">{{ $transaksi->pelanggan->nama_pelanggan ?? 'Walk-in Customer' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-luxury-charcoal text-right">Rp {{ number_format($transaksi->total_harga_penjualan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500 italic">No transactions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="bg-luxury-pearl rounded-2xl shadow-sm border border-luxury-gold/30 overflow-hidden">
                <div class="p-6 border-b border-luxury-gold/20">
                    <h4 class="text-xl font-serif font-bold text-luxury-charcoal">Top Products</h4>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($topProducts as $idx => $prod)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="text-lg font-serif font-bold text-luxury-gold">#{{ $idx + 1 }}</span>
                                <span class="text-sm font-semibold text-luxury-charcoal">{{ $prod->nama_produk }}</span>
                            </div>
                            <span class="text-sm text-slate-500 bg-luxury-ivory px-2 py-1 rounded-md">{{ $prod->total_terjual }} sold</span>
                        </div>
                    @empty
                        <div class="text-center text-slate-500 text-sm italic">Not enough data.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <!-- KASIR VIEW -->
    @if($role === 'kasir')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm">
                <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Orders Today</h4>
                <p class="text-4xl font-serif font-bold text-luxury-charcoal">{{ $pesananHariIni }}</p>
            </div>
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm">
                <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Processed By You</h4>
                <p class="text-4xl font-serif font-bold text-luxury-charcoal">{{ $pesananDiproses }}</p>
            </div>
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm">
                <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Total Customers</h4>
                <p class="text-4xl font-serif font-bold text-luxury-charcoal">{{ $totalCustomers }}</p>
            </div>
        </div>

        <div class="bg-luxury-pearl rounded-2xl shadow-sm border border-luxury-gold/30 overflow-hidden">
            <div class="p-6 border-b border-luxury-gold/20 flex justify-between items-center">
                <h4 class="text-xl font-serif font-bold text-luxury-charcoal">Recent Transactions</h4>
                <a href="{{ route('admin.pesanan.index') }}" class="px-4 py-2 bg-luxury-charcoal text-luxury-gold text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-black transition-colors">New Order</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-luxury-gold/20">
                    <thead class="bg-luxury-ivory/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Order ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Time</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-luxury-pearl divide-y divide-luxury-gold/10">
                        @forelse ($transaksiTerbaru as $transaksi)
                            <tr class="hover:bg-luxury-ivory/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-luxury-gold">
                                    <a href="{{ route('admin.riwayatpenjualan.show', $transaksi->id_penjualan) }}">#{{ str_pad($transaksi->id_penjualan, 5, '0', STR_PAD_LEFT) }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $transaksi->waktu_transaksi->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-medium">{{ $transaksi->pelanggan->nama_pelanggan ?? 'Walk-in' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-luxury-charcoal text-right">Rp {{ number_format($transaksi->total_harga_penjualan, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500 italic">No transactions today.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- PELANGGAN VIEW -->
    @if($role === 'pelanggan')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
                <div class="p-4 bg-luxury-gold/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">My Orders</h4>
                <p class="text-3xl font-serif font-bold text-luxury-charcoal">{{ $myOrders->count() }}</p>
                <a href="#" class="mt-4 text-xs font-bold text-luxury-gold uppercase tracking-widest hover:text-luxury-charcoal transition-colors">View All Orders &rarr;</a>
            </div>
            <div class="bg-luxury-pearl border border-luxury-gold/30 rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
                <div class="p-4 bg-luxury-gold/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Total Purchases</h4>
                <p class="text-3xl font-serif font-bold text-luxury-charcoal">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</p>
                <a href="#" class="mt-4 px-6 py-2 bg-luxury-charcoal text-luxury-gold text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-black transition-colors shadow-md">Browse Catalog</a>
            </div>
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
                checkHealth() {
                    fetch('/health')
                        .then(res => res.json())
                        .then(data => {
                            this.dbStatus = data.database;
                            this.cacheStatus = data.cache;
                        })
                        .catch(() => {
                            this.dbStatus = 'disconnected';
                            this.cacheStatus = 'disconnected';
                        });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const chartDataJson = {!! $chartData ?? '{}' !!};
            const chartData = typeof chartDataJson === 'string' ? JSON.parse(chartDataJson) : chartDataJson;
            
            // Luxury Color Palette for Charts
            const gold = '#C8A96B';
            const charcoal = '#1A1A1A';
            const gridColor = 'rgba(200, 169, 107, 0.1)';

            function createChart(ctxId, type, label, data, color) {
                const ctx = document.getElementById(ctxId);
                if(!ctx) return;
                
                new Chart(ctx.getContext('2d'), {
                    type: type,
                    data: {
                        labels: chartData.labels || [],
                        datasets: [{
                            label: label,
                            data: data || [],
                            backgroundColor: color === gold ? 'rgba(200, 169, 107, 0.2)' : 'rgba(26, 26, 26, 0.1)',
                            borderColor: color,
                            borderWidth: 2,
                            tension: 0.3,
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
                            y: { grid: { color: gridColor }, ticks: { color: '#64748b' } },
                            x: { 
                                type: 'time', 
                                time: { unit: 'day' },
                                grid: { color: gridColor }, 
                                ticks: { color: '#64748b' } 
                            }
                        }
                    }
                });
            }

            if (chartData.labels) {
                createChart('grafikPenghasilan', 'line', 'Revenue', chartData.penghasilan, gold);
                createChart('grafikJumlahPesanan', 'bar', 'Orders', chartData.jumlah_pesanan, charcoal);
            }
        });
    </script>
    @endif
    @endpush
</x-app-layout>