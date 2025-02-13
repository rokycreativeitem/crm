<?php

namespace App\Addons\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    public $table       = 'faqs';
    protected $fillable = [
        'id',
        'question',
        'client_id',
        'answer',
        'created_at',
        'updated_at',
    ];

}
