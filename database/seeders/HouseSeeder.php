<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        $houses = [
            ['house_number' => 'A-01', 'owner_name' => 'Bapak Budi', 'phone_number' => '628123456789'],
            ['house_number' => 'A-02', 'owner_name' => 'Ibu Siti', 'phone_number' => '628987654321'],
            ['house_number' => 'B-01', 'owner_name' => 'Bapak Joko', 'phone_number' => '628112233445'],
            ['house_number' => 'B-02', 'owner_name' => 'Ibu Ani', 'phone_number' => '628556677889'],
        ];

        foreach ($houses as $house) {
            House::create(array_merge($house, [
                'address' => 'Jl. Mawar No. ' . $house['house_number'],
                'qr_token' => Str::uuid()->toString(),
                'is_active' => true,
            ]));
        }
    }
}
