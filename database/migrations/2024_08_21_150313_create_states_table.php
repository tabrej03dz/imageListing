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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->mediumInteger('country_id')->unsigned();
            $table->char('country_code', 2)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('fips_code', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('iso2', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('type', 191)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('flag')->default(1);
            $table->string('wikiDataId', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->comment('Rapid API GeoDB Cities');

            $table->primary('id');
            $table->index('country_id', 'country_region');
            $table->foreign('country_id', 'country_region_final')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
