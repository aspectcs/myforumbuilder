@php
    $name = $field['name'];
    $label = $field['label'];
@endphp
<div class="mb-3">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <textarea name="{{$name}}" id="{{$name}}" class="form-control"
              placeholder="{{$label}}">{{@$data[$name]}}</textarea>
</div>
