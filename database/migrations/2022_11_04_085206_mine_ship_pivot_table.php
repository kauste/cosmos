<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Mine;
use App\Models\Ship;
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
        Schema::create('mine_ship', static function (Blueprint $table): void {
            $table->foreignIdFor(Mine::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Ship::class)->constrained()->cascadeOnDelete();
            $table->primary(['mine_id', 'ship_id']);
            $table->index('mine_id');
            $table->index('ship_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mine_ship');
    }
};
