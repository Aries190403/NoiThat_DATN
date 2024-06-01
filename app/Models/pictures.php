<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pictures extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'product_id', 'gallery_id', 'description', 'status'];
}
