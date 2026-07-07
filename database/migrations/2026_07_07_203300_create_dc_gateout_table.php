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
        Schema::create('dc_gateout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NM_SERVIS', 12)->nullable();
            $table->string('NO_CTR', 11)->nullable();
            $table->string('VOYAGE_NO', 17)->nullable();
            $table->string('NM_KAPAL', 17)->nullable();
            $table->string('VOYAGE_NO_PLG', 16)->nullable();
            $table->string('NM_AGEN', 44)->nullable();
            $table->integer('SIZE_CTR')->nullable();
            $table->string('TIPE_CTR', 3)->nullable();
            $table->string('STATUS_VALUE', 11)->nullable();
            $table->integer('BERAT_CTR')->nullable();
            $table->string('POL-POD', 11)->default('IDJKT-IDSBY')->nullable();
            $table->string('POL', 5)->nullable();
            $table->string('POD', 5)->nullable();
            $table->string('Depo_Tujuan', 20)->nullable();
            $table->string('Nopol', 9)->nullable();
            $table->string('No_Lambung', 20)->nullable();
            $table->string('Keterangan', 100)->nullable();
            $table->dateTime('TGL_GTI')->nullable();
            $table->string('alat', 50)->nullable();
            $table->string('operator', 50)->nullable();
            $table->dateTime('tgl_gateout')->useCurrent()->nullable();
            $table->string('STATUS_GATEOUT', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dc_gateout');
    }
};
