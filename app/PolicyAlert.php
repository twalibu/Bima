<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicyAlert extends Model
{
   	/**
     * Get the Tenant.
     */
    public function policy()
    {
        return $this->belongsTo('App\Policy');
    }
}
