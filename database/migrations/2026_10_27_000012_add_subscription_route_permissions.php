<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private array $permissions = [
        ['name' => 'view-subscription', 'label' => 'إدارة اشتراك المالك', 'route_name' => 'owner.subscription'],
        ['name' => 'request-subscription', 'label' => 'طلب اشتراك مميز', 'route_name' => 'owner.subscribe'],
        ['name' => 'approve-owner-subscription', 'label' => 'اعتماد اشتراك المالك', 'route_name' => 'admin.subscriptions.approve'],
    ];

    public function up(): void
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                $permission + ['created_at' => now(), 'updated_at' => now()]
            );
        }

        $ownerRoleId = DB::table('roles')->where('name', 'owner')->value('id');
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        foreach (['view-subscription', 'request-subscription'] as $name) {
            $permissionId = DB::table('permissions')->where('name', $name)->value('id');
            if ($ownerRoleId && $permissionId) {
                DB::table('permission_role')->insertOrIgnore([
                    'role_id' => $ownerRoleId,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        if ($adminRoleId) {
            foreach ($this->permissions as $permission) {
                $permissionId = DB::table('permissions')->where('name', $permission['name'])->value('id');
                DB::table('permission_role')->insertOrIgnore([
                    'role_id' => $adminRoleId,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }

    public function down(): void
    {
        $permissionIds = DB::table('permissions')
            ->whereIn('name', array_column($this->permissions, 'name'))
            ->pluck('id');

        DB::table('permission_role')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permissions')->whereIn('id', $permissionIds)->delete();
    }
};
