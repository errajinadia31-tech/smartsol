<?php

namespace Database\Seeders;

use App\Models\Zone;
use App\Models\User; // مهم جداً
use Illuminate\Database\Seeder;

class MoroccoZonesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $data = [
            'Tanger-Tétouan-Al Hoceïma' => ['Tanger', 'Tétouan', 'Al Hoceïma', 'Larache', 'Chefchaouen', 'Ouazzane'],
            'L\'Oriental' => ['Oujda', 'Nador', 'Berkane', 'Taourirt', 'Guercif', 'Figuig'],
            'Fès-Meknès' => ['Fès', 'Meknès', 'Taza', 'Ifrane', 'Séfrou', 'Taounate'],
            'Rabat-Salé-Kénitra' => ['Rabat', 'Salé', 'Kénitra', 'Skhirat', 'Témara', 'Khémisset'],
            'Béni Mellal-Khénifra' => ['Béni Mellal', 'Khouribga', 'Khénifra', 'Azilal', 'Fquih Ben Salah'],
            'Casablanca-Settat' => ['Casablanca', 'Mohammédia', 'El Jadida', 'Settat', 'Berrrechid', 'Benslimane'],
            'Marrakech-Safi' => ['Marrakech', 'Safi', 'Essaouira', 'El Kelaâ des Sraghna', 'Youssoufia'],
            'Drâa-Tafilalet' => ['Errachidia', 'Ouarzazate', 'Midelt', 'Tinghir', 'Zagora'],
            'Souss-Massa' => ['Agadir', 'Inezgane', 'Taroudant', 'Tiznit', 'Tata'],
            'Guelmim-Oued Noun' => ['Guelmim', 'Tan-Tan', 'Sidi Ifni', 'Assa-Zag'],
            'Laâyoune-Sakia El Hamra' => ['Laâyoune', 'Boujdour', 'Tarfaya', 'Es-Semara'],
            'Dakhla-Oued Ed-Dahab' => ['Dakhla', 'Aousserd'],
        ];

        foreach ($data as $region => $villes) {
            foreach ($villes as $ville) {
                // استخدام الـ ID الخاص بالمستخدم الذي جلبناه في الخطوة رقم 1
                Zone::firstOrCreate([
                    'name' => $region,
                    'city' => $ville,
                    'user_id' => $user->id 
                ]);
            }
        }
    }
}