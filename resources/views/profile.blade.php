@extends($layout)
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block col-md-10">
                            <div class="col-md-6">
                                <div class="profile-avatar">
                                    <i class="fa fa-pencil upload_photo" aria-hidden="true"></i>
                                    @if (Auth::user()['role'] == 'admin')
                                        <img src="{{$photoUrl}}"
                                             class="avatar_photo profile-avatar-img img-responsive thumbnail"
                                             alt="Profile Image">
                                    @else
                                        <img src="{{$photoUrl}}"
                                             class="avatar_photo profile-avatar-img img-responsive thumbnail"
                                             alt="Profile Image">
                                    @endif
                                    <form style="display: none" enctype="multipart/form-data">
                                        <input type="file" id="photo_uploader" name="avatar_photo">
                                        {{csrf_token()}}
                                    </form>
                                </div> <!-- /.profile-avatar -->
                            </div>
                            <div class="col-md-6">
                                <h3 class="employee-name">{{$employee_info[0]->first_name}} {{$employee_info[0]->last_name}} </h3>
                                <h6 class="text-muted">{{$employee_info[0]->title}}</h6>
                                <hr>
                                <ul class="list-group-profile">
                                    <li><i class="icon-li fa fa-map-marker"></i>
                                        <span>{{$employee_info[0]->address}}</span></li>
                                    <li><i class="icon-li fa fa-envelope"></i> <span>{{$employee_info[0]->email}}</span>
                                    </li>
                                    <li><i class="icon-li fa fa-skype"></i> <span>{{$employee_info[0]->skype}}</span>
                                    </li>
                                    <li><i class="icon-li fa fa-phone"></i>
                                        <span>{{$employee_info[0]->phone_number}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="block essential-block  col-md-10">
                            <span class="portlet-title">Essential </span>
                            <table class="essential-table table table-striped">
                                <tr>
                                    <td>
                                        Date of Birth
                                    </td>
                                    <td>
                                        {{fromDateView($employee_info[0]->date_of_birth, false)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Date of Hiring
                                    </td>
                                    <td>
                                        {{fromDateView($employee_info[0]->date_of_hiring, false)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        UID
                                    </td>
                                    <td>
                                        9
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Workload
                                    </td>
                                    <td>
                                        Full-time employee
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Department
                                    </td>
                                    <td>
                                        Development
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Resource Manager
                                    </td>
                                    <td>
                                        Petr Petrov
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Primary Skills
                                    </td>
                                    <td>
                                        java, PHP
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Languages
                                    </td>
                                    <td>
                                        English- Intermidiate
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="block vacations-balance col-md-10 col-sm-4">
                            <span class="portlet-title">Vacations Balance</span>
                            <table class="table table_vacantion_request table-striped">
                                <tr>
                                    <td>
                                        Vacations
                                    </td>
                                    <td>
                                        25
                                    </td>
                                    <td>
                                        <a href="#" class="vacantion_request_button btn btn-primary">Request Vac</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Unpaid Leave
                                    </td>
                                    <td>
                                        20
                                    </td>
                                    <td>
                                        <a href="#" class="vacantion_request_button btn btn-primary">Request Vac</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sickness
                                    </td>
                                    <td>
                                        15
                                    </td>
                                    <td>
                                        <a href="#" class="vacantion_request_button btn btn-primary">Request Vac</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="block planned-workload-block col-md-10 col-sm-5">
                            <span class="portlet-title">Planned Workload</span>
                            <table class="table-planned-workload table table-striped">
                                <thead>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        Jul
                                    </td>
                                    <td>
                                        Aug
                                    </td>
                                    <td>
                                        Sep
                                    </td>
                                    <td>
                                        Oct
                                    </td>
                                    <td>
                                        Nov
                                    </td>
                                    <td>
                                        Dec
                                        <br>
                                        <span class="year">2017</span>
                                    </td>
                                    <td>
                                        Jul
                                        <br>
                                        <span class="year">2018</span>
                                    </td>
                                    <td>
                                        Aug
                                    </td>
                                    <td>
                                        Sep
                                    </td>
                                    <td>
                                        Oct
                                    </td>
                                    <td>
                                        Nov
                                    </td>
                                    <td>
                                        Dec
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        AHA
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        0.8
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        0.5
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        0.8
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        0.5
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ACNE
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        0.8
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        0.8
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="total">In total</span>
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.0
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.00
                                    </td>
                                    <td>
                                        1.0
                                    </td>
                                </tr>

                                </tbody>

                            </table>
                        </div>
                        <div class="activity-feed col-md-10 col-sm-5">
                            <span class="portlet-title">Activity Feed</span>
                            <div class="feed-block block">
                            <span class="time">
                                29.06.2017 at 13:44
                            </span>
                                <p class="message">
                                    Admin approved a vacation request sent be Ivan Ivanov. <a href="#">See details</a> .
                                </p>
                            </div>
                            <div class="feed-block block">
                            <span class="time">
                                29.06.2017 at 13:44
                            </span>
                                <p class="message">
                                    Admin approved a vacation request sent be Ivan Ivanov. <a href="#">See details</a> .
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection