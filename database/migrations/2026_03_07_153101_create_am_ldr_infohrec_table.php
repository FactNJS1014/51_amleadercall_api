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
        Schema::create('AM_LDR_INFOHREC_TBL', function (Blueprint $table) {
            $table->string('AMLDRINF_HREC_ID', 255)->primary();
            $table->string('AMLDRINF_DOC_NUM', 255);
            $table->string('AMLDRINF_EMPHREC', 7);
            $table->string('AMLDRINF_HREC_LINE', 100);
            $table->string('AMLDRINF_HREC_CUS', 100);
            $table->string('AMLDRINF_HREC_WON', 255);
            $table->string('AMLDRINF_HREC_MDLCD', 255);
            $table->string('AMLDRINF_HREC_MDLNM', 255);
            $table->integer('AMLDRINF_HREC_LOTS');
            $table->string('AMLDRINF_HREC_PROCS', 255);
            $table->string('AMLDRINF_HREC_CSTYPE', 255);
            $table->string('AMLDRINF_HREC_PROB', 2000);
            $table->string('AMLDRINF_HREC_IMAGE', 255);
            $table->integer('AMLDRINF_HREC_STD');
            $table->integer('AMLDRINF_HREC_UPDATESTD')->nullable();
            $table->timestamp('AMLDRINF_HREC_LSTDT');
            $table->timestamp('AMLDRINF_HREC_UPDATELSTDT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AM_LDR_INFOHREC_TBL');
    }
};
