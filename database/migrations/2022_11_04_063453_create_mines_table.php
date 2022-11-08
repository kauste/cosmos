<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Country;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mines', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('latitude');
            $table->unsignedMediumInteger('longitude');
            $table->unique(['longitude', 'latitude']);
            $table->string('mine_name', 50)->unique();
            $table->foreignIdFor(Country::class)->onDelete('cascade');
            $table->unsignedMediumInteger('exploitation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mines');
    }
};
