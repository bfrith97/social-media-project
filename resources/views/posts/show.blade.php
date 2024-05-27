@include('partials.head')
@include('partials.nav')

@include('partials.posts.show')

@push('js')
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/shared/load-additional-comments.js') }}"></script>
    <script src="{{ asset('js/shared/comment.js') }}"></script>
    <script src="{{ asset('js/shared/like.js') }}"></script>
    <script src="{{ asset('js/follows/join.js') }}"></script>
@endpush

@include('partials.footer')
