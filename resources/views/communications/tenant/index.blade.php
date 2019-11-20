@extends('masters.tenant.app')

<!-- Page Title -->
@section('title')Communications @stop

<!-- Head Styles -->
@section('styles')
	<!-- Select2 -->
  	<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
@stop

<!-- Page Header -->
@section('header')Communications @stop

<!-- Page Description -->
@section('desc')Communications Portal @stop

<!-- Active Link -->
@section('active')Communications @stop

<!-- Page Content -->
@section('content')
<div class="row">
   	<div class="col-xs-12">
		@if (count($errors) > 0)
	        <div class="alert alert-danger">
	            <p><strong>Whoops!</strong> There were some problems with your input.</p>
	            <ul>
	                @foreach ($errors->all() as $error)
	                    <li>{{ $error }}</li>
	                @endforeach
	            </ul>
	        </div>
	    @endif

		<div class="row">
			<div class="col-lg-6 col-xs-12">
	        	<!-- small box -->
	            <div class="small-box bg-red">
	                <div class="inner">
	                    <h3>{{ number_format($bill->sms_count) }} SMS</h3>
	                    <p>SMS sent in <b>{{ $current_month }}</b></p>
	                </div>
	                <div class="icon">
	                    <i class="ion ion-social-usd"></i>
	                </div>
	                <a href="{{ url('communications') }}" class="small-box-footer">Communication Center <i class="fa fa-arrow-circle-right"></i></a>
	            </div>
	        </div>

	        <div class="col-lg-6 col-xs-12">        
	            <div class="small-box bg-orange">
	                <div class="inner">
	                    <h3>{{ $bill->tenant->sms->currency }} {{ number_format($bill->amount,2) }}/-</h3>
	                    <p>SMS sent in <b>{{ $current_month }}</b></p>
	                </div>
	                <div class="icon">
	                    <i class="ion ion-social-usd"></i>
	                </div>
	                <a href="{{ url('communications') }}" class="small-box-footer">Communication Centers <i class="fa fa-arrow-circle-right"></i></a>
	            </div>        
	        </div><!-- end of left col -->		
		</div>

		<div class="box">
			<div class="box-header">
                <h3 class="box-title">Communication Portal <small>Select from the Tabs Below</small></h3> 
            </div>
			<div class="box-body">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		                <li class="active"><a href="#clients" data-toggle="tab">Client Portal</a></li>
		            </ul>
		            <div class="tab-content">
		                <div class="tab-pane active" id="clients">
		                	<div class="row">
								<div class="col-md-3">
									<div class="box box-warning">
										<div class="box-header with-border">
									  		<h3 class="box-title">SMS Details</h3>
										</div>
										<div class="box-body no-padding">
									  		<ul class="nav nav-pills nav-stacked" id="sms-counter">
									    		<li><a href="#"><i class="fa fa-commenting"></i> SMS Length <span class="label label-warning pull-right length"></span></a></li>
									    		<li><a href="#"><i class="fa fa-sort-amount-desc"></i> Messages <span class="label label-warning pull-right messages"></span></a></li>
									    		<li><a href="#"><i class="fa fa-sliders"></i> Per Message <span class="label label-warning pull-right per_message"></span></a></li>
									    		<li><a href="#"><i class="fa fa-spinner"></i> Remaining Characters <span class="label label-warning pull-right remaining"></span></a></li>
									  		</ul>
										</div><!-- /.box-body -->
									</div><!-- /. box -->
								</div><!-- /.col -->
								<!-- Right Col -->
								<div class="col-md-9">
									<div class="box box-warning">
										<div class="box-header with-border">
									  		<h3 class="box-title">Composer SMS to {{ $bill->tenant->name }} Clients</h3>
										</div><!-- /.box-header -->
										<form action="{{ url('sendClients') }}" method="POST" accept-charset="UTF-8">
							                <input name="_token" value="{{ csrf_token() }}" type="hidden">
											<div class="box-body">
										  		<div class="form-group">
										    		<select name="clients[]" class="form-control clients" multiple="multiple" data-placeholder="Select Client(s)">
										    			@if($policies->count() > 0)
										    				<option value="all">Select All</option>
										    			@endif
										    			@foreach($policies as $policy)
								                  			<option value="{{ $policy->phone_number }}">{{ $policy->client_name }}</option>
								                  		@endforeach
										    		</select>
										  		</div>
										  		<div class="form-group">
										    		<input class="form-control" value="Sender: {{ $bill->tenant->sms->sender_name }}" disabled="true">
										  		</div>
										  		<div class="form-group">
										    		<textarea name="message" id="message" class="form-control" placeholder="Enter Message Here..." style="height: 200px"></textarea>
										  		</div>		  		
											</div><!-- /.box-body -->
											<div class="box-footer">
										  		<div class="pull-right">
										    		<button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
										  		</div>
											</div><!-- /.box-footer -->
										</form>
									</div><!-- /. box -->
								</div><!-- /.col -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

<!-- Page Scripts -->
@section('scripts')
	<!-- Select2 -->
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.clients').select2();

            // SMS Counter
        	$('#message').countSms('#sms-counter');
        })
    </script>
	<script src="{{ asset('bower_components/sms-counter/sms_counter.min.js') }}"></script>
@stop