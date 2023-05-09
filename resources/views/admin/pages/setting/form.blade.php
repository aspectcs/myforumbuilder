@extends('MyForumBuilder::admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="@asset('plugins/select2/css/select2.min.css')"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / Setting / </span> {{$edit?'Edit':'Add'}}</h4>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Setting</h5>
                </div>
                <div class="card-body">
                    <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif
                        @foreach($data->fields as $fields)
                            @include('MyForumBuilder::admin.pages.setting.chunks.'.$fields['type'],['field'=>$fields,'data'=>$data->values])
                        @endforeach
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
