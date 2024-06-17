<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','material_id', 'name', 'price', 'stock', 'sale_percentage', 'description','content','status','locked'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
