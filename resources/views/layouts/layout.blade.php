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
    <style>
    /* تخصيص الـ Scrollbar لكونتينر الميساجات فقط */
    #chat-messages::-webkit-scrollbar {
        width: 6px; /* السمك ديالو رقيق بزاف */
    }

    /* الخلفية ديال المجرى (Track) شفاف باش يبان الـ Glassmorphism */
    #chat-messages::-webkit-scrollbar-track {
        background: transparent; 
    }

    /* العجلة أو المقبض اللي كيتحرك (Thumb) */
    #chat-messages::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1); /* لـون أبيض شفاف خفيف */
        border-radius: 9999px; /* دائري من الجناب */
    }

    /* فاش يحط المستخدم عليه الفأرة (Hover) كيتحول للذهبي */
    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(251, 177, 8, 0.4); 
    }
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
              <!-- Notification Dropdown -->
<!-- Notification Dropdown -->
<div class="relative">
    <button id="bell-btn" class="text-gray-300 hover:text-yellow-500 transition-all">
        <i class="fa-regular fa-bell text-xl"></i>
        <span id="alert-badge" class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full hidden"></span>
    </button>

    <!-- هنا التعديل: ضفنا absolute، bg، و shadow باش يبان بحال القائمة -->
    <div id="alerts-list" class="hidden absolute right-0 mt-3 w-72 bg-[#121212]/90 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-4 z-50">
        <div class="text-sm font-bold text-white mb-3 border-b border-white/5 pb-2">التنبيهات</div>
        
        <div id="alerts-container" class="space-y-3">
            @forelse($notifications as $notif)
                <div class="text-red-400 text-xs border-b border-white/5 pb-2 flex justify-between">
                    <span>⚠️ {{ $notif->message }}</span>
                    <span class="text-[9px] text-gray-500">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-xs text-center">لا توجد تنبيهات حالياً</p>
            @endforelse
        </div>
    </div>
</div>
<div class="relative">
    <button onclick="toggleProfileMenu(event)" class="flex items-center gap-3 pl-2 py-1 rounded-full hover:bg-white/5 transition focus:outline-none">
        <div class="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-tr from-[#FBB108] to-yellow-200 text-black font-bold">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
    </button>

    <div id="profileMenu" class="absolute right-0 mt-3 w-48 bg-[#121212]/90 backdrop-blur-xl rounded-2xl border border-white/10 hidden shadow-2xl z-50 overflow-hidden">
        <div class="px-4 py-3 border-b border-white/5 bg-white/5">
            <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Connecté en tant que</p>
            <p class="text-sm font-bold truncate text-white">{{ Auth::user()->name }}</p>
        </div>
        
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-xs hover:bg-white/5 transition text-white">
            <i class="fa-regular fa-user text-[#FBB108]"></i> Mon Profil
        </a>

        <button type="button" 
                onclick="openLogoutModal()"
                class="w-full group flex items-center gap-3 px-4 py-3 text-xs font-medium text-red-400/80 hover:text-red-400 hover:bg-red-500/5 transition-all duration-200">
            <i class="fa-solid fa-power-off group-hover:scale-110 transition-transform"></i>
            <span>Déconnexion</span>
        </button>
    </div>
</div>

<div id="logout-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#121212]/90 border border-white/10 w-full max-w-md p-6 rounded-2xl shadow-2xl backdrop-blur-xl transform transition-all scale-95 duration-300 mx-4">
        
        <div class="flex items-start gap-4">
            <div class="p-3 bg-red-500/10 text-red-500 rounded-xl border border-red-500/20 shrink-0">
                <i class="fa-solid fa-power-off text-lg"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-white tracking-wide">Déconnexion</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Voulez-vous vraiment vous déconnecter de votre session SmartSol ?</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-6">
            <button onclick="closeLogoutModal()" class="px-4 py-2 text-xs font-medium text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl transition-all duration-200">
                Annuler
            </button>
            
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="px-4 py-2 text-xs font-medium text-black bg-gradient-to-r from-[#FBB108] to-yellow-300 hover:opacity-90 shadow-lg shadow-[#FBB108]/10 rounded-xl transition-all duration-200">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Chat Toggle Button - SmartSol Blue & Yellow Edition -->
<button onclick="toggleChat()" id="chat-toggle-btn" 
    class="fixed bottom-8 right-8 w-16 h-16 bg-[#1a1a1a]/60 backdrop-blur-xl border border-blue-500/30 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.5)] hover:border-[#FBB108] transition-all duration-500 flex items-center justify-center group z-50">
    
    <div class="absolute inset-0 rounded-2xl bg-blue-600 opacity-20 animate-pulse group-hover:opacity-40 transition-opacity"></div>
    
    <div class="absolute inset-0 rounded-2xl bg-[#FBB108] opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></div>
    
    <i class="fa-brands fa-bots text-[#FBB108] text-3xl group-hover:text-blue-400 group-hover:scale-110 transition-all duration-300 relative z-10"></i>
</button>

