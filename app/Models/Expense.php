<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'category',
        'amount',
        'date',
        'note',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];
}
