@extends('masters.tenant.app')

<!-- Page Title -->
@section('title')Roles @stop

<!-- Head Styles -->
@section('styles')
<!-- Creative Tim -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
<link rel="stylesheet" href="{{ asset('bower_components/material_bootstrap_wizard/assets/css/material-bootstrap-wizard.css') }}">
@stop

<!-- Page Header -->
@section('header')Edit Role @stop

<!-- Page Description -->
@section('desc')Edit Role Details @stop

<!-- Active Link -->
@section('active')Roles @stop

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
                <form action="{{ route('roles.update', $role->id) }}" method="POST" accept-charset="UTF-8">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input name="_method" value="PUT" type="hidden">
                    
                    <div class="wizard-header">
                        <h3 class="wizard-title">
                            Edit Role Details
                        </h3>
                        <h5>Please fill the information accurately.</h5>
                    </div>

                    <div class="wizard-navigation">
                        <ul>
                            <li><a href="#admin" data-toggle="tab">Details</a></li>
                        </ul>
                    </div>
                    
                    <div class="tab-content">
                        <!-- Admin -->
                        <div class="tab-pane" id="admin">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="info-text"> Role Details</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person_pin</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Role Name</label>
                                            <input name="name" value="{{ $role->name }}" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person_pin_circle</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Slug</label>
                                            <input name="slug" value="{{ $role->slug }}" type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <br><strong>Please Role Permissions Below</strong>

                                        <br><u>Users Permissions</u>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[users.create]" value="1" {{ $role->hasAccess('users.create') ? 'checked' : '' }}>
                                                users.create
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[users.update]" value="1" {{ $role->hasAccess('users.update') ? 'checked' : '' }}>
                                                users.update
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[users.view]" value="1" {{ $role->hasAccess('users.view') ? 'checked' : '' }}>
                                                users.view
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[users.destroy]" value="1" {{ $role->hasAccess('users.destroy') ? 'checked' : '' }}>
                                                users.destroy
                                            </label>
                                        </div>

                                        <br><u>Roles Permissions</u>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[roles.create]" value="1" {{ $role->hasAccess('roles.create') ? 'checked' : '' }}>
                                                roles.create
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[roles.update]" value="1" {{ $role->hasAccess('roles.update') ? 'checked' : '' }}>
                                                roles.update
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[roles.view]" value="1" {{ $role->hasAccess('roles.view') ? 'checked' : '' }}>
                                                roles.view
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[roles.destroy]" value="1" {{ $role->hasAccess('roles.destroy') ? 'checked' : '' }}>
                                                roles.destroy
                                            </label>
                                        </div>

                                        <br><u>Policies Permissions</u>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[policies.create]" value="1" {{ $role->hasAccess('policies.create') ? 'checked' : '' }}>
                                                policies.create
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[policies.update]" value="1" {{ $role->hasAccess('policies.update') ? 'checked' : '' }}>
                                                policies.update
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[policies.view]" value="1" {{ $role->hasAccess('policies.view') ? 'checked' : '' }}>
                                                policies.view
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[policies.destroy]" value="1" {{ $role->hasAccess('policies.destroy') ? 'checked' : '' }}>
                                                policies.destroy
                                            </label>
                                        </div>

                                        <br><u>Reports Permissions</u>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[reports.access]" value="1" {{ $role->hasAccess('reports.access') ? 'checked' : '' }}>
                                                reports.access
                                            </label>
                                        </div>

                                        <br><u>Communications Permissions</u>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[communications.access]" value="1" {{ $role->hasAccess('communications.access') ? 'checked' : '' }}>
                                                communications.access
                                            </label>
                                        </div>

                                        <br><u>System Settings Permissions</u>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[settings.access]" value="1" {{ $role->hasAccess('settings.access') ? 'checked' : '' }}>
                                                settings.access
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                  
                    </div>

                    <div class="wizard-footer">
                        <div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Next' />
                            <input type='submit' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' value='Update' />
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
<!-- Creative Tim -->
<script src="{{ asset('bower_components/material_bootstrap_wizard/assets/js/material-bootstrap-wizard.js') }}"></script>
<script src="{{ asset('bower_components/material_bootstrap_wizard/assets/js/jquery.bootstrap.js') }}" type="text/javascript"></script>
@stop