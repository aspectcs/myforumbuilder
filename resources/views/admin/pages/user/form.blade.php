@extends('MyForumBuilder::admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / User's / </span> {{$edit?'Edit':'Add'}}</h4>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form</h5>
                </div>
                <div class="card-body">
                    <form action="{{$action}}" method="POST">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{@$data->name}}"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'name'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   value="{{@$data->email}}" placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'email'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password <small
                                    class="text-danger">{{$edit?'Only in case if you want to change current password.':''}}</small></label>
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'password'])
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
