<div id="navbar-container" class="navbar-container">
    @if($data)
        @foreach($data as $nav)
            @php
                $key = 'navbar-'.rand();
                $nav['key']= $key;
            @endphp
            {!! str_replace('{key}',$key,view('MyForumBuilder::admin.pages.setting.chunks.navbar-card',$nav)) !!}
        @endforeach
    @endif
</div>
<div class="text-center py-3">
    <a href="javascript:void(0)" data-add="nav-item"><i class="bx bx-plus-circle h1 m-0"></i></a>
</div>
@push('style')
    <link rel="stylesheet" href="@asset('plugins/jquery-ui/jquery-ui.css')">
@endpush
@push('script')
    <script src="@asset('plugins/jquery-ui/jquery-ui.min.js')"></script>
    <script>
        $( function() {
            $( "#navbar-container, .navbar-child-container" ).sortable({
                revert: true
            });
        });
        $(document).ready(function (e) {
            const container = $('#navbar-container');
            @php
                $card = view('MyForumBuilder::admin.pages.setting.chunks.navbar-card');
                $card = str_replace(PHP_EOL,'',$card);

                $child_card = view('MyForumBuilder::admin.pages.setting.chunks.navbar-child-card');
                $child_card = str_replace(PHP_EOL,'',$child_card);
            @endphp
            const card = '{!! $card !!}';
            const child_card = '{!! $child_card !!}';
            $(document).on('click', '[data-add="nav-item"]', function (e) {
                e.preventDefault();
                let key = 'navbar-' + (Math.random() + 1).toString(36).substring(7);
                let child_key = 'navbar-child-' + (Math.random() + 1).toString(36).substring(7);
                const newCard = card.replaceAll('{key}', key).replaceAll('{child-key}', child_key);
                container.append(newCard);
            });

            $(document).on('click', '[data-remove]', function (e) {
                e.preventDefault();
                let key = $(this).data('remove');
                $('.card[data-value="' + key + '"]').remove();
            });

            $(document).on('click', '[data-add="nav-child-item"]', function (e) {
                e.preventDefault();
                let key = $(this).data('parent');
                let child_key = 'navbar-child-' + (Math.random() + 1).toString(36).substring(7);
                const newCard = child_card.replaceAll('{key}', key).replaceAll('{child-key}', child_key);
                $('.navbar-child-container[data-parent="' + key + '"]').append(newCard);
            });
        });
    </script>
@endpush
