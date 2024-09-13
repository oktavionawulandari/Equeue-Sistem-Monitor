<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loket extends Model
{
    use HasFactory;
    protected $table = 'loket';
    protected $primaryKey = 'id';
    protected $guarded = [''];
}
