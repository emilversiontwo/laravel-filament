<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->json('settings')->nullable();

            $table->dropForeign('chats_owner_user_id_foreign');
            $table->dropColumn('owner_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('settings');

            $table->unsignedBigInteger('owner_user_id')->nullable();
            $table->foreignId('owner_user_id_foreign')->nullable()->references('id')->on('users');
        });
    }
};
