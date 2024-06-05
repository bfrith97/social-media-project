@include('partials.head')
@include('partials.nav', ['notificationsCount' => $notificationsCount])

@include('partials.messages.index')

@push('js')
    <script src="{{ asset('js/messages/message.js') }}"></script>
    <script src="{{ asset('js/messages/get-users-for-new-chat.js') }}"></script>
    <script src="{{ asset('js/messages/start-new-chat.js') }}"></script>
@endpush

@include('partials.footer')

