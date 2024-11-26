<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antrian extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = [''];

    public function AntrianNow()
    {
        return $this->hasMany(AntrianNow::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
