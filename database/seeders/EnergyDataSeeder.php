<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Panel;
use App\Models\EnergyData;
use Carbon\Carbon;

class EnergyDataSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        if ($users->isEmpty()) {

            $users = collect([
                User::firstOrCreate(
                    ['email' => 'test@smartsol.com'],
                    [
                        'name' => 'Nadia Erraji',
                        'password' => bcrypt('password123'),
                    ]
                )
            ]);
        }

        foreach ($users as $user) {

            $panel = Panel::firstOrCreate(
                ['serial_number' => 'SN-' . $user->id . '-ALPHA'],
                [
                    'user_id' => $user->id,
                    'name' => 'Panneau Alpha #' . $user->id,
                    'power_capacity' => 445,
                    'status' => 'active',
                ]
            );

            // تنظيف البيانات القديمة
            EnergyData::where('panel_id', $panel->id)->delete();

            // آخر ساعتين كل 10 دقائق
            for ($i = 12; $i >= 0; $i--) {

                $time = Carbon::now()->subMinutes($i * 10);

                $basePower = $panel->power_capacity;

                $hour = $time->hour;

                // إنتاج حسب الوقت
                if ($hour >= 7 && $hour <= 18) {

                    // النهار
                    $variation = rand(55, 95) / 100;

                } else {

                    // الليل
                    $variation = rand(0, 5) / 100;
                }

                $power = round($basePower * $variation, 2);

                EnergyData::create([

                    'panel_id' => $panel->id,

                    'power' => $power,

                    'voltage' => rand(220, 240),

                    'current' => rand(2, 8),

                    'energy_kwh' => round($power / 1000, 4),

                    'created_at' => $time,

                    'updated_at' => $time,
                   
                ]);
            }
        }
    }
}