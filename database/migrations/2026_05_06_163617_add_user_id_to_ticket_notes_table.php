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
        Schema::table('ticket_notes', function (Blueprint $table) {
            //adding columns
            $table->foreignId('user_id')->nullable()->after('ticket_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_notes', function (Blueprint $table) {
            //removing columnns
            $table->dropColumn('user_id');
        });
    }
};
