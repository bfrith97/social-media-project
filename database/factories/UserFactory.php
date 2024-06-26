<?php

namespace Database\Factories;

use App\Models\Relationship;
use App\Models\User;
use App\Services\UserFactoryService;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        [
            $name,
            $picture,
        ] = UserFactoryService::handleImageAndName();

        return [
            'name' => $name,
            'role' => fake()->jobTitle(),
            'company' => fake()->company(),
            'info' => fake()->text(100),
            'email' => fake()
                ->unique()
                ->safeEmail(),
            'profile_picture' => $picture,
            'number' => fake()->numerify('##########'),
            'date_of_birth' => fake()
                ->dateTimeThisCentury()
                ->format('Y-m-d'),
            'relationship_id' => Relationship::inRandomOrder()
                ->first()->id,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
