<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement | Smart Pro</title>
    <link rel="shortcut icon" href="{{asset('images/logo1.png')}}" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .border-gold { border-color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        .text-gold { color: #d4af37; }
        .hover-bg-gold:hover { background-color: #b8962a; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-white font-sans antialiased min-h-screen flex flex-col items-center justify-center py-12 px-4">

    <div class="mb-10 text-center">
        <div class="flex justify-center items-center space-x-3">
 
            <div class=" p-3 rounded-xl shadow-lg shadow-gold/20">
                <img src="{{ asset('images/logo1.png') }}" class=" h-[80px]" alt="">
        </div>
            <h1 class="text-3xl font-bold tracking-wider text-white">Smart<span class="text-gold">Sol</span></h1>
        </div>
    </div>

    <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-start bg-[#0a0a0a]">
        
        <div class="bg-[#121212] p-8 rounded-2xl shadow-xl border border-gold relative h-full flex flex-col">
            
            <div class="absolute top-0 right-6 transform -translate-y-1/2 bg-[#E1A91A] text-black text-xs font-bold px-3 py-1 rounded-full tracking-wide">
                SÉCURISÉ PAR CMI / STRIPE
            </div>

            <h2 class="text-2xl font-bold mb-6 mt-4">Informations de paiement</h2>

            <form action="{{ route('paiement') }}" method="POST" class="flex-1 flex flex-col justify-between">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nom sur la carte</label>
                        <input type="text" name="card_name" placeholder="Nom Prénom" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-gray-800 text-white focus:outline-none focus:border-gold transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Numéro de carte</label>
                        <input type="text" name="card_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-gray-800 text-white tracking-widest focus:outline-none focus:border-gold transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Date d'expiration</label>
                            <input type="text" name="card_expiry" placeholder="MM/AA" maxlength="5" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-gray-800 text-white focus:outline-none focus:border-gold transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Code CVV</label>
                            <input type="password" name="card_cvv" placeholder="***" maxlength="4" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-gray-800 text-white focus:outline-none focus:border-gold transition">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 mt-8 bg-[#E1A91A] text-black font-bold rounded-lg  shadow-lg shadow-gold/20 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Payer 399,00 MAD
                </button>
            </form>
        </div>
 <div class="bg-[#121212] p-8 rounded-2xl shadow-xl border border-gray-800 h-full flex flex-col justify-between">
            <div>
                <div class="border-b border-gray-800 pb-6 mb-6">
                    <h2 class="text-2xl font-bold text-gold mb-2">Résumé de votre commande</h2>
                    <p class="text-gray-400 text-sm">Vérifiez les détails de votre abonnement avant de procéder au paiement.</p>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-semibold text-lg">Abonnement Smart Pro</h3>
                        <p class="text-xs text-gray-400">Facturation Mensuelle</p>
                    </div>
                    <span class="font-bold text-lg">399.00 MAD</span>
                </div>

                <div class="border-t border-gray-800 pt-4 mt-4 space-y-2">
                    <div class="flex justify-between text-sm text-gray-400">
                        <span>Sous-total</span>
                        <span>399.00 MAD</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-400">
                        <span>TVA (20%)</span>
                        <span>Incluse</span>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-lg font-bold pt-4 border-t border-gray-800 text-white mb-8">
                    <span>Total à payer</span>
                    <span class="text-gold">399.00 MAD</span>
                </div>

                <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-800/50 pt-4">
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg> Paiement sécurisé</span>
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> Données cryptées</span>
                </div>
            </div>
        </div>
           <div>    <a href="{{ route('welcome') }}" class="text-xl"><i class="fa-solid fa-arrow-left text-[#E1A91A]"></i> back</a>
</div>
    </div>

</body>
</html>