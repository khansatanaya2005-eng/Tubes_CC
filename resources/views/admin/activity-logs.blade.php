<x-app-layout>
    <x-slot name="header">
        {{ __('Activity Monitor') }}
    </x-slot>

    <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-6">
            <h4 class="text-2xl font-sans font-bold text-luxury-charcoal">System Activity Log</h4>
            <p class="text-slate-500 text-sm mt-2">Real-time monitor of restaurant operations, orders, and guest registry events.</p>
        </div>

        <div class="relative max-w-4xl">
            <!-- Vertical Line -->
            <div class="absolute left-6 top-0 bottom-0 w-px bg-slate-200"></div>

            <div class="space-y-8">
                @forelse ($activities as $activity)
                    <div class="relative flex items-start group">
                        <!-- Icon -->
                        <div class="absolute left-0 w-12 h-12 rounded-full bg-white border-4 border-white flex items-center justify-center shadow-sm z-10 transition-transform group-hover:scale-110">
                            @if($activity['type'] === 'order')
                                <div class="w-10 h-10 rounded-full bg-luxury-gold/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="ml-16 pt-2 w-full">
                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 group-hover:bg-white group-hover:shadow-md transition-all duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <h5 class="text-sm font-bold text-luxury-charcoal">{{ $activity['title'] }}</h5>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-200/50 px-2.5 py-1 rounded-md">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $activity['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ml-16 p-8 text-center bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-slate-500 font-medium">No recent activities to display.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
