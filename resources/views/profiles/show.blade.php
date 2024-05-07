@include('partials.head')
@include('partials.nav')

@include('partials.profiles.show')

@push('js')
    <script src="{{ asset('js/profile/tabs.js') }}"></script>
    <script src="{{ asset('js/profile/post.js') }}"></script>
    <script src="{{ asset('js/posts/comment.js') }}"></script>
    <script src="{{ asset('js/posts/post-like.js') }}"></script>
@endpush

@include('partials.footer')

