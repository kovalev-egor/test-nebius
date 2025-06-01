<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $building1 = Building::create([
            'address' => 'г. Москва, ул. Ленина 1, офис 3',
            'latitude' => 55.7558,
            'longitude' => 37.6173
        ]);

        $building2 = Building::create([
            'address' => 'г. Москва, ул. Блюхера 32/1',
            'latitude' => 55.7658,
            'longitude' => 37.6273
        ]);

        // Создание деятельностей (дерево с ограничением в 3 уровня)
        $food = Activity::create(['name' => 'Еда']);
        $meat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id]);
        $dairy = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id]);
        $cars = Activity::create(['name' => 'Автомобили']);
        Activity::create(['name' => 'Грузовые', 'parent_id' => $cars->id]);
        $passenger = Activity::create(['name' => 'Легковые', 'parent_id' => $cars->id]);
        $parts = Activity::create(['name' => 'Запчасти', 'parent_id' => $passenger->id]);

        // Создание организаций
        $org1 = Organization::create([
            'name' => 'ООО Рога и Копыта',
            'building_id' => $building1->id
        ]);

        $org2 = Organization::create([
            'name' => 'ООО АвтоМир',
            'building_id' => $building2->id
        ]);

        // Телефоны
        OrganizationPhone::create(['organization_id' => $org1->id, 'phone_number' => '2-222-222']);
        OrganizationPhone::create(['organization_id' => $org1->id, 'phone_number' => '3-333-333']);
        OrganizationPhone::create(['organization_id' => $org2->id, 'phone_number' => '8-923-666-13-13']);

        // Привязка деятельностей
        $org1->activities()->attach([$meat->id, $dairy->id]);
        $org2->activities()->attach([$parts->id]);
    }
}
