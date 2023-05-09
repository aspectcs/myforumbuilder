@extends('MyForumBuilder::admin.layouts.app-auth')
@push('style')
    <link rel="stylesheet" href="@asset('css/pages/page-auth.css')">
@endpush
@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2">Welcome to MyForumBuilder ! 👋</h4>
                    <p class="mb-4">Please put your APP key and secret</p>

                    <form id="formAuthentication" class="mb-3" action="@route('setup.action')" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="step2"/>
                        <div class="mb-3">
                            <label for="APP_KEY" class="form-label">APP KEY</label>
                            <input
                                type="password"
                                class="form-control"
                                id="APP_KEY"
                                name="APP_KEY"
                                placeholder="Enter your APP KEY"
                                autofocus
                                value="{{old('APP_KEY')}}"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'APP_KEY'])
                        </div>
                        <div class="mb-3">
                            <label for="APP_SECRET" class="form-label">APP SECRET</label>
                            <input
                                type="password"
                                class="form-control"
                                id="APP_SECRET"
                                name="APP_SECRET"
                                placeholder="Enter your APP SECRET"
                                autofocus
                                value="{{old('APP_SECRET')}}"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'APP_SECRET'])
                        </div>
                        @include('MyForumBuilder::admin.layouts.alert')
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Next</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
