<?php

use App\Enums\ReportStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('post_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('post_reports', 'status')) {
                $table->string('status')->default(ReportStatus::Pending->value)->after('reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('post_reports', function (Blueprint $table) {
            if (Schema::hasColumn('post_reports', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
