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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>BLOG WEBSITE</title>
</head>
<body>
   <?php include_once('includes/navbar.php'); ?> 
<div>
    <div class="container m-auto mt-3 row">
        <div class="col-8">

        <?php 
        if (isset($_GET['search'])) {
          $keyword = $_GET['search'];
        $postQuery="SELECT * FROM posts WHERE title LIKE '%$keyword%' ORDER BY id DESC LIMIT $result,$post_per_page";
        }else{
          $postQuery="SELECT * FROM posts ORDER BY id DESC LIMIT $result,$post_per_page";

        }
        $runPQ=mysqli_query($db,$postQuery);
        while($post=mysqli_fetch_assoc($runPQ)){
          ?>

<div class="card mb-3" style="max-width: 800px;">
<a href="post.php?id=<?=$post['id']?>" style="text-decoration:none;color:black">
            <div class="row g-0">
              <div class="col-md-5" style="background-image: url('images/<?getPostThumb($db,$post['id'])?>');background-size: cover">
                 <img src="data:image/jpeg;base64,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" alt="..."> 
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title"><?=$post['title']?></h5>

                  <p class="card-text text-truncate"><?=$post['content']?></p>
                  <p class="card-text"><small class="text-muted">Posted on <?=date('F jS,Y',strtotime($post['created_at']))?></small></p>
                </div>
              </div>
            </div>
</a>
          </div>
<?php 
        }
        ?>
        
          
    </div>
    <?php include_once('includes/sidebar.php'); ?>
    </div>
<?php 
 if (isset($_GET['search'])) {
  $keyword =$_GET['search'];
  $q="SELECT * FROM posts WHERE title LIKE '%$keyword%'";
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
          <?php
        if($page>1){
          $switch="";
        }else{
          $switch="disabled";
        }
        if($page<$total_pages){
          $nswitch="";
        }else{
          $nswitch="disabled";
        }
          ?>
          
          <li class="page-item <?=$switch?>">
            <a class="page-link" href="?<?php if(isset($_GET['search'])){ echo"search=$keyword&";}?>page=<?=$page-1?>" tabindex="-1" aria-disabled="true">Previous</a>
          </li>
          <?php 
    for ($opage = 1; $opage<=$total_pages;$opage++) {
?>
      <li class="page-item "><a class="page-link" href="?<?php if (isset($_GET['search'])) { echo "search=$keyword&"; } ?>page=<?=$opage?>"><?=$opage?></a></li>

<?php
    }
?>
          
          <li class="page-item <?=$nswitch?>">
            <a class="page-link" href=" ?<?php  if (isset($_GET['search'])) { echo "search=$keyword&"; } ?>page=<?=$page+1?>">Next</a>
          </li>
        </ul>
      </nav>
      
      
      <?php include_once('includes/footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>    
</body>
</html>