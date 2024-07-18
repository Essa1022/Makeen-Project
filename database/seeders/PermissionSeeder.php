<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'see.permission']);
        Permission::create(['name' => 'give.permission']);
        // Role Permissions
        Permission::create(['name' => 'create.role']);
        Permission::create(['name' => 'see.role']);
        Permission::create(['name' => 'delete.role']);
        Permission::create(['name' => 'give.role']);
        // User Permissions
        Permission::create(['name' => 'create.user']);
        Permission::create(['name' => 'see.user']);
        Permission::create(['name' => 'update.user']);
        Permission::create(['name' => 'delete.user']);
        //Label Permissions
        Permission::create(['name' => 'create.label']);
        Permission::create(['name' => 'see.label']);
        Permission::create(['name' => 'delete.label']);
        Permission::create(['name' => 'give.label']);
        //Category Permissions
        Permission::create(['name' => 'create.category']);
        Permission::create(['name' => 'update.category']);
        Permission::create(['name' => 'delete.category']);
        // Article Permissions
        Permission::create(['name' => 'create.article']);
        Permission::create(['name' => 'see.article']);
        Permission::create(['name' => 'update.article']);
        Permission::create(['name' => 'delete.article']);
        // Comment Permissions:
        Permission::create(['name' => 'see.comment']);
        Permission::create(['name' => 'update.comment']);
        Permission::create(['name' => 'delete.comment']);
        //Media Permissions
        Permission::create(['name' => 'create.media']);
        Permission::create(['name' => 'update.media']);
        Permission::create(['name' => 'delete.media']);
        // Ad Permissions
        Permission::create(['name' => 'create.ad']);
        Permission::create(['name' => 'update.ad']);
        Permission::create(['name' => 'delete.ad']);

        // Super Admin Role
        $Super_Admin = Role::where('name', 'Super_Admin')->exists();
        if (!$Super_Admin)
        {
            $Super_Admin = Role::create(['name' => 'Super_Admin']);
        }
        // Admin Role
        $Admin = Role::where('name', 'Admin')->exists();
        if (!$Admin)
        {
            $Admin = Role::create(['name' => 'Admin']);
        }
        // Reporter Role
        $Reporter = Role::where('name', 'Reporter')->exists();
        if (!$Reporter)
        {
            $Reporter = Role::create(['name' => 'Reporter']);
        }

        $Super_Admin->syncPermissions([
            'see.permission',
            'give.permission',
            'create.role',
            'see.role',
            'delete.role',
            'give.role',
            'create.user',
            'see.user',
            'update.user',
            'delete.user',
            'create.label',
            'see.label',
            'delete.label',
            'give.label',
            'create.category',
            'update.category',
            'delete.category',
            'create.article',
            'see.article',
            'update.article',
            'delete.article',
            'see.comment',
            'update.comment',
            'delete.comment',
            'create.media',
            'update.media',
            'delete.media',
            'create.ad',
            'update.ad',
            'delete.ad'
        ]);


        $Admin->syncPermissions([
            'create.user',
            'see.user',
            'update.user',
            'delete.user',
            'create.label',
            'see.label',
            'delete.label',
            'give.label',
            'create.category',
            'delete.category',
            'create.article',
            'see.article',
            'update.article',
            'delete.article',
            'see.comment',
            'update.comment',
            'create.media',
            'update.media',
            'delete.media',
            'create.ad',
            'update.ad',
            'delete.ad',
        ]);

        $Reporter->syncPermissions([
            'create.article',
            'update.article',
            'delete.article',
            'create.media',
            'update.media',
            'delete.media'
        ]);

        $Super_Admin = User::create([
            'username' => 'Ehsan',
            'phone_number' => '09021111111',
            'password' => 'Aa12345678'
        ]);

        $Super_Admin->assignRole('Super_Admin');

        $Reporter = User::create([
            'username' => 'Ali',
            'phone_number' => '09121111111',
            'password' => 'Aa12345678'
        ]);

        $Reporter->assignRole('Reporter');
    }
}
