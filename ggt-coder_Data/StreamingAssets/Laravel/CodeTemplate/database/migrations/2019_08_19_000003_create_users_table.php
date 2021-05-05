<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('用户 ID');
            $table->bigInteger('phone')->default(0)->index()->comment('手机号');
            $table->string('name')->index()->comment('姓名');
            $table->string('password')->default(\Illuminate\Support\Facades\Hash::make('123456'))->comment('密码');
            $table->integer('belongs_to')->default(0)->index()->comment('所属人');
            $table->text('belongs_path')->nullable()->comment('从属路径');
            $table->text('admin_remark')->nullable()->comment('管理员备注');
            $table->tinyInteger('status')->default(1)->index()->comment('状态(1.正常, 9.冻结, 10.删除)');
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable()->comment('上次登录时间');
            $table->rememberToken();
            $table->integer('updated_by')->default(0)->comment('更新者');
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
