<x-app-layout>
    <div class="h-screen overflow-hidden relative font-sans text-white bg-[#050505]">
        
        <div class="absolute top-20 -left-10 w-96 h-96 bg-[#FBB108] rounded-full mix-blend-multiply filter blur-[150px] opacity-10"></div>
        <div class="absolute bottom-20 -right-10 w-96 h-96 bg-yellow-700 rounded-full mix-blend-multiply filter blur-[150px] opacity-10"></div>

        <div class="relative z-10 h-full flex flex-col">
            
            <header class="py-6 px-8 border-b border-white/5 bg-black/20 backdrop-blur-md">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div>
                        <h2 class="font-black text-2xl tracking-tighter uppercase italic">
                            PRO<span class="text-[#FBB108]">FILE</span>
                        </h2>
                        <p class="text-[10px] text-white/40 uppercase tracking-[0.3em]">Gestion du compte SmartSol</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/logo1.png') }}" class="w-8 h-8 object-contain opacity-80" alt="Logo">
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto custom-scrollbar py-8">
                <div class="max-w-4xl mx-auto px-6 space-y-8 pb-12">
                    
                    <section class="bg-black/40 border border-white/5 rounded-3xl p-6 md:p-10 backdrop-blur-xl shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#FBB108]/5 blur-3xl rounded-full"></div>
                        <div class="relative z-10">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </section>

                    <section class="bg-black/40 border border-white/5 rounded-3xl p-6 md:p-10 backdrop-blur-xl shadow-2xl relative overflow-hidden group">
                        <div class="relative z-10">
                            @include('profile.partials.update-password-form')
                        </div>
                    </section>

                    <section class="bg-red-500/5 border border-red-500/10 rounded-3xl p-6 md:p-10 backdrop-blur-xl shadow-2xl">
                        <div class="relative z-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>

 
</x-app-layout>