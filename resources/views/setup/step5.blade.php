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
                    <p class="mb-4">Go to settings and setup your Forum.</p>

                    <form id="formAuthentication" class="mb-3" action="@route('setup.action')" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="step5"/>
                        <div class="mb-3">
                            <label for="CRON_COMMAND" class="form-label">Setup your Cron Command according to your server.</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    disabled
                                    value="* * * * * cd {{base_path()}} && php artisan schedule:run >/dev/null 2>&1"
                            />
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'CRON_COMMAND'])
                        </div>
                        @include('MyForumBuilder::admin.layouts.alert')
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Go to Settings</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
