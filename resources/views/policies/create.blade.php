@extends('masters.tenant.app')

<!-- Page Title -->
@section('title')Policies @stop

<!-- Head Styles -->
@section('styles')
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- Material Wizard CSS Files -->
    <link href="{{ asset('bower_components/material_bootstrap_wizard/assets/css/material-bootstrap-wizard.css') }}" rel="stylesheet" />
@stop

<!-- Page Header -->
@section('header')Add Policy @stop

<!-- Page Description -->
@section('desc')Create New Policy @stop

<!-- Active Link -->
@section('active')Policies @stop

<!-- Page Content -->
@section('content')
<div class="row">
	<div class="col-md-12"> 
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
        <!--      Wizard container        -->   
        <div class="wizard-container">
            <div class="card wizard-card" data-color="blue" id="wizard">
                <form action="{{ route('policies.store') }}" method="POST" accept-charset="UTF-8">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    
                    <div class="wizard-header">
                        <h3 class="wizard-title">
                            New Policy Registration
                        </h3>
                        <h5>Please fill the information accurately.</h5>
                    </div>

                    <div class="wizard-navigation">
                        <ul>
                            <li><a href="#details" data-toggle="tab">Details</a></li>
                        </ul>
                    </div>
                    
                    <div class="tab-content">
                        <!-- Details -->
                        <div class="tab-pane" id="details">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="info-text"> Let's start with the basic details.</h4>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">vpn_key</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Policy Number</label>
                                            <input name="policy_number" value="{{ old('policy_number') }}" type="text" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Client Name</label>
                                            <input name="client_name" value="{{ old('client_name') }}" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">contact_phone</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Phone Number</label>
                                            <input name="phone_number" value="{{ old('phone_number') }}" type="number" class="form-control">
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Renewal Date</label>
                                            <input name="renewal_date" value="{{ old('renewal_date') }}" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                     
                    </div>

                    <div class="wizard-footer">
                        <div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Next' />
                            <input type='submit' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' value='Finish' />
                        </div>
                        <div class="pull-left">
                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div> <!-- wizard container --> 
    </div>        
</div>
@stop

<!-- Page Scripts -->
@section('scripts')
    <!--   Material Wizard JS Files   -->
    <script src="{{ asset('bower_components/material_bootstrap_wizard/assets/js/jquery.bootstrap.js') }}" type="text/javascript"></script>
    <!--  Plugin for the Wizard -->
    <script src="{{ asset('bower_components/material_bootstrap_wizard/assets/js/material-bootstrap-wizard.js') }}"></script>
@stop