@include('partials.head')
@include('partials.nav', ['notificationsCount' => $notificationsCount])

@push('js')
    <script src="{{ asset('js/messages/message.js') }}"></script>
@endpush

@include('partials.messages.index')

@include('partials.footer')
