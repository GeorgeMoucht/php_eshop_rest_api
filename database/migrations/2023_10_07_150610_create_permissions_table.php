<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Types of calls.
     * @var array|string[]
     */
    private array $types = [
        'get', 'post', 'put', 'destroy'
    ];

    /**
     * Names of the permissions.
     * @var array|string[]
     */
    private array $names = [
        'user','role','customer','order','product'
    ];


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name','45')->unique();
        });

        $this->makePermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }

    /**
     * Generate the permissions data to be saved
     * @return void
     */
    private function makePermissions() : void
    {
        foreach($this->types as $type){
            foreach ($this->names as $permission) {
                \App\Models\Permission::firstOrCreate(['name' => $type . '_' . $permission]);
            }
        }
        \App\Models\Permission::create([
            'name' => \App\Enums\ACL\Permissions\PermissionName::GET_SPECIFIC_CUSTOMER->value
        ]);

        \App\Models\Permission::create([
            'name' => \App\Enums\ACL\Permissions\PermissionName::POST_SPECIFIC_CUSTOMER->value
        ]);
        \App\Models\Permission::create([
            'name' => \App\Enums\ACL\Permissions\PermissionName::INDEX_CUSTOMER->value
        ]);
        \App\Models\Permission::create([
            'name' => \App\Enums\ACL\Permissions\PermissionName::PUT_SPECIFIC_CUSTOMER->value
        ]);
    }

};
