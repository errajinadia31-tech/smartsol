<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/logo1.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>SmartSOL - Intelligent Solar Management</title>

    <style>
        .text-ener-gold {
            color: #FBB108;
        }

        .bg-ener-gold {
            background-color: #FBB108;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #FBB108 !important;
        }

        .glass-nav {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-[#0a0a0a] overflow-x-hidden text-white antialiased">
    <!-- navbar start -->
    <header >
        <nav class="absolute top-0  left-0 w-full z-20 flex items-center justify-between px-12 py-6 text-white bg-black/50 backdrop-blur-sm">
            <div class="flex items-center">
                <img src="{{ asset('images/logo1.png') }}" class="w-[38px]" alt="Logo">
                <span class="font-bold text-2xl tracking-tighter uppercase italic"> Smart<span class="text-[#FBB108]">Sol</span></span>
            </div>

            <nav class="hidden md:flex items-center gap-4 text-xs font-bold uppercase tracking-widest">
                <a href=""
                    class="border rounded-full px-5 py-2 transition-all  hover:bg-white hover:text-black transition duration-300">
                    Accueil
                </a>

                <a href="#features"
                    class="border border-white/20 rounded-full px-5 py-2 text-gray-300 transition-all hover:bg-white hover:text-black transition duration-300 ">
                    Caractéristiques
                </a>

                <a href="#about"
                    class="border border-white/20 rounded-full px-5 py-2  text-gray-300 transition-all hover:bg-white hover:text-black transition duration-300 ">
                    A propos
                </a>
            </nav>
        <div class="hidden md:block">
            <a href="{{ route('login') }}" class="px-5 py-2 border border-white/50 rounded-full hover:bg-white hover:text-black transition duration-300 text-sm">Se connecter</a>
            <a href="{{ route('register') }}" class="px-5 py-2 border border-white/50 rounded-full hover:bg-white hover:text-black transition duration-300 text-sm">S'inscrire</a>
            <a href="#pricing" class="px-6 py-2 bg-[#FBB108] text-black font-bold rounded-full hover:bg-white transition duration-300 text-sm shadow-[0_0_15px_rgba(251,177,8,0.4)]">
        S'abonner
    </a>
        </div>
        </nav>
    </header>
    <!-- navbar end -->

    <!-- hero section start -->
    <section class="relative h-screen w-full overflow-hidden bg-[#050505]">

        <div class="absolute inset-0 z-0">
            <video class="w-full h-full object-cover " autoplay muted loop playsinline>
                <source src="{{ asset('videos/video_bg.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/50 to-transparent"></div>
            <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px]"></div>
        </div>

        <div class="relative z-10 h-full container mx-auto px-6 flex flex-col justify-center">
            <div class="max-w-4xl">

                <div class="flex items-center gap-4 mb-6 mt-4" data-aos="fade-down">
                    <div class="h-[1px] w-12 bg-[#FBB108]"></div>
                    <span class="text-[#FBB108] text-[10px] font-black uppercase tracking-[0.5em]">Next-Gen Solar Intelligence</span>
                </div>

                <h1 class="text-7xl md:text-[120px] font-black leading-none uppercase italic tracking-tighter text-white" data-aos="fade-right" data-aos-delay="200">
                    SOLAR <br>
                    <span class="text-transparent" style="-webkit-text-stroke: 1.5px #FBB108;">ENERGY</span>
                </h1>

                <div class="grid md:grid-cols-2 gap-6 mt-12" data-aos="fade-up" data-aos-delay="400">

                    <div class="p-8 bg-black/40 backdrop-blur-xl border border-white/10 rounded-[2rem] flex flex-col justify-between">
                        <p class="text-white/60 text-lg leading-relaxed">
                            Prenez le contrôle total de votre production d'énergie avec une interface intuitive et des données en temps réel.
                        </p>
                        <div class="mt-8 flex gap-4">
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-[#FBB108] text-black font-black uppercase text-[10px] tracking-widest rounded-full hover:bg-white transition-all">
                                Commencer Maintenant
                            </a>
                            <button class="w-12 h-12 flex items-center justify-center border border-white/20 rounded-full text-white hover:bg-white/10">
                                <i class="fa-solid fa-play text-[10px]"></i>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] flex flex-col items-center justify-center text-center group hover:border-[#FBB108]/50 transition-all">
                            <i class="fa-solid fa-chart-line text-[#FBB108] mb-3 text-xl"></i>
                            <span class="text-[9px] text-white/40 uppercase font-bold tracking-widest">Analytics</span>
                        </div>
                        <div class="p-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] flex flex-col items-center justify-center text-center group hover:border-[#FBB108]/50 transition-all">
                            <img src="{{ asset('images/logo1.png') }}" class="w-8 h-8 mb
                            <span class="text-[9px] text-white/40 uppercase font-bold tracking-widest">Eco-Friendly</span>
                        </div>
                        <div class="col-span-2 p-6 bg-[#FBB108]/10 backdrop-blur-md border border-[#FBB108]/20 rounded-[2rem] flex items-center justify-between px-8">
                            <div>
                                <p class="text-[10px] text-[#FBB108] font-black uppercase">Live Status</p>
                                <p class="text-white font-bold">System Online</p>
                            </div>
                            <div class="w-2 h-2 rounded-full bg-[#FBB108] animate-ping"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="absolute right-10 top-1/2 -translate-y-1/2 hidden lg:flex flex-col gap-8 items-center">
            <div class="h-32 w-[1px] bg-gradient-to-b from-transparent via-white/20 to-transparent"></div>
            <a href="#" class="rotate-90 text-[10px] uppercase tracking-[0.4em] text-white/30 hover:text-[#FBB108] transition-all">Energy Solar</a>
            <div class="h-32 w-[1px] bg-gradient-to-b from-transparent via-white/20 to-transparent"></div>
        </div>

    </section>
    <!-- hero section end -->


    <!-- features section start -->
    <section class="py-32 px-8 xl:px-0 bg-[#0a0a0a]" id="features">
        <div class="text-center mb-20">
            <h3 class="text-ener-gold uppercase tracking-[0.4em] text-xs font-bold mb-3" data-aos="fade-up">Technologie</h3>
            <h2 class="text-4xl md:text-5xl font-black uppercase" data-aos="fade-up" data-aos-delay="200">NOS <span class="italic font-light">fonctionnalités </span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto">

            <div class="bg-[#121212] p-12 relative overflow-hidden group border border-white/5 hover:border-ener-gold/50 transition-all duration-500 rounded-2xl" data-aos="fade-right">
                <div class="relative z-10 lg:pr-40">
                    <h2 class="text-white mb-4 text-2xl xl:text-3xl font-bold uppercase italic">Suivi des Données Énergétiques</h2>
                    <p class="text-gray-500 leading-relaxed">Suivez simplement la production et la consommation de votre énergie pour mieux la gérer</p>
                </div>
                <div class="absolute right-0 bottom-0 transform transition-transform group-hover:scale-110 duration-500">
                    <img src="{{ asset('images/img1.jpg') }}" class="w-[14rem] rounded-tl-[100%] opacity-40 group-hover:opacity-80" alt="Monitoring">
                </div>
            </div>

            <div class="bg-[#181818] p-12 relative overflow-hidden group border border-white/5 hover:border-ener-gold/50 transition-all duration-500 rounded-2xl" data-aos="fade-up-left">
                <div class="relative z-10 lg:pl-40">
                    <h2 class="text-white mb-4 text-2xl xl:text-3xl font-bold uppercase italic text-right">Analyse & Rapports</h2>
                    <p class="text-gray-500 leading-relaxed text-right">Obtenez des rapports détaillés de 7, 15 ou 30 jours pour optimiser votre efficacité énergétique au quotidien</p>
                </div>
                <div class="absolute left-0 bottom-0 transform transition-transform group-hover:scale-110 duration-500">
                    <img src="{{ asset('images/img2.jpg') }}" class="w-[14rem] rounded-tr-[100%] opacity-40 group-hover:opacity-80" alt="Analysis">
                </div>
            </div>

            <div class="bg-[#181818] p-12 relative overflow-hidden group border border-white/5 hover:border-ener-gold/50 transition-all duration-500 rounded-2xl" data-aos="fade-up-right">
                <div class="relative z-10 lg:pr-40">
                    <h2 class="text-white mb-4 text-2xl xl:text-3xl font-bold uppercase italic">Intelligent Energy Analysis
</h2>
                    <p class="text-gray-500 leading-relaxed">Analyse automatique, détection d'anomalies et recommandations intelligentes pour optimiser la performance</p>
                </div>
                <div class="absolute right-0 top-0 transform transition-transform group-hover:scale-110 duration-500">
                    <img src="{{ asset('images/img_4.jpg') }}" class="w-[14rem] rounded-bl-[100%] opacity-40 group-hover:opacity-80" alt="Optimization">
                </div>
            </div>

            <div class="bg-[#121212] p-12 relative overflow-hidden group border border-white/5 hover:border-ener-gold/50 transition-all duration-500 rounded-2xl" data-aos="fade-up-left">
                <div class="relative z-10 lg:pl-40">
                    <h2 class="text-white mb-4 text-2xl xl:text-3xl font-bold uppercase italic text-right">Agent Ai</h2>
                    <p class="text-gray-500 leading-relaxed text-right"> Répond aux questions techniques des utilisateurs en suggérant des scénarios de panne possibles, leurs causes et des solutions techniques</p>
                </div>
                <div class="absolute left-0 top-0 transform transition-transform group-hover:scale-110 duration-500">
                    <img src="{{ asset('images/chatbot1.jpg') }}" class="w-[14rem] rounded-br-[100%] opacity-40 group-hover:opacity-80" alt="Alerts">
                </div>
            </div>

        </div>
    </section>
    <!-- features section end -->

    <!-- about section start-->
    <section class="py-32 px-8 xl:px-0 bg-[#0a0a0a]" id="about">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div class="relative" data-aos="fade-down" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out">
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-t-2 border-l-2 border-ener-gold opacity-50"></div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 border-b-2 border-r-2 border-ener-gold opacity-50"></div>

                    <div class="relative overflow-hidden rounded-2xl border border-white/10">
                        <div class="relative w-full h-[550px]  rounded-[2rem]">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="{{ asset('videos/video_2.mp4') }}" type="video/mp4">
                            </video>

                            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/20 to-black/80 z-10"></div>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full p-8 bg-gradient-to-t from-black/90 to-transparent ">
                            <div class="flex gap-8 z-20 relative">
                                <div>
                                    <span class="block text-3xl font-black text-ener-gold">100%</span>
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400">Énergie Propre</span>
                                </div>
                                <div class="border-l border-white/10 pl-8">
                                    <span class="block text-3xl font-black text-white">24/7</span>
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400">Monitoring</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out">
                    <h3 class="text-ener-gold uppercase tracking-[0.4em] text-xs font-bold mb-4 italic">À Propos du SmartSol</h3>
                    <h2 class="text-4xl md:text-6xl font-black uppercase mb-8 leading-tight">Une solution intelligente pour <span class="italic font-light text-white/80"> une énergie plus intelligente.</span></h2>

                    <div class="space-y-6">
                        <p class="text-gray-400 leading-relaxed text-lg">
                            <strong>SmartSol</strong> est né d'une vision simple : rendre la gestion de l'énergie solaire accessible, intelligente et transparente. Nous avons conçu une plateforme qui fait le pont entre le hardware haute performance et une interface logicielle intuitive.
                        </p>

                        <p class="text-gray-400 leading-relaxed italic border-l-2 border-ener-gold pl-6">
                            « Notre mission est de transformer les données électriques brutes en informations utiles, afin d’aider les utilisateurs à mieux comprendre et optimiser leur consommation d’énergie pour un avenir plus durable. » </p>

                        <div class="grid grid-cols-2 gap-6 mt-12">
                            <div class="p-6 bg-[#121212] rounded-xl border border-white/5 hover:border-ener-gold/30 transition">
                            <i class="fa-solid fa-brain text-ener-gold mb-3 text-xl"></i>    
                                <h4 class="text-white font-bold mb-2">Agent AI</h4>
                                <p class="text-xs text-gray-500">
                                   Agent intelligent qui analyse les données en temps réel et fournit des recommandations pour optimiser le système
                                </p>
                            </div>
                            <div class="p-6 bg-[#121212] rounded-xl border border-white/5 hover:border-ener-gold/30 transition">
                            <i class="fa-solid fa-bolt text-ener-gold mb-3 text-xl"></i>   
                                <h4 class="text-white font-bold mb-2">Suivi Énergétique</h4>
                                <p class="text-xs text-gray-500">
                                  Suivi simple de la production et de la consommation d’énergie
                                </p>
                            </div>
                        </div>

                        <div class="pt-8">
                            <a href="#features" class="inline-flex items-center gap-3 text-ener-gold font-bold uppercase text-xs tracking-[0.2em] group">
                                Découvrir nos solutions
                                <span class="w-10 h-[1px] bg-ener-gold group-hover:w-16 transition-all"></span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- about section end-->
    
    
    <!-- saas section start-->
    <section id="pricing" class="py-20 bg-black text-white relative overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[#E1A91A]/[0.03] blur-[150px] rounded-full pointer-events-none"></div>
        
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" >
        
        <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out">
            <span class="text-xs font-bold tracking-widest text-[#E1A91A] uppercase">Abonnements</span>
            <h2 class="text-4xl md:text-5xl font-extrabold mt-2 tracking-tight">
                DES PLANS FLEXIBLES POUR <span class="text-[#E1A91A]">CHAQUE BESOIN</span>
            </h2>
            <p class="text-gray-400 mt-4 max-w-2xl mx-auto text-sm md:text-base">
                Choisissez le plan idéal pour optimiser votre production solaire et bénéficier de la puissance de notre IA.
            </p>

            <div class="mt-10 flex justify-center items-center gap-4">
                <span id="text-monthly" class="text-sm font-medium text-white transition-colors duration-300">Mensuel</span>
                
                <button id="billing-toggle" 
                        class="w-14 h-8 flex items-center bg-white/[0.06] border border-white/[0.1] rounded-full p-1 cursor-pointer transition-all duration-300 relative focus:outline-none">
                    <div id="toggle-circle" class="w-6 h-6 bg-[#E1A91A] rounded-full shadow-md transform transition-transform duration-300 translate-x-0"></div>
                </button>

                <span id="text-yearly" class="text-sm font-medium text-gray-500 flex items-center gap-2 transition-colors duration-300">
                    Annuel 
                    <span class="bg-[#E1A91A]/[0.1] text-[#E1A91A] text-[10px] font-bold px-2 py-0.5 rounded-md border border-[#E1A91A]/[0.2]">
                        -20%
                    </span>
                </span>
            </div>  
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch" data-aos="fade-down" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out">
            
            <div id="plan-starter" 
                 class="pricing-card backdrop-blur-md bg-white/[0.03] border border-white/[0.08] rounded-3xl p-8 flex flex-col justify-between cursor-pointer transition-all duration-300 hover:border-white/[0.15] hover:bg-white/[0.05]">
                <div>
                    <h3 class="plan-title text-xl font-bold text-gray-200 transition-colors duration-300">Starter</h3>
                    <p class="text-xs text-gray-400 mt-1">Pour les petites exploitations agricoles connectées</p>
                    <div class="mt-6 mb-8">
                        <span id="price-starter" class="price-text text-4xl font-extrabold text-white transition-colors duration-300">0 DH</span>
                        <span class="text-xs text-gray-400">/ mois</span>
                    </div>
                    <ul class="space-y-4 border-t border-white/[0.05] pt-6 text-sm text-gray-300">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Suivi en temps réel (1 onduleur)
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Monitoring basique de production énergétique
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Rapports basiques (7 jours)
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Accès limité à l’Agent AI (diagnostics simples)
                        </li>
                        </ul>
                </div>
                <button class="plan-btn w-full mt-8 py-3 rounded-xl border border-white/[0.1] hover:bg-white/[0.05] transition-all font-semibold text-sm">
                    Commencer Gratuitement
                </button>
            </div>

            <div id="plan-pro" 
                 class="shadow-yellow-500/10  relative backdrop-blur-md bg-gradient-to-b from-white/[0.08] to-white/[0.02] border-2 border-[#E1A91A] rounded-3xl p-8 flex flex-col justify-between shadow-[0_0_30px_rgba(225,169,26,0.1)] transform md:-translate-y-4 cursor-pointer transition-all duration-300">
                <span class="badge-populaire absolute -top-3 right-8 bg-[#E1A91A] text-black text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
                    Populaire
                </span>
                <div>
                    <h3 class="plan-title text-xl font-bold text-[#E1A91A] transition-colors duration-300">Smart Pro</h3>
                    <p class="text-xs text-gray-300 mt-1">Idéal pour optimiser au maximum la performance énergétique</p>
                    <div class="mt-6 mb-8">
                        <span id="price-pro" class="price-text text-4xl font-extrabold text-[#E1A91A] transition-colors duration-300">399 DH</span>
                        <span class="text-xs text-gray-400">/ mois</span>
                    </div>
                    <ul class="space-y-4 border-t border-white/[0.1] pt-6 text-sm text-gray-200">
                        
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Rapports détaillés (15, 30 et 90 jours)
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-semibold text-white">Analyse énergétique intelligente avec détection d’anomalies</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-semibold text-white">Agent IA avancé (support technique et diagnostic 24/7)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Alertes en temps réel en cas d’anomalies
                        </li>
                    </ul>
                </div>
                <a href="{{ route('paiement') }}" class="plan-btn w-full text-center mt-8 py-3 rounded-xl bg-[#E1A91A] text-black font-bold text-sm hover:bg-[#cda018] shadow-lg transition-all">
                    Plan Sélectionné
                </a>
            </div>

            <div id="plan-enterprise" 
                 class="pricing-card backdrop-blur-md bg-white/[0.03] border border-white/[0.08] rounded-3xl p-8 flex flex-col justify-between cursor-pointer transition-all duration-300 hover:border-white/[0.15] hover:bg-white/[0.05]">
                <div>
                    <h3 class="plan-title text-xl font-bold text-gray-200 transition-colors duration-300">Enterprise</h3>
                    <p class="text-xs text-gray-400 mt-1">Pour les grandes exploitations agricoles et sites industriels complexes.</p>
                    <div class="mt-6 mb-8">
                        <span id="price-enterprise" class="price-text text-3xl font-extrabold text-white transition-colors duration-300">Sur Mesure</span>
                    </div>
                    <ul class="space-y-4 border-t border-white/[0.05] pt-6 text-sm text-gray-300">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Analyse énergétique intelligente avancée avec modèles personnalisés
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Modèles d’intelligence artificielle sur mesure
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                           Analyse énergétique en temps réel
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Suivi multi-sites & multi-onduleurs
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#E1A91A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Support technique dédié 24/7
                        </li>
                    </ul>
                </div>
                <button class="plan-btn w-full mt-8 py-3 rounded-xl border border-white/[0.1] hover:bg-white/[0.05] transition-all font-semibold text-sm">
                    Contacter le Tech Support
                </button>
            </div>

        </div>
    </div>
</section>
<!-- saas secrion end  -->

<!-- testimonials section start -->
<section id="testimonials" class="py-24 bg-black text-white relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#E1A91A]/[0.03] blur-[150px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-20" data-aos="fade-up" >
            <span class="text-xs font-bold tracking-widest text-[#E1A91A] uppercase">Avis d'experts</span>
            <h2 class="text-3xl md:text-5xl font-extrabold mt-2 tracking-tight">
                 <span class="text-[#E1A91A]"> Témoignages</span> Clients

            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 md:gap-8 pt-10 items-stretch"  data-aos="fade-down" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out">
            
            <div class="relative backdrop-blur-md bg-white/[0.02] border border-white/[0.08] rounded-3xl p-8 pt-16 text-center transition-all duration-300 hover:border-[#E1A91A]/[0.4] hover:shadow-[0_10px_30px_rgba(225,169,26,0.05)]">
                <div class="absolute -top-14 left-1/2 -translate-x-1/2">
                    <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-b from-[#E1A91A] to-transparent shadow-xl">
                        <img src="{{ asset('images/mouaad.png') }}" 
                             alt="mouaad" 
                             class="w-full h-full object-cover rounded-full border-2 border-black">
                    </div>
                </div>

                <h3 class="text-xl font-bold text-[#E1A91A] tracking-wide">Mouaad</h3>
                <p class="text-xs text-gray-400 mt-1">Responsable Énergie</p>
                
                <div class="flex justify-center gap-1 text-[#E1A91A] my-4 text-sm">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>

                <cite class="text-sm text-gray-300 leading-relaxed italic border-t border-white/[0.05] pt-4">
                    "Grâce à SmartSol, notre rendement énergétique a augmenté de 15%."
                </cite>
            </div>

            <div class="relative  backdrop-blur-md bg-white/[0.02] border border-white/[0.08] rounded-3xl p-8 pt-16 text-center  transition-all duration-300 hover:border-[#E1A91A]/[0.4] hover:shadow-[0_10px_30px_rgba(225,169,26,0.05)]">
                <div class="absolute -top-14 left-1/2 -translate-x-1/2">
                    <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-b from-[#E1A91A] to-[#E1A91A]/[0.3] shadow-xl shadow-[#E1A91A]/[0.1]">
                        <img src="{{asset('images/abdlhamid.jpeg')}}"
                             alt="abdlhamid" 
                             class="w-full h-full object-cover rounded-full border-2 border-black">
                    </div>
                </div>

                <h3 class="text-xl font-bold text-[#E1A91A] tracking-wide">Abd Elhamid</h3>
                <p class="text-xs text-gray-400 mt-1 font-medium">Expert en énergies renouvelables</p>
                
                <div class="flex justify-center gap-1 text-[#E1A91A] my-4 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <cite class="text-sm text-gray-300 leading-relaxed italic border-t border-white/[0.1] pt-4">
                    "SmartSol a permis une optimisation intelligente de notre production d’énergie."
                </cite>
            </div>

            <div class="relative backdrop-blur-md bg-white/[0.02] border border-white/[0.08] rounded-3xl p-8 pt-16 text-center transition-all duration-300 hover:border-[#E1A91A]/[0.4] hover:shadow-[0_10px_30px_rgba(225,169,26,0.05)]">
                <div class="absolute -top-14 left-1/2 -translate-x-1/2">
                    <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-b from-[#E1A91A] to-transparent shadow-xl">
                        <img src="{{asset('images/nassim.jpeg') }}" 
                             alt="nassim" 
                             class="w-full h-full object-cover rounded-full border-2 border-black">
                    </div>
                </div>

                <h3 class="text-xl font-bold text-[#E1A91A] tracking-wide">Nassim</h3>
                <p class="text-xs text-gray-400 mt-1">Chef de projet énergétique</p>
                
                <div class="flex justify-center gap-1 text-[#E1A91A] my-4 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <cite class="text-sm text-gray-300 leading-relaxed italic border-t border-white/[0.05] pt-4">
                    "SmartSol nous a permis d’améliorer significativement notre efficacité énergétique."
                </cite>
            </div>

            <div class="relative backdrop-blur-md bg-white/[0.02] border border-white/[0.08] rounded-3xl p-8 pt-16 text-center transition-all duration-300 hover:border-[#E1A91A]/[0.4] hover:shadow-[0_10px_30px_rgba(225,169,26,0.05)]">
                <div class="absolute -top-14 left-1/2 -translate-x-1/2">
                    <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-b from-[#E1A91A] to-transparent shadow-xl">
                        <img src="{{asset('images/agri.jpeg') }}" 
                             alt="agriculteur" 
                             class="w-full h-full object-cover rounded-full border-2 border-black">
                    </div>
                </div>

                <h3 class="text-xl font-bold text-[#E1A91A] tracking-wide">Mohammed</h3>
                <p class="text-xs text-gray-400 mt-1">Agriculteur</p>
                
                <div class="flex justify-center gap-1 text-[#E1A91A] my-4 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <cite class="text-sm text-gray-300 leading-relaxed italic border-t border-white/[0.05] pt-4">
                    "SmartSol a amélioré l’efficacité énergétique de ma ferme."
                </cite>
            </div>

        </div>
    </div>
</section>
<!-- testimonials section end -->

    <!-- footer section start-->
    <footer class="bg-[#070707] border-t border-white/5 pt-20 pb-10 px-8 xl:px-0">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">

                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('images/logo1.png') }}" class="w-[35px]" alt="SmartSol Logo">
                        <span class="text-white font-bold text-xl tracking-tighter uppercase italic">Smart<span class="text-[#FBB108]">Sol</span></span>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Plateforme intelligente dédiée à l’analyse et l’optimisation de l’énergie solaire.
                    </p>
                  
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase text-xs tracking-[0.2em] mb-6">Navigation</h4>
                    <ul class="space-y-4">
                        <li><a href="" class="text-gray-500 hover:text-[#FBB108] text-sm transition">Accueil</a></li>
                        <li><a href="#features" class="text-gray-500 hover:text-[#FBB108] text-sm transition">Caractéristiques</a></li>
                        <li><a href="#about" class="text-gray-500 hover:text-[#FBB108] text-sm transition">À propos</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase text-xs tracking-[0.2em] mb-6">Plateforme</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('login') }}" class="text-gray-500 hover:text-[#FBB108] text-sm transition">Connexion</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-500 hover:text-[#FBB108] text-sm transition">S'inscrire</a></li>
                        <li><span class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fa-solid fa-sun text-[#FBB108]"></i>Bienvenue sur SmartSol
                            </span></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase text-xs tracking-[0.2em] mb-6">Contact Tech</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-phone text-[#FBB108] mt-1 "></i>
                            <a href="tel:+212612345678" class=" hover:text-[#FBB108] text-sm transition">+212 7 16 71 55 80</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-envelope text-[#FBB108] mt-1 "></i>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=smartsoloujda26@gmail.com" target="_blank" class=" hover:text-[#FBB108] text-sm transition">smartsoloujda26@gmail.com</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-[#FBB108] mt-1"></i>
                            <span>Oujda, Maroc</span>
                        </li>
                    </ul>
                      <div class="flex gap-4 mt-6">
                        <a href="https://www.linkedin.com/in/nadia-erraji-17b804379/" target="_blank" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-white hover:border-[#FBB108] hover:text-[#FBB108] transition duration-300">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/errajinadia31-tech" target="_blank" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-white hover:border-[#FBB108] hover:text-[#FBB108] transition duration-300">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://whatsApp.com/+212716715580" target="_blank" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-white hover:border-[#FBB108] hover:text-[#FBB108] transition duration-300">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://wa.me/212716715580?text=Bonjour%20SmartSol" target="_blank" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-white hover:border-[#FBB108] hover:text-[#FBB108] transition duration-300">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    </div>
                </div>
                
            </div>

            <div class="border-t border-white/5 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[10px] text-gray-600 uppercase tracking-widest text-center md:text-left">
                    &copy; {{ date('Y') }} SmartSol -Intelligent Solar Energy Platform
                </p>
                <div class="flex gap-8">
                    <a href="#" class="text-[10px] text-gray-600 hover:text-white transition uppercase tracking-tighter">Privacy Policy</a>
                    <a href="#" class="text-[10px] text-gray-600 hover:text-white transition uppercase tracking-tighter">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer section end-->

    <!-- js start-->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-quad',
        });

        document.addEventListener('DOMContentLoaded', () => {
        let isYearly = false;

        // Elements dial Toggle
        const toggleBtn = document.getElementById('billing-toggle');
        const toggleCircle = document.getElementById('toggle-circle');
        const textMonthly = document.getElementById('text-monthly');
        const textYearly = document.getElementById('text-yearly');
        
        // Elements dial Prices
        const pricePro = document.getElementById('price-pro');
        const cards = document.querySelectorAll('.pricing-card');

        // 1. GESTION DU TOGGLE (MENSUEL / ANNUEL)
        toggleBtn.addEventListener('click', (e) => {
            // Empecher l-click bache ma y-clikish 3la chi haja khra wra l-toggle
            e.stopPropagation(); 
            
            isYearly = !isYearly;

            if (isYearly) {
                // Animation d switch button
                toggleBtn.classList.add('border-[#E1A91A]/[0.4]', 'bg-[#E1A91A]/[0.1]');
                toggleCircle.classList.remove('translate-x-0');
                toggleCircle.classList.add('translate-x-6');
                
                // Color change dial text labels
                textMonthly.classList.remove('text-white');
                textMonthly.classList.add('text-gray-500');
                textYearly.classList.remove('text-gray-500');
                textYearly.classList.add('text-white');

                // Update l-prix d Smart Pro b l-remise (-20% d 299 DH ghadi t-bân 239 DH)
                // Ila knti bghitiha f active style d gold, l-color ghadi t-bqa sfar ola t-bdel 3la hsa l-card state
                pricePro.textContent = '320 DH';
            } else {
                // Reset button style
                toggleBtn.classList.remove('border-[#E1A91A]/[0.4]', 'bg-[#E1A91A]/[0.1]');
                toggleCircle.classList.remove('translate-x-6');
                toggleCircle.classList.add('translate-x-0');
                
                // Reset text labels
                textMonthly.classList.remove('text-gray-500');
                textMonthly.classList.add('text-white');
                textYearly.classList.remove('text-white');
                textYearly.classList.add('text-gray-500');

                // Reset l-prix d Smart Pro l 299 DH
                pricePro.textContent = '399 DH';
            }
        });

        // 2. GESTION DES CARDS CLICKABLES
        cards.forEach(card => {
            card.addEventListener('click', () => {
                // Clean states mn ga3 l-cards
                cards.forEach(c => {
                    c.className = "pricing-card backdrop-blur-md bg-white/[0.03] border border-white/[0.08] rounded-3xl p-8 flex flex-col justify-between cursor-pointer transition-all duration-300 hover:border-white/[0.15] hover:bg-white/[0.05]";
                    
                    c.querySelector('.plan-title').className = "plan-title text-xl font-bold text-gray-200 transition-colors duration-300";
                    
                    const priceSpan = c.querySelector('.price-text');
                    if(priceSpan.textContent.includes('Sur Mesure')) {
                        priceSpan.className = "price-text text-3xl font-extrabold text-white transition-colors duration-300";
                    } else {
                        priceSpan.className = "price-text text-4xl font-extrabold text-white transition-colors duration-300";
                    }

                    const btn = c.querySelector('.plan-btn');
                    btn.className = "plan-btn w-full mt-8 py-3 rounded-xl border border-white/[0.1] hover:bg-white/[0.05] transition-all font-semibold text-sm";
                    
                    if(c.id === 'plan-starter') btn.textContent = "Commencer Gratuitement";
                    if(c.id === 'plan-pro') btn.textContent = "Choisir Smart Pro";
                    if(c.id === 'plan-enterprise') btn.textContent = "Contacter le Tech Support";
                });

                // Zid dynamic focus l-card li t-clickat dba
                card.className = "pricing-card relative backdrop-blur-md bg-gradient-to-b from-white/[0.08] to-white/[0.02] border-2 border-[#E1A91A] rounded-3xl p-8 flex flex-col justify-between shadow-[0_0_30px_rgba(225,169,26,0.1)] transform md:-translate-y-4 cursor-pointer transition-all duration-300";
                
                card.querySelector('.plan-title').className = "plan-title text-xl font-bold text-[#E1A91A] transition-colors duration-300";
                
                const activePrice = card.querySelector('.price-text');
                if(activePrice.textContent.includes('Sur Mesure')) {
                    activePrice.className = "price-text text-3xl font-extrabold text-[#E1A91A] transition-colors duration-300";
                } else {
                    activePrice.className = "price-text text-4xl font-extrabold text-[#E1A91A] transition-colors duration-300";
                }

                const activeBtn = card.querySelector('.plan-btn');
                activeBtn.className = "plan-btn w-full mt-8 py-3 rounded-xl bg-[#E1A91A] text-black font-bold text-sm hover:bg-[#cda018] shadow-lg transition-all";
                activeBtn.textContent = "Plan Sélectionné";
            });
        });
    });

    </script> 
</body>
</html>