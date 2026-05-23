<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>SmartSol - Récupération</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media (max-height: 700px) {
            .form-container { transform: scale(0.9); transform-origin: center; }
            .header-nav { top: 1rem !important; }
        }
    </style>
</head>
<body class="bg-[url({{ asset('images/image_hero.jpg') }})] bg-cover bg-center font-sans antialiased text-white h-screen overflow-hidden relative">

<div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] z-0"></div>

<header class="header-nav absolute top-8 left-0 w-full z-20 flex justify-center px-4 transition-all">
    <nav class="flex items-center gap-2 bg-white/5 backdrop-blur-md border border-white/10 px-2 py-1.5 rounded-full shadow-2xl">
        <a href="{{ route('login') }}" class="px-6 py-2 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest text-white hover:bg-white hover:text-black transition-all">
            <i class="fa-solid fa-arrow-left mr-2"></i> Retour
        </a>
    </nav>
</header>

<main class="h-full relative z-10 flex flex-col items-center justify-center px-6">
    
    <div class="absolute top-0 -left-4 w-64 h-64 bg-[#FBB108] rounded-full mix-blend-multiply filter blur-[100px] opacity-10 animate-blob"></div>
    <div class="absolute bottom-0 -right-4 w-64 h-64 bg-yellow-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-10 animate-blob animation-delay-2000"></div>

    <div class="form-container w-full max-w-[480px] transition-transform duration-300">
        
        <div class="flex flex-col items-center mb-6 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 mb-2 object-contain">
            <h1 class="font-bold text-xl md:text-2xl tracking-tighter uppercase italic">Smart<span class="text-[#FBB108]">Sol</span></h1>
            <p class="text-white/50 text-[9px] uppercase tracking-[0.2em] mt-1">Réinitialisation</p>
        </div>

        <div class="p-2 md:p-4">
            <div class="mb-6 text-[11px] text-white/60 text-center leading-relaxed uppercase tracking-wider">
                {{ __('Mot de passe oublié ? Indiquez-nous votre adresse e-mail et nous vous enverrons un lien de réinitialisation.') }}
            </div>

            @if (session('status'))
                <div class="mb-4 text-[10px] text-green-400 bg-green-400/10 p-3 rounded-xl border border-green-400/20 text-center uppercase tracking-widest">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-white/80 uppercase tracking-widest ml-1">Email professionnel</label>
                    <div class="relative group">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                        <input type="email" name="email" :value="old('email')" required autofocus
                            class="w-full bg-black/40 border border-white/10 rounded-xl py-4 pl-11 pr-4 text-sm focus:border-[#FBB108]/50 focus:ring-0 transition-all outline-none text-white placeholder:text-white/20"
                            placeholder="votre@email.com">
                    </div>
                    @if($errors->get('email'))
                        <p class="text-[10px] text-red-500 ml-1 mt-1 uppercase">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <button type="submit" class="w-full bg-[#FBB108] text-black font-black py-4 rounded-xl shadow-lg hover:shadow-[#FBB108]/20 transition-all active:scale-95 uppercase tracking-widest text-[11px]">
                    {{ __('Envoyer le lien') }}
                </button>
            </form>

            <div class="mt-8 text-center border-t border-white/5 pt-6">
                <a href="{{ route('login') }}" class="text-white/40 hover:text-[#FBB108] text-[10px] uppercase tracking-widest transition-colors font-bold">
                    Annuler et revenir
                </a>
            </div>
        </div>
    </div>
</main>

</body>
</html>