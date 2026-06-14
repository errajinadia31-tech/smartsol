@extends('layouts.layout')
@section('title', __('SmartSol | Dashboard'))
@section('content')

<main class="text-white px-8 mt-10 min-h-screen">

    <section>
        <div class="mx-auto grid grid-cols-1 lg:grid-cols-3 gap-[5rem] items-start">
            <div class="lg:col-span-1">
                <h1 class="text-5xl font-bold mb-2 leading-tight">
                    {{ __('Bienvenue sur,') }}<br>
                    <span class="italic">Smart<span class="text-[#FBB108]">Sol</span></span>
                </h1>
                <p class="text-gray-400 text-lg font-light max-w-xs leading-relaxed">
                    {{ __("Suivi et analyse de la production et de la consommation d'énergie solaire en temps réel.") }}
                </p>

                <div class="flex mb-8 mt-6 gap-2">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full border text-green-500 border-green-500/30 bg-green-500/5 hover:bg-green-500/20 transition-colors">
                        <i class="fa-solid fa-battery-full text-sm"></i>
                    </div>
                    <div class="w-10 h-10 flex items-center justify-center rounded-full border border-yellow-400/30 text-yellow-400 bg-yellow-400/5 hover:bg-yellow-400/20 transition-colors">
                        <i class="fa-solid fa-bolt text-sm"></i>
                    </div>
                    <div class="w-10 h-10 flex items-center justify-center rounded-full border border-red-400/30 text-red-400 bg-red-400/5 hover:bg-red-400/20 transition-colors">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 flex justify-end">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[2rem] w-[320px] min-h-[320px] flex flex-col justify-between transition-all hover:border-[#FBB108]/30 group shadow-2xl relative overflow-hidden">

                        <div class="absolute -right-6 -top-6 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity rotate-12">
                            <i class="fa-solid fa-microchip text-[10rem] text-white"></i>
                        </div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div class="space-y-1">
                                    <h2 class="text-gray-400 uppercase text-[10px] tracking-[0.2em] font-black italic">{{ __('Infrastructure') }}</h2>
                                    <p class="text-white text-xs font-bold tracking-tighter uppercase">{{ __('Total des Unités') }}</p>
                                </div>
                                <span class="text-[9px] text-green-500 bg-green-500/10 px-3 py-1 rounded-full border border-green-500/20 font-black italic uppercase">
                                    {{ __('Système Live') }}
                                </span>
                            </div>

                            <div class="flex items-baseline gap-3 mb-8">
                                <span class="text-white text-7xl font-black italic tracking-tighter group-hover:text-[#FBB108] transition-colors duration-500">
                                    {{ str_pad($totalPanels, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-gray-500 text-[14px] uppercase font-black tracking-widest italic">{{ __('Panneaux') }} </span>
                            </div>
                        </div>

                        <div class="relative z-10 space-y-5 border-t border-white/5 pt-8">
                            <div class="space-y-1">
                                <div class="flex justify-between text-[9px] uppercase font-black tracking-widest text-gray-500">
                                    <span>{{ __('Actifs') }}</span>
                                    <span class="text-white">{{ $activePanelsCount }}</span>
                                </div>
                                <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                                    <div class="bg-[#FBB108] h-full rounded-full" style="width: '{{ $totalPanels > 0 ? ($activePanelsCount / $totalPanels) * 100 : 0 }}%'"></div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="flex justify-between text-[9px] uppercase font-black tracking-widest text-gray-500">
                                    <span>{{ __('Maintenance') }}</span>
                                    <span class="text-red-500">{{ $maintenanceCount }}</span>
                                </div>
                                <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: '{{ $totalPanels > 0 ? ($maintenanceCount / $totalPanels) * 100 : 0 }}%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10  p-10 rounded-[2rem] w-[320px] min-h-[280px] flex flex-col justify-between transition-all hover:border-[#FBB108]/30 group shadow-xl relative overflow-hidden">

                        <div class="absolute -right-6 -top-6 opacity-[0.03]  group-hover:opacity-[0.08] transition-opacity rotate-12">
                            <i class="fa-solid fa-power-off text-[10rem] text-white"></i>
                        </div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-center mb-10 ">
                                <h2 class="text-gray-400 uppercase text-[10px] tracking-[0.2em] font-black">{{ __('Disponibilité') }}</h2>
                                <span class="text-[9px] text-gray-500 bg-white/5 px-3 py-1 rounded-full border border-white/5 font-black italic uppercase">{{ __('Offline') }}</span>
                            </div>

                            <div class="space-y-2">
                                @php
                                $inactiveCount = $totalPanels - $activePanelsCount - $maintenanceCount;
                                @endphp
                                <div class="flex items-baseline gap-3">
                                    <span class="text-gray-400 text-6xl font-black italic tracking-tighter transition-transform group-hover:scale-105 duration-500">
                                        {{ str_pad(max(0, $inactiveCount), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-gray-500 text-[12px] uppercase font-black tracking-widest leading-none">{{ __('Panneaux') }}<br>{{ __('Inactifs') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 mt-auto">
                            <p class="text-[9px] text-gray-600 mt-4 font-medium italic leading-relaxed max-w-[200px]">
                                {{ __("Unités hors service. Vérifiez les connexions réseau ou l'alimentation") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 will-change-transform">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
    <div class="bg-[#121212]/70 border border-[#FBB108]/30 p-8 rounded-[2rem] shadow-3xl">
        <h3 class="text-[#FBB108] text-xs font-bold uppercase tracking-widest">{{ __('Économie quotidienne') }}</h3>
        <p id="display-savings" class="text-white text-4xl font-black mt-4">0.00 <span class="text-sm text-gray-500 font-normal">MAD</span></p>
    </div>

    <div class="bg-[#121212]/70 border border-[#FBB108]/30 p-8 rounded-[2rem] shadow-3xl">
        <h3 class="text-[#FBB108] text-xs font-bold uppercase tracking-widest">{{ __('prévisions de production') }}</h3>
        <p id="display-forecast" class="text-white text-4xl font-black mt-4">0.00 <span class="text-sm text-gray-500 font-normal">W</span></p>
    </div>

    <!-- weatherCards start -->
    @foreach($weatherCards as $city => $weather)

    @if(!empty($weather))

    <div class="bg-[#121212]/60 backdrop-blur-md border border-[#FBB108]/20 p-6 rounded-[2rem] w-full h-[150px] flex justify-between shadow-xl relative overflow-hidden group">

        {{-- background icon --}}
        <div class="absolute -right-6 -top-6 opacity-[0.04] group-hover:opacity-[0.10] transition rotate-12">
            <i class="fa-solid fa-cloud text-[7rem] text-white"></i>
        </div>

        {{-- LEFT --}}
        <div class="relative z-10 flex flex-col justify-between">

            <div>
                <h2 class="text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black">
                    {{ $weather['city'] ?? $city }}
                </h2>

                <span class="inline-block mt-2 text-[9px] text-gray-400 bg-white/5 px-3 py-1 rounded-full border border-white/10">
                    {{ $weather['desc'] ?? '--' }}
                </span>
            </div>

            <div class="flex items-end gap-2">
                <span class="text-white text-5xl font-black italic">
                    {{ $weather['temp'] ?? 0 }}
                </span>
                <span class="text-[#FBB108] text-sm font-bold mb-2">°C</span>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="relative z-10 flex flex-col items-end justify-between">

            @if(!empty($weather['icon']))
                <img src="http://openweathermap.org/img/wn/{{ $weather['icon'] }}.png"
                     class="w-12 h-12">
            @endif

            <div class="text-[9px] text-gray-400 text-right">
                <div>H <span class="text-white">{{ $weather['humidity'] ?? 0 }}%</span></div>
                <div>W <span class="text-white">{{ $weather['wind'] ?? 0 }} km/h</span></div>
            </div>

        </div>

    </div>

    @endif

@endforeach
    <!-- weatherCards end  -->
            <div class="bg-[#121212]/70 border border-[#FBB108]/30 p-8 rounded-[2rem] md:col-span-3 shadow-3xl ">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-[#FBB108] font-bold italic uppercase tracking-widest text-sm">{{ __('Assistant SmartSol AI') }}</h2>
                    <button id="ai-btn" class="bg-[#FBB108] text-black px-6 py-2 rounded-full font-black text-[10px] uppercase hover:scale-105 transition-all">
                        {{ __('Lancer Diagnostic') }}
                    </button>
                </div>
                <div id="ai-response" class="text-right text-gray-400 font-medium italic text-sm border-t border-white/5 pt-4">
                    {{ __('Cliquez pour obtenir une analyse intelligente de votre production actuelle...') }}
                </div>
            </div>

            <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-[#FBB108]/30 transition-all group shadow-2xl relative overflow-hidden">
                <div class="absolute -right-2 -top-2 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fa-solid fa-sun text-8xl text-[#FBB108]"></i>
                </div>
                <h2 class="text-gray-400 self-start mb-10 font-medium uppercase text-[10px] tracking-widest">{{ __('Production Actuelle') }}</h2>
                <div class="flex items-baseline gap-2">
                    <span id="live-power" class="text-[#FBB108] text-6xl font-black italic tracking-tighter">{{ $currentProduction }}</span>
                    <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">{{ __('Watts') }}</span>
                </div>
            </div>

            <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-blue-500/30 transition-all group shadow-2xl relative overflow-hidden">
                <div class="absolute -right-2 -top-2 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fa-solid fa-plug-circle-bolt text-8xl text-blue-500"></i>
                </div>
                <h2 class="text-gray-400 self-start mb-10 font-medium uppercase text-[10px] tracking-widest">{{ __('Consommation Actuelle') }}</h2>
                <div class="flex items-baseline gap-2">
                    <span id="live-consumption" class="text-blue-500 text-6xl font-black italic tracking-tighter">{{ $currentConsommation }}</span>
                    <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">{{ __('Watts') }}</span>
                </div>
            </div>

            <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-green-500/30 transition-all shadow-2xl">
                <h2 class="text-gray-400 self-start mb-10 font-medium uppercase text-[10px] tracking-widest">{{ __('Capacité Système') }}</h2>
                <div class="flex items-baseline gap-2">
                    <span id="total-cap" class="text-green-500 text-6xl font-black italic tracking-tighter">{{ $totalPower }}</span>
                    <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">{{ __('Wp') }}</span>
                </div>
            </div>

            <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-8 rounded-[2rem] flex flex-col w-full md:col-span-3 shadow-3xl">
                <div class="flex justify-between items-center mb-10 px-4">
                    <h2 class="text-gray-300 font-bold italic uppercase tracking-widest text-sm border-l-2 border-[#FBB108] pl-4">
                        {{ __('Production vs Consommation') }} 
                    </h2>
                    <span class="flex items-center gap-2 text-[10px] text-[#FBB108] bg-[#FBB108]/10 px-4 py-1 rounded-full border border-[#FBB108]/20 animate-pulse font-bold">● {{ __('LIVE DATA') }}</span>
                </div>
                <div class="h-[400px] w-full">
                    <canvas id="energyChart"></canvas>
                </div>
            </div>
            
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    let energyChart;

    document.addEventListener('DOMContentLoaded', function () {
        const labels = []; 
        const prodData = [];
        const consData = [];

        const ctx = document.getElementById('energyChart').getContext('2d');

        energyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "{{ __('Production') }}", // ترجمة عنوان المبيان
                        data: prodData,
                        borderColor: '#FBB108',
                        backgroundColor: 'rgba(251,177,8,0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: "{{ __('Consommation') }}", // ترجمة عنوان المبيان
                        data: consData,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#fff' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        suggestedMax: 100, 
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            font: { size: 12 }
                        },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    },
                    x: {
                        ticks: { color: 'rgba(255, 255, 255, 0.7)' },
                        grid: { display: false }
                    }
                }
            }
        });

        const btn = document.getElementById('ai-btn');
        const output = document.getElementById('ai-response');

       if(btn) {
    btn.addEventListener('click', async () => {

       const power = parseFloat(document.getElementById('live-power').innerText.replace(/[^0-9.]/g, '')) || 0;
        const cap = parseFloat(document.getElementById('total-cap').innerText.replace(/[^0-9.]/g, '')) || 0;
        btn.innerText = "{{ __('Analyse en cours...') }}";
        btn.disabled = true;

        try {

            const res = await fetch('/analyze-energy', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    prod: power,
                    cap: cap
                })
            });

            const data = await res.json();

            // تحديث Cards
            if (data.metrics) {

                document.getElementById('display-savings').innerHTML =
                    `${Number(data.metrics.savings).toFixed(2)}
                    <span class="text-sm text-gray-500 font-normal">MAD</span>`;

                document.getElementById('display-forecast').innerHTML =
                    `${Math.round(data.metrics.forecast)}
                    <span class="text-sm text-gray-500 font-normal">W</span>`;
            }

            output.innerHTML = data.analysis
                ? "🤖 " + data.analysis
                : "❌ " + data.error;

        } catch (e) {

            output.innerHTML = "❌ {{ __('Erreur de connexion') }}";

        } finally {

            btn.innerText = "{{ __('Lancer Diagnostic') }}";
            btn.disabled = false;

        }
    });
}

        function refreshSimulation() {
            fetch('{{ route("simulation.data") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('live-power').innerText = data.production;
                    document.getElementById('live-consumption').innerText = data.consumption;

                    const weatherSpan = document.getElementById('weather-status');
                    if (weatherSpan) {
                        if (!data.isDay) {
                            weatherSpan.innerHTML = '<i class="fa-solid fa-moon text-blue-300"></i>';
                        } else if (data.cloudiness > 70) {
                            weatherSpan.innerHTML = '<i class="fa-solid fa-cloud text-gray-400"></i>';
                        } else {
                            weatherSpan.innerHTML = '<i class="fa-solid fa-sun text-yellow-500"></i>';
                        }
                    }

                    const currentTime = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    updateChart(data.production, data.consumption, currentTime);
                });
        }

        refreshSimulation();
        setInterval(refreshSimulation, 4000);
    });

    function updateChart(prod, cons, time) {
        if (!energyChart) return;

        const prodValue = Number(prod);
        const consValue = Number(cons);

        energyChart.data.labels.push(time);
        energyChart.data.datasets[0].data.push(prodValue);
        energyChart.data.datasets[1].data.push(consValue);

        if (energyChart.data.labels.length > 8) {
            energyChart.data.labels.shift();
            energyChart.data.datasets[0].data.shift();
            energyChart.data.datasets[1].data.shift();
        }

        energyChart.update('none');
    }
    
</script>
@endsection