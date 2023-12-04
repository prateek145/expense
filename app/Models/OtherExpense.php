<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherExpense extends Model
{
       protected $table = "other_expenses";

       public function invoices(){
              return $this->hasMany(ExpenseAmount::class,'ei_id','id')->where('ei_info','other');
       }
}
