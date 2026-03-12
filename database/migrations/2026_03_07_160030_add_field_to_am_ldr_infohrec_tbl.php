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
        Schema::table('AM_LDR_INFOHREC_TBL', function (Blueprint $table) {
            $table->string('AMLDRINF_HREC_STARTTIME', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('AM_LDR_INFOHREC_TBL', function (Blueprint $table) {
            $table->dropColumn('AMLDRINF_HREC_STARTTIME');
        });
    }
};
