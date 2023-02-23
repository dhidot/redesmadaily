<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    const MANAGER_POSITION_ID = 2;
    const INTERNSHIP_POSITION_ID = 4;
    use HasFactory;

    protected $fillable = ['name'];
}
