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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->char('iso3', 3)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->char('numeric_code', 3)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->char('iso2', 2)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('phonecode')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('capital')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('currency')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('currency_name')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('currency_symbol')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('tld')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('native')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('region')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->unsignedMediumInteger('region_id')->nullable();
            $table->string('subregion')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->unsignedMediumInteger('subregion_id')->nullable();
            $table->string('nationality')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('timezones')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('translations')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('emoji', 191)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('emojiU', 191)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->comment('Rapid API GeoDB Cities');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
