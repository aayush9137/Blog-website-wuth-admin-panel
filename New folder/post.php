<?php
require('includes/db.php');
require('includes/function.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Blog</title>
    <style>
        .Feature{
            position: absolute;
            right:2px ;
        }
    </style>
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
  <?php
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
          <?php 
          $post_id=$_GET['id'];
        $postQuery="SELECT * FROM posts WHERE id=$post_id";
        $runPQ=mysqli_query($db,$postQuery);
        $post=mysqli_fetch_assoc($runPQ);
          ?>
            <div class="card mb-3">
                
                <div class="card-body">
                  <h5 class="card-title"><?=$post['title']?></h5>
                 
                  <span class="badge bg-primary ">Posted on <?=date('F jS, Y',strtotime($post['created_at']))?></small></span>
                  <span class="badge bg-danger"><?=getCategory($db,$post['category_id'])?></span>
                  <div class="border-bottom mt-3"></div>
   
<?php 
$post_images=getImagesByPost($db,$post['id']);


?>

<div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
  <div class="carousel-inner">
    <?php 
    $c=1;
foreach($post_images as $image){
  if($c>1){
    $sw = "";
  }else{
    $sw = "active";
  }
  ?>
 <div class="carousel-item <?=$sw?> ">
      <img src="images/<?=$image['image']?>" class="d-block w-100" alt="...">
    </div>
  <?php 
  $c++;
}
    ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!--    <img src="https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg" class="img-fluid mb-2 mt-2" alt="Responsive image"> -->


                  <p class="card-text"><?=$post['content']?>
                  </p>
                  <div class="sharethis-inline-share-buttons"></div>
                  <br>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Comment On This
</button>

                </div>
                </div>
        <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Your Comment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="includes/add_comment.php" method="post"> 
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="name" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp">
    
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Comment</label>
    <input type="text" class="form-control" name="comment" id="exampleInputPassword1">
  </div>
 <input type="hidden" name="post_id" value="<?=$post_id?>">
  <button type="submit" name="addcomment" class="btn btn-primary">Add Comment</button>
</form>
      </div>
      
    </div>
  </div>
</div>
        </div>
        <div>
    <h4>Related Posts</h4>
    <?php
    $pquery = "SELECT * FROM posts WHERE category_id={$post['category_id']} ORDER BY id DESC";
    $prun = mysqli_query($db, $pquery);
    while ($rpost = mysqli_fetch_assoc($prun)) {
        if ($rpost['id'] == $post_id) {
            continue;
        }
    ?>
    <div class="card mb-3" class="related-post-link">
    <a href="post.php?id=<?=$rpost['id']?>"  style="text-decoration:none;color:black">
                
                <div class="row g-0">
                    <div class="col-md-5" style="background-image: url('https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg');background-size: cover">
                        <!-- <img src="https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg" alt="..."> -->
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title"><?=$rpost['title']?></h5>
                            <p class="card-text text-truncate"><?=$rpost['content']?></p>
                            <p class="card-text"><small class="text-muted">Posted on <?=date('F jS, Y',strtotime($rpost['created_at']))?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    <?php 
    }
    ?>
        </div>

    </div>
      <?php include_once('includes/sidebar.php');
?>
    </div>
   <nav class="navbar navbar-expand-lg navbar-light bg-light border-top">
          <div class="container m-auto">
            <a href="#" class="m-auto" style="text-decoration: none;">Developed by Aayush Singh </a>
          </div>
        </nav>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> 
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=64bec2aa60781a00121c7f8b&product=inline-share-buttons' async='async'></script>   
</body>
</html>