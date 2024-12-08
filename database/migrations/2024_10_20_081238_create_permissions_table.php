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
        Schema::create('permissions', static function (Blueprint $table) {
            $table->increments('id')->comment('權限ID');
            $table->integer('parent_id')->default(0)->comment('上層權限的id');
            $table->string('name', 10)->comment('權限名稱');
            $table->string('key', 50)->comment('程式判斷用代碼');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
