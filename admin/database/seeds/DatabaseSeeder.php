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
            SiteVoucherTableSeeder::class,
            UsersTableSeeder::class,
            UserSitesTableSeeder::class,
            ProvidersTableSeeder::class,
            ProductsTableSeeder::class,
            PresentationSeeder::class,
            StocksTableSeeder::class,
            PurchaseRequestTableSeeder::class,
            PurchaseRequestDetailTableSeeder::class,
            CustomersTableSeeder::class,
            ServiceRequestTableSeeder::class,
            ServiceRequestDetailsTableSeeder::class,
            ServicesTableSeeder::class,
            ServiceLogsTableSeeder::class
        ]);
    }
}
