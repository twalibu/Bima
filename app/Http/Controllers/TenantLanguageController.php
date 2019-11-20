<?php

namespace App\Http\Controllers;

use Alert;
use Redirect;
use Sentinel;

use App\SMSLanguage;
use App\TenantSMSLanguage;
use Illuminate\Http\Request;
use App\Http\Requests\TenantSMSLanguageRequestForm as TenantSMSLanguageRequestForm;

class TenantLanguageController extends Controller
{
    public function __construct()
    {
        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:settings.access');
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

        $languages = TenantSMSLanguage::where('tenant_id', $tenant)->get();

        return view('settings.tenant.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = SMSLanguage::all();

        return view('settings.tenant.languages.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenantSMSLanguageRequestForm $request)
    {
        // Retrieving Tenant Details
        $tenant = Sentinel::getUser()->tenant->id;

        $language = new TenantSMSLanguage;

        $language->language_id        = $request->language;
        $language->tenant_id          = $tenant;
        
        $language->save();

        Alert::success('New SMS Language Registered!');

        return Redirect::to('TenantLanguages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = TenantSMSLanguage::findorfail($id);

        $language->delete();

        Alert::success('SMS Language Removed Successfully!');

        return Redirect::to('TenantLanguages');
    }
}
