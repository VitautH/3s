@extends('layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="portlet portlet-boxed">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading ">
                                        <h4 class="portlet-title no-border">My projects</h4>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table class="table-striped table project_table">
                                            <thead class="thead-default">
                                            <tr>
                                                <th>Project</th>
                                                <th>Project Owner</th>
                                                <th>Hourly rate</th>
                                                <th>Workload</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @for($i=0; $i < count($projects); $i++)
                                                <tr>
                                                    <td>{{$projects[$i]->name}}</td>
                                                    <td>{{$projects[$i]->project_ownersFirstName.' '.$projects[$i]->project_ownersLastName}}</td>
                                                    <td>
                                                        <i class="fa fa-usd project_rate"></i>{{$projects[$i]->rate}}
                                                    </td>
                                                    <td>{{$projects[$i]->project_positionsWorkload}}</td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div> <!-- /.portlet-body -->
                </div> <!-- /.portlet -->
            </div> <!-- /.container -->
        </div> <!-- .content -->
    </div> <!-- /.content-page -->
@endsection