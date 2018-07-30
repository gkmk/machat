<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'room_id',
        'from_id',
        'from_name',
        'is_public'
    ];

    /**
     * Casting 
     */
    protected $casts = [
        'created_at' => 'datetime:c',
    ];


    /**
     * Relationships
     */
    /**
     * Get the phone record associated with the user.
     */
    public function from()
    {
        return $this->hasOne('App\User', 'id', 'from_id');
    }
}
