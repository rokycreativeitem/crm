<?php

namespace App\Addons\Support\Models;

use App\Addons\Support\Models\Ticket_category;
use App\Addons\Support\Models\Ticket_priority;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public $table       = 'tickets';
    protected $fillable = [
        'id',
        'subject',
        'code',
        'client_id',
        'staff_id',
        'status',
        'priority_id',
        'category_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function category()
    {
        return $this->belongsTo(Ticket_category::class, 'category_id');
    }
    public function priority()
    {
        return $this->belongsTo(Ticket_priority::class, 'priority_id');
    }
}
