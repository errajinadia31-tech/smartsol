@extends('layouts.layout')

@section('title', __('SmartSol | Gestion des Panneaux'))

@section('content')

<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10 px-4 md:px-8">
        <h1 class="text-2xl font-bold text-white">
        {{ __('Gestion des Panneaux') }}
    </h1>

    <button onclick="toggleModal()"
        class="bg-[#FBB108] hover:bg-[#fbc547] text-black font-bold py-3 px-6 rounded-xl shadow-[0_0_20px_rgba(251,177,8,0.3)] transition-all active:scale-95 flex items-center gap-2">
        <i class="fa-solid fa-plus-circle"></i>
        {{ __('Ajouter un Panneau') }}
    </button>
</div>

@if(session('success'))
<div class="max-w-4xl mx-auto mb-6 px-8">
    <div class="bg-green-500/10 border border-green-500/50 backdrop-blur-md text-green-500 p-4 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-check-circle text-lg"></i>
        <span class="font-medium">{{ __(session('success')) }}</span>
    </div>
</div>
@endif

{{-- ADD PANEL MODAL --}}
<div id="panelModal" class="fixed inset-0 z-50 hidden overflow-y-auto">

    <div class="fixed inset-0 bg-black/40 backdrop-blur-[4px]" onclick="toggleModal()"></div>

    <div class="flex items-center justify-center min-h-screen p-4">

        <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 w-full max-w-2xl p-8 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.5)]">

            <button onclick="toggleModal()"
                class="absolute top-6 right-6 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span class="p-2 bg-[#FBB108]/10 rounded-lg">
                        <i class="fa-solid fa-solar-panel text-[#FBB108]"></i>
                    </span>
                    {{ __('Configuration du Panneau') }}
                </h2>
            </div>

            <form action="{{ route('panels.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            {{ __('Nom du Panneau') }}
                        </label>
                        <input type="text" name="name" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white outline-none focus:border-[#FBB108]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            {{ __('Numéro de Série') }}
                        </label>
                        <input type="text" name="serial_number" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white outline-none focus:border-[#FBB108]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            {{ __('Puissance (Watts)') }}
                        </label>
                        <input type="number" step="0.01" name="power_capacity" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white outline-none focus:border-[#FBB108]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            {{ __('État') }}
                        </label>
                        <select name="status" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl py-3 px-4 text-white outline-none">
                            <option value="active">{{ __('Active') }}</option>
                            <option value="inactive">{{ __('Inactive') }}</option>
                            <option value="maintenance">{{ __('Maintenance') }}</option>
                        </select>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            {{ __('Région') }}
                        </label>
                        <select id="region-select" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl py-3 px-4 text-white outline-none">
                            <option value="" disabled selected>{{ __('Choisir une région') }}</option>
                            @foreach($zones->unique('name') as $zone)
                                <option value="{{ $zone->name }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            {{ __('Ville') }}
                        </label>
                        <select id="city-select" name="zone_id" required
                            class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl py-3 px-4 text-white outline-none">
                            <option value="" disabled selected>{{ __('Sélectionner la ville') }}</option>
                        </select>
                    </div>

                </div>

                <div class="pt-6 flex justify-end gap-4 border-t border-white/5">
                    <button type="button" onclick="toggleModal()" class="text-gray-400 hover:text-white px-4">
                        {{ __('Annuler') }}
                    </button>
                    <button type="submit" class="bg-[#FBB108] text-black font-bold py-3 px-10 rounded-xl shadow-lg">
                        {{ __('Enregistrer') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- PANELS GRID --}}
<div class="px-8 mt-10 rounded-3xl py-10">

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($panels as $panel)

        <div class="group relative overflow-hidden w-full bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] hover:border-[#FBB108]/50 transition-all duration-500 overflow-hidden flex flex-col">

            {{-- IMAGE --}}
            <div class="relative h-48 w-full overflow-hidden">
                <img src="{{ asset('images/panel.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/40"></div>
                
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter backdrop-blur-md
                        @if($panel->status == 'active')
                            bg-green-700/20 text-green-400 border border-green-500/30
                        @elseif($panel->status == 'maintenance')
                            bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                        @else
                            bg-red-800/20 text-red-400 border border-red-500/30
                        @endif">
                        ● {{ __(ucfirst($panel->status)) }}
                    </span>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="p-6 relative z-10 flex flex-col flex-grow">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-white font-bold text-xl group-hover:text-[#FBB108] transition-colors">
                            {{ $panel->name }}
                        </h3>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mt-1">
                            {{ $panel->serial_number }}
                        </p>
                    </div>
                    <div class="p-3 bg-[#FBB108]/10 rounded-2xl text-[#FBB108] group-hover:bg-[#FBB108] group-hover:text-black transition-all">
                        <i class="fa-solid fa-solar-panel text-lg"></i>
                    </div>
                </div>

                {{-- STATS --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-black/40 p-4 rounded-2xl border border-white/5">
                        <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">
                            {{ __('Capacité') }}
                        </p>
                        <p class="text-white font-black text-lg">
                            {{ $panel->power_capacity }}
                            <span class="text-xs text-[#FBB108]">W</span>
                        </p>
                    </div>

                    <div class="bg-black/40 p-4 rounded-2xl border border-white/5">
                        <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">
                            {{ __('Ville') }}
                        </p>
                        <p class="text-white font-black text-lg truncate">
                            {{ $panel->zone->city ?? __('N/A') }}
                        </p>
                    </div>
                </div>

                {{-- WEATHER SECTION --}}
                @php
                    $city = $panel->zone->city ?? null;
                    $cityWeather = $weatherData[$city] ?? null;
                @endphp

                <div class="mt-auto pt-5 border-t border-white/5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-[#FBB108] rounded-full animate-pulse"></div>
                            <span class="text-xs text-gray-400 font-medium">
                                {{ $city ?? __('Ville N/A') }}
                            </span>
                        </div>

                        @if($cityWeather && isset($cityWeather['weather'][0]['icon']))
                        <div class="flex items-center gap-1 bg-black/30 px-3 py-1 rounded-full border border-white/5">
                            <img src="http://openweathermap.org/img/wn/{{ $cityWeather['weather'][0]['icon'] }}.png" class="w-8 h-8" alt="weather">
                            <span class="text-[#FBB108] text-sm font-black italic">
                                {{ round($cityWeather['main']['temp']) }}°C
                            </span>
                        </div>
                        @endif
                    </div>

                    @if($cityWeather)
                    <div class="grid grid-cols-2 gap-2 text-[10px] text-gray-500 uppercase font-bold tracking-tight">
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-droplet text-[#FBB108]"></i>
                            <span>
                                {{ __('Humidité:') }}
                                <span class="text-white">{{ $cityWeather['main']['humidity'] }}%</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-wind text-[#FBB108]"></i>
                            <span>
                                {{ __('Vent:') }}
                                <span class="text-white">{{ round($cityWeather['wind']['speed']) }} km/h</span>
                            </span>
                        </div>
                    </div>
                    @else
                    <div class="text-center italic text-gray-600 text-[10px]">
                        {{ __('Météo indisponible') }}
                    </div>
                    @endif
                </div>

                {{-- ACTIONS --}}
                <div class="mt-5 pt-5 border-t border-white/5">
                    <div class="flex gap-2 justify-end">
                        {{-- EDIT --}}
                        <button type="button"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 text-gray-400 hover:bg-[#FBB108] hover:text-black transition-all"
                            onclick="openEditModal(
                                {{ $panel->id }},
                                '{{ $panel->name }}',
                                '{{ $panel->serial_number }}',
                                {{ $panel->power_capacity }},
                                '{{ $panel->status }}',
                                {{ $panel->zone_id ?? 'null' }}
                            )">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                        </button>

                        {{-- DELETE --}}
                        <form action="{{ route('panels.destroy', $panel->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('{{ __('Supprimer ce panneau ?') }}')"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                <i class="fa-solid fa-trash text-[10px]"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @empty
        <div class="col-span-full py-20 text-center text-gray-500 uppercase tracking-widest font-bold">
            {{ __('Aucun panneau trouvé') }}
        </div>
        @endforelse

    </div>
</div>

{{-- EDIT MODAL --}}
<div id="editPanelModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm px-4">
    <div class="absolute inset-0" onclick="closeEditModal()"></div>

    <div class="relative w-full max-w-lg overflow-hidden rounded-3xl border border-white/10 bg-[#0b0b0b]/95 shadow-[0_0_60px_rgba(251,177,8,0.08)]">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#FBB108] via-yellow-300 to-[#FBB108]"></div>

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-7 py-5 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#FBB108]/10 flex items-center justify-center border border-[#FBB108]/20">
                    <i class="fa-solid fa-pen text-[#FBB108] text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">
                        {{ __('Modifier le panneau') }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Mise à jour des informations du panneau solaire') }}
                    </p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-red-500 hover:text-white text-gray-400 transition-all flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- FORM --}}
        <form id="editPanelForm" method="POST" class="p-7 space-y-5">
            @csrf
            @method('PUT')

            <input type="hidden" id="panel_id" name="panel_id">
            <input type="hidden" id="edit_zone_id" name="zone_id">

            {{-- PANEL NAME --}}
            <div class="space-y-2">
                <label class="text-xs uppercase tracking-widest text-gray-500 font-bold">
                    {{ __('Nom du panneau') }}
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FBB108]">
                        <i class="fa-solid fa-solar-panel"></i>
                    </span>
                    <input type="text" id="edit_name" name="name" placeholder="{{ __('Nom du panneau') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white/5 border border-white/10 text-white placeholder:text-gray-600 outline-none focus:border-[#FBB108] focus:bg-[#FBB108]/[0.03] transition-all">
                </div>
            </div>

            {{-- SERIAL --}}
            <div class="space-y-2">
                <label class="text-xs uppercase tracking-widest text-gray-500 font-bold">
                    {{ __('Numéro de série') }}
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FBB108]">
                        <i class="fa-solid fa-barcode"></i>
                    </span>
                    <input type="text" id="edit_serial_number" name="serial_number" placeholder="{{ __('Numéro de série') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white/5 border border-white/10 text-white placeholder:text-gray-600 outline-none focus:border-[#FBB108] focus:bg-[#FBB108]/[0.03] transition-all">
                </div>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- POWER --}}
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-widest text-gray-500 font-bold">
                        {{ __('Puissance') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FBB108]">
                            <i class="fa-solid fa-bolt"></i>
                        </span>
                        <input type="number" id="edit_power_capacity" name="power_capacity" placeholder="0"
                            class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white/5 border border-white/10 text-white placeholder:text-gray-600 outline-none focus:border-[#FBB108] focus:bg-[#FBB108]/[0.03] transition-all">
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-widest text-gray-500 font-bold">
                        {{ __('Status') }}
                    </label>
                    <select id="edit_status" name="status"
                        class="w-full py-3 px-4 bg-gray-600 rounded-2xl bg-white/5 border border-white/10 text-white outline-none focus:border-[#FBB108] transition-all">
                        <option value="active" class="bg-[#111111] text-white">{{ __('Active') }}</option>
                        <option value="inactive" class="bg-[#111111] text-white">{{ __('Inactive') }}</option>
                        <option value="maintenance" class="bg-[#111111] text-white">{{ __('Maintenance') }}</option>
                    </select>
                </div>
            </div>

            {{-- REGION & CITY --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- REGION --}}
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-widest text-gray-500 font-bold">
                        {{ __('Région') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FBB108]">
                            <i class="fa-solid fa-map"></i>
                        </span>
                        <select id="edit_region" class="w-full pl-12 pr-4 py-3 bg-gray-600 rounded-2xl bg-white/5 border border-white/10 text-white outline-none focus:border-[#FBB108] transition-all">
                            <option value="" class="bg-yellow-500 font-bold">{{ __('Choisir région') }}</option>
                            @foreach($zones->unique('name') as $zone)
                                <option value="{{ $zone->name }}" class="bg-[#111111] text-white">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- CITY --}}
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-widest text-gray-500 font-bold">
                        {{ __('Ville') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FBB108]">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <select id="edit_city" name="zone_id" class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white/5 border border-white/10 text-white outline-none focus:border-[#FBB108] transition-all">
                            <option value="" class="bg-[#111111] text-white">{{ __('Choisir ville') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="flex items-center justify-end gap-3 pt-5 border-t border-white/5">
                <button type="button" onclick="closeEditModal()" class="px-5 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-gray-300 transition-all">
                    {{ __('Annuler') }}
                </button>
                <button type="submit" class="px-6 py-3 rounded-2xl bg-[#FBB108] hover:bg-[#ffd04d] text-black font-bold shadow-[0_0_20px_rgba(251,177,8,0.25)] transition-all active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ __('Sauvegarder') }}
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function toggleModal() {
    document.getElementById('panelModal').classList.toggle('hidden');
}

/* =========================
   ADD MODAL - REGION/CITY
========================= */
document.addEventListener('DOMContentLoaded', function () {
    const allZones = @json($zones);
    const regionSelect = document.getElementById('region-select');
    const citySelect = document.getElementById('city-select');

    if (regionSelect) {
        regionSelect.addEventListener('change', function () {
            const selectedRegion = this.value;
            citySelect.innerHTML = '<option value="" disabled selected>{{ __("Choisir la ville") }}</option>';

            const filteredCities = allZones.filter(zone => zone.name === selectedRegion);

            filteredCities.forEach(zone => {
                const option = document.createElement('option');
                option.value = zone.id;
                option.textContent = zone.city;
                option.classList.add('bg-[#111111]', 'text-white');
                citySelect.appendChild(option);
            });
        });
    }
});

/* =========================
   EDIT MODAL - REGION/CITY
========================= */
const allZones = @json($zones);
const editRegion = document.getElementById('edit_region');
const editCity = document.getElementById('edit_city');

if (editRegion) {
    editRegion.addEventListener('change', function () {
        const selectedRegion = this.value;
        editCity.innerHTML = '<option value="">{{ __("Choisir ville") }}</option>';

        const filteredCities = allZones.filter(zone => zone.name === selectedRegion);

        filteredCities.forEach(zone => {
            const option = document.createElement('option');
            option.value = zone.id;
            option.textContent = zone.city;
            option.classList.add('bg-[#111111]', 'text-white');
            editCity.appendChild(option);
        });
    });
}

/* =========================
   OPEN EDIT MODAL
========================= */
function openEditModal(id, name, serial, power, status, zoneId) {
    document.getElementById('editPanelModal').classList.remove('hidden');
    document.getElementById('panel_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_serial_number').value = serial;
    document.getElementById('edit_power_capacity').value = power;
    document.getElementById('edit_status').value = status;
    document.getElementById('editPanelForm').action = `/panels/${id}`;

    const currentZone = allZones.find(zone => zone.id == zoneId);

    if (currentZone) {
        editRegion.value = currentZone.name;
        const filteredCities = allZones.filter(zone => zone.name === currentZone.name);
        editCity.innerHTML = '<option value="" class="bg-yellow-500 text-white font-bold">{{ __("Choisir ville") }}</option>';

        filteredCities.forEach(zone => {
            const option = document.createElement('option');
            option.value = zone.id;
            option.textContent = zone.city;
            option.classList.add('bg-[#111111]', 'text-white');

            if (zone.id == zoneId) {
                option.selected = true;
            }
            editCity.appendChild(option);
        });
    }
}

function closeEditModal() {
    document.getElementById('editPanelModal').classList.add('hidden');
}
</script>
@endsection