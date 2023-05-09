@extends('MyForumBuilder::admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / Category / </span> {{$edit?'Edit':'Add'}}</h4>
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
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{@$data->name}}"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'name'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" id="description" class="form-control">{{@$data->description}}</textarea>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'description'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="priority">Priority</label>
                            <input type="number" class="form-control" id="priority" name="priority"
                                   value="{{@$data->priority}}" placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'priority'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{@$data->slug}}"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'slug'])
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
