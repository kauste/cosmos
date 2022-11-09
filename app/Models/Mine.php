<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\MineFactory;
use App\Models\Country;
use App\Models\Ship;


class Mine extends Model
{
    use HasFactory;
    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    
    public function ships(){
        return $this->belongsToMany(Ship::class);
    }
    
    protected static function newMineFactory()
    {
        return MineFactory::new();
    }
}
