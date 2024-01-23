<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    Protected $fillable = ['name','description','start_time','end_time','user_id'];

    //user can be an owner or user of an event
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //list of attendees
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
