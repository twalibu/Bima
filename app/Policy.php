<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    /**
     * Get the Policy Alert.
     */
    public function alert()
    {
        return $this->hasOne('App\PolicyAlert');
    }

    /**
     * Get the Tenant.
     */
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
}
