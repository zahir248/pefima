<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'name',
        'category_id',
        'amount',
        'date',
    ];

    // If you need to define relationships, you can add them here
    // Example: a budget might belong to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Example: a budget might belong to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
