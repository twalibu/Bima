<?php

namespace App\Http\Controllers;

use Excel;
use Carbon;
use Sentinel;
use App\SMSReport;
use App\TenantBill;
use Illuminate\Http\Request;
use App\Http\Requests\ReportGenerateRequest as ReportGenerateRequest;

class ReportController extends Controller
{
    public function __construct()
    {
        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:reports.access');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieving Tenant Details
        $date = Carbon::now();
        $current_month = $date->format('F');
        $tenant = Sentinel::getUser()->tenant->id;

        $bill = TenantBill::where([
                                ['tenant_id', $tenant],
                                ['year', $date->year],
                                ['month', $date->month]
                            ])->first();

        if (!$bill) {
            $bill = new TenantBill;

            $bill->sms_count = 0;
            $bill->amount = 0;
            $bill->month = $date->month;
            $bill->year = $date->year;
            $bill->tenant_id = $tenant;

            $bill->save();
        }

        $reports = SMSReport::where('tenant_id', $tenant)->orderBy('created_at', 'DESC')->paginate(50);

        return view('tools.tenant.reports.index', compact('reports', 'bill', 'current_month'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(ReportGenerateRequest $request)
    {
        $reports = SMSReport::where('tenant_id', Sentinel::getUser()->tenant->id)
                            ->whereBetween('date', [$request->report_start, $request->report_end])
                            ->select('date', 'phone_number', 'text', 'sms_count')
                            ->get();

        $reports = $reports->toArray();
        
        $time = Carbon::now()->toDateString();
        $name = 'SMS Report | '.$time;
        $tenant = Sentinel::getUser()->tenant->name;
   
        Excel::create($name, function($excel) use($reports, $name) {
            $excel->sheet($name, function($sheet) use($reports) {
                $sheet->fromModel($reports);
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(14);
                });
            });
        })->download('xlsx');

        Alert::sucess('Report Generated Successfully');
        return back();
    }
}
