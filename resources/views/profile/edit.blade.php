<x-app-layout>
    <div class="min-h-screen relative font-sans text-gray-200 bg-[#050505] selection:bg-[#FBB108]/30 selection:text-white antialiased">
        
        <div class="relative z-10 flex flex-col min-h-screen">
            
            <!-- En-tête épuré et figé au défilement -->
            <header class="py-5 px-6 md:px-12 border-b border-white/[0.06] bg-[#050505]/60 backdrop-blur-xl sticky top-0 z-50">
                <div class=" flex justify-between items-center mt-8">
                    <div>
                        <h2 class="font-black text-2xl tracking-tighter">
                            PROFILE
                        </h2>
                        <p class="text-[9px] text-white/40 uppercase tracking-[0.35em] mt-0.5 mb-8">Gestion du compte SmartSol</p>
                    </div>
                    
                    <div class="relative group">
                        <img src="{{ asset('images/logo1.png') }}" class="relative w-9 h-9 object-contain opacity-90" alt="Logo">
                    </div>
                </div>
            </header>

            <!-- Contenu des formulaires -->
            <main class="flex-1 py-12 px-4 md:px-8">
                <div class=" mx-auto space-y-10 pb-16 ">
                    
                    <!-- Formulaire : Informations Profil -->
                    <section class="bg-gradient-to-b from-white/[0.03] to-transparent border border-white/[0.05] rounded-[2rem] p-6 md:p-10 backdrop-blur-2xl shadow-2xl relative overflow-hidden group transition-all duration-500 hover:border-white/[0.12] hover:shadow-[#FBB108]/[0.02]_0px_20px_40px]">
                        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#FBB108]/[0.03] blur-3xl rounded-full transition-all duration-700 group-hover:bg-[#FBB108]/[0.06]"></div>
                        <div class="relative z-10">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </section>

                    <!-- Formulaire : Sécurité / Mot de passe -->
                    <section class="bg-gradient-to-b from-white/[0.03] to-transparent border border-white/[0.05] rounded-[2rem] p-6 md:p-10 backdrop-blur-2xl shadow-2xl relative overflow-hidden group transition-all duration-500 hover:border-white/[0.12] hover:shadow-[#FBB108]/[0.02]_0px_20px_40px]">
                        <div class="absolute -top-12 -right-12 w-40 h-40 bg-yellow-600/[0.02] blur-3xl rounded-full transition-all duration-700 group-hover:bg-yellow-600/[0.05]"></div>
                        <div class="relative z-10">
                            @include('profile.partials.update-password-form')
                        </div>
                    </section>

                    <!-- Formulaire : Zone critique (Suppression) -->
                    <section class="bg-gradient-to-b from-red-500/[0.02] to-transparent border border-red-500/[0.08] rounded-[2rem] p-6 md:p-10 backdrop-blur-2xl shadow-2xl relative overflow-hidden group transition-all duration-500 hover:border-red-500/[0.2] hover:shadow-red-950/[0.1]_0px_20px_40px]">
                        <div class="absolute -top-12 -right-12 w-40 h-40 bg-red-500/[0.01] blur-3xl rounded-full"></div>
                        <div class="relative z-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>