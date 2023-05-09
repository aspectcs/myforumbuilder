(function ($) {

    let datatable = new Datatable();

    const http = new Http($('base').attr('href'));

    $(document).ready(function () {

    });

    $(document).on('keypress', '[data-number="true"]', function (event) {
        return event.which >= 48 && event.which <= 57 || event.which === 46;
    });

    $(document).on('change', '[data-update-status]', function (e) {
        e.preventDefault();
        let url = $(this).data('update-status');
        http.ajax({
            type: 'PATCH',
            processData: true,
            contentType: http.defaultContentType(),
            url: url,
            success: function (e) {
                if (e.status === 200) {
                    swal({
                        title: 'Good job!',
                        text: e.message,
                        type: 'success',
                        padding: '2em'
                    })
                } else {
                    swal({
                        title: 'Error !',
                        text: e.message,
                        type: 'error',
                        padding: '2em'
                    })
                }
            },
        });
    });

    $(document).on('click', '.delete-confirm', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        swal({
            title: 'Are you sure?',
            text: "Are you sure you would like to delete!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function (result) {
            if (result.value) {
                http.ajax({
                    type: 'DELETE',
                    processData: true,
                    contentType: http.defaultContentType(),
                    url: url,
                    success: function (e) {
                        if (e.status === 200) {
                            swal({
                                title: 'Good job!',
                                text: e.message,
                                type: 'success',
                                padding: '2em'
                            }).then(function (result) {
                                datatable.draw();
                            });
                        } else {
                            swal({
                                title: 'Error !',
                                text: e.message,
                                type: 'error',
                                padding: '2em'
                            })
                        }
                    },
                });
            }
        })
    });

    if ($("select.select2").length > 0) {
        Select.select2Basic($("select.select2"))
    }
    if ($("[data-select2-ajax]:not([multiple])").length > 0) {
        Select.select2Ajax($("[data-select2-ajax]:not([multiple])"))
    }
    if ($("[data-select2-ajax][multiple]").length > 0) {
        Select.select2AjaxMultiple($("[data-select2-ajax][multiple]"))
    }
    if ($("[data-autocomplete-ajax]").length > 0) {
        Select.autoComplete($("[data-autocomplete-ajax]"));
    }
})
(jQuery);
