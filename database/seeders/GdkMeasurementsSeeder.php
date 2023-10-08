<?php

namespace Database\Seeders;

use App\Models\ContragentTypes;
use App\Models\GdkMeasurements;
use Illuminate\Database\Seeder;

class GdkMeasurementsSeeder extends Seeder
{
    const Measurements = [
        'Реакція середовища (pH)' => 9.0,
        'Мінералізація'           => 1500,
        'БСК5'                    => 260,
        'ХСК'                     => 500,
        'Завислі речовини'        => 300,
        'Азот'                    => 50,
        'Фосфати'                 => 5,
        'Нафта'                   => 10,
        'Жири загальні'           => 50,
        'Хлориди'                 => 300,
        'Сульфати'                => 100,
        'Сульфіди'                => 1,
        'СПАР'                    => 10,
        'Залізо'                  => 5,


    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $index = 1;
        foreach (self::Measurements as $measurement => $value) {
            GdkMeasurements::create([
                'name'        => $measurement,
                'standard'    => $value,
                'order_index' => $index,
            ]);

            $index ++;
        }
    }
}
