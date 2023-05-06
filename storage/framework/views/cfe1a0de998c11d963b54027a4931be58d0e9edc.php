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
    <title><?php echo $__env->yieldContent('title'); ?> | Sender</title>

    <link rel="canonical" href="<?php echo e(url('/')); ?>">

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
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
      <?php echo $__env->make('sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <!--------- Input errors -------------->
          <?php if(count($errors) > 0): ?>
                          <?php echo $__env->make('input-errors', ['errors'=>$errors], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     <?php endif; ?> 
		  
		  <?php echo $__env->yieldContent('content'); ?>
      </main>
  </div>
</div>
<!-- Script -->
<script type="text/javascript" src="js/modernizr-2.0.6.js"></script><!-- Modernizr -->
<script type="text/javascript" src="js/jquery-2.2.2.js"></script><!-- jQuery -->
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script><!-- Bootstrap -->
<script src="js/mmm.js?ver=<?php echo e(rand(12454494,2237347438)); ?>"></script>
<script src="js/helpers.js?ver=<?php echo e(rand(12454494,2237347438)); ?>"></script>

<!--SweetAlert JS--> 
<script src="lib/sweet-alert/sweetalert2.js"></script>

<!--Datatables JS--> 
<script src="lib/datatables/datatables.min.js"></script>

<?php echo $__env->yieldContent('scripts'); ?>

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

                 <?php if($pop != "" && $val != ""): ?>
                   <?php echo $__env->make('session-status',['pop' => $pop, 'val' => $val], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                 <?php endif; ?>

<?php if($user == null): ?>
<!--------- Plugins: DO NOT EDIT ------>
<?php
foreach($plugins as $p)
{
?>
<?php echo $p['value']; ?>

<?php
}
?>
<!------------------------------------->
<?php endif; ?>

</body>
</html><?php /**PATH C:\repos\ob-sender-new\resources\views/layout.blade.php ENDPATH**/ ?>