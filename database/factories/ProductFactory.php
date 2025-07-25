<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'slug'         => $this->faker->slug,
            'name'         => $this->faker->word, // Temporary name (will be updated)
            'description'  => $this->faker->sentence,
            'weight'       => $this->faker->numberBetween(1, 10),
            'is_published' => 1,
            'category_id'  => $this->faker->numberBetween(1, 2),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Generate a country ID
            $countryId = $this->faker->randomElement(['121', '122', '189', '10']);

            // Update the product's name dynamically
            $product->update([
                'name' => $countryId . ' - ' . $product->name,
            ]);

            // Create stock for the product
            $product->stock()->create([
                'quantity' => 100,
            ]);

            // Create country pricing
            $product->countryPrices()->create([
                'country_id'  => $countryId,
                'price'       => $this->faker->numberBetween(100, 200),
                'promo_price' => $this->faker->optional()->numberBetween(30, 99),
            ]);

            // Assign users as agents
            $userIds = User::inRandomOrder()->limit($this->faker->numberBetween(3, 5))->pluck('id')->toArray();
            $agents = array_map(fn($id) => ['user_id' => $id], $userIds);
            
            $product->agents()->createMany($agents);
        });
    }
}
