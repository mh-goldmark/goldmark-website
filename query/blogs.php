<?php
// Prepare the blogs
$sql_blogs = "SELECT tbl_news.id, ";
$sql_blogs.= "tbl_news.title, ";
$sql_blogs.= "tbl_news.published_date, ";
$sql_blogs.= "tbl_news.source, ";
$sql_blogs.= "tbl_news.editor, ";
$sql_blogs.= "tbl_news.images ";
$sql_blogs.= "FROM tbl_news ";
$sql_blogs.= "WHERE tbl_news.status = true ";
$sql_blogs.= "AND tbl_news.deleted = false ";
$sql_blogs.= "AND tbl_news.images != '' ";
if(!empty($row_article['id'])) {
  $sql_blogs.= "AND tbl_news.id != '".$row_article['id']."' ";
}
$sql_blogs.= "ORDER by tbl_news.published_date DESC ";
$sql_blogs.= "LIMIT 9";

$result_blogs = $conn->query($sql_blogs);
?>
