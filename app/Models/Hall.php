<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rowCount',
        'seatsCount',
        'priceStandart',
        'priceVip',
        'active',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
