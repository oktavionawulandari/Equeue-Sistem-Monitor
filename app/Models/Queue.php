<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $guarded = [''];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }

    public function counter() {
        return $this->belongsTo(Counter::class);
    }
}
