<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'user_type' => 'admin',
            'password' => '12345678'
        ]);
        Product::factory()->count(5)->create();
        $statuses = ['Pending','Shipped','Delivered','Cancelled'];
        foreach($statuses  as $status){
            $s = new Status();
            $s->name = $status;
            $s->save();
        }
    }
}
