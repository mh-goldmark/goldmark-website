<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("../includes/constants.php");	// Page constants
require_once(absolutedir."config/connect.php");					// Connect to the database and table
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");

// Prepare the news articles
$sql_articles = "SELECT tbl_news.id, ";
$sql_articles.= "tbl_news.title, ";
$sql_articles.= "tbl_news.sub_title, ";
$sql_articles.= "tbl_news.tags, ";
$sql_articles.= "tbl_news.category, ";
$sql_articles.= "tbl_news.details, ";
$sql_articles.= "tbl_news.images, ";
$sql_articles.= "tbl_news.published_date, ";
$sql_articles.= "tbl_news.source, ";
$sql_articles.= "tbl_news.editor, ";
$sql_articles.= "tbl_news.status ";
$sql_articles.= "FROM tbl_news ";
$sql_articles.= "WHERE tbl_news.status = true ";
$sql_articles.= "AND tbl_news.deleted = false ";
$sql_articles.= "AND tbl_news.images != '' ";
if($_POST['topic'] != 'All') {
  $sql_articles.= "AND tbl_news.category LIKE '%".encodeData($_POST['topic'])."%' ";
}
$sql_articles.= "ORDER by tbl_news.published_date DESC";

$result_articles = $conn->query($sql_articles);

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
      <h3 class="title mt-1 line-wrapper two-lines">
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
<?php
// Close database connection
$conn->close();
?>
