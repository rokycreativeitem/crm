<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $table = 'project_payments';

    protected $fillable = [
        'title',
        'project_id',
        'user_id',
        'payment',
        'payment_method',
        'status',
        'timestamps',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
