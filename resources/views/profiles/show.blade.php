@include('partials.head')
@include('partials.nav', ['notificationsCount' => $notificationsCount])

@include('partials.profiles.show')

@push('js')
    <script src="{{ asset('js/profile/tabs.js') }}"></script>
    <script src="{{ asset('js/profile/follow.js') }}"></script>
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/shared/comment.js') }}"></script>
    <script src="{{ asset('js/shared/like.js') }}"></script>
@endpush

@include('partials.footer')

