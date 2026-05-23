@extends('layouts.layout')
@section('title','SmartSol | Dashboard')
@section('content')

<main class="text-white px-8 mt-10 min-h-screen">

    <section>
        <div class="mx-auto grid grid-cols-1 lg:grid-cols-3 gap-[5rem] items-start">
            <div class="lg:col-span-1">
                <h1 class="text-6xl font-bold mb-2 leading-tight">
                    Welcome in,<br>
                    <span class="italic">Smart<span class="text-[#FBB108]">Sol</span></span>
                </h1>
                <p class="text-gray-400 text-lg font-light max-w-xs leading-relaxed">
                    Suivi et analyse de la production et de la consommation d'énergie solaire en temps réel.
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
                                    <h2 class="text-gray-400 uppercase text-[10px] tracking-[0.2em] font-black italic">Infrastructure</h2>
                                    <p class="text-white text-xs font-bold tracking-tighter uppercase">Total des Unités</p>
                                </div>
                                <span class="text-[9px] text-green-500 bg-green-500/10 px-3 py-1 rounded-full border border-green-500/20 font-black italic uppercase">
                                    Système Live
                                </span>
                            </div>

                            <div class="flex items-baseline gap-3 mb-8">
                                <span class="text-white text-7xl font-black italic tracking-tighter group-hover:text-[#FBB108] transition-colors duration-500">
                                    {{ str_pad($totalPanels, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-gray-500 text-[14px] uppercase font-black tracking-widest italic">Panneaux </span>
                            </div>
                        </div>

                        <div class="relative z-10 space-y-5 border-t border-white/5 pt-8">
                            <div class="space-y-1">
                                <div class="flex justify-between text-[9px] uppercase font-black tracking-widest text-gray-500">
                                    <span>Actifs</span>
                                    <span class="text-white">{{ $activePanelsCount }}</span>
                                </div>
                                <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                                    <div class="bg-[#FBB108] h-full rounded-full" style="width: {{ $totalPanels > 0 ? ($activePanelsCount / $totalPanels) * 100 : 0 }}%"></div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="flex justify-between text-[9px] uppercase font-black tracking-widest text-gray-500">
                                    <span>Maintenance</span>
                                    <span class="text-red-500">{{ $maintenanceCount }}</span>
                                </div>
                                <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: {{ $totalPanels > 0 ? ($maintenanceCount / $totalPanels) * 100 : 0 }}%"></div>
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
                                <h2 class="text-gray-400 uppercase text-[10px] tracking-[0.2em] font-black">Disponibilité</h2>
                                <span class="text-[9px] text-gray-500 bg-white/5 px-3 py-1 rounded-full border border-white/5 font-black italic uppercase">Offline</span>
                            </div>

                            <div class="space-y-2">
                                @php
                                $inactiveCount = $totalPanels - $activePanelsCount - $maintenanceCount;
                                @endphp
                                <div class="flex items-baseline gap-3">
                                    <span class="text-gray-400 text-6xl font-black italic tracking-tighter transition-transform group-hover:scale-105 duration-500">
                                        {{ str_pad(max(0, $inactiveCount), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-gray-500 text-[12px] uppercase font-black tracking-widest leading-none">Panneaux<br>Inactifs</span>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 mt-auto">
                            <p class="text-[9px] text-gray-600 mt-4 font-medium italic leading-relaxed max-w-[200px]">
                                Unités hors service. Vérifiez les connexions réseau ou l'alimentation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- cards section -->
<section class="mt-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
        
       <!-- 4. AI Assistant Card (تأخذ العرض كاملاً) -->
        <div class="bg-[#121212]/70 border border-[#FBB108]/30 p-8 rounded-[2rem] md:col-span-3 shadow-3xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-[#FBB108] font-bold italic uppercase tracking-widest text-sm">Assistant SmartSol AI</h2>
                <button id="ai-btn" class="bg-[#FBB108] text-black px-6 py-2 rounded-full font-black text-[10px] uppercase hover:scale-105 transition-all">
                    Lancer Diagnostic
                </button>
            </div>
            <div id="ai-response" class="text-right text-gray-400 font-medium italic text-sm border-t border-white/5 pt-4">
                انقر للحصول على تحليل ذكي لإنتاجك الحالي...
            </div>
        </div>

        <!-- 1. Production Card -->
        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-[#FBB108]/30 transition-all group shadow-2xl relative overflow-hidden">
            <div class="absolute -right-2 -top-2 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fa-solid fa-sun text-8xl text-[#FBB108]"></i>
            </div>
            <h2 class="text-gray-400 self-start mb-10 font-medium uppercase text-[10px] tracking-widest">Production Actuelle</h2>
            <div class="flex items-baseline gap-2">
                <span id="live-power" class="text-[#FBB108] text-6xl font-black italic tracking-tighter">{{ $currentProduction }}</span>
                <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">Watts</span>
            </div>
        </div>

        <!-- 2. Consommation Card -->
        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-blue-500/30 transition-all group shadow-2xl relative overflow-hidden">
            <div class="absolute -right-2 -top-2 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fa-solid fa-plug-circle-bolt text-8xl text-blue-500"></i>
            </div>
            <h2 class="text-gray-400 self-start mb-10 font-medium uppercase text-[10px] tracking-widest">Consommation Actuelle</h2>
            <div class="flex items-baseline gap-2">
                <span id="live-consumption" class="text-blue-500 text-6xl font-black italic tracking-tighter">{{ $currentConsommation }}</span>
                <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">Watts</span>
            </div>
        </div>

        <!-- 3. Capacité Card -->
        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-green-500/30 transition-all shadow-2xl">
            <h2 class="text-gray-400 self-start mb-10 font-medium uppercase text-[10px] tracking-widest">Capacité Système</h2>
            <div class="flex items-baseline gap-2">
                <span id="total-cap" class="text-green-500 text-6xl font-black italic tracking-tighter">{{ $totalPower }}</span>
                <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">Wp</span>
            </div>
        </div>

     

        <!-- 5. Chart Section (تأخذ العرض كاملاً) -->
        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-8 rounded-[2rem] flex flex-col w-full md:col-span-3 shadow-3xl">
            <div class="flex justify-between items-center mb-10 px-4">
                <h2 class="text-gray-300 font-bold italic uppercase tracking-widest text-sm border-l-2 border-[#FBB108] pl-4">
    Production vs Consommation <span id="weather-status" class="ml-2"></span>
</h2>
                <span class="flex items-center gap-2 text-[10px] text-[#FBB108] bg-[#FBB108]/10 px-4 py-1 rounded-full border border-[#FBB108]/20 animate-pulse font-bold">● LIVE DATA</span>
            </div>
            <div class="h-[400px] w-full">
                <canvas id="energyChart"></canvas>
            </div>
        </div>
        
    </div>
</section>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    let energyChart;

    document.addEventListener('DOMContentLoaded', function () {
        // 1. تجهيز الداتا الأولية من Laravel
        const labels = @json($latestReadings->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('H:i')));
        const prodData = @json($latestReadings->pluck('power'));
        const consData = @json($latestReadings->pluck('consumption'));

        const ctx = document.getElementById('energyChart').getContext('2d');

        // 2. إعداد الـ Chart
        energyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Production',
                        data: prodData,
                        borderColor: '#FBB108',
                        backgroundColor: 'rgba(251,177,8,0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Consommation',
                        data: consData,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // 3. كود الـ AI
        const btn = document.getElementById('ai-btn');
        const output = document.getElementById('ai-response');

        btn.addEventListener('click', async () => {
            const power = parseFloat(document.getElementById('live-power').innerText) || 0;
            const cap = parseFloat(document.getElementById('total-cap').innerText) || 0;

            btn.innerText = "جاري التحليل...";
            btn.disabled = true;

            try {
                const res = await fetch('/analyze-energy', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ prod: power, cap: cap })
                });

                const data = await res.json();
                output.innerHTML = data.analysis ? "🤖 " + data.analysis : "❌ " + data.error;
            } catch (e) {
                output.innerHTML = "❌ خطأ في الاتصال";
            }
            btn.innerText = "Lancer Diagnostic";
            btn.disabled = false;
        });

        // 4. دالة التحديث (Simulation)
        function refreshSimulation() {
            fetch('{{ route("simulation.data") }}')
                .then(response => response.json())
                .then(data => {
                    // تحديث القيم فالبطاقات مع transition سلس
                    document.getElementById('live-power').innerText = data.production;
                    document.getElementById('live-consumption').innerText = data.consumption;

                    // تحديث أيقونة الطقس
                    const weatherSpan = document.getElementById('weather-status');
                    if (!data.isDay) {
                        weatherSpan.innerHTML = '<i class="fa-solid fa-moon text-blue-300"></i>';
                    } else if (data.cloudiness > 70) {
                        weatherSpan.innerHTML = '<i class="fa-solid fa-cloud text-gray-400"></i>';
                    } else {
                        weatherSpan.innerHTML = '<i class="fa-solid fa-sun text-yellow-500"></i>';
                    }

                    // تحديث المبيان
                    updateChart(data.production, data.consumption, data.timestamp);
                });
        }

        // تحديث كل ثانيتين
        setInterval(refreshSimulation, 2000);
    });

    // دالة تحديث المبيان
    function updateChart(prod, cons, time) {
        if (!energyChart) return;

        energyChart.data.labels.push(time);
        energyChart.data.datasets[0].data.push(prod);
        energyChart.data.datasets[1].data.push(cons);

        if (energyChart.data.labels.length > 13) {
            energyChart.data.labels.shift();
            energyChart.data.datasets[0].data.shift();
            energyChart.data.datasets[1].data.shift();
        }
        
        energyChart.update('none'); // تحديث بدون animation ثقيل
    }
</script>
@endsection