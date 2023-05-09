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
                    <p class="mb-4">Please wait while we migrating database</p>

                    <form id="formAuthentication" class="mb-3" action="@route('setup.action')" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="step3"/>
                        @include('MyForumBuilder::admin.layouts.alert')
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Migrate Now</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
