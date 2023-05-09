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
                    <p class="mb-4">Please your email and password to login into admin.</p>

                    <form id="formAuthentication" class="mb-3" action="@route('setup.action')" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="step4"/>
                        <div class="mb-3">
                            <label for="ADMIN_URL_PREFIX" class="form-label">Admin url prefix
                                (admin,forum-admin)</label>
                            <input
                                type="text"
                                class="form-control"
                                id="ADMIN_URL_PREFIX"
                                name="ADMIN_URL_PREFIX"
                                placeholder="Enter your admin url prefix"
                                autofocus
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'ADMIN_URL_PREFIX'])
                        </div>
                        <div class="mb-3">
                            <label for="ADMIN_EMAIL" class="form-label">Admin email</label>
                            <input
                                type="text"
                                class="form-control"
                                id="ADMIN_EMAIL"
                                name="ADMIN_EMAIL"
                                placeholder="Enter your admin email"
                                disabled
                                value="{{$email}}"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'ADMIN_EMAIL'])
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label for="ADMIN_PASSWORD" class="form-label">Admin password</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="ADMIN_PASSWORD"
                                    name="ADMIN_PASSWORD"
                                    placeholder="Enter your admin password"
                                    autofocus
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'ADMIN_PASSWORD'])
                        </div>
                        @include('MyForumBuilder::admin.layouts.alert')
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
