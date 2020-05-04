<?php

use Illuminate\Database\Seeder;

class ServiceRequestDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ServiceRequestDetail::class, 250)->create();
    }
}
