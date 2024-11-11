<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء مستخدم "admin"
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // تأكد من استخدام كلمة مرور مشفرة
            'role' => 'admin', // تأكد من أن هذا الدور يتوافق مع الأعمدة في قاعدة البيانات
        ]);

        // إنشاء مستخدم "user"
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user', // تأكد من أن هذا الدور يتوافق مع الأعمدة في قاعدة البيانات
        ]);

        // يمكنك إضافة المزيد من المستخدمين إذا أردت

        // مثال: إنشاء عدة مستخدمين عشوائيين باستخدام Faker
        \App\Models\User::factory(10)->create(); // إذا كان لديك Factory للمستخدمين
    }
}
