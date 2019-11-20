@extends('masters.tenant.app')

<!-- Page Title -->
@section('title')Policies @stop

<!-- Head Styles -->
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@stop

<!-- Page Header -->
@section('header')Policies @stop

<!-- Page Description -->
@section('desc')Policies Dashboard @stop

<!-- Active Link -->
@section('active')Policies @stop

<!-- Page Content -->
@section('content')
<div class="row">
    <div class="col-xs-12">
		<div class="box">
            <div class="box-header">
                <h3 class="box-title">List of All Policies</h3>              
                <div class="btn-group pull-right row">
                    <div class="col-md-4">
                        <a href="{{ url('policy/addBulk') }} " class="btn btn-success btn-sm">Add Bulk Policies</a>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <a href="{{ url('policies/create') }} " class="btn btn-primary btn-sm">Add One Policy</a>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="xa" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Client Details</th>
                            <th>Policy Details</th>
                            <th>Reminders</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>                
                        @foreach ($policies as $policy)
                        <tr>
                            <td>
                                Full Name: <b>{{ $policy->client_name }}</b><br>
                                Phone Number: <b>+{{ $policy->phone_number }}</b>
                            </td>
                            <td>
                                Policy Number: <b>{{ $policy->policy_number }}</b><br>
                                Renewal Date: <b>{{ Carbon::parse($policy->expiration_date)->toFormattedDateString() }}</b>
                            </td>
                            <td>
                                Reminder One: <b>{{ Carbon::parse($policy->alert->alert_one)->toFormattedDateString() }}</b><br>
                                Reminder Two: <b>{{ Carbon::parse($policy->alert->alert_two)->toFormattedDateString() }}</b><br>
                                Final Reminder: <b>{{ Carbon::parse($policy->expiration_date)->toFormattedDateString() }}</b>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">Actions</button>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('policies.edit', array($policy->id)) }}">Edit Details</a></li>
                                        <li class="divider"></li>
                                        <li>
                                            <form id="deleteform" action="{{ route('policies.destroy', array($policy->id)) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button id="delete" class="btn btn-danger btn-block">Remove Policy</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td> 
                        </tr>                
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Client Details</th>
                            <th>Policy Details</th>
                            <th>Reminders</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@stop

<!-- Page Scripts -->
@section('scripts')
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('#xa').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                "columnDefs": [
                    { "width": 200, targets: 0 }
                ],
                "fixedColumns": true
            });

            $('#deleteform').on('click', function(e){
                e.preventDefault();
                var $this = $(this);
                swal({
                  title: "Are you sure Remove Policy",
                  text: "You will not be able to recover the Policy!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Remove Policy!',
                  cancelButtonText: 'No, Cancel Please!',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
                  }).then(function () {
                        $("#deleteform").submit();
                        return true;
                    }, function (dismiss) {
                      // dismiss can be 'cancel', 'overlay',
                      // 'close', and 'timer'
                      if (dismiss === 'cancel') {
                        swal("Cancelled", "Policy Not Removed :)", "error");
                        e.preventDefault();
                      }
                    })
            });
        });
    </script>
@stop