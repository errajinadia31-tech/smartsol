@extends('layouts.layout')
@section('title', __('SmartSol | Entreprises'))

@section('content')

<div class="min-h-screen px-6 md:px-8 py-10">

    <div class="max-w-5xl mx-auto text-center mb-10">

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#FBB108]/10 border border-[#FBB108]/20 text-[#FBB108] text-sm mb-5">
            <i class="fa-solid fa-solar-panel"></i>
            {{ __('Réseau National des Entreprises Solaires') }}
        </div>

        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight">
            {{ __('Annuaire des') }}
            <span class="text-[#FBB108]">{{ __('Entreprises Solaires') }}</span>
        </h1>

        <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
            {{ __('Trouvez rapidement des sociétés spécialisées dans les panneaux solaires, l’énergie photovoltaïque et les solutions énergétiques partout au Maroc.') }}
        </p>

    </div>

    <div class="max-w-6xl mx-auto mb-10">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="md:col-span-3 relative">

                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>

                <input
                    type="text"
                    id="searchInput"
                    onkeyup="filterCompanies()"
                    placeholder="{{ __('Rechercher une entreprise...') }}"
                    class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-900/70 border border-white/10 text-white placeholder:text-gray-500 focus:outline-none focus:border-[#FBB108] transition-all duration-300">

            </div>

            <div>

                <select
                    id="cityFilter"
                    onchange="filterCompanies()"
                    class="w-full py-4 px-4 rounded-2xl bg-gray-900/70 border border-white/10 text-white focus:outline-none focus:border-[#FBB108] transition-all duration-300">
                    <option value="all">{{ __('Toutes les villes') }}</option>
                    <option value="Oujda">{{ __('Oujda') }}</option>
                    <option value="Casablanca">{{ __('Casablanca') }}</option>
                    <option value="Rabat">{{ __('Rabat / Témara') }}</option>
                    <option value="Marrakech">{{ __('Marrakech') }}</option>
                    <option value="Tanger">{{ __('Tanger') }}</option>
                </select>

            </div>

        </div>

    </div>

    <div id="companiesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @php
        $companies = [
            ['name'=>'Energy Pro Tech','city'=>'Oujda','phone'=>'+212 661-966236','badge'=>'Solar Expert','icon'=>'solar-panel'],
            ['name'=>'Sun Energy and Water','city'=>'Oujda','phone'=>'+212 536-741345','badge'=>'Énergie','icon'=>'sun'],
            ['name'=>'STE ONERA SYSTEMS','city'=>'Oujda','phone'=>'+212 670-207269','badge'=>'Installation','icon'=>'bolt'],

            ['name'=>'Chamsolar Maroc','city'=>'Casablanca','phone'=>'+212 623-948607','badge'=>'Photovoltaïque','icon'=>'solar-panel'],
            ['name'=>'Tecas Energie Solaire','city'=>'Casablanca','phone'=>'+212 520-854141','badge'=>'Green Energy','icon'=>'leaf'],
            ['name'=>'Energy Market','city'=>'Casablanca','phone'=>'+212 659-305986','badge'=>'Solar Pro','icon'=>'sun'],
            ['name'=>'SUNQ ENERGIE','city'=>'Casablanca','phone'=>'+212 661-081009','badge'=>'Smart Energy','icon'=>'lightbulb'],
            ['name'=>'BEYSOLAR','city'=>'Casablanca','phone'=>'+212 808-545914','badge'=>'Distribution','icon'=>'building'],

            ['name'=>'Freeray Rabat','city'=>'Rabat','phone'=>'+212 537-686637','badge'=>'Installation','icon'=>'screwdriver-wrench'],
            ['name'=>'Innov Énergie','city'=>'Rabat','phone'=>'+212 661-068337','badge'=>'Innovation','icon'=>'bolt'],
            ['name'=>'Maroc Energies Renouvelable','city'=>'Rabat','phone'=>'+212 537-770082','badge'=>'Renewable','icon'=>'leaf'],

            ['name'=>'EXPERT GROUPE MAROC','city'=>'Marrakech','phone'=>'+212 600-109300','badge'=>'Expert','icon'=>'gear'],
            ['name'=>'Wattuneed Maroc','city'=>'Marrakech','phone'=>'+212 645-699083','badge'=>'Smart Energy','icon'=>'lightbulb'],
            ['name'=>'Cercles énergie','city'=>'Marrakech','phone'=>'+212 614-666721','badge'=>'Solar Tech','icon'=>'sun'],

            ['name'=>'Sysol Maroc','city'=>'Tanger','phone'=>'+212 662-798070','badge'=>'Photovoltaïque','icon'=>'solar-panel'],
            ['name'=>'GREENOOR énergie','city'=>'Tanger','phone'=>'+212 772-072760','badge'=>'Green Energy','icon'=>'leaf'],
            ['name'=>'B2B Distribution','city'=>'Tanger','phone'=>'+212 662-152773','badge'=>'Distribution','icon'=>'building'],

            ['name'=>'Abousol','city'=>'Casablanca','phone'=>'+212 522 81 57 91','badge'=>'National','icon'=>'globe'],
            ['name'=>'ChamsTech','city'=>'Maroc','phone'=>'+212 703 99 26 21','badge'=>'Renewable','icon'=>'bolt'],
            ['name'=>'Tawfir Energy','city'=>'Maroc','phone'=>'Non disponible','badge'=>'Smart Energy','icon'=>'lightbulb'],
            ['name'=>'Deep Solar','city'=>'Casablanca','phone'=>'+212 661 63 79 68','badge'=>'Photovoltaïque','icon'=>'solar-panel'],
            ['name'=>'CI Energy','city'=>'Rabat','phone'=>'Non disponible','badge'=>'Green Energy','icon'=>'leaf'],
        ];
        @endphp

        @foreach($companies as $company)

        <div
            class="company-card group bg-gradient-to-b from-gray-900/80 to-black/40 border border-white/10 hover:border-[#FBB108]/50 rounded-3xl p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_0_30px_rgba(251,177,8,0.15)] backdrop-blur-xl"
            data-name="{{ strtolower($company['name']) }}"
            data-city="{{ $company['city'] }}">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <span class="text-[10px] px-3 py-1 rounded-full bg-[#FBB108]/10 border border-[#FBB108]/20 text-[#FBB108]">
                        {{ __($company['badge']) }}
                    </span>

                    <h3 class="title text-white font-extrabold text-2xl mt-3">
                        {{ $company['name'] }}
                    </h3>

                    <p class="text-gray-400 text-sm mt-1">
                        {{ __($company['city']) }}
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-[#FBB108]/10 flex items-center justify-center text-[#FBB108] text-2xl">
                    <i class="fa-solid fa-{{ $company['icon'] }}"></i>
                </div>

            </div>

            @if($company['phone'] != 'Non disponible')

            <a
                href="tel:{{ str_replace(' ','',$company['phone']) }}"
                class="flex items-center gap-3 p-4 rounded-2xl bg-white/5 border border-white/5 hover:border-[#FBB108]/20 hover:bg-[#FBB108]/5 transition-all duration-300 text-gray-300 hover:text-white">

                <i class="fa-solid fa-phone text-[#FBB108]"></i>
                {{ $company['phone'] }}

            </a>

            @else

            <div class="flex items-center gap-3 p-4 rounded-2xl bg-white/5 border border-white/5 text-gray-500">
                <i class="fa-solid fa-circle-exclamation text-[#FBB108]"></i>
                {{ __('Contact non disponible') }}
            </div>

            @endif

        </div>

        @endforeach

    </div>

    <div id="noResults" class="hidden text-center mt-16">

        <div class="w-24 h-24 mx-auto rounded-full bg-[#FBB108]/10 flex items-center justify-center mb-5">
            <i class="fa-solid fa-circle-exclamation text-4xl text-[#FBB108]"></i>
        </div>

        <h3 class="text-white text-2xl font-bold mb-2">
            {{ __('Aucun résultat trouvé') }}
        </h3>

        <p class="text-gray-400">
            {{ __('Essayez un autre nom ou une autre ville.') }}
        </p>

    </div>

</div>

<script>
    function filterCompanies() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const city = document.getElementById('cityFilter').value;
        const cards = document.getElementsByClassName('company-card');
        const noResults = document.getElementById('noResults');
        let visibleCount = 0;

        for (let card of cards) {
            // دابا الـ JavaScript كايقرا الـ Attributes الأصلية وخا تبدل لغة الواجهة
            const companyName = card.getAttribute('data-name');
            const cardCity = card.getAttribute('data-city');

            const matchesSearch = companyName.includes(search);
            const matchesCity = city === 'all' || cardCity === city;

            if (matchesSearch && matchesCity) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        }

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }
</script>

@endsection