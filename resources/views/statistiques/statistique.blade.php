@extends('layouts.layout')
@section('title','SmartSol | Statistiques & Analyse')
@section('content')

<div class="p-8 space-y-8 min-h-screen text-white">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full">

        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-[#FBB108]/30 transition-all shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#FBB108]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 7V3M12 21v-4m9-5h-4M7 12H3m15.364-6.364l-2.828 2.828M8.464 15.536l-2.828 2.828m0-11.314l2.828 2.828m8.486 8.486l2.828 2.828M12 8a4 4 0 100 8 4 4 0 000-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <h2 class="text-gray-400 self-start mb-10 font-medium tracking-wide uppercase text-xs">Production d'énergie</h2>
            <div class="flex items-baseline gap-2 mt-4">
                <span id="stat-power" class="text-[#FBB108] text-5xl font-black italic tracking-tighter">
                    {{ $latestData->isNotEmpty() ? $latestData->first()->power : '0' }}
                </span>
                <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">Watts</span>
            </div>
        </div>

        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-blue-500/30 transition-all shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="text-gray-400 self-start mb-10 font-medium tracking-wide uppercase text-xs">Consommation Estimée</h2>
            <div class="flex items-baseline gap-2 mt-4">
                <span class="text-blue-500 text-5xl font-black italic tracking-tighter">
                    {{ $latestData->isNotEmpty() ? number_format($latestData->first()->power * 0.65, 1) : '0' }}
                </span>
                <span class="text-gray-500 text-[11px] uppercase font-bold tracking-widest">Watts</span>
            </div>
        </div>

        <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 p-10 rounded-[1.5rem] flex flex-col hover:border-white/20 transition-all shadow-2xl">
            <h2 class="text-gray-400 self-start mb-6 font-medium tracking-wide uppercase text-[10px]">Tendance de Production</h2>
            <div class="w-full h-full min-h-[100px]">
                <canvas id="minichart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 rounded-[1.5rem] p-8 shadow-2xl">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="h-6 w-[2px] bg-[#FBB108]"></div>
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-300">Analyse Comparative (P vs C)</h3>
            </div>
            <div class="flex gap-4 text-[10px] uppercase font-bold tracking-widest">
                <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#FBB108]"></span> Production</span>
                <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Consommation</span>
            </div>
        </div>
        <div class="w-full h-[350px]">
            <canvas id="comparisonChart"></canvas>
        </div>
    </div>

    <div class="bg-[#121212]/50 backdrop-blur-md border border-white/10 rounded-[1.5rem] overflow-hidden shadow-2xl">
        <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-400">Historique des mesures</h3>
            <span class="text-[10px] text-[#FBB108] bg-[#FBB108]/10 px-3 py-1 rounded-full border border-[#FBB108]/20 italic">Live Data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-white/5 text-gray-500 uppercase text-[10px] tracking-widest border-b border-white/5">
                    <tr>
                        <th class="px-8 py-5">Heure</th>
                        <th class="px-8 py-5">Voltage (V)</th>
                        <th class="px-8 py-5">Courant (A)</th>
                        <th class="px-8 py-5">Puissance (W)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($latestData as $data)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-8 py-5 font-mono text-gray-400">{{ $data->created_at->format('H:i:s') }}</td>
                        <td class="px-8 py-5 text-gray-400">{{ $data->voltage }}V</td>
                        <td class="px-8 py-5 text-gray-400">{{ $data->current }}A</td>
                        <td class="px-8 py-5 font-bold text-[#FBB108] text-lg italic tracking-tight">{{ $data->power }}W</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-500 italic">
                            <i class="fa-solid fa-plug-circle-exclamation mb-2 block text-2xl text-gray-600"></i>
                            Aucune donnée disponible
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@php
$chartData = $latestData->reverse();
$labels = $chartData->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('H:i'));
$powers = $chartData->pluck('power');
@endphp


<script src="https://cdn.jsdelivr.net/npm/chart.js">
    
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // جلب البيانات الممررة من الـ Blade
        const labelsData = @json($labels);
        const productionData = @json($powers);
        
        // محاكاة بيانات الاستهلاك (60% من الإنتاج + نويز خفيف)
        const consumptionData = productionData.map(p => (p * 0.6) + (Math.random() * 5));

        // ==========================================
        // 1️⃣ إعداد وإشعاع الـ MINI CHART (تيسير خط الإنتاج)
        // ==========================================
        const ctxMini = document.getElementById('minichart').getContext('2d');
        
        // إنشاء تدرج شفاف تحت الخط الأصفر
        const gradMini = ctxMini.createLinearGradient(0, 0, 0, 70);
        gradMini.addColorStop(0, 'rgba(251, 177, 8, 0.25)');
        gradMini.addColorStop(1, 'rgba(251, 177, 8, 0)');

        new Chart(ctxMini, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    data: productionData,
                    borderColor: '#FBB108',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: gradMini,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                scales: { x: { display: false }, y: { display: false } },
                animation: { duration: 800, easing: 'easeOutQuad' }
            }
        });

        // ==========================================
        // 2️⃣ إعداد مبيان المقارنة الرئيسي (Comparison Chart)
        // ==========================================
        const ctxComp = document.getElementById('comparisonChart').getContext('2d');
        
        // تدرج لوني فخم للإنتاج (الأصفر الشفاف)
        const gradProd = ctxComp.createLinearGradient(0, 0, 0, 300);
        gradProd.addColorStop(0, 'rgba(251, 177, 8, 0.15)');
        gradProd.addColorStop(1, 'rgba(251, 177, 8, 0.01)');

        // تدرج لوني ناعم للاستهلاك (الأزرق الشفاف)
        const gradCons = ctxComp.createLinearGradient(0, 0, 0, 300);
        gradCons.addColorStop(0, 'rgba(59, 130, 246, 0.08)');
        gradCons.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctxComp, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [
                    {
                        label: 'Production',
                        data: productionData,
                        borderColor: '#FBB108',
                        backgroundColor: gradProd,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FBB108',
                        pointBorderColor: '#121212',
                        pointBorderWidth: 1.5,
                        pointRadius: 0, // مخفي ويظهر فقط عند الـ Hover
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#FBB108',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    },
                    {
                        label: 'Consommation',
                        data: consumptionData,
                        borderColor: '#3b82f6',
                        backgroundColor: gradCons,
                        borderWidth: 2,
                        borderDash: [6, 6], // ستايل مقطع احترافي للتمييز
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        pointHoverBackgroundColor: '#3b82f6',
                        pointHoverBorderColor: '#ffffff'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: { display: false }, // مخفية لأننا صاوبنا وحدة مخصصة بالـ HTML
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#16161a', // خلفية داكنة متناسقة مع السيستم
                        titleColor: '#94a3b8',
                        titleFont: { size: 11, weight: 'bold', family: 'sans-serif' },
                        bodyColor: '#ffffff',
                        bodyFont: { size: 13, weight: '600' },
                        borderColor: 'rgba(255, 255, 255, 0.08)',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        cornerRadius: 12,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) label += context.parsed.y.toFixed(1) + ' W';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11, weight: '500' },
                            maxTicksLimit: 12 // منع ازدحام الكلمات فالمحور الأفقي
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.03)', // خطوط أفقية ناعمة جداً
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11, family: 'monospace' },
                            callback: function(value) { return value + ' W'; }
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });
    });
</script>

<style>
    /* تحسين الـ Scrollbar ليتناسب مع الـ Bento Grid والـ Dark Mode */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #0d0d0d;
    }

    ::-webkit-scrollbar-thumb {
        background: #222222;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #FBB108;
    }
</style>

@endsection