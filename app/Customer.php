<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'country_id','city_id','lang_skills','date_of_birth','resume'];
}
