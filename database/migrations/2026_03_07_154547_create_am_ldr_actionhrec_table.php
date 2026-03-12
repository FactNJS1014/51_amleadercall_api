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
        Schema::create('AM_LDR_ACTIONHREC_TBL', function (Blueprint $table) {
            $table->string('AMLDRACT_HREC_ID', 255)->primary();
            $table->string('AMLDRINF_HREC_ID', 255)->index();
            $table->foreign('AMLDRINF_HREC_ID')->references('AMLDRINF_HREC_ID')->on('AM_LDR_INFOHREC_TBL');
            $table->text('AMLDRACT_HREC_RTCAUSE');
            $table->text('AMLDRACT_HREC_ACTION');
            $table->string('AMLDRACT_HREC_ACTIONEMP', 7);
            $table->string('AMLDRACT_HREC_IMAGE', 255);
            $table->integer('AMLDRACT_HREC_STD');
            $table->integer('AMLDRACT_HREC_UPDATESTD')->nullable();
            $table->timestamp('AMLDRACT_HREC_LSTDT');
            $table->timestamp('AMLDRACT_HREC_UPDATELSTDT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AM_LDR_ACTIONHREC_TBL');
    }
};
