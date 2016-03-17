<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Right;
use App\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RightsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        Model::reguard();
    }
}

class RightsTableSeeder extends Seeder {
    public function run()
    {
        // Check if no right at 1 exists
        $right = Right::find(1);
        if(!$right){
            // Empty table and reinit auto-increment
            DB::table('rights')->truncate();
            // Create rights
            Right::create(array('name' => 'Client - Create'));
            Right::create(array('name' => 'Client - Modify'));
            Right::create(array('name' => 'Client - Delete'));
            Right::create(array('name' => 'Project - Create'));
            Right::create(array('name' => 'Project - Modify'));
            Right::create(array('name' => 'Project - Delete'));
            Right::create(array('name' => 'Project - Subscribe'));
            Right::create(array('name' => 'Client - Archive'));
            Right::create(array('name' => 'Project - Archive'));
            Right::create(array('name' => 'Copydeck - Create'));
            Right::create(array('name' => 'Copydeck - Modify'));
            Right::create(array('name' => 'Copydeck - Delete'));
            Right::create(array('name' => 'Version - Create'));
            Right::create(array('name' => 'Version - Modify'));
            Right::create(array('name' => 'Version - Delete'));
            Right::create(array('name' => 'Version - Status to "In Edition"'));
            Right::create(array('name' => 'Version - Status to "Ready"'));
            Right::create(array('name' => 'Version - Status to "In development"'));
            Right::create(array('name' => 'Version - Status to "Deployed"'));
            Right::create(array('name' => 'User - Create'));
            Right::create(array('name' => 'User - Modify'));
            Right::create(array('name' => 'User - Delete'));
            Right::create(array('name' => 'User - Change roles'));
            Right::create(array('name' => 'Role - Create'));
            Right::create(array('name' => 'Role - Modify'));
            Right::create(array('name' => 'Role - Delete'));
            Right::create(array('name' => 'Right - Create'));
            Right::create(array('name' => 'Right - Modify'));
            Right::create(array('name' => 'Right - Delete'));
            Right::create(array('name' => 'Access to Admin'));
            Right::create(array('name' => 'Create Discussion'));
            Right::create(array('name' => 'Delete Discussion'));
            Right::create(array('name' => 'Post Message in Discussion'));
            Right::create(array('name' => 'Edit (every) Message in Discussion'));
            Right::create(array('name' => 'Delete (every) Message in Discussion'));
        }
    }
}

class RolesTableSeeder extends Seeder {
    public function run()
    {
        // Check if no role at 1 exists
        $role = Role::find(1);
        if(!$role){
            // Empty table and reinit auto-increment
            DB::table('roles')->truncate();
            // Create roles and attach rights
            $watcher = Role::create(array('name' => 'Watcher'));
            $watcher->rights()->sync(7);

            $editor = Role::create(array('name' => 'Editor'));
            $editor->rights()->sync([7, 10, 11, 13, 14, 16]);

            $developer = Role::create(array('name' => 'Developer'));
            $developer->rights()->sync([10, 11, 13, 14, 18, 19]);

            $admin = Role::create(array('name' => 'Admin'));
            $admin->rights()->sync([1, 2, 3, 8, 9, 20, 21 ,22, 23 ,24 ,25, 26, 30]);

            $superAdmin = Role::create(array('name' => 'Super admin'));
            $superAdmin->rights()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35]);

            $projectManager = Role::create(array('name' => 'Project Manager'));
            $projectManager->rights()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 17]);
        }
    }
}

class UsersTableSeeder extends Seeder {
    public function run()
    {
        // Check if no user at 1 exists
        $user = User::find(1);
        if(!$user){
            // Empty table and reinit auto-increment
            DB::table('users')->truncate();
            // Create user
            $userAdmin = User::create(array(
                'name' => 'Admin',
                'email' => 'rlutter@lemieuxbedard.com',
                'password' => Hash::make('W0nd3rfu1')
            ));
            // Make him Super Admin
            $userAdmin->roles()->sync(5);
        }
    }
}