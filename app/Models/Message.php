<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Message extends Model
{
    use HasFactory;
    /*

    if there is no user_id as a forgein id i should write the forgien key in my table
    and in this cas is user_id_from

    /* the relationship is belongsto so the message belongs to one user

    */
    public function userFrom(){
      return $this->belongsTo('app\Models\User','user_id_from');
    }

    public function userTo(){
      return $this->belongsTo('app\Models\User','user_id_to');
    }


    public function scopeNotDeleted($query){
    return $query->where('deleted',false);

    }

    public function scopeDeleted($query){
        return $query->where('deleted',true);

        }

}
