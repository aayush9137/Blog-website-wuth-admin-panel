<?php
require('includes/db.php');
include('includes/function.php');

if (isset($_GET['page'])) {
  $page = $_GET['page'];
  if ($page < 1) {
    $page = 1;
  }
} else {
  $page = 1;
}

$post_per_page = 5;
$result = ($page - 1) * $post_per_page;

if (isset($_GET['search'])) {
  $keyword = $_GET['search'];
  $postQuery = "SELECT * FROM posts WHERE title LIKE '%$keyword%' ORDER BY id DESC LIMIT $result, $post_per_page";
} else {
  $postQuery = "SELECT * FROM posts ORDER BY id DESC LIMIT $result, $post_per_page";
}

$runPQ = mysqli_query($db, $postQuery);

$total_posts = mysqli_num_rows(mysqli_query($db, "SELECT * FROM posts"));
$total_pages = ceil($total_posts / $post_per_page);

$nswitch_prev = ($page == 1) ? "disabled" : ""; // Disable previous button on first page
$nswitch_next = ($page >= $total_pages) ? "disabled" : ""; // Disable next button on last page
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <title>Blog</title>
</head>

<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="#">My Blog</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
<?php 
$navQuery = "SELECT * FROM menu";
$runNav=mysqli_query($db,$navQuery);
while($menu=mysqli_fetch_assoc($runNav)){
  $no = getSubMenuNo($db,$menu['id']);
  if(!$no){
    ?>

<li class="nav-item">
  <a class="nav-link" aria-current="page" href="<?=$menu['action']?>"><?=$menu['name']?></a>

</li>
<?php 
  }else{
   ?>
 <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="<?=$menu['action']?>
" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?=$menu['name']?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
      <?php 
    $submenus = getSubMenu($db,$menu['id']);
    foreach($submenus as $sm){
?>
 
  <li><a class="dropdown-item" href="<?=$sm['action']?>"><?=$sm['name']?></a></li>
      
  
<?php
    }
      ?>
    
<?php 
  }
  ?>
  <? 
}
?>
    </ul>
</li>
 <form class="d-flex">
              <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    
      
      <div>
<div class="container m-auto mt-3 row">
    <div class="col-8">
      <? 
      while ($post = mysqli_fetch_assoc($runPQ)) {
      ?>
        <div class="card mb-3" style="max-width: 800px;">
          <a href="post. ?id=<?= $post['id'] ?>" style="text-decoration:none;color:black">
            <div class="row g-0">
              <div class="col-md-5" style="background-image: url('https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg');background-size: cover"></div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title"><?= $post['title'] ?></h5>
                  <p class="card-text text-truncate"><?= $post['content'] ?></p>
                  <p class="card-text"><small class="text-muted">Posted on <?= date('F jS, Y', strtotime($post['created_at'])) ?></small></p>
                </div>
              </div>
            </div>
          </a>
        </div>
      <? 
      } if (isset($_GET['search'])) {
        $keyword = $_GET['search'];
        $q = "SELECT * FROM posts WHERE title LIKE '%$keyword%'";
      }
      else{
        $q="SELECT * FROM posts";
      }
      $r = mysqli_query($db, $q);

$total_posts = mysqli_num_rows($r);
$total_pages = ceil($total_posts / $post_per_page);

      ?>

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item <?= $nswitch_prev ?>">
      <a class="page-link" href="?<?  if (isset($_GET['search'])) { echo "search=$keyword&"; } ?>page=<?= $page - 1 ?>" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
    <? 
    for ($opage = 1; $opage <= $total_pages; $opage++) {
    ?>
      <li class="page-item"><a class="page-link" href="?<?  if (isset($_GET['search'])) { echo "search=$keyword&"; } ?>page=<?= $opage ?>"><?= $opage ?></a></li>
    <?php
    }
    ?>
    <li class="page-item <?= $nswitch_next ?>"><a class="page-link" href="?<?php if (isset($_GET['search'])) { echo "search=$keyword&"; } ?>page=<?= $page + 1 ?>">Next</a></li>
  </ul>
</nav>

    </div>
 
    <?php include_once('includes/sidebar.php'); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-top">
      <div class="container m-auto">
        <a href="#" class="m-auto" style="text-decoration: none;">Developed by Aayush Singh</a>
      </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>
