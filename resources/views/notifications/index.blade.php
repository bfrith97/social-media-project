@include('partials.head')
@include('partials.nav', ['notificationsCount' => $notificationsCount])

@include('partials.notifications.index')

@include('partials.footer')
