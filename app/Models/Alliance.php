<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alliance extends Model
{
    use HasFactory;

    public function countries(){
        return $this->hasMany(Country::class, 'alliance_id', 'id');
    }
}
