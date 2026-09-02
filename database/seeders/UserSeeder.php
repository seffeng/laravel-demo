<?php

namespace Database\Seeders;

use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = '10086';
        if (!User::byUsername($username)->exists()) {
            $model = new User();
            $model->fill([
                'username' => $username,
                'password' => 'Aa123456',
                'login_count' => 0,
                'login_at' => 0,
                'login_ip' => ''
            ]);
            $model->loadDefaultValue()->encryptPassword();
            $model->save();
        }
    }
}
