<?php
$void = "javascript:void(0)";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Sender">
    <title>@yield('title') | Sender</title>

    <link rel="canonical" href="{{url('/')}}">

   <!-- Styles -->
   <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" /><!-- Bootstrap -->


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!--SweetAlert CSS--> 
    <link href="lib/sweet-alert/sweetalert2.css" rel="stylesheet">

    <!--Datatables CSS--> 
    <link href="lib/datatables/datatables.min.css" rel="stylesheet">
  </head>
  <body>
  
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{$void}}">API Mailer</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="{{$void}}"></a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
      @include('sidebar')
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <!--------- Input errors -------------->
          @if (count($errors) > 0)
                          @include('input-errors', ['errors'=>$errors])
                     @endif 
		  
		  @yield('content')
      </main>
  </div>
</div>
<!-- Google -->
<script src="js/google/googleInit.js?ver={{rand(12454494,2237347438)}}"js"></script>
<script src="js/google/api.js" onload="gapiLoaded()"></script>
<script src="js/google/gsiclient.js" onload="gisLoaded()"></script>

<!-- Script -->
<script type="text/javascript" src="js/modernizr-2.0.6.js"></script><!-- Modernizr -->
<script type="text/javascript" src="js/jquery-2.2.2.js"></script><!-- jQuery -->
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script><!-- Bootstrap -->
<script src="js/mmm.js?ver={{rand(12454494,2237347438)}}"></script>
<script src="js/helpers.js?ver={{rand(12454494,2237347438)}}"></script>

<!--SweetAlert JS--> 
<script src="lib/sweet-alert/sweetalert2.js"></script>

<!--Datatables JS--> 
<script src="lib/datatables/datatables.min.js"></script>

@yield('scripts')

 <!--------- Session notifications-------------->
 <?php
               $pop = ""; $val = "";
               
               if(isset($signals))
               {
                  foreach($signals['okays'] as $key => $value)
                  {
                    if(session()->has($key))
                    {
                  	$pop = $key; $val = session()->get($key);
                    }
                 }
              }
              
             ?> 

                 @if($pop != "" && $val != "")
                   @include('session-status',['pop' => $pop, 'val' => $val])
                 @endif

@if($user == null)
<!--------- Plugins: DO NOT EDIT ------>
<?php
foreach($plugins as $p)
{
?>
<!--{!! $p['value'] !!} -->
<?php
}
?>
<!------------------------------------->
@endif

</body>
</html>