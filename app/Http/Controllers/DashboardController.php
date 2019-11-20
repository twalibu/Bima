<?php

namespace App\Http\Controllers;

use Carbon;
use Sentinel;
use App\Policy;
use App\Tenant;
use App\TenantSMS;
use Illuminate\Http\Request;
use infobip\api\client\GetAccountBalance;
use infobip\api\client\SendSingleTextualSms;
use infobip\api\configuration\BasicAuthConfiguration;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Tenant Middleware
        $this->middleware('sentinel.auth', ['only' => ['tenant']]);

        // Admin Middleware
        $this->middleware('sentry.auth', ['only' => ['admin']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $username =  env('INFOBIP_USERNAME');
        $password =  env('INFOBIP_PASSWORD');

        // Initializing GetAccountBalance client with appropriate configuration
        $client = new GetAccountBalance(new BasicAuthConfiguration($username, $password));
        // Executing request
        $response = $client->execute();

        $amount = $response->getBalance();
        $currency = $response->getCurrency();
        $tenants = Tenant::all()->count();
        $policies = Policy::all();

        return view('dashboards.admin', compact('amount', 'currency', 'tenants', 'policies'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tenant()
    {
        // Retrieving Tenant Details
        $today = Carbon::today()->toDateString();
        $tenant = Sentinel::getUser()->tenant;
        
        $total_alerts = 0;
        $expiring_today = 0;
        $total_policies = Policy::where('tenant_id', $tenant->id)->count();

        $all_policies = Policy::where('tenant_id', $tenant->id)->get();

        foreach ($all_policies as $policy) {
            if (Carbon::parse($policy->expiration_date)->toDateString() == $today) {
                $expiring_today += 1;
                $total_alerts += 1;
            }elseif (Carbon::parse($policy->alert->alert_one)->toDateString() == $today) {
                $total_alerts += 1;
            }elseif (Carbon::parse($policy->alert->alert_two)->toDateString() == $today) {
                $total_alerts += 1;
            }
        }


        return view('dashboards.tenant', compact('tenant', 'total_policies', 'expiring_today', 'total_alerts'));
    }   
}
