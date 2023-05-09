@extends('MyForumBuilder::admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / Import / Questions </span></h4>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form</h5>
                </div>
                <div class="card-body">
                    <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Upload File (Csv) <a
                                    href="@route('admin.questions.import.sample')">Download Sample</a></label>
                            <input class="form-control" type="file" id="csv_file" name="csv_file" accept=".csv"/>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'csv_file'])
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
