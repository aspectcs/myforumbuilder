@isset($retry)
    <a class="" href="{{$retry}}" title="Retry"><i class="bx bx-revision me-1"></i> </a>
@endisset
@isset($view)
    <a class="" href="{{$view}}" target="_blank" title="View"><i class="bx bx-show-alt me-1"></i> </a>
@endisset
@isset($edit)
    <a class="" href="{{$edit}}" title="Edit"><i class="bx bx-edit-alt me-1"></i> </a>
@endisset
@isset($delete)
    <a class="delete-confirm" href="{{$delete}}" title="Delete"><i class="bx bx-trash me-1"></i> </a>
@endisset
