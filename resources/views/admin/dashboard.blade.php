<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <x-slot name="header">
        {{-- Header ini akan ditampilkan oleh app.blade.php di dalam area konten --}}
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    {{-- Konten utama dashboard dimulai di sini (di dalam {{ $slot }} di app.blade.php) --}}
    <div class="bg-slate-50 py-2"> {{-- Menambahkan padding di sini atau di <main> di app.blade.php --}}
        <div class="max-w-full mx-auto"> {{-- Menggunakan max-w-full agar mengisi konten --}}

            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6 p-6">
                <h3 class="text-2xl font-bold text-slate-700">
                    Selamat datang kembali, {{ $adminName }}!
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-slate-500 text-sm font-medium">PENGHASILAN HARI INI</h4>
                    <p class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($penghasilanHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-slate-500 text-sm font-medium">PESANAN HARI INI</h4>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $pesananHariIni }} Transaksi</p>
                </div>
            </div>

            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <label for="period_days" class="text-sm font-medium text-slate-700">Tampilkan Data Untuk:</label>
                    <select name="period_days" id="period_days" class="block w-auto border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm text-slate-700">
                        <option value="7" {{ ($currentPeriodDays ?? 7) == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30" {{ ($currentPeriodDays ?? 7) == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                        <option value="90" {{ ($currentPeriodDays ?? 7) == 90 ? 'selected' : '' }}>90 Hari Terakhir</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-md hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                        Filter
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-700 mb-2" id="judulGrafikPenghasilan">Grafik Penghasilan ({{ $currentPeriodDays ?? 7 }} Hari Terakhir)</h4>
                    <div class="relative h-80"> 
                        <canvas id="grafikPenghasilan"></canvas>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-700 mb-2" id="judulGrafikJumlahPesanan">Grafik Jumlah Pesanan ({{ $currentPeriodDays ?? 7 }} Hari Terakhir)</h4>
                    <div class="relative h-80">
                        <canvas id="grafikJumlahPesanan"></canvas>
                    </div>
                </div>
            </div>

             <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-slate-900">
                    <h3 class="text-lg font-medium text-slate-700 mb-4">Transaksi Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($transaksiTerbaru as $transaksi)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-sky-600 hover:underline">
                                            <a href="{{ route('admin.riwayatpenjualan.show', $transaksi->id_penjualan) }}">#{{ $transaksi->id_penjualan }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $transaksi->waktu_transaksi->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $transaksi->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 text-right">{{ number_format($transaksi->total_harga_penjualan, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-slate-500">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Kode JavaScript untuk Chart.js (Sudah diatur untuk warna terang sebelumnya)
        document.addEventListener('DOMContentLoaded', function () {
            const chartDataJson = {!! $chartData ?? '{}' !!};
            let chartData;
            try {
                chartData = typeof chartDataJson === 'string' ? JSON.parse(chartDataJson) : chartDataJson;
            } catch (e) {
                console.error("Gagal mem-parse chartData:", e, chartDataJson);
                chartData = { labels: [], penghasilan: [], jumlah_pesanan: [] };
            }
            
            const currentPeriodDays = {{ $currentPeriodDays ?? 7 }};
            // ... (sisa JavaScript untuk update judul dan inisialisasi chart tetap sama seperti sebelumnya)

            window.grafikPenghasilanInstance = null;
            window.grafikJumlahPesananInstance = null;

            const lightModeTextColor = 'rgba(55, 65, 81, 0.8)'; // slate-700
            const lightModeGridColor = 'rgba(226, 232, 240, 0.6)'; // slate-300

            function initOrUpdateChart(chartId, chartInstanceVarName, type, label, data, backgroundColor, borderColor, tension = undefined) {
                const canvas = document.getElementById(chartId);
                if (!canvas) {
                    console.error(`Canvas dengan ID "${chartId}" tidak ditemukan.`);
                    return;
                }
                const ctx = canvas.getContext('2d');

                if (window[chartInstanceVarName]) {
                    window[chartInstanceVarName].destroy();
                }
                
                window[chartInstanceVarName] = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: chartData.labels || [],
                        datasets: [{
                            label: label,
                            data: data || [],
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1,
                            tension: tension
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: chartId === 'grafikJumlahPesanan' && (data || []).length > 0 && (data || []).every(val => Number.isInteger(val)) ? 1 : undefined,
                                    color: lightModeTextColor
                                },
                                grid: {
                                    color: lightModeGridColor
                                }
                            },
                            x: { 
                                type: 'time',
                                time: {
                                    unit: 'day', 
                                    tooltipFormat: 'dd MMM yy', 
                                    displayFormats: {
                                        day: 'dd MMM' 
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Tanggal',
                                    color: lightModeTextColor
                                },
                                ticks: {
                                     color: lightModeTextColor
                                },
                                grid: {
                                    color: lightModeGridColor
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: lightModeTextColor
                                }
                            }
                        }
                    }
                });
            }

            if (chartData && chartData.labels && chartData.penghasilan && chartData.jumlah_pesanan) {
                 initOrUpdateChart(
                    'grafikPenghasilan',
                    'grafikPenghasilanInstance',
                    'bar',
                    'Penghasilan (Rp)',
                    chartData.penghasilan,
                    'rgba(54, 162, 235, 0.6)', // Biru soft
                    'rgba(54, 162, 235, 1)'
                );

                initOrUpdateChart(
                    'grafikJumlahPesanan',
                    'grafikJumlahPesananInstance',
                    'line',
                    'Jumlah Pesanan',
                    chartData.jumlah_pesanan,
                    'rgba(75, 192, 192, 0.6)', // Teal soft
                    'rgba(75, 192, 192, 1)',
                    0.1
                );
            } else {
                console.warn("Data untuk chart tidak lengkap atau tidak valid");
            }

            const periodSelect = document.getElementById('period_days');
            if (periodSelect) {
                periodSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });
    </script>
    @endpush
</x-app-layout>