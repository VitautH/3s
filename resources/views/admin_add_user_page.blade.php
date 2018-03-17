@extends('layouts.admin')
@section('content')
    <link href="{{ asset('css/team_users.css') }}" rel="stylesheet">
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <h2 class="title-page">Add Employee</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                        <div class="block table-users table-responsive">
                            <form action="./page-settings.html" class="form-horizontal">
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Username</label>
                                    <div class="col-md-7">
                                        <input type="text" name="user-name" value="soham.for.mayor" class="form-control">
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-7">
                                        <input type="text" name="first-name" value="Soham" class="form-control">
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-7">
                                        <input type="text" name="last-name" value="Hayes" class="form-control">
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email Address</label>
                                    <div class="col-md-7">
                                        <input type="text" name="email-address" value="soham.hayes@gmail.com" class="form-control">
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Website</label>
                                    <div class="col-md-7">
                                        <input type="text" name="website" value="http://jumpstartthemes.com" class="form-control">
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">About You</label>
                                    <div class="col-md-7">
                                        <textarea id="about-textarea" name="about-you" rows="6" class="form-control">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.</textarea>
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                                <div class="form-group">
                                    <div class="col-md-7 col-md-push-3">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div> <!-- /.col -->
                                </div> <!-- /.form-group -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.container -->
    </div> <!-- .content -->
@endsection