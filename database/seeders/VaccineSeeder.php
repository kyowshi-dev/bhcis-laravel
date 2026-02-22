<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineSeeder extends Seeder
{
    public function run(): void
    {
        $vaccines = [
            ['vaccine_code' => 'BCG', 'vaccine_name' => 'BCG (Tuberculosis)', 'description' => 'At birth', 'sort_order' => 1],
            ['vaccine_code' => 'HepB', 'vaccine_name' => 'Hepatitis B', 'description' => 'Birth, 6, 10, 14 weeks', 'sort_order' => 2],
            ['vaccine_code' => 'DPT', 'vaccine_name' => 'DPT (Diphtheria-Pertussis-Tetanus)', 'description' => '6, 10, 14 weeks; 12–23 months', 'sort_order' => 3],
            ['vaccine_code' => 'OPV', 'vaccine_name' => 'OPV (Oral Polio Vaccine)', 'description' => '6, 10, 14 weeks; 12–23 months', 'sort_order' => 4],
            ['vaccine_code' => 'PCV', 'vaccine_name' => 'PCV (Pneumococcal)', 'description' => '6, 10, 14 weeks; 12–15 months', 'sort_order' => 5],
            ['vaccine_code' => 'Measles', 'vaccine_name' => 'Measles', 'description' => '9 months; 12–23 months (MMR)', 'sort_order' => 6],
            ['vaccine_code' => 'MMR', 'vaccine_name' => 'MMR (Measles-Mumps-Rubella)', 'description' => '12–23 months', 'sort_order' => 7],
            ['vaccine_code' => 'TT', 'vaccine_name' => 'Tetanus Toxoid (TT)', 'description' => 'Pregnant women; booster every 10 years', 'sort_order' => 8],
            ['vaccine_code' => 'COVID', 'vaccine_name' => 'COVID-19', 'description' => 'As per DOH schedule', 'sort_order' => 9],
            ['vaccine_code' => 'Flu', 'vaccine_name' => 'Influenza', 'description' => 'Annual (high-risk)', 'sort_order' => 10],
        ];

        $now = now();
        foreach ($vaccines as $i => $v) {
            $vaccines[$i]['created_at'] = $now;
            $vaccines[$i]['updated_at'] = $now;
        }
        foreach ($vaccines as $v) {
            DB::table('vaccines_lookup')->insertOrIgnore($v);
        }
    }
}
