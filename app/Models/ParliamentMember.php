<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParliamentMember extends Model
{
    use HasFactory;

    public function agendaItems()
    {
        return $this->belongsToMany(AgendaItem::class);
    }
}
