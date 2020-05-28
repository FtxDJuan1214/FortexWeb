<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMIN
        Permission::create([
            'name'          => 'View dashboard admin',   
            'slug'          => 'admin.index',   
            'description'   => 'See dashboard admin',
        ]);

        // Technical Admin
        Permission::create([
            'name'          => 'View dashboard technical Admin',   
            'slug'          => 'technicalAdmin.index',   
            'description'   => 'See dashboard Technical Admin',
        ]);

        // Project Manager
        Permission::create([
            'name'          => 'View dashboard Project Manager',   
            'slug'          => 'projectManager.index',   
            'description'   => 'See dashboard Project Manager',
        ]);

        // team Admin
        Permission::create([
            'name'          => 'View dashboard team manager',   
            'slug'          => 'teamManager.index',   
            'description'   => 'See dashboard team manager',
        ]);

        // Designer
        Permission::create([
            'name'          => 'View dashboard designer',   
            'slug'          => 'designer.index',   
            'description'   => 'See dashboard designer',
        ]);

        // client
        Permission::create([
            'name'          => 'View dashboard client',   
            'slug'          => 'client.index',   
            'description'   => 'See dashboard client',
        ]);

        // Prospective clients
        Permission::create([
            'name'          => 'View dashboard Prospective clients',   
            'slug'          => 'prospectiveClients.index',   
            'description'   => 'See dashboard Prospective clients',
        ]);


        //Roles
        Permission::create([
            'name'          => 'View roles',   
            'slug'          => 'roles.index',   
            'description'   => 'List and browse all system roles',
        ]);
        Permission::create([
            'name'          => 'View rol details',   
            'slug'          => 'roles.show',   
            'description'   => 'See in detail each system user',
        ]);
        Permission::create([
            'name'          => 'Role creation',   
            'slug'          => 'roles.create',   
            'description'   => 'Create new roles in the system',
        ]);
        Permission::create([
            'name'          => 'Role editing',   
            'slug'          => 'roles.edit',   
            'description'   => 'Edit any data of a system role',
        ]);
        Permission::create([
            'name'          => 'Detele rol',   
            'slug'          => 'roles.destroy',   
            'description'   => 'Delete any system rol',
        ]);
    }
}
