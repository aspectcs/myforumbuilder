@extends('MyForumBuilder::admin.layouts.app')
@section('title', 'Check Update')
@push('style')

@endpush
@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-12">
                @include('MyForumBuilder::admin.layouts.alert')
                <div class="card">
                    @isset($old_version)
                        <div class="card-header text-center">
                            New Version Available {{$version}}
                        </div>
                    @endisset
                    <div class="card-body">
                        {!! $content !!}
                    </div>
                    @isset($old_version)
                        <div class="card-footer text-center">
                            <a href="@route('admin.do-update')" class="btn btn-primary">Update now</a>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
