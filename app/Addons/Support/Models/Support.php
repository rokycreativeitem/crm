<?php

namespace App\Addons\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;
    public $table       = 'test';
    protected $fillable = [
        'title',
    ];
}
