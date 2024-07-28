<?php
require('../includes/db.php');
require('../includes/function.php');
if (!isset($_SESSION['isUserloggedIn'])) {
    header('Location:login.php');

}
$admin=getAdminInfo($db, $_SESSION['email']); // Assign the result to the $admin variable
?>


<!DOCTYPE html>
<html lang="en"> 

<head>      
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MyBlog-Admin panel</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">CONTROL CENTRE</span>
      </a>
    </div><!-- End Logo -->

   

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        
        </li><!-- End Search Icon-->

        <li class="dropdown">
         <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <span class="username"><?=$admin['full-name']?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Aayush Singh</h6>
              <span>Web Developer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
             
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../includes/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
</body>

  <!-- ======= Sidebar ======= -->
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>MyBlog-Admin panel</title>

    <!-- Include Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include your custom CSS if needed -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Include CKEditor from CDN -->
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>

    <!-- Add any additional styles or scripts here -->
    <style>
        .button-gap {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="active">
                <a class="nav-link active" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Add Post</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" d href="index.php?managepost">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Manage Post</span>
                </a>
               
            </li>
            
            <li class="active">
                <a class="nav-link" href="index.php?managecategory">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Manage Category</span>
                </a>
               
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?managemenu">
                    <i class="bi bi-bar-chart"></i>
                    <span>Manage Menu</span>
                </a>
                
            </li>
        </ul>
    </aside>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <section id="main-content">
      <section class="wrapper">
    <main id="main" class="main">
            <div class="row">
             <?php

             if(isset($_GET['managepost'])){
                ?>
<div class="col-lg-12">
  <h5 class="card-title font-weight-bold">Posts
<html lang="en">

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th> Post Title </th>
            <th> Post Category </th>
            <th>Post Date</th>
            <th>Action</th>
        
            
        </tr>
    </thead>
    <tbody>
    <?php 
 $posts = getAllPosts($db);
 $count=1;
 foreach($posts as $post){
?>

<tr>
            <td><?=$count?></td>
            <td><?=$post['title']?></td>

            <td><?=getCategory($db,$post['category_id'])?></td>
            <td><?=date('F jS,Y',strtotime($post['created_at']))?></td>

           
            <td >
              <div class="btn-group">
                
                <a href="../includes/removepost.php?id=<?=$post['id']?>" class="btn btn-danger">Remove</a>
              </div>
            </td>
        </tr>

<?php
$count++;
 }
?>
    
        <!-- Add more rows with user data as needed -->
    </tbody>
</table>
<?php

             }else if(isset($_GET['managemenu'])){
              ?>

<div class="col-lg-12">
  <h5 class="card-title font-weight-bold">Menu --
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>    Add New Menu
</title>

    <!-- Add Bootstrap CSS (make sure to include Bootstrap and jQuery libraries) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Button to trigger the modal -->
<button type="button" class="text-primary" data-toggle="modal" href="#myModal">
    Add New Menu
</button>
<a>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <label class="modal-title">Add New Menu </label>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form role="form" method="post" action="../includes/addmenu.php">
                    <div class="form-group">
                        <label for="email">Menu Title:</label>
                        <input type="text" name="menu_name" class="form-control" id="email" placeholder="Enter Menu Name...">
                    </div>
                    <div class="form-group">
                        <label for="email">Menu Link:</label>
                        <input type="text" name="menu_link" class="form-control" id="email" value="#" placeholder="Enter Menu Link...">
                    </div>
                
            
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <!-- Add JavaScript to trigger the form submission -->
                <button type="submit" name="addmenu" class="btn btn-primary" id="addCategoryBtn">Add</button>
             </form>
            </div>
            </div>
        </div>
    </div>


<script>
    // Add an event listener to the "Add" button
    document.getElementById('addCategoryBtn').addEventListener('click', function () {
        // Submit the form when the button is clicked
        document.querySelector('form').submit();
    });
</script>


<!-- Add Bootstrap JS (make sure to include Bootstrap and jQuery libraries) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
</h5>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th> Menu </th>
            <th>Link</th>
            <th>Action</th>
        
            
        </tr>
    </thead>
    <tbody>
    <?php 
 $menus = getmenu($db);
 $count=1;
 foreach($menus as $menu){
?>

<tr>
            <td><?=$count?></td>
            <td><?=$menu['name']?></td>
            <td><?=$menu['action']?></td>

           
            <td >
              <div class="btn-group">
                
                <a href="../includes/removemenu.php?id=<?=$menu['id']?>" class="btn btn-danger">Remove</a>
              </div>
            </td>
        </tr>

<?php
$count++;
 }
?>
    
        <!-- Add more rows with user data as needed -->
    </tbody>
</table>


<div class="col-lg-12">
  <h5 class="card-title font-weight-bold">SubMenu -- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>    Add New SubMenu
</title>

    <!-- Add Bootstrap CSS (make sure to include Bootstrap and jQuery libraries) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<button type="button" class="text-primary" data-toggle="modal" href="#myModal1">
    Add New Submenu
</button></a>

<!-- Modal -->
<div class="modal fade" id="myModal1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <label class="modal-title">Add New SubMenu</label>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form role="form" method="post" action="../includes/addmenu.php">
                    <div class="form-group">
                        <label for="email">SubMenu Title:</label>
                        <input type="text" name="submenu-name" class="form-control" id="email" placeholder="Enter Menu Name...">
                    </div>
                    <div class="form-group">
                        <label for="email">Select Parent menu:</label>
                        <select name="parent-id" class="form-control" id="email" >
                            <?php
$mlist = getAllmenu($db);
foreach($mlist as $m){

    ?>
<option value="<?=$m['id']?>"><?=$m['name']?></option>
    <?php
}

?>
   </select>
                    </div>
            
                    <div class="form-group">
                        <label for="email">SubMenu Link:</label>
                        <input type="text" name="submenu-link" class="form-control" id="email" value="#" placeholder="Enter Menu Link...">
                    </div>
        
                <!-- Add JavaScript to trigger the form submission -->
                <button type="submit" name="addsmenu" class="btn btn-primary" id="addCategoryBtn">Add</button>
              </form>
</div>
        </div>
    </div>
</div>

<script>
    // Wrap your code in a document ready function
        // Add an event listener to the "Add" button
        document.getElementById('addCategoryBtn').addEventListener('click', function () {
            // Submit the form when the button is clicked
            document.querySelector('form').submit();
        });
</script>



<!-- Add Bootstrap JS (make sure to include Bootstrap and jQuery libraries) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
</h5>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th> Sub Menu </th>
            <th> Parent Menu </th>
            <th>Link</th>
            <th>Action</th>  
        </tr>
    </thead>
    <tbody>
    <?php 
 $smenus = getAllsmenu($db);
 $count=1;
 foreach($smenus as $menu){
?>

<tr>
            <td><?=$count?></td>
            <td><?=$menu['name']?></td>
            <td><?=getMenuName($db,$menu['parent_menu_id'])?></td>
            <td><?=$menu['action']?></td>

           
            <td >
              <div class="btn-group">
                
                <a href="../includes/removesubmenu.php?id=<?=$menu['id']?>" class="btn btn-danger">Remove</a>
              </div>
            </td>
        </tr>

<?php
$count++;
 }
?>
    
        <!-- Add more rows with user data as needed -->
    </tbody>
</table>
<?Php

             }
             else if(isset($_GET['managecategory'])){
  ?><div class="col-lg-12">
  <h5 class="card-title font-weight-bold">Category -- <!DOCTYPE html>
<html lang="en">
      <!-- Add Bootstrap CSS (make sure to include Bootstrap and jQuery libraries) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Button to trigger the modal -->
<button type="button" class="text-primary" data-toggle="modal" href="#myModal">
    Add New Category
</button>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
           <!-- Modal body -->
<div class="modal-body">
    <form role="form" method="post" action="../includes/addct.php">
        <div class="form-group">
            <label for="category-name">Category Name:</label>
            <input type="text" name="category_name" class="form-control" id="category-name" placeholder="Enter Category...">
        </div>
        <!-- Add a hidden input for the 'addct' key to be sent -->
                <button type="submit" name="addct" class="btn btn-primary" id="addCategoryBtn">Add</button>
    </form>
</div>
        </div>
    </div>
</div>

<script>
    // Add an event listener to the "Add" button
    document.getElementById('addCategoryBtn').addEventListener('click', function () {
        // Submit the form when the button is clicked
        document.querySelector('form').submit();
    });
</script>


<!-- Add Bootstrap JS (make sure to include Bootstrap and jQuery libraries) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
</h5>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Category NAme </th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>
    <?php 
 $categories = getAllCategory($db);
 $count=1;
 foreach($categories as $ct){
?>

<tr>
    <td><?=$count?></td>
            <td><?=$ct['name']?></td>
           
            <td >
              <div class="btn-group">
                
                <a class="btn btn-danger" href="../includes/removect.php?id=<?=$ct['id']?>">Remove</a>
              </div>
            </td>
        </tr>

<?php
$count++;
 }
?>
    <!-- Add more rows with user data as needed -->
    </tbody>
</table>

<?php

}else{
  ?>
  <div class="col-lg-12">
                    <h5 class="card-title">Add Post</h5>
                    <form action="../includes/addpost.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label for="post-title">Post Title</label>
                            <input type="text" class="form-control" id="post-title" name="post_title">
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-sm-12">
                           <label for="post-content text-truncate">Post Content</label>

                            <textarea id="editor" name="post_content"></textarea>
                        </div>
                        </div>

                        <div class="row">
                            
                            <div class="form-group col-md-6">
                                <label for="post-category">Select Post Category</label>
                                <select name="post_category" class="form-control" id="post-category">
                                    <?php
                                    // Replace this with actual category data retrieval
                                    $categories = getAllCategory($db);
                                    foreach ($categories as $ct) {
                                        ?>
                                        <option value="<?=$ct['id']?>"><?=$ct['name']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="post-category">Upload photo (max 5)</label>
                                <input type="file" class="form-control" name="post_image[]" accept="image/*" multiple/>
                            </div>
                        </div>
                        <div class="col-md-12 button-gap">
                            <input type="submit" name="addpost" class="btn btn-primary" value="Add Post">
                        </div>
                    </form>
                </div>
  <?php
}
?>
</div>

            
            
       
    <!-- End Main Content -->


    <!-- Vendor JS Files (Bootstrap) -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Initialize CKEditor after the textarea -->
    <script>
        // Replace 'editor' with the ID of your textarea element
        CKEDITOR.replace('editor');
    </script>
    
</body>
</html>
