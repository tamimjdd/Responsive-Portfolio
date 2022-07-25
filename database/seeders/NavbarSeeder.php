<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navbar;

class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'name' => 'Home',
                'route' => '/',
                'ordering' => 1,
            ],
            [
                'name' => 'notifications',
                'route' => '/notifications',
                'ordering' => 2,
            ],
            // [
            //     'name' => 'About US',
            //     'route' => 'about.us',
            //     'ordering' => 3,
            // ]
        ];

        foreach ($links as $key => $navbar) {
            Navbar::create($navbar);
        }
    }
}
