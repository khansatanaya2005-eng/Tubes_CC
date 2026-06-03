<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-700">Daftar Notifikasi</h3>
                        @if(Auth::user()->unreadNotifications()->count() > 0)
                            <form action="{{ route('admin.notifikasi.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md">
                                    Tandai semua sudah dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        @forelse ($notifikasis as $notifikasi)
                            <div class="p-4 rounded-md {{ $notifikasi->read_at ? 'bg-gray-100' : 'bg-blue-50 border border-blue-200' }}">
                                <p class="font-medium {{ $notifikasi->read_at ? 'text-gray-600' : 'text-blue-800' }}">
                                    {{-- Link ke detail penjualan --}}
                                    <a href="{{ route('admin.riwayatpenjualan.show', $notifikasi->data['id_penjualan']) }}" class="hover:underline">
                                        {{ $notifikasi->data['message'] }}
                                    </a>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $notifikasi->created_at->diffForHumans() }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Tidak ada notifikasi.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $notifikasis->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>