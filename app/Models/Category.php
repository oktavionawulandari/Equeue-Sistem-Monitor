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
        return $this->hasMany(Counter::class, 'category_id', 'id');
    }

    public function queue()
    {
        return $this->hasMany(Queue::class);
    }

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function AntrianNow()
    {
        return $this->hasMany(AntrianNow::class);
    }

}
