@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <h2 class="title-page">All current Projects</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    <div class="block table-projects table-responsive">
                        <table class="table table-striped table-striped">
                            <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Project Owner</th>
                                <th>Project Workload</th>
                                <th>Project Rate</th>
                                <th>Employee</th>
                                <th>Employee Workload</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project['projectName'] }}</td>
                                    <td>
                                        {{$project['ownerName']}}
                                    </td>
                                    <td>{{ $project['projectWorkload'] }} Hrs</td>
                                    <td>$ {{ $project['projectRate'] }}  </td>
                                    <td>
                                        @foreach ($project['employees'] as $i=>$employee)
                                            <a href="/admin/user/{{$employee['id']}}"> {{$employee['employee_full_name']}}</a>
                                            @if($i < count($project['employees'])-1)
                                                <hr>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($project['employees'] as $i=>$workload)
                                            {{$workload['workload']}}
                                            @if($i < count($project['employees'])-1)
                                                <hr>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /.container -->
    </div> <!-- .content -->
    </div> <!-- /.content-page -->
@endsection





