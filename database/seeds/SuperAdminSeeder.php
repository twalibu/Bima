<?php

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_groups')->truncate();

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Users',
            'permissions' => array(
                'admin' => 0,
                'users' => 1,
            )));

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Admins',
            'permissions' => array(
                'admin' => 1,
                'users' => 1,
            )));

        DB::table('admin_users')->truncate();

        Sentry::getUserProvider()->create(array(
            'email'    => 'cliff@techlegend.co',
            'first_name' => 'Thomson',
            'last_name' => 'Maguru',
            'username' => 'ngaiza',
            'password' => 'precious',
            'activated' => 1,
        ));

        DB::table('admin_users_groups')->truncate();

        $adminUser = Sentry::getUserProvider()->findByLogin('cliff@techlegend.co');
        $adminGroup = Sentry::getGroupProvider()->findByName('Admins');
        $userGroup = Sentry::getGroupProvider()->findByName('Users');

        // Assign the groups to the users
        $adminUser->addGroup($userGroup);
        $adminUser->addGroup($adminGroup);
    }
}
