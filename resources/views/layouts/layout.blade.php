<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- tailwind css  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- logo icon -->
    <link rel="shortcut icon" href="{{asset('images/logo1.png')}}" type="image/x-icon">
    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>@yield('title', config('app.name', 'SmartSol'))</title>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .nav-link { transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.1); }
        .nav-link:hover { background: rgba(255,255,255,0.1); border-color: #FBB108; }
        .active-nav { background: white !important; color: black !important; font-weight: 700; border-color: white; }
    </style>
</head>

<body class="bg-cover bg-center h-screen bg-[url('{{ asset("images/dashboard_bg.jpeg") }}')] ">

    <div class="h-full bg-black/70 backdrop-blur-[8px] p-6 flex flex-col">
        <!-- navbar start-->
        <header class="flex items-center justify-between px-8 py-4 text-white mb-6">
            <div class="flex items-center">
                <img src="{{ asset('images/logo1.png') }}" class="w-[38px]" alt="Logo">
                <span class="font-bold text-2xl tracking-tighter uppercase italic">Smart<span class="text-[#FBB108]">Sol</span></span>
            </div>
            
            <nav class="hidden lg:flex gap-3 text-xs uppercase tracking-widest">
                <a href="{{ route('dashboard') }}" class="nav-link rounded-full px-5 py-2.5 {{ request()->routeIs('dashboard') ? 'active-nav' : '' }}">Dashboard</a>
                <a href="{{ route('panels.index') }}" class="nav-link rounded-full px-5 py-2.5 {{ request()->routeIs('panels.index') ? 'active-nav' : '' }}">Panneaux</a>
                <a href="{{ route('statistiques') }}" class="nav-link rounded-full px-5 py-2.5 {{ request()->routeIs('statistiques') ? 'active-nav' : '' }}">Statistiques</a>
                <a href="{{ route('rapport') }}" class="nav-link rounded-full px-5 py-2.5 {{ request()->routeIs('rapport')? 'active-nav' : '' }}">Rapports</a>
            </nav>

            <div class="flex items-center gap-3">
                <div class="flex items-center border-r border-white/10 pr-4 gap-2">
                    <button class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 hover:bg-[#FBB108] hover:text-black transition">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 hover:bg-[#FBB108] hover:text-black transition relative">
                        <i class="fa-regular fa-bell text-xs"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-black"></span>
                    </button>
                </div>
                
               <div class="relative">
    <button onclick="toggleProfileMenu(event)" class="flex items-center gap-3 pl-2 py-1 rounded-full hover:bg-white/5 transition focus:outline-none">
        <div class="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-tr from-[#FBB108] to-yellow-200 text-black font-bold">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
    </button>

    <div id="profileMenu" class="absolute right-0 mt-3 w-48 bg-[#121212] backdrop-blur-xl rounded-2xl border border-white/10 hidden shadow-2xl z-50 overflow-hidden">
        <div class="px-4 py-3 border-b border-white/5 bg-white/5">
            <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Connecté en tant que</p>
            <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-xs hover:bg-white/5 transition text-white">
            <i class="fa-regular fa-user text-[#FBB108]"></i> Mon Profil
        </a>
<form method="POST" action="{{ route('logout') }}" id="logout-form">
    @csrf
    <button type="button" 
            onclick="confirmLogout()"
            class="w-full group flex items-center gap-3 px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-red-400/80 hover:text-red-400 hover:bg-red-500/5 transition-all duration-300 rounded-xl border border-transparent hover:border-red-500/10">
        <i class="fa-solid fa-power-off group-hover:scale-110 transition-transform"></i>
        <span>Déconnexion</span>
    </button>
</form>
    </div>
</div>
<!-- Chat Toggle Button - SmartSol Blue & Yellow Edition -->
<button onclick="toggleChat()" id="chat-toggle-btn" 
    class="fixed bottom-8 right-8 w-16 h-16 bg-[#1a1a1a]/60 backdrop-blur-xl border border-blue-500/30 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.5)] hover:border-[#FBB108] transition-all duration-500 flex items-center justify-center group z-50">
    
    <!-- Animated Blue Pulse (Zre9) -->
    <div class="absolute inset-0 rounded-2xl bg-blue-600 opacity-20 animate-pulse group-hover:opacity-40 transition-opacity"></div>
    
    <!-- Yellow Glow on Hover (Sfer) -->
    <div class="absolute inset-0 rounded-2xl bg-[#FBB108] opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></div>
    
    <!-- Icon (Yellow to Blue transition) -->
    <i class="fa-brands fa-bots text-[#FBB108] text-3xl group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 relative z-10"></i>
</button>

<div id="chat-window" class="fixed bottom-20 right-5 w-80 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl hidden flex-col h-[450px] z-50 overflow-hidden animate-fade-in-up">
    
    <div class="p-4 border-b border-white/10 font-bold text-white bg-white/5 flex justify-between items-center">
        <span>🤖 SmartSol Chatbot</span>
        <button onclick="toggleChat()" class="text-gray-400 hover:text-white">✕</button>
    </div>

    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto text-sm text-gray-200 space-y-4 scrollbar-thin scrollbar-thumb-white/20">
        <div class="bg-white/5 border border-white/10 p-3 rounded-2xl rounded-tl-none">
            hi 
    </div>
    </div>

    <div class="p-3 bg-white/5 border-t border-white/10 flex gap-2">
        <input id="user-input" 
               type="text" 
               onkeypress="if(event.key === 'Enter') sendMessage()"
               class="flex-1 bg-black/40 border border-white/10 rounded-xl text-white p-2 text-xs focus:outline-none focus:border-blue-500 transition-colors" 
               placeholder="سولني على الطاقة...">
        
        <button onclick="sendMessage()" class="bg-blue-600 hover:bg-blue-500 p-2 rounded-xl text-white transition-transform active:scale-95">
            🚀
        </button>
    </div>
            </div>
        </header>
        <!-- navbar end -->
        
        <main class="flex-1 overflow-y-auto custom-scrollbar">
            @yield('content')
        </main>
    
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #FBB108; }
    </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    async function sendMessage() {
    const input   = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-messages');
    const message = input.value.trim();

    if (!message) return;

    // ── User bubble ──────────────────────────────────────────────
    chatBox.innerHTML += `
        <div class="flex justify-end">
            <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-none max-w-[80%] text-sm">
                ${message}
            </div>
        </div>`;

    input.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;

    // ── Loading bubble ───────────────────────────────────────────
    const loadingId = 'load-' + Date.now();
    chatBox.innerHTML += `
        <div id="${loadingId}" class="flex justify-start">
            <div class="bg-white/10 border border-white/10 text-white px-4 py-2 rounded-2xl rounded-bl-none text-sm animate-pulse">
                كنفكر... ⚡
            </div>
        </div>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    // ── API call ─────────────────────────────────────────────────
    try {
        const res = await fetch('/ask', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                'Accept':       'application/json',
            },
            body: JSON.stringify({ message }),
        });

        const data = await res.json();
        document.getElementById(loadingId)?.remove();

        // ── Bot bubble ───────────────────────────────────────────
        const text = data.answer ?? 'ما جاوبش 😥';
        chatBox.innerHTML += `
            <div class="flex justify-start">
                <div class="bg-white/10 border border-white/10 text-white px-4 py-2
                            rounded-2xl rounded-bl-none max-w-[80%] text-sm
                            leading-relaxed text-right" style="direction:rtl">
                    ${text.replace(/\n/g, '<br>')}
                </div>
            </div>`;

    } catch (err) {
        document.getElementById(loadingId)?.remove();
        chatBox.innerHTML += `
            <div class="flex justify-start">
                <div class="bg-red-500/80 text-white px-4 py-2 rounded-2xl text-sm">
                    وقع مشكل في الاتصال 😥
                </div>
            </div>`;
        console.error('[SolarBot]', err);
    }

    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>
</body>
</html>