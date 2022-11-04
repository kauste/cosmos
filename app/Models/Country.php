<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mine;

class Country extends Model
{
    use HasFactory;
    public function mines(){
        return $this->hasMany(Mine::class, 'country_id', 'id');
    }
}
