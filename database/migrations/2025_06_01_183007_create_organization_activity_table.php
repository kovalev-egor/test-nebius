<?php

use App\Models\Activity;
use App\Models\Organization;
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
        Schema::create('organization_activity', function (Blueprint $table) {
            $table->foreignIdFor(Organization::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Activity::class)->constrained()->cascadeOnDelete();
            $table->primary(['organization_id', 'activity_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_activity');
    }
};
