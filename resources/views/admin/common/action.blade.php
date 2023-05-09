@isset($view)
    <a class="" href="{{$view}}" target="_blank"><i class="bx bx-show-alt me-1"></i> </a>
@endisset
@isset($edit)
    <a class="" href="{{$edit}}"><i class="bx bx-edit-alt me-1"></i> </a>
@endisset
@isset($delete)
    <a class="delete-confirm" href="{{$delete}}"><i class="bx bx-trash me-1"></i> </a>
@endisset
