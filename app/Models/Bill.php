<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'amount',
        'service',
        'account_number',
        'category',
        'comment',
        'status',
        'is_archive',
    ];
}
