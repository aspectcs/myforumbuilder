<div class="card mb-3" data-type="key" data-value="{key}">
    <div class="card-header">
        <div class="float-end">
            <i class="bx bx-x" data-remove="{key}"></i>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Label</label>
            <input type="text" class="form-control" data-type="label" name="navbar[{key}][label]"
                   value="{{@$label}}" placeholder=""/>
        </div>
        <div class="mb-3">
            <label class="form-label">Href</label>
            <input type="text" class="form-control" data-type="href" name="navbar[{key}][href]"
                   value="{{@$href}}" placeholder=""/>
        </div>
    </div>
</div>
