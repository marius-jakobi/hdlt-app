<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = Role::create(['name' => 'administrator', 'description' => 'Administratoren']);
        $technicians = Role::create(['name' => 'technician', 'description' => 'Service-Techniker']);
        $backoffice = Role::create(['name' => 'back-office', 'description' => 'Mitarbeiter im Innendienst']);
        $sales = Role::create(['name' => 'sales-agents', 'description' => 'Mitarbeiter im Außendienst']);

        $createUsers = Permission::create(['name' => 'create-users', 'description' => 'Die Rolle kann neue Benutzer erstellen']);
        $collectStationData = Permission::create(['name' => 'collect-station-data', 'description' => 'Die Rolle kann Anlagen aufnehmen']);
        $executeJobs = Permission::create(['name' => 'execute-jobs', 'description' => 'Die Rolle kann Aufträge durchführen']);
    }
}
