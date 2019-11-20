@extends('masters.tenant.app')

<!-- Page Title -->
@section('title')Dashboard @stop

<!-- Head Styles -->
@section('styles')
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@stop

<!-- Page Header -->
@section('header')Dashboard @stop

<!-- Page Description -->
@section('desc')BIma Alert Dashboard @stop

<!-- Active Link -->
@section('active')Dashboard @stop

<!-- Page Content -->
@section('content')
    <!-- Small boxes Section -->
    <div class="row">
        <div class="col-lg-6 col-xs-12">
        <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $total_policies }} Policies</h3>
                    <p>Policy Management</p>
                </div>
                <div class="icon">
                    <i class="ion ion-umbrella"></i>
                </div>
                <a href="{{ url('/policies') }}" class="small-box-footer">Manage Policies <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-6 col-xs-12">
        <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $expiring_today }} Policies</h3>
                    <p>Policy Expiring Today</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cube"></i>
                </div>
                <a href="{{ url('/policies') }}" class="small-box-footer">Manage Policies <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    
    <!-- Second row -->
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Policies Summary</h3>
                    <a href="{{ url('policies/create') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add Policies</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-square margin-r-5"></i>{{ $tenant->name }}</strong>
                    <a href="{{ url('policies') }}"><span class="label label-info pull-right">See Details</span></a>
                    <p class="text-muted"><b>Total Policies:</b> {{ $total_policies }} {{ str_plural('Policy', $total_policies) }}</p>
                    <p class="text-muted"><b>Expiring Today:</b> {{ $expiring_today }} {{ str_plural('Policy', $expiring_today) }}</p>
                    <p class="text-muted"><b>Total To Alert:</b> {{ $total_alerts }} {{ str_plural('Alert', $total_alerts) }}</p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->   
        </div><!-- end of left col -->

        <div class="col-lg-6 col-xs-12">
            <!-- Calendar -->
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>
                        <h3 class="box-title">Calendar</h3>                    
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <!--The calendar -->
                        <div id="calendar" style="width: 100%"></div>
                    </div><!-- /.box-body -->                
                </div><!-- /.box -->
        </div><!-- End of right col -->
    </div>
@stop

<!-- Page Scripts -->
@section('scripts')
    <!-- datepicker -->
    <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
    $(function () {
        //The Calender
        $('#calendar').datepicker({
            todayHighlight: true
        });
    });
</script>
@stop