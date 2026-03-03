<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
        UserType::query()->truncate();

        $userTypes = ['Сова', 'Заяц', 'Волк', 'Мышь'];

        foreach ($userTypes as $userType) {
            $model = new UserType();
            $model->name = $userType;
            $model->save();
        }
    }
}
