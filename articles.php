<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
require_once(absolutedir."query/media.php");
?>
<?php if($result_articles->num_rows >= 1) { ?>
<?php while($row_articles = $result_articles->fetch_assoc()) { ?>
<div class="col-sm-6 col-lg-4 items-listings">
  <div class="blog-style1">
    <div class="blog-img">
      <a href="media-room/<?php echo cleanString($row_articles['title'])."-".$row_articles['id']; ?>.html" title="<?php echo decodeData($row_articles['title']); ?>">
        <img class="w-100" src="<?php echo localhost.'images/news/'.$row_articles['id'].'/'.$row_articles['images']; ?>" alt="<?php echo decodeData($row_articles['title']); ?>">
      </a>
    </div>
    <div class="blog-content">
      <div class="date">
        <span class="month">
          <?php echo date("M", strtotime($row_articles['published_date'])); ?>
        </span>
        <span class="day">
          <?php echo date("d", strtotime($row_articles['published_date'])); ?>
        </span>
      </div>
      <h3 class="title mt15 line-wrapper two-lines">
        <a href="media-room/<?php echo cleanString($row_articles['title'])."-".$row_articles['id']; ?>.html" title="<?php echo decodeData($row_articles['title']); ?>">
          <?php echo decodeData($row_articles['title']); ?>
        </a>
      </h3>
      <div class="keywords-tags">
        <?php $categories = explode(",",$row_articles['category']); ?>
        <?php foreach($categories as $category) { ?>
        <?php if(!empty($category)) { ?>
        <span class="tag">
          <?php echo decodeData($category); ?>
        </span>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php } else { ?>
  <div class="col-12 no_result text-center">
    <p><?php echo $search_result_text; ?></p>
  </div>
<?php } ?>

<div class="clearfix"></div>

<?php if($page != $chk_count) { ?>
<div class="infinite-paging">
  <a class="jscroll-next button" href="articles.php?page=<?php echo ($page + 1); ?>">
    <span class="flaticon-new-tab"></span>
    Load More
  </a>
</div>
<?php } ?>
<?php $conn->close(); ?>
