<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
            return $model->save();
        }
    }
}
