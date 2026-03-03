<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable();
            $table->string('gender');
            $table->date('birthday');
            $table->string('best_friend_name');

            $table->unsignedBigInteger('user_type_id');
            $table->foreign('user_type_id')->references('id')->on('user_types');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nickname');
            $table->dropColumn('gender');
            $table->dropColumn('birthday');
            $table->dropColumn('best_friend_name');

            $table->dropForeign('users_user_type_id_foreign');

            $table->dropColumn('user_type_id');
        });
    }
};
