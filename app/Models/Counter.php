<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $guarded = [''];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    // public function queue()
    // {
    //     return $this->belongsTo(Queue::class);
    // }
}
