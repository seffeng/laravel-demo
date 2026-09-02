<?php

namespace Database\Seeders;

use App\Modules\Admin\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = '10086';
        if (!Admin::byUsername($username)->exists()) {
            $model = new Admin();
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
