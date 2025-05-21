<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    //

    protected $fillable = ['title', 'description', 'points', 'start_date', 'end_date','category_id'];
    

    //   *********************************************  Erlazioak ***********************************************

    public function users(){
        return $this->belongsToMany(User::class);
    }

    




}
