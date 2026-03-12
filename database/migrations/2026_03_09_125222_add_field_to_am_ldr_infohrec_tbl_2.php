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
            $table->text('AMLDRINF_HREC_LOCATE');
            $table->string('AMLDRINF_HREC_MACHINE', 2000);
            $table->integer('AMLDRINF_HREC_QTYNG');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('AM_LDR_INFOHREC_TBL', function (Blueprint $table) {
            $table->dropColumn('AMLDRINF_HREC_LOCATE');
            $table->dropColumn('AMLDRINF_HREC_MACHINE');
            $table->dropColumn('AMLDRINF_HREC_QTYNG');
        });
    }
};
