<?php

namespace App\Addons\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_category extends Model
{
    use HasFactory;
    public $table       = 'ticket_categories';
    protected $fillable = [
        'id',
        'title',
        'status',
        'created_at',
        'updated_at',
    ];

}
