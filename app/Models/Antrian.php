<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = [''];

    public function counter()
    {
        return $this->belongsTo(Counter::class); 
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class); 
    }
}