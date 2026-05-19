@extends('layouts.layout')
@section('title','SmartSol | Rapport de Performance')

@section('content')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="px-8 pb-20">
    {{-- Header "Modern Glassmorphism" --}}
    <div class="relative bg-gradient-to-r from-white/10 to-transparent p-8 rounded-[2.5rem] border border-white/10 mb-10 overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#FBB108]/10 rounded-full blur-[100px]"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-8 h-[2px] bg-[#FBB108]"></span>
                    <span class="text-[#FBB108] text-xs font-black uppercase tracking-[0.3em]">Analytics Engine</span>
                </div>
                <h1 class="text-4xl font-black text-white tracking-tighter">Rapport de Performance</h1>
                <p class="text-gray-400 mt-2 font-light">Analyse détaillée de votre infrastructure.</p>
            </div>
            
            {{-- Filter & Print --}}
            <div class="flex items-center gap-4">
                <form action="{{ route('rapport') }}" method="GET" id="periodForm">
                    <select name="period" onchange="this.form.submit()" class="bg-[#0d0d0d] text-white text-xs font-bold py-3 px-5 rounded-xl border border-white/10 outline-none focus:border-[#FBB108] cursor-pointer">
                        <option value="7" {{ request('period') == 7 ? 'selected' : '' }}>7 Jours</option>
                        <option value="15" {{ request('period') == 15 ? 'selected' : '' }}>15 Jours</option>
                        <option value="30" {{ request('period') == 30 || !request('period') ? 'selected' : '' }}>30 Jours</option>
                        <option value="90" {{ request('period') == 90 ? 'selected' : '' }}>90 Jours</option>
                    </select>
                </form>
                <button onclick="window.print()" class="bg-[#FBB108] hover:bg-[#fbc547] text-black font-bold py-3 px-6 rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        @php
            $cards = [
                ['label' => 'Total Panneaux', 'val' => $stats['total_panels'], 'icon' => 'fa-solar-panel', 'color' => '#FBB108'],
                ['label' => 'Capacité Totale', 'val' => number_format($stats['total_power'], 0) . ' W', 'icon' => 'fa-bolt', 'color' => '#3b82f6'],
                ['label' => 'Unités Actives', 'val' => $stats['active_panels'], 'icon' => 'fa-plug-circle-check', 'color' => '#10b981'],
                ['label' => 'Maintenance', 'val' => $stats['maintenance'], 'icon' => 'fa-triangle-exclamation', 'color' => '#ef4444']
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-[#0d0d0d] border border-white/5 p-7 rounded-[2rem] hover:border-white/20 transition-all duration-500 relative overflow-hidden">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: {{ $card['color'] }}20; color: {{ $card['color'] }}">
                    <i class="fa-solid {{ $card['icon'] }} text-xl"></i>
                </div>
                <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $card['label'] }}</span>
            </div>
            <h3 class="text-3xl font-black text-white tracking-tight">{{ $card['val'] }}</h3>
        </div>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 bg-white/5 border border-white/10 p-8 rounded-[3rem] backdrop-blur-xl">
            <h2 class="text-white font-bold mb-8 text-sm uppercase tracking-widest italic border-l-2 border-[#FBB108] pl-4">Distribution de l'énergie (W)</h2>
            <div class="h-[300px]">
                <canvas id="powerChart"></canvas>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 p-8 rounded-[3rem] backdrop-blur-xl flex flex-col items-center">
            <h2 class="text-white font-bold mb-8 text-sm uppercase tracking-widest italic">État des Unités</h2>
            <div class="h-[250px] w-full">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-[#0d0d0d]/40 border border-white/10 rounded-[3rem] backdrop-blur-3xl overflow-hidden shadow-2xl">
        <div class="px-10 py-8 border-b border-white/5">
            <h2 class="text-xl font-bold text-white tracking-tight">Inventaire Technique</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.3em] text-gray-600 font-black bg-white/[0.01]">
                        <th class="px-10 py-6">Équipement</th>
                        <th class="px-10 py-6">Localisation</th>
                        <th class="px-10 py-6 text-center">Status</th>
                        <th class="px-10 py-6 text-right">Serial No.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($panels as $panel)
                    <tr class="group hover:bg-white/[0.03] transition-all">
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-[#FBB108]">
                                    <i class="fa-solid fa-solar-panel"></i>
                                </div>
                                <span class="text-white font-bold">{{ $panel->name }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-7 text-gray-400 italic">
                            {{ $panel->zone->city ?? 'N/A' }}
                        </td>
                        <td class="px-10 py-7 text-center">
                            <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest
                                @if($panel->status == 'active') bg-green-500/10 text-green-500
                                @elseif($panel->status == 'maintenance') bg-[#FBB108]/10 text-[#FBB108]
                                @else bg-red-500/10 text-red-500 @endif">
                                {{ $panel->status }}
                            </span>
                        </td>
                        <td class="px-10 py-7 text-right">
                            <span class="text-xs font-mono text-gray-600">{{ $panel->serial_number }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Power Chart
    new Chart(document.getElementById('powerChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Watts',
                data: @json($values),
                backgroundColor: '#FBB108',
                borderRadius: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#666' } },
                x: { grid: { display: false }, ticks: { color: '#666' } }
            }
        }
    });

    // Status Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Actifs', 'Alertes', 'Hors-service'],
            datasets: [{
                data: [{{ $stats['active_panels'] }}, {{ $stats['maintenance'] }}, {{ $stats['total_panels'] - $stats['active_panels'] - $stats['maintenance'] }}],
                backgroundColor: ['#10b981', '#FBB108', '#ef4444'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { color: '#888', padding: 20 } } },
            cutout: '80%'
        }
    });
</script>

<style>
    @media print {
        body { background: white; }
        .bg-[#0d0d0d], .bg-white\/5 { background: white !important; border: 1px solid #eee !important; color: black !important; }
        .text-white, h1, h2, h3 { color: black !important; }
        button, select { display: none !important; }
    }
</style>
@endsection