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

                // إنتاج واستهلاك حسب الوقت
                if ($hour >= 7 && $hour <= 18) {
                    // ☀️ النهار: الإنتاج طالع والاستهلاك كيكون متوازن (مثلاً بين 40% و 70% من الإنتاج)
                    $variation = rand(55, 95) / 100;
                    $power = round($basePower * $variation, 2);
                    $consumption = round(($power * 0.6) + rand(5, 15), 2);
                } else {
                    // 🌙 الليل: الإنتاج شبه منعدم، ولكن الاستهلاك كيبقى كاين (الأجهزة، الإضاءة...)
                    $variation = rand(0, 5) / 100;
                    $power = round($basePower * $variation, 2);
                    // استهلاك ليلي عشوائي منطقي (مثلاً بين 30W و 80W)
                    $consumption = round(rand(30, 80), 2);
                }

                EnergyData::create([
                    'panel_id' => $panel->id,
                    'power' => $power,
                    'consumption' => $consumption, // ✅ الكولون الجديد اللي زدتيه ف الـ Migration
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