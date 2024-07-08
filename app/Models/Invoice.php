<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_date',
        'address',
        'phone',
        'name',
        'total',
        'discountMoney',
        'status',
        'delivery',
        'user_id',
        'coupon_id',
        'pay_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoicedetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function code()
    {
        return $this->hasOne(coupon::class, 'coupon_id');
    }

    public function pay()
    {
        return $this->belongsTo(Pay::class, 'pay_id');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
}
