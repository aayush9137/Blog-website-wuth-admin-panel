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
    <title>Blog website with admin panel</title>
    <style>
        .Feature{
            position: absolute;
            right:2px ;
        }
    </style>
</head>
<body>
<?php include_once('includes/navbar.php'); ?> 

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
                    <div class="col-md-5" style="background-image: url();background-size: cover">
                        <img src="data:image/jpeg;base64,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" alt="..."> 
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