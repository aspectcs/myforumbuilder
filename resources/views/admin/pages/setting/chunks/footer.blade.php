<div id="footer-container" class="navbar-container">
    @if($data)
        @foreach($data as $nav)
            @php
                $key = 'footer-'.rand();
                $nav['key']= $key;
            @endphp
            {!! str_replace('{key}',$key,view('MyForumBuilder::admin.pages.setting.chunks.footer-card',$nav)) !!}
        @endforeach
    @endif
</div>
<div class="text-center py-3">
    <a href="javascript:void(0)" data-add="footer-item"><i class="bx bx-plus-circle h1 m-0"></i></a>
</div>
@push('style')
    <link rel="stylesheet" href="@asset('plugins/jquery-ui/jquery-ui.css')">
@endpush
@push('script')
    <script src="@asset('plugins/jquery-ui/jquery-ui.min.js')"></script>
    <script>
        $( function() {
            $( "#footer-container" ).sortable({
                revert: true
            });
        });
        $(document).ready(function (e) {
            const container = $('#footer-container');
            @php
                $card = view('MyForumBuilder::admin.pages.setting.chunks.footer-card');
                $card = str_replace(PHP_EOL,'',$card);
            @endphp
            const card = '{!! $card !!}';
            $(document).on('click', '[data-add="footer-item"]', function (e) {
                e.preventDefault();
                let key = 'footer-' + (Math.random() + 1).toString(36).substring(7);
                const newCard = card.replaceAll('{key}', key);
                container.append(newCard);
            });

            $(document).on('click', '[data-remove]', function (e) {
                e.preventDefault();
                let key = $(this).data('remove');
                $('.card[data-value="' + key + '"]').remove();
            });

        });
    </script>
@endpush
