<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $guarded = [''];

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    public function queue()
    {
        return $this->hasMany(Queue::class);
    }

}