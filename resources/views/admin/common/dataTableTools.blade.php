@extends('MyForumBuilder::admin.layouts.app')

@push('style')
    <link rel="stylesheet" type="text/css" href="@asset('plugins/datatable/datatables.css')">
    <link rel="stylesheet" type="text/css" href="@asset('plugins/datatable/custom_dt_html5.css')">
    <link rel="stylesheet" type="text/css" href="@asset('plugins/datatable/dt-global_style.css')">
    <link rel="stylesheet" type="text/css" href="@asset('plugins/datatable/custom_dt_custom.css')">

    <link href="@asset('plugins/flatpickr/flatpickr.css')" rel="stylesheet" type="text/css">
    <link href="@asset('plugins/flatpickr/custom-flatpickr.css')" rel="stylesheet" type="text/css">
@endpush

@section('content')

    @php
        $lastEle = array_pop($breadcrumb['chunks']);
    @endphp
    <h4 class="fw-bold py-3 mb-4"><span
            class="text-muted fw-light">{{implode(' / ',$breadcrumb['chunks'])}} /</span> {{$lastEle}}</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-end">
                        @isset($import)
                            <a href="{{$import}}" class="btn btn-primary">Import</a>
                        @endisset
                        @isset($addNew)
                            <a href="{{$addNew}}" class="btn btn-primary">Add</a>
                        @endisset

                        @isset($customButtons)
                            @foreach($customButtons as $buttons)
                                <a href="{{$buttons['url']}}" class="btn btn-danger">{{$buttons['label']}}</a>
                            @endforeach
                        @endisset
                    </div>
                    <h4 class="card-title">{{@$dtHeading}}</h4>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover" data-json-url="{{$dataTableJSON}}">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        let dataTableInfo = {!!json_encode($dtInfo)!!};
    </script>
    <script src="@asset('plugins/datatable/datatables.js')"></script>

    <script src="@asset('plugins/datatable/button-ext/dataTables.buttons.min.js')"></script>
    <script src="@asset('plugins/datatable/button-ext/jszip.min.js')"></script>
    <script src="@asset('plugins/datatable/button-ext/buttons.html5.min.js')"></script>
    <script src="@asset('plugins/datatable/button-ext/buttons.print.min.js')"></script>

    <script src="@asset('plugins/flatpickr/flatpickr.js')"></script>
@endpush

