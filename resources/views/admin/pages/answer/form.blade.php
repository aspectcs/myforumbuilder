@extends('MyForumBuilder::admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="@asset('plugins/select2/css/select2.min.css')"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h4 class="fw-bold py-3 mb-4"><span
                    class="text-muted fw-light">Dashboard / Answer / </span> {{$edit?'Edit':'Add'}}</h4>
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
                            <label class="form-label" for="answer">Answer</label>
                            <textarea name="answer" id="answer" class="form-control">{{@$data->answer}}</textarea>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'answer'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="answer_html">Answer HTML</label>
                            <textarea name="answer_html" id="answer_html"
                                      class="form-control">{{@$data->answer_html}}</textarea>
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'answer_html'])
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="created_at">Created At</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at"
                                   value="{{@$data->created_at}}"
                                   placeholder="">
                            @include('MyForumBuilder::admin.layouts.input-error',['name'=>'created_at'])
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="@asset('plugins/select2/js/select2.min.js')"></script>
    <script src="@asset('plugins/tinymce/tinymce.min.js')"></script>
    <script>

        tinymce.init({
            selector: 'textarea#answer_html',
            convert_urls: false,
            relative_urls: false,
            anchor_top: false,
            anchor_bottom: false,
            theme: "modern",
            height: 300,
            content_style: "img { height: auto; max-width: 100%; }",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
        });


    </script>
@endpush
