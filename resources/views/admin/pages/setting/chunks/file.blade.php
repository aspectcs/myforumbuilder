@php
    $name = $field['name'];
    $label = $field['label'];
@endphp
<div class="mb-3">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    @isset($data[$name])
        <input type="hidden" name="{{$name}}" value="{{$data[$name]}}"/>
        <img src="@route('uploads',$data[$name])" class="img-thumbnail mb-2 border p-2" alt="{{$name}}" width="100"/>
    @endisset
    <input type="file" class="form-control" id="{{$name}}" name="{{$name}}"/>
</div>
