<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
      ];

    protected $primaryKey = 'id';
}
