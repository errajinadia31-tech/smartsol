<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>SmartSol | Login</title>
    <link rel="shortcut icon" href="{{asset('images/logo1.png')}}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

@media (max-height: 720px) {
            .form-container { transform: scale(0.85); transform-origin: center; }
            .header-nav { top: 1rem !important; }
        }
        @media (max-width: 640px) and (max-height: 600px) {
            .form-container { transform: scale(0.75); }
        }
    </style>
</head>
<body class="bg-[url({{ asset('images/image_hero.jpg') }})] bg-cover bg-center font-sans antialiased text-white h-screen overflow-hidden relative">

<div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] z-0"></div>

<header class="header-nav absolute top-8 left-0 w-full z-20 flex justify-center px-4 transition-all">
    <nav class="flex items-center gap-2 bg-white/5 backdrop-blur-md border border-white/10 px-2 py-1.5 rounded-full shadow-2xl">
        <a href="{{ route('welcome') }}" class="px-4 md:px-6 py-2 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest text-white hover:bg-white hover:text-black transition-all">Home</a>
        <div class="w-[1px] h-4 bg-white/10"></div>
        <a href="{{ route('register') }}" class="px-4 md:px-6 py-2 rounded-full text-[#FBB108] text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-[#FBB108] hover:text-black transition-all">S'inscrire</a>
    </nav>
</header>

<main class="h-full relative z-10 flex flex-col items-center justify-center px-6">
    
    <div class="absolute top-0 -left-4 w-64 h-64 bg-[#FBB108] rounded-full mix-blend-multiply filter blur-[100px] opacity-10 animate-blob"></div>
    <div class="absolute bottom-0 -right-4 w-64 h-64 bg-yellow-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-10 animate-blob animation-delay-2000"></div>

    <div class="form-container w-full max-w-[480px] transition-transform duration-300">
        
        <div class="flex flex-col items-center m-12">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="w-10 h-10 mb-2 object-contain text-center">
            <p class="text-white/50 text-[9px] uppercase tracking-[0.3em] mt-1 text-center">Authentification</p>
        </div>

        <div class="p-2 md:p-4">
            @if (session('status'))
                <div class="mb-4 text-[10px] text-green-400 bg-green-400/10 p-2 rounded-lg border border-green-400/20 text-center uppercase tracking-widest">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-white/80 uppercase tracking-widest ml-1">Identifiant</label>
                    <div class="relative group">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-black/40 border border-white/10 rounded-xl py-3.5 pl-11 pr-4 text-sm focus:border-[#FBB108]/50 focus:ring-0 transition-all outline-none text-white placeholder:text-white/20"
                            placeholder="nom@exemple.com">
                    </div>
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[10px] font-bold text-white/80 uppercase tracking-widest">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[9px] text-white/40 hover:text-[#FBB108] transition-colors uppercase tracking-tighter">Oublié ?</a>
                        @endif
                    </div>
                    <div class="relative group">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                        <input type="password" name="password" required
                            class="w-full bg-black/40 border border-white/10 rounded-xl py-3.5 pl-11 pr-4 text-sm focus:border-[#FBB108]/50 focus:ring-0 transition-all outline-none text-white placeholder:text-white/20"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center px-1">
                    <input id="remember_me" type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-white/10 bg-white/5 text-[#FBB108] focus:ring-0 cursor-pointer">
                    <label for="remember_me" class="ml-2 text-[10px] text-white/60 cursor-pointer uppercase tracking-tighter">Rester connecté</label>
                </div>

                <button type="submit" class="w-full bg-[#FBB108] text-black font-black py-4 rounded-xl shadow-lg hover:shadow-[#FBB108]/20 transition-all active:scale-95 uppercase tracking-widest text-[11px] mt-2">
                    Se connecter
                </button>
            </form>

            <div class="mt-8 text-center border-t border-white/5 pt-6">
                <p class="text-white/40 text-[9px] uppercase tracking-widest text-center">Pas encore de compte ?</p>
                <a href="{{ route('register') }}" class="text-[#FBB108] font-bold text-xs uppercase tracking-widest hover:underline mt-1 inline-block text-center">Créer un compte</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>