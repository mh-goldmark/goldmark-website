<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");					
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
require_once(absolutedir."query/communities.php");
?>
<?php if($result_communities->num_rows >= 1) { ?>
<?php while($row_communities = $result_communities->fetch_assoc()) { ?>
  <?php
  if(!empty($row_communities['headline'])) {
     $page_communities_title = $row_communities['headline'];
  } else {
     $page_communities_title = decodeData($row_communities['location']). ' | Community Guide';
  }
  ?>
  <div class="col-sm-6 col-lg-4 items-listings">
    <div class="blog-style1">
      <div class="blog-img">
        <a href="community-guides/<?php echo cleanString($row_communities['location']); ?>/<?php echo cleanString($page_communities_title)."-".$row_communities['community_id']; ?>.html" title="<?php echo decodeData($page_communities_title); ?>" style="background-image: url('<?php echo localhost.'images/communities/thumbnails/'.$row_communities['community_id'].'/'.$row_communities['image']; ?>');">
        </a>
      </div>
      <div class="blog-content">
        <h3 class="title mt10">
          <a href="community-guides/<?php echo cleanString($row_communities['location']); ?>/<?php echo cleanString($page_communities_title)."-".$row_communities['community_id']; ?>.html" title="<?php echo decodeData($page_communities_title); ?>">
            <?php echo decodeData($row_communities['location']); ?>
          </a>
        </h3>
        <h4>
          <?php if(!empty($row_communities['community_name'])) { echo decodeData($row_communities['community_name']); } else { echo '-'; } ?>
        </h4>
      </div>
    </div>
  </div>
  <?php unset($page_communities_title); ?>
  <?php } ?>
<?php } else { ?>
  <div class="col-12 no_result text-center">
    <p><?php echo $search_result_text; ?></p>
  </div>
<?php } ?>

<div class="clearfix"></div>

<?php if($page != $chk_count) { ?>
<div class="infinite-paging">
  <a class="jscroll-next button" href="areas.php?page=<?php echo ($page + 1); ?>">
    <span class="flaticon-new-tab"></span>
    Load More
  </a>
</div>
<?php } ?>
<?php $conn->close(); ?>
