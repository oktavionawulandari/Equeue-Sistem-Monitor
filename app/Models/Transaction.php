<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $guarded = [''];
    
    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
