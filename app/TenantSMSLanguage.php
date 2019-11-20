<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenantSMSLanguage extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tenant_s_m_s_languages';
	
    /**
     * Get the Language.
     */
    public function language()
    {
        return $this->belongsTo('App\SMSLanguage', 'language_id');
    }

    /**
     * Get the Tenant.
     */
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
}
