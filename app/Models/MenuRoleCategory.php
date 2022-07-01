<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRoleCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'menu_id' => 'string'
      ];
}
