<div class="mb-3">
    <label class="form-label" for="meta_title">Meta Title</label>
    <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{@$meta_title}}"
           placeholder="">
    @include('MyForumBuilder::admin.layouts.input-error',['name'=>'meta_title'])
</div>
<div class="mb-3">
    <label class="form-label" for="meta_description">Meta Description</label>
    <textarea name="meta_description" id="meta_description"
              class="form-control">{{@$meta_description}}</textarea>
    @include('MyForumBuilder::admin.layouts.input-error',['name'=>'meta_description'])
</div>
