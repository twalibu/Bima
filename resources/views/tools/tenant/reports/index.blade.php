@extends('masters.tenant.app')

<!-- Page Title -->
@section('title')SMS Reports @stop

<!-- Head Styles -->
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@stop

<!-- Page Header -->
@section('header')SMS Reports @stop

<!-- Page Description -->
@section('desc')Tenant SMS Reports @stop

<!-- Active Link -->
@section('active')SMS Reports @stop

<!-- Page Content -->
@section('content')
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ number_format($bill->sms_count) }} SMS Sent</h3>
                <p>SMS Sent in <b>{{ $current_month }}</b> | Charges are <b>{{ $bill->tenant->sms->currency }} {{ number_format(($bill->sms_count * $bill->tenant->sms->price)) }}/-</b> </p>
                <p>{{ Sentinel::getUser()->tenant->name }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-paper-airplane"></i>
            </div>
            <a href="{{ url('communications') }}" class="small-box-footer">Send Messages To Clients <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- End of left col -->

     <div class="col-lg-6 col-xs-12">
        <!-- General Loan Report -->
        <form action="{{ url('report/generate') }}" method="POST" accept-charset="UTF-8">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-clone"></i>
                    <h3 class="box-title">SMS Reports</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <i class="fa fa-bolt"></i> SMS Report in Details
                    </div><!-- /. tools -->
                </div>
                <div class="box-body">                    
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input type="hidden" name="report_start" id="report_start" value="">
                    <input type="hidden" name="report_end" id="report_end" value="">
                    <div class="form-group">
                        <div class="input-group">
                            <button type="button" class="btn btn-default pull-right" name="daterange" id="daterange">
                                <span>
                                    <i class="fa fa-calendar"></i> Please Select Start and End Dates
                                </span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                        </div>
                    </div>                   
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-default" type="submit">Generate Report <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </form>
    </div><!-- end of right col -->
</div>

<div class="row">
    <div class="col-xs-12">
		<div class="box">
            <div class="box-header">
                <h3 class="box-title">List of SMS Reports</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="xa" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SMS Details</th>
                            <th>SMS Preview</th>
                        </tr>
                    </thead>
                    <tbody>                
                        @foreach ($reports as $report)
                            <tr>
                                <td>
                                    <b>Date:</b> {{ Carbon::parse($report->date)->toFormattedDateString() }}<br>
                                    <b>Phone Number:</b> +{{ $report->phone_number }}<br>
                                    <b>SMS Count:</b> {{ $report->sms_count }} SMS
                                </td>
                                <td>{{ $report->text }}</td>
                            </tr>                
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SMS Details</th>
                            <th>SMS Preview</th>
                        </tr>
                    </tfoot>
                </table>
                {{  $reports->links() }}
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@stop

<!-- Page Scripts -->
@section('scripts')
    <!-- daterangepicker -->
    <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('#xa').DataTable({
                "paging": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "columnDefs": [
                    { "width": 200, targets: 0 }
                ],
                "fixedColumns": true
            });

             //Date range as a button
            $('#daterange').daterangepicker(
                {
                    ranges: {
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()]                    
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#report_start').val(start.format('YYYY-MM-DD'));
                    $('#report_end').val(end.format('YYYY-MM-DD'));
                }
            );
        });
    </script>
@stop