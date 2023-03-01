<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Datos extends Model
{
    use HasFactory;    

    private $name;
    private $birthdate;
    private $valid;
    private $address;
    private $size;
    private $country;
    private $created;
    private $edited;
    private $balance;
    private $phone;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
