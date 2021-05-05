<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_storages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0)->index()->comment('用户 ID');
            $table->string('name')->index()->comment('地址');
            $table->tinyInteger('used')->default(\App\Models\ResourceStorage::USED_FALSE_CODE)->index()->comment('已使用');
            $table->string('used_model_type')->nullable()->comment('引用模型');
            $table->bigInteger('used_model_id')->default(0)->comment('引用模型 ID');
            $table->string('used_model_field')->nullable()->comment('引用模型字段');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}
