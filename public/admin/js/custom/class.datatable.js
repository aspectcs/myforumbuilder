class Datatable {
    datatable = null;

    constructor() {
        this.datatable = $('table[data-json-url]');
        if (this.datatable.length === 1) {
            this.datatable = this.single(this.datatable, dataTableInfo);
        } else {
            const that = this;
            this.datatable.each(function (k, v) {
                that.datatable[k] = that.single($(this), dataTableMultipleInfo[k]);
            });
        }
        return this.datatable;
    }

    single(datatable, dataTableInfo) {
        return datatable.DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            // deferRender: true,
            processing: true,
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }],
            columns: dataTableInfo['labels'],
            order: dataTableInfo['order'],
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]],
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: datatable.data('json-url'),
                type: "POST"
            }, drawCallback: function (settings) {
                if ($('.bs-tooltip').length > 0)
                    $('.bs-tooltip').tooltip();

                if ($('.js-switch').length > 0) {
                    $('.js-switch').each(function () {
                        new Switchery($(this)[0], $(this).data());
                    });
                }

            }, "language": {
                search: ""
            },
            dom: '<"row"<"col-md-12"<"row"<"col-md-12"B><"col-md-6"l> <"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [
                    {extend: 'copy', className: 'btn'},
                    {extend: 'csv', className: 'btn'},
                    {extend: 'excel', className: 'btn'},
                    {extend: 'print', className: 'btn'}
                ]
            },
            oLanguage: {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },

            initComplete: function () {
                $('thead tr', this).clone(false).appendTo($('thead', this));
                $('thead tr:eq(1) th', this).removeClass('sorting').removeClass('sorting_desc').addClass('filter');
                $('thead tr:eq(1) th', this).each(function (i) {
                    if ($(this).hasClass('searchable')) {
                        const title = $(this).text();
                        if ($(this).hasClass('datepicker')) {
                            /*$(this).html('<input id="flatpicker' + i + '" class="form-control w-200px flatpickr flatpickr-input active" readonly="readonly" type="text" placeholder="Select ' + title + '" />');
                            //$('input', this).datepicker({dateFormat: 'yy-mm-dd'});

                            flatpickr(document.getElementById('flatpicker' + i), {
                                enableTime: false,
                                dateFormat: "Y-m-d",
                                onClose: function (selectedDates, dateStr, instance) {
                                    if (datatable.column(i).search() !== dateStr) {
                                        datatable
                                            .column(i)
                                            .search(dateStr)
                                            .draw();
                                    }
                                }
                            });*/
                        } else if (dataTableInfo['labels'][i]['data-select'] !== undefined && dataTableInfo['labels'][i]['data-select'].length > 0) {
                            let options = '<option value="">Select ' + title + '</option>';
                            let obj = dataTableInfo['labels'][i]['data-select'];
                            $.each(obj, function (k, v) {
                                if (typeof v === 'object' && v !== null) {
                                    options += "<option value='" + v.key + "'>" + v.value + "</option>";
                                } else {
                                    options += "<option value='" + k + "'>" + v + "</option>";
                                }
                            });
                            $(this).html('<select class="form-control w-200px">' + options + '</select>');
                            $('select', this).on('change', function () {
                                if (datatable.column(i).search() !== this.value) {
                                    datatable
                                        .column(i)
                                        .search(this.value)
                                        .draw();
                                }
                            });
                        } else if (dataTableInfo['labels'][i]['data-select-multiple-ajax'] !== undefined) {

                            let url = dataTableInfo['labels'][i]['data-select-multiple-ajax'];

                            $(this).html('<select class="form-control w-200px" data-selected="[]" data-select2-ajax="' + url + '" data-placeholder="Select ' + title + '" name="multiple' + i + '[]"></select>');

                            Select.select2AjaxMultiple($('select', this));

                            $('select', this).on('change', function () {
                                if (datatable.column(i).search() !== $(this).val()) {
                                    datatable
                                        .column(i)
                                        .search($(this).val())
                                        .draw();
                                }
                            });
                        } else if (dataTableInfo['labels'][i]['data-filter'] !== undefined && dataTableInfo['labels'][i]['data-filter'] === 'range') {
                            $(this).html('<div class="w-200px row px-3"><input class="form-control col-12 p-1" type="number" name="value' + i + '[]"/> <span class="d-flex justify-content-center align-items-center col-12 p-0"><-></span> <input class="form-control col-12 p-1" type="number" name="value' + i + '[]"/></div>');
                            const $this = $(this);
                            $('input', $this).on('keyup change clear', function () {
                                let min = $('input', $this).get(0).value;
                                let max = $('input', $this).get(1).value;
                                if (datatable.column(i).search() !== min + '|' + max) {
                                    datatable
                                        .column(i)
                                        .search(min + '|' + max)
                                        .draw();
                                }
                            });
                        } else {
                            $(this).html('<input class="form-control w-200px" type="text" placeholder="Search ' + title + '" />');
                            $('input', this).on('keyup change clear', function () {
                                if (datatable.column(i).search() !== this.value) {
                                    datatable
                                        .column(i)
                                        .search(this.value)
                                        .draw();
                                }
                            });
                        }
                    } else {
                        $(this).html('&nbsp;');
                    }
                });
            }
        });
    }
}

