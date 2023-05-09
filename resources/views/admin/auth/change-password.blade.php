@extends('MyForumBuilder::admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / Change Password</h4>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="@route('admin.change-password')" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"/>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'password'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="confirm_confirmation">Confirm Password</label>
                            <input type="password" name="confirm_confirmation" id="confirm_confirmation" class="form-control"/>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'password_confirmation'])
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
