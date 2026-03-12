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
        Schema::create('AM_LDR_CONFIRMHREC_TBL', function (Blueprint $table) {
            $table->string('AMLDRCONF_HREC_ID', 255)->primary();
            $table->string('AMLDRINF_HREC_ID', 255)->index();
            $table->foreign('AMLDRINF_HREC_ID')->references('AMLDRINF_HREC_ID')->on('AM_LDR_INFOHREC_TBL');
            $table->string('AMLDRACT_HREC_ID', 255)->index();
            $table->foreign('AMLDRACT_HREC_ID')->references('AMLDRACT_HREC_ID')->on('AM_LDR_ACTIONHREC_TBL');
            $table->string('AMLDRCONF_HREC_EMPNO', 7);
            $table->text('AMLDRCONF_HREC_RESULT');
            $table->string('AMLDRCONF_HREC_ENDTIME', 255);
            $table->string('AMLDRCONF_HREC_TOTALTIME', 255);
            $table->integer('AMLDRCONF_HREC_STD');
            $table->timestamp('AMLDRCONF_HREC_LSTDT');
            $table->integer('AMLDRCONF_HREC_REJECTSTD')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AM_LDR_CONFIRMHREC_TBL');
    }
};
