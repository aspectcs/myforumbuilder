class Select {
    static select2Basic(obj) {
        obj.each(function () {
            $(this).select2({
                dropdownParent: $(this).parent()
            });
        });
    }

    static select2Ajax(obj) {
        obj.each(function () {
            $(this).select2({
                allowClear: true,
                dropdownParent: $(this).parent(),
                data: $(this).data('selected'),
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).data('select2-ajax'),
                    type: "post",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        let customParam = {q: params.term};
                        if ($(this).data('params') !== undefined) {
                            let chunks = $(this).data('params');
                            if (chunks.length > 0) {
                                for (let v of chunks) {
                                    if (v instanceof Object) {
                                        let obj = $(v.object);
                                        customParam[v.key] = obj.val();
                                    } else {
                                        let obj = $(v);
                                        customParam[obj.attr('name')] = obj.val();
                                    }
                                }
                            }
                        }
                        return customParam;
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: false
                },
                minimumInputLength: 1,
                templateResult: (repo) => {
                    if (repo.loading) {
                        return repo.text;
                    } else if (repo.length <= 0) {
                        return false;
                    }

                    let inner = '';
                    if (repo.name) {
                        inner += "<div class='select2-result'><span class='name'>" + repo.name + "</span></div>";
                    }
                    if (repo.email) {
                        inner += "<div class='select2-result'> <span class='email'>" + repo.email + "</span></div>";
                    }
                    if (repo.phone) {
                        inner += "<div class='select2-result'><span class='phone'>" + repo.phone + "</span></div>";
                    }

                    const $container = $(
                        "<div class='select2-result-repository clearfix'>" +
                        "<div class='select2-result-repository__meta'>" +
                        inner +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );

                    return $container;
                },
                templateSelection: (repo) => {

                    return repo.name;
                }
            });
            $(".select2-selection__placeholder").each(function () {
                $(this).text($(this).parent().attr('title'));
            });
        });
    }

    static select2AjaxMultiple(obj) {
        obj.each(function () {
            $(this).select2({
                multiple: true,
                dropdownParent: $(this).parent(),
                data: $(this).data('selected'),
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).data('select2-ajax'),
                    type: "post",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {

                        let customParam = {q: params.term};
                        if ($(this).data('params') !== undefined) {
                            let chunks = $(this).data('params');
                            if (chunks.length > 0) {
                                for (let v of chunks) {
                                    let obj = $(v);
                                    customParam[obj.attr('name')] = obj.val();
                                }
                            }
                        }
                        return customParam;
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: false
                },
                minimumInputLength: 1,
                templateResult: (repo) => {
                    if (repo.loading) {
                        return repo.text;
                    } else if (repo.length <= 0) {
                        return false;
                    }

                    let inner = '';
                    if (repo.name) {
                        inner += "<div class='select2-result'><span class='name'>" + repo.name + "</span></div>";
                    }
                    if (repo.email) {
                        inner += "<div class='select2-result'> <span class='email'>" + repo.email + "</span></div>";
                    }
                    if (repo.phone) {
                        inner += "<div class='select2-result'><span class='phone'>" + repo.phone + "</span></div>";
                    }

                    const $container = $(
                        "<div class='select2-result-repository clearfix'>" +
                        "<div class='select2-result-repository__meta'>" +
                        inner +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );

                    return $container;
                },
                templateSelection: (repo) => {
                    return repo.name;
                }
            });
            $(".select2-selection__placeholder").each(function () {
                $(this).text($(this).parent().attr('title'));
            });
        });
    }

    static autoComplete(obj) {
        obj.each(function () {
            $(this).autocomplete({
                type: 'POST',
                paramName: 'q',
                ajaxSettings: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                serviceUrl: $(this).data('autocomplete-ajax'),
                minChars: 1,
                onSelect: function (suggestion) {
                    console.log(suggestion)
                },
                showNoSuggestionNotice: true,
                noSuggestionNotice: 'Sorry, no matching results'
            });
        });
    }
}

