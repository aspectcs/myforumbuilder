@php
    $name = $field['name'];
    $label = $field['label'];
@endphp
<div class="mb-3">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <input type="text" class="form-control" id="{{$name}}" name="{{$name}}" value="{{env($name)}}"
           placeholder="{{$label}}"/>
</div>
