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
    <div class="card-footer">
        <div class="navbar-child-container" data-parent="{key}">
            @isset($child)
                @foreach($child as $nav)
                    @php
                        $child_key = 'navbar-child-'.rand();
                    @endphp
                    {!! str_replace(['{key}','{child-key}'],[$key,$child_key],view('MyForumBuilder::admin.pages.setting.chunks.navbar-child-card',$nav)) !!}
                @endforeach
            @endisset
        </div>
        <div class="text-center">
            <a href="javascript:void(0)" data-add="nav-child-item" data-parent="{key}"><i
                    class="bx bx-plus-circle h1 m-0"></i></a>
        </div>
    </div>
</div>
