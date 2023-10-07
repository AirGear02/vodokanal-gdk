<?php

namespace Database\Seeders;

use App\Models\ContragentTypes;
use Illuminate\Database\Seeder;

class ContragentTypesSeeder extends Seeder
{
    const CONTRAGENT_TYPES = [
        'Заклад харчування',
        'Мийка',
        'Заправка',
        'Виробництво',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::CONTRAGENT_TYPES as $type_name) {
            ContragentTypes::create(['name' => $type_name]);
        }
    }
}
