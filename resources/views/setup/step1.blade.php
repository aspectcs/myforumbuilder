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
                    <p class="mb-4">Please Put your database name username and password</p>

                    <form id="formAuthentication" class="mb-3" action="@route('setup.action')" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="step1"/>
                        <div class="mb-3">
                            <label for="DB_HOST" class="form-label">Database Host</label>
                            <input
                                type="text"
                                class="form-control"
                                id="DB_HOST"
                                name="DB_HOST"
                                placeholder="Enter your Database Host"
                                autofocus
                                value="{{old('DB_HOST','localhost')}}"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'DB_HOST'])
                        </div>
                        <div class="mb-3">
                            <label for="DB_DATABASE" class="form-label">Database name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="DB_DATABASE"
                                name="DB_DATABASE"
                                placeholder="Enter your Database name"
                                autofocus
                                value="{{old('DB_DATABASE')}}"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'DB_DATABASE'])
                        </div>
                        <div class="mb-3">
                            <label for="DB_USERNAME" class="form-label">Database username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="DB_USERNAME"
                                name="DB_USERNAME"
                                placeholder="Enter your Database username"
                                autofocus
                                value="{{old('DB_USERNAME')}}"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'DB_USERNAME'])
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label for="DB_PASSWORD" class="form-label">Database password</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="DB_PASSWORD"
                                    name="DB_PASSWORD"
                                    placeholder="Enter your Database password"
                                    autofocus
                                    value="{{old('DB_PASSWORD')}}"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'DB_PASSWORD'])
                        </div>
                        @include('MyForumBuilder::admin.layouts.alert')
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Connect</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
