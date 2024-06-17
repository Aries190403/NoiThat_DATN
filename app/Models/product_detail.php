<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_detail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'material_id', 'size', 'price', 'stock', 'description', 'content', 'status'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
