<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>L'Atelier a Vin</title>


  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

  {{-- Section AlpineJS --}}
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.11.1/cdn.js"></script>




</head>
<body>
      

      @if(auth()->check() && auth()->user()->is_admin == 1)
      <div class="w-full bg-red-900 ">
        <div class="flex justify-between p-4">
          <a href="/admin" class="text-lg font-semibold uppercase  text-white">L'atelier a vin </a>
          
          <a href="/logout" class="text-white">Déconnexion </a>
          
        </div>
  </div>
  @else
  <div class="w-full bg-red-900 ">
    <div class="text-center py-4">
      @if(auth()->check())
      <a href="/cellier" class="text-lg font-semibold uppercase  text-white">L'atelier a vin </a>
      @else
      <a href="/" class="text-lg font-semibold uppercase  text-white">L'atelier a vin </a>
      @endif
    </div>
</div>

@endif

</body>
  @yield('content')

</html>
