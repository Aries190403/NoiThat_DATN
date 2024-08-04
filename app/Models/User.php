<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $fillable = ['role', 'name', 'password', 'phone', 'email', 'address_id', 'locked', 'status', 'avatar'];

    // Các trường ẩn như mật khẩu không nên xuất hiện khi truy vấn
    protected $hidden = ['password', 'remember_token'];

    // Mô hình User có thể có nhiều địa chỉ
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function picture()
    {
        return $this->belongsTo(picture::class, 'avatar');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
