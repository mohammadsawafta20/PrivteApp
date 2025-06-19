<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    use HasFactory;
    
        
 
     protected $table = 'sub_areas';
     protected $fillable = ['name', 'area_id', 'delivery_price'];


    public $timestamps = false;

    public function area()
{
    return $this->belongsTo(Area::class);
}

}
