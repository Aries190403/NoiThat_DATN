<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email', 'address_id', 'status', 'avatar', 'content', 'description' ,'avatar'];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function picture()
    {
        return $this->belongsTo(picture::class, 'avatar');
    }
}
