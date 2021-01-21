@include('webpanel.includes.header')

<div class="page-container">
@include('webpanel.includes.sidebar')

    <div class="page-content">
@yield('body')

@include('webpanel.includes.footer')
</div>
</div>