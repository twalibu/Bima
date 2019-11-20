<?php

namespace App\Http\Controllers;

use Alert;
use Redirect;

use App\SMSLanguage;
use Illuminate\Http\Request;
use App\Http\Requests\SMSLanguageRequestForm as SMSLanguageRequestForm;
use App\Http\Requests\SMSLanguageRequestEditForm as SMSLanguageRequestEditForm;

class LanguageController extends Controller
{
    public function __construct()
    {
        // Middleware
        $this->middleware('sentry.auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = SMSLanguage::all();

        return view('settings.admin.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.admin.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SMSLanguageRequestForm $request)
    {
        $language = new SMSLanguage;

        $language->language           = $request->name;
        
        $language->save();

        Alert::success('New SMS Language Registered!');

        return Redirect::to('admin/languages');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = SMSLanguage::findorfail($id);

        return view('settings.admin.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SMSLanguageRequestEditForm $request, $id)
    {
        $language = SMSLanguage::findorfail($id);

        $language->language           = $request->name;

        $language->save();

        Alert::success('SMS Language Edited Successfully!');

        return Redirect::to('admin/languages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = SMSLanguage::findorfail($id);

        if ($language->tenants->count() > 0) {
            Alert::error('SMS Language has Tenants Already, Please remove the Tenants First', 'Error')->persistent('Close');

            return back();
        }

        $language->delete();

        Alert::success('SMS Language Removed Successfully!');

        return Redirect::to('admin/languages');
    }
}
