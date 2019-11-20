<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * Get Tenant Policies
     */
    public function policies()
    {
        return $this->hasMany('App\Policy');
    }

    /**
     * Get Tenant Groups
     */
    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    /**
     * Get Tenant SMS Languages
     */
    public function languages()
    {
        return $this->hasMany('App\TenantSMSLanguage');
    }

    /**
     * Get Tenant Sales Contacts
     */
    public function sales()
    {
        return $this->hasOne('App\TenantSale');
    }

    /**
     * Get Tenant Schedule
     */
    public function schedule()
    {
        return $this->hasOne('App\TenantSchedule');
    }

    /**
     * Get Tenant Subscription
     */
    public function subscription()
    {
        return $this->hasOne('App\TenantSubscription');
    }

    /**
     * Get Tenant Address
     */
    public function address()
    {
        return $this->hasOne('App\TenantAddress');
    }

    /**
     * Get Tenant SMS Details
     */
    public function sms()
    {
        return $this->hasOne('App\TenantSMS');
    }

    /**
     * Get Tenant SMS Reports
     */
    public function smsReports()
    {
        return $this->hasMany('App\SMSReport');
    }

    /**
     * Get Tenant SMS Bill
     */
    public function bills()
    {
        return $this->hasMany('App\TenantBill');
    }

    /**
     * Get Tenant Contact Persons
     */
    public function contacts()
    {
        return $this->hasMany('App\TenantContact');
    }

    /**
     * Get Tenant Users
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get Tenant Roles
     */
    public function roles()
    {
        return $this->hasMany('App\Role');
    }
}
