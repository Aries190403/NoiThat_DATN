<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'gallery_id', 'name', 'sale_percentage', 'description','content','status','locked'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
