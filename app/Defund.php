<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defund extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fund_type()
    {
        if ($this->type == "Invested")
        {
            return "Invested";
        }
        elseif ($this->type == "Balance"){
            return "Balance";
        }
        elseif ($this->type == "Profit"){
            return "Balance";
        }
        elseif ($this->type == "Bonus"){
            return "Bonus";
        }
        return 'null';
    }

    public function status()
    {
        if ($this->status == 0){
            return "<span class='badge bg-danger text text-uppercase'>Pending</span>";
        }elseif ($this->status == 1){
            return "<span class='badge bg-success text text-uppercase'>Successful</span>";
        }else{
            return "<span class='badge bg-warning text text-uppercase'>Canceled</span>";
        }
    }

}
