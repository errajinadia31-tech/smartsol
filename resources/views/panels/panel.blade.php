@extends('layouts.layout')
@section('title','SmartSol | Gestion des Panneaux')

@section('content')
<div class="flex justify-between items-center mb-10 px-8">
    <h1 class="text-2xl font-bold text-white">Gestion des Panneaux</h1>
    <button onclick="toggleModal()" class="bg-[#FBB108] hover:bg-[#fbc547] text-black font-bold py-3 px-6 rounded-xl shadow-[0_0_20px_rgba(251,177,8,0.3)] transition-all active:scale-95 flex items-center gap-2">
        <i class="fa-solid fa-plus-circle"></i>
        Ajouter un Panneau
    </button>
</div>

@if(session('success'))
<div class="max-w-4xl mx-auto mb-6 px-8">
    <div class="bg-green-500/10 border border-green-500/50 backdrop-blur-md text-green-500 p-4 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-check-circle text-lg"></i>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

{{-- Modal d'ajout (نفس الكود ديالك بدون تغيير) --}}
<div id="panelModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-[4px]" onclick="toggleModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 w-full max-w-2xl p-8 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
            <button onclick="toggleModal()" class="absolute top-6 right-6 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span class="p-2 bg-[#FBB108]/10 rounded-lg">
                        <i class="fa-solid fa-solar-panel text-[#FBB108]"></i>
                    </span>
                    Configuration du Panneau
                </h2>
            </div>
            <form id="panelForm" action="{{ route('panels.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Nom du Panneau</label>
                        <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white outline-none focus:border-[#FBB108]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Numéro de Série</label>
                        <input type="text" name="serial_number" required class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white outline-none focus:border-[#FBB108]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Puissance (Watts)</label>
                        <input type="number" step="0.01" name="power_capacity" required class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white outline-none focus:border-[#FBB108]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">État</label>
                        <select name="status" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl py-3 px-4 text-white outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Région</label>
                        <select id="region-select" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl py-3 px-4 text-white outline-none">
                            <option value="" disabled selected>Choisir une région</option>
                            @foreach($zones->unique('name') as $zone)
                                <option value="{{ $zone->name }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Ville</label>
                        <select id="city-select" name="zone_id" required class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl py-3 px-4 text-white outline-none">
                            <option value="" disabled selected>Sélectionnez la ville</option>
                        </select>
                    </div>
                </div>
                <div class="pt-6 flex justify-end gap-4 border-t border-white/5">
                    <button type="button" onclick="toggleModal()" class="text-gray-400 hover:text-white px-4">Annuler</button>
                    <button type="submit" class="bg-[#FBB108] text-black font-bold py-3 px-10 rounded-xl shadow-lg">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Section des Cards --}}
<div class="px-8 mt-10 rounded-3xl py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($panels as $panel)
        <div class="group relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] hover:border-[#FBB108]/50 transition-all duration-500 overflow-hidden flex flex-col">
            
            {{-- Image & Status --}}
            <div class="relative h-48 w-full overflow-hidden">
                <img src="{{ asset('images/panel.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Panneau">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter backdrop-blur-md
                        @if($panel->status == 'active') bg-green-700/20 text-green-400 border border-green-500/30
                        @elseif($panel->status == 'maintenance') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                        @else bg-red-800/20 text-red-400 border border-red-500/30 @endif">
                        ● {{ $panel->status }}
                    </span>
                </div>
            </div>

            {{-- Info Content --}}
            <div class="p-6 relative z-10 flex flex-col flex-grow">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-white font-bold text-xl group-hover:text-[#FBB108] transition-colors">{{ $panel->name }}</h3>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mt-1">{{ $panel->serial_number }}</p>
                    </div>
                    <div class="p-3 bg-[#FBB108]/10 rounded-2xl text-[#FBB108] group-hover:bg-[#FBB108] group-hover:text-black transition-all">
                        <i class="fa-solid fa-solar-panel text-lg"></i>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-black/40 p-4 rounded-2xl border border-white/5">
                        <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Capacité</p>
                        <p class="text-white font-black text-lg">{{ $panel->power_capacity }} <span class="text-xs text-[#FBB108]">W</span></p>
                    </div>
                    <div class="bg-black/40 p-4 rounded-2xl border border-white/5">
                        <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Ville</p>
                        <p class="text-white font-black text-lg truncate">{{ $panel->zone->city ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Weather Section (Logic corrected) --}}
                @php
                    $city = $panel->zone->city ?? null;
                    $cityWeather = $weatherData[$city] ?? null;
                @endphp

                <div class="mt-auto pt-5 border-t border-white/5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-[#FBB108] rounded-full animate-pulse"></div>
                            <span class="text-xs text-gray-400 font-medium">{{ $city ?? 'Ville N/A' }}</span>
                        </div>
                        
                        @if($cityWeather && isset($cityWeather['weather'][0]['icon']))
                        <div class="flex items-center gap-1 bg-black/30 px-3 py-1 rounded-full border border-white/5">
                            <img src="http://openweathermap.org/img/wn/{{ $cityWeather['weather'][0]['icon'] }}.png" class="w-8 h-8" alt="weather">
                            <span class="text-[#FBB108] text-sm font-black italic">{{ round($cityWeather['main']['temp']) }}°C</span>
                        </div>
                        @endif
                    </div>

                    @if($cityWeather)
                    <div class="grid grid-cols-2 gap-2 text-[10px] text-gray-500 uppercase font-bold tracking-tight">
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-droplet text-[#FBB108]"></i>
                            <span>Humidité: <span class="text-white">{{ $cityWeather['main']['humidity'] }}%</span></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-wind text-[#FBB108]"></i>
                            <span>Vent: <span class="text-white">{{ round($cityWeather['wind']['speed']) }} km/h</span></span>
                        </div>
                    </div>
                    @else
                        <div class="text-center italic text-gray-600 text-[10px]">Météo indisponible</div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex gap-2 justify-end mt-4 pt-4 border-t border-white/5">
                        <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 text-gray-400 hover:bg-[#FBB108] hover:text-black transition-all"
                                onclick="openEditModal({{ $panel->id }}, '{{ $panel->name }}', '{{ $panel->serial_number }}', {{ $panel->power_capacity }}, '{{ $panel->status }}', '{{ $panel->zone->name ?? '' }}', {{ $panel->zone_id }})">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                        </button>
                        <form action="{{ route('panels.destroy', $panel->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce panneau ?')" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                <i class="fa-solid fa-trash text-[10px]"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center text-gray-500 uppercase tracking-widest font-bold">
            Aucun panneau trouvé
        </div>
        @endforelse
    </div>
</div>

<script>
    function toggleModal() {
        document.getElementById('panelModal').classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const allZones = @json($zones);
        const regionSelect = document.getElementById('region-select');
        const citySelect = document.getElementById('city-select');

        regionSelect.addEventListener('change', function() {
            const selectedRegion = this.value;
            citySelect.innerHTML = '<option value="" disabled selected>Sélectionnez la ville</option>';
            const filteredCities = allZones.filter(zone => zone.name === selectedRegion);
            filteredCities.forEach(zone => {
                const option = document.createElement('option');
                option.value = zone.id;
                option.textContent = zone.city;
                citySelect.appendChild(option);
            });
        });
    });
</script>
@endsection