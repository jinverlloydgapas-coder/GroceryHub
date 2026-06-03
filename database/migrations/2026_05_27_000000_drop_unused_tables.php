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
        // Drop unused cache table
        if (Schema::hasTable('cache')) {
            Schema::drop('cache');
        }

        // Drop unused jobs table
        if (Schema::hasTable('jobs')) {
            Schema::drop('jobs');
        }

        // Drop unused job_batches table
        if (Schema::hasTable('job_batches')) {
            Schema::drop('job_batches');
        }

        // Drop unused failed_jobs table
        if (Schema::hasTable('failed_jobs')) {
            Schema::drop('failed_jobs');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration removes unused tables, reverting would recreate them
        // which is not necessary for this cleanup
    }
};
