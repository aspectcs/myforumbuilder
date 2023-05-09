@extends('MyForumBuilder::admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="@asset('plugins/select2/css/select2.min.css')"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / Question / </span> {{$edit?'Edit':'Add'}}</h4>
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
                            <label class="form-label" for="category_id">Category</label>
                            <select class="form-control select2" id="category_id" name="category_id"
                                    data-placeholder="Select Category">
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}" {{@$data->category_id == $category->id?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'category_id'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sub_category_id">Sub Category</label>
                            <select class="form-control select2" id="sub_category_id" name="sub_category_id"
                                    data-placeholder="Select Sub Category"
                                    data-select2-ajax="@route('admin.select2.sub-category')"
                                    data-params='["#category_id"]' data-selected='[{{$data->sub_category}}]'>
                            </select>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'sub_category_id'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="question">Question</label>
                            <textarea name="question" id="question"
                                      class="form-control">{{@$data->question}}</textarea>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'question'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" id="description"
                                      class="form-control">{{@$data->description}}</textarea>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'description'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{@$data->slug}}"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'slug'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="created_at">Created At</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at"
                                   value="{{@$data->created_at}}"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'created_at'])
                        </div>
                        <hr>
                        @include('MyForumBuilder::admin.common.meta',['meta_title'=>$data->meta_title,'meta_description'=>$data->meta_description])

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="@asset('plugins/select2/js/select2.min.js')"></script>
@endpush
