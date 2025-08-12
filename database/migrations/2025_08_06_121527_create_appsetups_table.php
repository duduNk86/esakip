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
        Schema::create('appsetups', function (Blueprint $table) {
            $table->id();
            $table->string('kabupaten');
            $table->string('unit');
            $table->string('pimpinan');
            $table->string('nip', 18);
            $table->string('alamat');
            $table->text('map');
            $table->string('telp');
            $table->string('fax');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('kodepos');
            $table->string('website');
            $table->string('twitter_x');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('youtube');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appsetups');
    }
};
