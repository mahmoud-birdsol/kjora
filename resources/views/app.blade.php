<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overscroll-none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/images/favIcons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/images/favIcons/favicon-16x16.png')}}">
    <link rel="manifest" href="/site.webmanifest">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <!--Social -->
    @if(isset($page['props']['social_meta']))

        <meta property="og:url" content="{{ (isset($page['props']['social_meta']['url'])) ? ($page['props']['social_meta']['url']) : '' }}" />
        <meta property="og:title"
              content="{{ (isset($page['props']['social_meta']['title'])) ? ('Kjora | '.$page['props']['social_meta']['title']) : '' }}"/>
        <meta property="og:description"
              content="{{ (isset($page['props']['social_meta']['description'])) ? $page['props']['social_meta']['description'] : '' }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:image"
              content="{{  (isset($page['props']['social_meta']['image'])) ? $page['props']['social_meta']['image'] : asset('/images/logo.png') }}"/>
        <meta property="og:image:alt"
              content="{{  (isset($page['props']['social_meta']['image'])) ? $page['props']['social_meta']['image'] : asset('/images/logo.png') }}"/>
    @endif

    <script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});
    </script><script type="text/javascript">window.Beacon('init', '290f1635-e165-406b-a964-96cf65fc2efd')</script>
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
    @inertia
</body>

</html>
