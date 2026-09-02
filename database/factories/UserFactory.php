<?php

namespace Database\Factories;

use App\Common\Constants\DeleteConst;
use App\Common\Constants\StatusConst;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<User>
     */
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = 'Aa123456';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'password' => static::$password ? password_hash(static::$password, PASSWORD_DEFAULT) : Hash::make('password'),
            'status_id' => StatusConst::NORMAL,
            'delete_id' => DeleteConst::NOT
        ];
    }
}
