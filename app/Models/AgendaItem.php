<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{
    use HasFactory;

    public function parliamentMembers()
    {
        return $this->belongsToMany(ParliamentMember::class, 'agenda_item_parliament_members');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'agenda_item_users');
    }
}
