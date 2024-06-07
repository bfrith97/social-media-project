@include('partials.head')
@include('partials.nav', ['notificationsCount' => $notificationsCount])

@push('js')
    <script src="{{ asset('js/shared/comment.js') }}"></script>
    <script src="{{ asset('js/shared/like.js') }}"></script>
@endpush

@include('partials.news.show')

@include('partials.footer')
