<?php

namespace App\Models;
use App\Models\Subarea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];
    
        public $timestamps = false; // ⬅️ هذا يمنع Laravel من محاولة استخدام created_at و updated_at


    public function subareas()
    {
        return $this->hasMany(Subarea::class);
    }
}
