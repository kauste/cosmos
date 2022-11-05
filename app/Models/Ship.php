<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Mine;

class Ship extends Model
{
    use HasFactory;

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function mines(){
        return $this->belongsToMany(Mine::class);
    }
}
