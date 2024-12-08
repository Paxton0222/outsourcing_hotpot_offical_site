<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->comment('群組名稱');
            $table->string('desc', 100)->nullable()->comment('群組說明');
            $table->json('perm_ids')->nullable()->comment('群組對應權限表(json)');
            $table->timestamps();
        });
        Schema::table('users', static function (Blueprint $table) {
            $table->bigInteger('role_id')->comment('角色 ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
};
