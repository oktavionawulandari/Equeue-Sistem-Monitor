<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianNow extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = [''];

    use HasFactory;

    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}
