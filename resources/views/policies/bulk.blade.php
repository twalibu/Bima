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

    <!-- File Upload -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/file/css/component.css') }}" />
    <style type="text/css">  
        .center-block {  
            width:350px;  
            padding:50px;  
            background-color:#eceadc;  
            color:#ec8007  
        }
    </style>
@stop

<!-- Page Header -->
@section('header')Bulk Policies @stop

<!-- Page Description -->
@section('desc')Create New Policies @stop

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
                <form action="{{ route('post.policy.add') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    
                    <div class="wizard-header">
                        <h3 class="wizard-title">
                            Bulk Policies Registration
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
                                <div class="col-sm-12">
                                    <div class="center-block">
                                        <input type="file" name="file" id="file-5" accept=".csv,.xls,.xlsx" class="inputfile inputfile-5" />
                                        <label for="file-5"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span></span></label>
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
    <!-- File Upload -->
    <script src="{{ asset('bower_components/file/js/custom-file-input.js') }}"></script>

    <script>
        (function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);
    </script>
@stop