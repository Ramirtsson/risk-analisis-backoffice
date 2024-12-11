<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountNexen extends Model
{
    protected $connection = 'nexen_db';

    protected $table = 'Razon_Bancos';
}
