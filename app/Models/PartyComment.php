<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyComment extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function party() {
        return $this->belongsTo(Party::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
