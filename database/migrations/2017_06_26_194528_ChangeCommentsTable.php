<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class ChangeCommentsTable
 *
 * Связывание комментариев с определенным пользователем (в случае, когда его оставляет кто-то из
 * администрации - зарег.пользователь) и с определенной статьей
 */
class ChangeCommentsTable extends Migration
{

    /** @return void */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->bigInteger(config('comments.key_field'))->unsigned();
            $table->foreign(config('comments.key_field'))->references('id')->on(config('comments.key_table'))->onDelete('cascade');

            if(config('comments.user')){
                $table->bigInteger('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
            }
        });
    }

    /** @return void */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }

}
