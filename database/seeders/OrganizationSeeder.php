<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    // public function run()
    // {
    //     Organization::create([
    //         'name' => 'Tech Solutions',
    //         'logo' => 'images/organizations/01JJS5MMFY9J7SKEJPMD2PXJMV.png', // Adjust the path as per storage
    //         'address' => '123 Tech Street, City, Country',
    //         'maxDiscount' => 20,
    //         'minDiscount' => 5,
    //         'district_id' => 1,
    //         'sub_district_id' => 2,
    //     ]);

    //     Organization::create([
    //         'name' => 'Home Decor Hub',
    //         'logo' => 'images/organizations/01JJS5MMFY9J7SKEJPMD2PXJMV.png',
    //         'address' => '456 Design Avenue, City, Country',
    //         'maxDiscount' => 15,
    //         'minDiscount' => 3,
    //         'district_id' => 1,
    //         'sub_district_id' => 2,
    //     ]);
    // }

    public function run()
    {
        Organization::factory()->count(40)->create();
    }
}
