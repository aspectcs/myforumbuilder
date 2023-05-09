class Http {
    constructor(base) {
        this.base = base;
        this.request = null;
        this.response = null
    }

    ajax(obj) {
        let defaultobj = {
            url: this.base + 'ajax/',
            type: 'POST',
            data: {},
            enctype: 'multipart/form-data',
            async: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            dataType: 'JSON',
            success: function (response) {
                swal({
                    title: 'Good job!',
                    text: "Data successfully updated.",
                    type: 'success',
                    padding: '2em'
                })
            }, error: function (e) {
                swal({
                    title: 'Error !',
                    text: e.responseJSON.message,
                    type: 'error',
                    padding: '2em'
                })
            }
        };
        $.extend(defaultobj, obj);
        this.request = defaultobj.data;
        /*let formData = new FormData();
        $.each(defaultobj.data, function (k, v) {
            formData.append(k, v)
        });
        defaultobj.data = formData;*/
        const ajax = $.ajax(defaultobj);
        const response = ajax.responseText;
        this.response = JSON.parse(response);

    }

    defaultContentType() {
        return 'application/x-www-form-urlencoded; charset=UTF-8';
    }
}

