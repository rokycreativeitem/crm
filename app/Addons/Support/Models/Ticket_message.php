<?php

namespace App\Addons\Support\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket_message extends Model
{
    use HasFactory;
    public $table       = 'ticket_messages';
    protected $fillable = [
        'id',
        'ticket_thread_code',
        'message',
        'sender_id',
        'receiver_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        $user = $this->belongsTo(User::class, 'sender_id', 'id');

        if ($user->value('id') != Auth::user()->id) {
            return $user;
        } else {
            return $this->belongsTo(User::class, 'receiver_id', 'id');
        }
    }
    // public function user()
    // {
    //     $user = $this->belongsTo(User::class, 'sender_id', 'id')->first();

    //     if ($user && $user->id != Auth::user()->id) {
    //         return $user;
    //     }

    //     return $this->belongsTo(User::class, 'receiver_id', 'id')->first();
    // }

}
