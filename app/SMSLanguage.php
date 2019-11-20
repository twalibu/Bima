<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSLanguage extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 's_m_s_languages';
	
    /**
     * Get the Tenant.
     */
    public function tenants()
    {
        return $this->hasMany('App\TenantSMSLanguage', 'language_id');
    }
}
