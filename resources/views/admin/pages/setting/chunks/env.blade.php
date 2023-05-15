@php
    $name = $field['name'];
    $label = $field['label'];
    $fieldType = $field['fieldType']??null;
@endphp
@if(@$fieldType == 'hidden')
    <div class="mb-3 form-password-toggle">
        <label class="form-label" for="{{$name}}">{{$label}}</label>
        <div class="input-group input-group-merge">
            <input
                type="password"
                class="form-control"
                id="{{$name}}" name="{{$name}}"
                value="{{env($name)}}"
                placeholder="{{$label}}"
            />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>
@else
    <div class="mb-3">
        <label class="form-label" for="{{$name}}">{{$label}}</label>
        <input type="{{@$fieldType == 'date'?'date':'text'}}" class="form-control" id="{{$name}}" name="{{$name}}"
               value="{{env($name)}}"
               placeholder="{{$label}}"/>
    </div>
@endif