<div id="chat-window" class="fixed bottom-24 right-8 w-[500px] max-w-[calc(100vw-2rem)] bg-[#111111]/80 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl hidden flex-col h-[630px] z-50 overflow-hidden transition-all duration-300">
    
    <div class="p-4 border-b border-white/10 font-bold text-white bg-white/5 flex justify-between items-center shrink-0">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-md tracking-wide font-mono text-green-500"> <i class="fa-solid fa-robot text-xs text-yellow-400"></i> SMARTSOL AGENT AI</span>
        </div>
        <button onclick="toggleChat()" class="text-gray-400 hover:text-white transition-colors text-sm">✕</button>
    </div>

    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto text-xs text-gray-200 space-y-4 flex flex-col scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
        <div class="bg-white/5 border border-white/10 p-3 rounded-2xl rounded-tl-none max-w-[85%] self-start text-right break-words" dir="rtl">
    مرحباً بك! أنا مساعد <span class="text-green-400">SmartSol</span> الذكي. أنا هنا لمساعدتك في كل ما يخص الطاقات الشمسية والزراعة. كيف يمكنني مساعدتك اليوم؟
</div>
    </div>

    <div class="p-3 bg-black/40 border-t border-white/10 flex gap-2 shrink-0">
        <input id="user-input" 
               type="text" 
               onkeypress="if(event.key === 'Enter') sendMessage()"
               class="flex-1 bg-black/60 border border-white/10 rounded-xl text-white p-2.5 text-xs focus:outline-none focus:border-[#FBB108] transition-colors text-right" 
               placeholder="سولني على أي حاجة..." dir="rtl">
        
        <button onclick="sendMessage()" class="bg-blue-600 hover:bg-[#FBB108] hover:text-black p-2.5 rounded-xl text-white font-bold transition-all duration-300 active:scale-95 flex items-center justify-center">
            <i class="fa-solid fa-paper-plane text-md"></i>
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
    // --- منطق قائمة البروفايل ---
    function toggleProfileMenu(event) {
        event.stopPropagation();
        const menu = document.getElementById('profileMenu');
        const alertsMenu = document.getElementById('alerts-list'); // تأمين إغلاق التنبيهات
        alertsMenu.classList.add('hidden');
        menu.classList.toggle('hidden');
    }

    // --- منطق المودال ديال الخروج ---
    function openLogoutModal() {
        document.getElementById('profileMenu').classList.add('hidden');
        const modal = document.getElementById('logout-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logout-modal');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    // --- منطق الشات ---
    function toggleChat() {
        const chatWindow = document.getElementById('chat-window');
        if (chatWindow.classList.contains('hidden')) {
            chatWindow.classList.remove('hidden');
            chatWindow.classList.add('flex');
        } else {
            chatWindow.classList.remove('flex');
            chatWindow.classList.add('hidden');
        }
    }

    function sendMessage() {
        const inputEl = document.getElementById('user-input');
        const chatMessages = document.getElementById('chat-messages');
        const message = inputEl.value.trim();

        if (!message) return;

        chatMessages.innerHTML += `
            <div class="bg-blue-600/10 border border-blue-500/20 text-blue-300 p-3 rounded-2xl rounded-tr-none max-w-[85%] self-end text-right text-xs break-words" dir="rtl">
                ${message}
            </div>
        `;
        inputEl.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        const typingId = 'typing-' + Date.now();
        chatMessages.innerHTML += `
            <div id="${typingId}" class="bg-white/5 border border-white/5 text-gray-400 p-3 rounded-2xl rounded-tl-none max-w-[50%] self-start text-right text-xs animate-pulse" dir="rtl">
              ... جاري الرد⏳
            </div>
        `;
        chatMessages.scrollTop = chatMessages.scrollHeight;

        fetch("{{ route('chatbot.message') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById(typingId).remove();
            let formattedReply = data.reply.replace(/\*\*(.*?)\*\*/g, '<strong class="text-[#FBB108] font-bold">$1</strong>').replace(/\n/g, '<br>');
            chatMessages.innerHTML += `
                <div class="bg-white/5 border border-white/10 p-3 rounded-2xl rounded-tl-none max-w-[85%] self-start text-right text-xs leading-relaxed break-words text-gray-200" dir="rtl">
                    ${formattedReply}
                </div>
            `;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(err => {
            document.getElementById(typingId)?.remove();
            chatMessages.innerHTML += `<div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-2xl rounded-tl-none max-w-[85%] self-start text-right text-xs" dir="rtl">عذراً، حدث خطأ تقني.</div>`;
        });
    }

    // --- منطق التنبيهات (Alerts) المدمج ---
    const bellBtn = document.getElementById('bell-btn');
    const alertsList = document.getElementById('alerts-list');
    const alertBadge = document.getElementById('alert-badge');

    bellBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('profileMenu').classList.add('hidden'); // إغلاق البروفايل إيلا كان مفتوح
        alertsList.classList.toggle('hidden');
    });

    function addAlert(message) {
        if(alertsList.querySelector('p')) alertsList.innerHTML = '';
        alertsList.innerHTML += `<div class="text-red-400 text-xs border-b border-white/5 pb-2">⚠️ ${message}</div>`;
        alertBadge.classList.remove('hidden');
    }

    // --- المنسق العام للنقرات ---
    window.onclick = function(event) {
        const menu = document.getElementById('profileMenu');
        const modal = document.getElementById('logout-modal');
        const alertsList = document.getElementById('alerts-list');
        
        if (!menu.contains(event.target)) menu.classList.add('hidden');
        if (!alertsList.contains(event.target) && event.target !== bellBtn) alertsList.classList.add('hidden');
        
        if (event.target == modal) closeLogoutModal();
    }
</script>
</body>
</html>