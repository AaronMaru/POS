<?php
use App\Models\Category;
use App\User;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::login(User::first());
        factory(Category::class, 10)->create()->each(function ($product) {
            $product->products()->save(factory(App\Models\Product::class)->make());
        });
    }
}
