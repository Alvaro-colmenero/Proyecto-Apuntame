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
        //Modifica la tabla de usuarios añadiéndole la columna email_verified_at de tipo fecha y hora
        //permitiendo que esta pueda ser nula y la columna en cuestión se posiciona después del email
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('email_verified_at')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Elimina la columna, se ejecuta en le caso en el que se ejecute en el desarrollo el comando
        //php artisan mirage:rollback
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
};
