@include('partials.head')
@include('partials.nav', ['notificationsCount' => $notificationsCount])

@include('partials.posts.index')

@push('js')
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/shared/load-additional-comments.js') }}"></script>
    <script src="{{ asset('js/shared/load-additional-posts.js') }}"></script>
    <script src="{{ asset('js/shared/comment.js') }}"></script>
    <script src="{{ asset('js/shared/like.js') }}"></script>
    <script src="{{ asset('js/follows/follow.js') }}"></script>
@endpush

@include('partials.footer')
