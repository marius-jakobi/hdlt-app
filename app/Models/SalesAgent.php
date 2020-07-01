<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesAgent extends Model
{
    protected $fillable = ['id', 'name_first', 'name_last'];

    public function customer() {
        return $this->belongsToMany('App\Models\Customer', 'sales_agent_id', 'id');
    }
}
