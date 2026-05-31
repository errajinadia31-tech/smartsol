@extends('layouts.layout')
@section('title', __('SmartSol | Rapport de Performance'))

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
                <h1 class="text-4xl font-black text-white tracking-tighter">{{ __('Rapport de Performance') }}</h1>
                <p class="text-gray-400 mt-2 font-light">{{ __('Analyse détaillée de votre infrastructure.') }}</p>
            </div>
            
            {{-- Filter & Print --}}
            <div class="flex items-center gap-4">
                <form action="{{ route('rapport') }}" method="GET" id="periodForm">
                    <select name="period" onchange="this.form.submit()" class="bg-[#0d0d0d] text-white text-xs font-bold py-3 px-5 rounded-xl border border-white/10 outline-none focus:border-[#FBB108] cursor-pointer">
                        <option value="7" {{ request('period') == 7 ? 'selected' : '' }}>7 {{ __('Jours') }}</option>
                        <option value="15" {{ request('period') == 15 ? 'selected' : '' }}>15 {{ __('Jours') }}</option>
                        <option value="30" {{ request('period') == 30 || !request('period') ? 'selected' : '' }}>30 {{ __('Jours') }}</option>
                        <option value="90" {{ request('period') == 90 ? 'selected' : '' }}>90 {{ __('Jours') }}</option>
                    </select>
                </form>
                <button onclick="window.print()" class="bg-[#FBB108] hover:bg-[#fbc547] text-black font-bold py-3 px-6 rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-file-pdf"></i> {{ __('PDF / Imprimer') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-12 print:grid-cols-4 print:gap-4 print:mb-8">
        @php
            $cards = [
                ['label' => __('Total Panneaux'), 'val' => $stats['total_panels'], 'icon' => 'fa-solar-panel', 'color' => '#FBB108'],
                ['label' => __('Capacité Totale'), 'val' => number_format($stats['total_power'], 0) . ' W', 'icon' => 'fa-bolt', 'color' => '#3b82f6'],
                ['label' => __('Unités Actives'), 'val' => $stats['active_panels'], 'icon' => 'fa-plug-circle-check', 'color' => '#10b981'],
                ['label' => __('Maintenance'), 'val' => $stats['maintenance'], 'icon' => 'fa-triangle-exclamation', 'color' => '#ef4444']
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-[#0d0d0d] border border-white/5 p-7 rounded-[2rem] hover:border-white/20 transition-all duration-500 relative overflow-hidden print:bg-gray-50 print:border-gray-200 print:p-5 print:rounded-2xl">
            <div class="flex items-center gap-4 mb-4 print:mb-2">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center print:w-9 print:h-9 print:rounded-xl" style="background: {{ $card['color'] }}20; color: {{ $card['color'] }}">
                    <i class="fa-solid {{ $card['icon'] }} text-xl print:text-sm"></i>
                </div>
                <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest print:text-[8px] print:text-gray-600">{{ $card['label'] }}</span>
            </div>
            <h3 class="text-3xl font-black text-white tracking-tight print:text-xl print:text-black">{{ $card['val'] }}</h3>
        </div>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 bg-white/5 border border-white/10 p-8 rounded-[3rem] backdrop-blur-xl">
            <h2 class="text-white font-bold mb-8 text-sm uppercase tracking-widest italic border-s-2 rtl:border-s-0 rtl:border-e-2 border-[#FBB108] ps-4 rtl:ps-0 rtl:pe-4">{{ __("Distribution de l'énergie (W)") }}</h2>
            <div class="h-[300px]">
                <canvas id="powerChart"></canvas>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 p-8 rounded-[3rem] backdrop-blur-xl flex flex-col items-center">
            <h2 class="text-white font-bold mb-8 text-sm uppercase tracking-widest italic">{{ __('État des Unités') }}</h2>
            <div class="h-[250px] w-full">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-[#0d0d0d]/40 border border-white/10 rounded-[3rem] backdrop-blur-3xl overflow-hidden shadow-2xl">
        <div class="px-10 py-8 border-b border-white/5">
            <h2 class="text-xl font-bold text-white tracking-tight">{{ __('Inventaire Technique') }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-start">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.3em] text-gray-600 font-black bg-white/[0.01]">
                        <th class="px-10 py-6 text-start">{{ __('Équipement') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('Localisation') }}</th>
                        <th class="px-10 py-6 text-center">{{ __('Status') }}</th>
                        <th class="px-10 py-6 text-end">{{ __('Serial No.') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($panels as $panel)
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
                            {{ $panel->zone->city ?? __('N/A') }}
                        </td>
                        <td class="px-10 py-7 text-center">
                            <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest
                                @if($panel->status == 'active') bg-green-500/10 text-green-500
                                @elseif($panel->status == 'maintenance') bg-[#FBB108]/10 text-[#FBB108]
                                @else bg-red-500/10 text-red-500 @endif">
                                {{ __($panel->status) }}
                            </span>
                        </td>
                        <td class="px-10 py-7 text-end">
                            <span class="text-xs font-mono text-gray-600">{{ $panel->serial_number }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-10 text-center text-gray-500 italic">
                            {{ __('Aucun équipement trouvé pour cette période.') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // 1. Power Chart (Bar Chart)
    new Chart(document.getElementById('powerChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Watts',
                data: @json($values),
                backgroundColor: '#FBB108',
                hoverBackgroundColor: '#fbc547',
                borderRadius: 12,
                borderSkipped: false
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
                    grid: { color: 'rgba(255,255,255,0.05)' }, 
                    ticks: { color: '#888', font: { size: 11 } } 
                },
                x: { 
                    grid: { display: false }, 
                    ticks: { color: '#888', font: { size: 11 } } 
                }
            }
        }
    });

    // 2. Status Chart (Doughnut)
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ["{{ __('Actifs') }}", "{{ __('Maintenance') }}", "{{ __('Inactifs') }}"],
            datasets: [{
                data: [
                    {{ $stats['active_panels'] }}, 
                    {{ $stats['maintenance'] }}, 
                    {{ max(0, $stats['total_panels'] - $stats['active_panels'] - $stats['maintenance']) }}
                ],
                backgroundColor: ['#10b981', '#FBB108', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        color: '#aaa', 
                        padding: 20,
                        font: { size: 11, weight: 'bold' } 
                    } 
                } 
            },
            cutout: '75%'
        }
    });
</script>

<style>
    #chat-messages::-webkit-scrollbar {
        width: 5px;
    }
    #chat-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    #chat-messages::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 9999px;
    }
    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(251, 177, 8, 0.4);
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-shadow: none !important;
        }

        body, html, main, #app, .px-8, div, section {
            background: #ffffff !important;
            color: #000000 !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: visible !important;
        }

        button, select, form, #chat-window, .fixed, sidebar, nav, .fa-file-pdf, iframe {
            display: none !important;
        }

        .relative.bg-gradient-to-r {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1.5rem !important;
            padding: 1.5rem 2rem !important;
            margin-top: 1rem !important;
            margin-bottom: 2rem !important;
        }
        .relative.bg-gradient-to-r h1 { color: #000000 !important; font-size: 1.75rem !important; }
        .relative.bg-gradient-to-r p { color: #475569 !important; }
        .relative.bg-gradient-to-r .absolute { display: none !important; }

        .grid.grid-cols-1.sm\:grid-cols-2.md\:grid-cols-4 {
            display: grid !important;
            grid-template-cols: repeat(4, minmax(0, 1fr)) !important;
            gap: 1rem !important;
            margin-bottom: 2rem !important;
        }
        .grid.grid-cols-1.sm\:grid-cols-2.md\:grid-cols-4 > div {
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 1rem !important;
            padding: 1rem !important;
        }

        .grid-cols-1.lg\:grid-cols-3 {
            display: flex !important;
            flex-direction: column !important;
            gap: 1.5rem !important;
        }

        .lg\:col-span-2.bg-white\/5, .bg-white\/5.flex-col {
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 1.5rem !important;
            padding: 1.5rem !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            margin-bottom: 1.5rem !important;
        }

        .h-\[300px\], .h-\[250px\] {
            height: 240px !important; 
        }
        canvas {
            max-width: 100% !important;
            height: 100% !important;
        }

        .bg-\[\#0d0d0d\]\/40 {
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 1.5rem !important;
            margin-top: 2rem !important;
            page-break-inside: auto !important;
        }
        table { width: 100% !important; page-break-inside: auto !important; }
        tr { page-break-inside: avoid !important; break-inside: avoid !important; }
        th { color: #475569 !important; background: #f8fafc !important; padding: 12px !important; }
        td { color: #000000 !important; padding: 12px !important; border-bottom: 1px solid #e2e8f0 !important; }

        @page {
            size: A4;
            margin: 20mm 15mm 20mm 15mm;
        }
    }
</style>
@endsection