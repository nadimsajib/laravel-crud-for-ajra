<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'country_id','city_id','lang_skills','date_of_birth','resume'];
    public function cities()
    {
        return $this->hasMany('App\City', 'id', 'city_id');
    }
    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }
    public function city()
    {
        return $this->hasOne('App\City', 'id', 'city_id');
    }
}
