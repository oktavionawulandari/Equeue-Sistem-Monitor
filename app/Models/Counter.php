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

    public function AntrianNow()
    {
        return $this->hasMany(AntrianNow::class);
    }


    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
