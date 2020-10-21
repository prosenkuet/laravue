<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ldcservice extends Model
{
    protected $fillable=['costcenter','servicetype','serialno','providername','contactperson','email','phone','lastrenew','nextrenew','amount','currency','remarks'];
}
