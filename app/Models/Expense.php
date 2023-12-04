<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function meals(){
        return $this->hasMany(Meal::class,'expense_id','id');
    }

    public function travels(){
        return $this->hasMany(Travel::class,'expense_id','id');
    }
    
    public function hotels(){
        return $this->hasMany(Hotel::class,'expense_id','id');
    }

    public function das(){
        return $this->hasMany(ExpenseDa::class,'expense_id','id');
    }

    public function others(){
        return $this->hasMany(OtherExpense::class,'expense_id','id');
    }
}
