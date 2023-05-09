<div class="mb-3">
    @error('message')
        <div class="alert alert-success">{{ $message }}</div>
    @enderror
    @error('error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
