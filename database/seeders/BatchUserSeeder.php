<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Models\User;
use App\Common\Constants\DeleteConst;
use App\Common\Constants\StatusConst;

class BatchUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usernameItems = ['10000', '10001', '10002'];
        if (User::whereIn('username', $usernameItems)->exists()) {
            return true;
        }
        $model = new User();
        $model->password = 'Aa123456';
        $password = $model->encryptPassword();
        $tableName = $model->getTable();
        $time = time();
        $data = [];
        foreach ($usernameItems as $username) {
            $data[] = [
                'username' => $username,
                'password' => $password,
                'status_id' => StatusConst::NORMAL,
                'delete_id' => DeleteConst::NOT,
                'login_count' => 0,
                'login_at' => 0,
                'login_ip' => '',
                'created_at' => $time,
                'updated_at' => $time
            ];
        }
        DB::table($tableName)->insert($data);
    }
}
