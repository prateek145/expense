<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = "travels";

    public function invoices(){
        return $this->hasMany(ExpenseAmount::class,'ei_id','id')->where('ei_info','travel');
    }
}
