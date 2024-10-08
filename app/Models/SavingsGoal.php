<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'target_amount',
        'current_amount',
        'start_date',
        'end_date',
    ];

    // If you need to define relationships, you can add them here
    // Example: a budget might belong to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
