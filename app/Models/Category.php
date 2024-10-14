<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'budget',
    ];

    // Define a relationship to the Budget model
    public function budgets()
    {
        return $this->hasMany(Budget::class, 'category_id');
    }

    // Define an accessor to calculate total expenses for the category
    public function getTotalExpensesAttribute()
    {
        return $this->budgets()->sum('amount'); // Calculate total expenses
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->budget > 0) {
            return min(($this->total_expenses / $this->budget) * 100, 100); // Limit progress to 100%
        }
        return 0;
    }

    public function expenses()
    {
        return $this->hasMany(Budget::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
