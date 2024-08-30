@extends('layout.auth.index')
@section('content')
<form class="my-4" action="{{route('login')}}" method="POST">
    @csrf
    <div class="form-group mb-2">
        <label class="form-label" for="username">Username</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email">
    </div><!--end form-group-->

    <div class="form-group">
        <label class="form-label" for="userpassword">Password</label>
        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">
    </div><!--end form-group-->

    <div class="form-group row mt-3">
        <div class="col-sm-6">
            <div class="form-check form-switch form-switch-success">
                <input class="form-check-input" type="checkbox" id="customSwitchSuccess">
                <label class="form-check-label" for="customSwitchSuccess">Remember me</label>
            </div>
        </div><!--end col-->
    </div><!--end form-group-->

    <div class="form-group mb-0 row">
        <div class="col-12">
            <div class="d-grid mt-3">
                <button class="btn btn-primary" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
            </div>
        </div><!--end col-->
    </div> <!--end form-group-->
</form><!--end form-->
@endsection
