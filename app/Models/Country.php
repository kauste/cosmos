<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mine;
use App\Models\Ship;

class Country extends Model
{
    use HasFactory;
    public function mines(){
        return $this->hasMany(Mine::class, 'country_id', 'id');
    }
    public function ships(){
        return $this->hasMany(Ship::class, 'country_id', 'id');
    }
}
