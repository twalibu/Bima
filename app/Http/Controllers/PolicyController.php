<?php

namespace App\Http\Controllers;

use Excel;
use Alert;
use Carbon;
use Redirect;
use Sentinel;

use App\Policy;
use App\PolicyAlert;
use Illuminate\Http\Request;
use App\Http\Requests\PolicyFormRequest as PolicyFormRequest;
use App\Http\Requests\BulkPoliciesRequest as BulkPoliciesRequest;
use App\Http\Requests\PolicyEditFormRequest as PolicyEditFormRequest;

class PolicyController extends Controller
{
    public function __construct()
    {
        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:policies.create', ['only' => ['create', 'store', 'addBulk', 'postBulk']]);
        $this->middleware('sentinel.access:policies.view', ['only' => ['index']]);
        $this->middleware('sentinel.access:policies.update', ['only' => ['edit', 'update']]);
        $this->middleware('sentinel.access:policies.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieving Tenant Details
        $tenant = Sentinel::getUser()->tenant->id;

        $policies = Policy::where('tenant_id', $tenant)->get();

        return view('policies.index', compact('policies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('policies/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBulk()
    {
        return view('policies/bulk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postBulk(BulkPoliciesRequest $request)
    {
        // Retrieving Tenant Details
        $tenant = Sentinel::getUser()->tenant->id;

        // Import A User Provided File
        $imported = $request->file('file');

        Excel::load($imported, function($reader) use($tenant) {

            // Getting All Policies from File
            $dbseeder = $reader->select(array('client_name', 'policy_number', 'renewal_date', 'phone_number'))->get();

            foreach ($dbseeder as $entry) {
                $policy = new Policy;

                $expiration_date = Carbon::parse($entry->renewal_date);

                $policy->client_name            = $entry->client_name;
                $policy->policy_number          = $entry->policy_number;
                $policy->expiration_date        = $expiration_date;
                $policy->phone_number           = str_replace(' ', '', $entry->phone_number);
                $policy->tenant_id              = $tenant;

                $policy->save();

                $alert_one = Carbon::parse($policy->expiration_date)->subDays(7);
                $alert_two = Carbon::parse($policy->expiration_date)->subDays(3);

                $alert = new PolicyAlert;

                $alert->alert_one           = $alert_one;
                $alert->alert_two           = $alert_two;
                $alert->policy_id           = $policy->id;

                $alert->save();
            }
        });

        Alert::success('Bulk Policies Registered!');

        return Redirect::to('policies');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyFormRequest $request)
    {
        // Retrieving Tenant Details
        $tenant = Sentinel::getUser()->tenant->id;

        $policy = new Policy;

        $policy->client_name            = $request->client_name;
        $policy->policy_number          = $request->policy_number;
        $policy->expiration_date        = $request->renewal_date;
        $policy->phone_number           = $request->phone_number;
        $policy->tenant_id              = $tenant;

        $policy->save();

        $alert_one = Carbon::parse($policy->expiration_date)->subDays(7);
        $alert_two = Carbon::parse($policy->expiration_date)->subDays(3);

        $alert = new PolicyAlert;

        $alert->alert_one           = $alert_one;
        $alert->alert_two           = $alert_two;
        $alert->policy_id           = $policy->id;

        $alert->save();

        Alert::success('New Policy Registered!');

        return Redirect::to('policies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $policy = Policy::findorfail($id);

        return view('policies.edit', compact('policy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $policy = Policy::findorfail($id);

        $policy->client_name            = $request->client_name;
        $policy->policy_number          = $request->policy_number;
        $policy->expiration_date        = $request->renewal_date;
        $policy->phone_number           = $request->phone_number;

        $policy->save();

        $alert_one = Carbon::parse($policy->expiration_date)->subDays(7);
        $alert_two = Carbon::parse($policy->expiration_date)->subDays(3);

        $alert = PolicyAlert::where('policy_id', $policy->id)->first();

        $alert->alert_one           = $alert_one;
        $alert->alert_two           = $alert_two;

        $alert->save();

        Alert::success('Policy Edited Successfully!');

        return Redirect::to('policies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $policy  = Policy::findorfail($id);

        $policy->alert->delete();
        
        $policy->delete();

        Alert::success('Policy Removed Successfully!');

        return Redirect::to('policies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeBulk()
    {
        return view('policies/remove');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeAll(BulkPoliciesRequest $request)
    {
        // Import A User Provided File
        $file = request()->file('file');

        // Retrieving Tenant Details
        $tenant = $request->tenant;

        Excel::load($file, function($reader) use($tenant) {

            // Getting All Policies
            $dbseeder = $reader->select(array('policy_number', 'mobile', 'client_name', 'renewal_date'))->get();

            foreach ($dbseeder as $entry) {
                $policy = Policy::where('policy_number', $entry->policy_number)->first();
                $alert = PolicyAlert::findorfail($policy->id);

                $alert->delete();
                $policy->delete();
            }
        });

        Alert::success('Bulk Policies Removed!');

        return Redirect::to('policies');
    }
}
