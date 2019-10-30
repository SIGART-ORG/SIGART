<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
            UnityTableSeeder::class,
            SitesTableSeeder::class,
            UsersTableSeeder::class,
            UserSitesTableSeeder::class,
            ProvidersTableSeeder::class,
            ProductsTableSeeder::class,
            PresentationSeeder::class,
            PurchaseRequestTableSeeder::class,
            PurchaseRequestDetailTableSeeder::class,
            TypeServicesTableSeeder::class,
        ]);
    }
}
