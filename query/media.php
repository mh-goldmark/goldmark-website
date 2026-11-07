<?php
if(!empty($_GET["page"])) {
	$page = $_GET["page"];
} else {
	$page = 1;
}
$limit 		  = $page_views;
$startpoint = ($page * $limit) - $limit;

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
$sql_articles.= "ORDER by tbl_news.published_date DESC ";
$sql_articles.= "LIMIT ".$startpoint.", ".$limit;

$result_articles = $conn->query($sql_articles);

// Count the total articles
$sql_count_articles = "SELECT COUNT(*) as total ";
$sql_count_articles.= "FROM tbl_news ";
$sql_count_articles.= "WHERE tbl_news.status = true ";
$sql_count_articles.= "AND tbl_news.deleted = false ";
$sql_count_articles.= "AND tbl_news.images != '' ";

$count      = $conn->query($sql_count_articles);
$total 	    = $count->fetch_assoc();
$chk_count 	= ceil($total['total']/$limit);

// Prepare topics
$sql_topics = "SELECT tbl_news.category ";
$sql_topics.= "FROM tbl_news ";
$sql_topics.= "WHERE tbl_news.status = true ";
$sql_topics.= "AND tbl_news.deleted = false ";
$sql_topics.= "AND tbl_news.images != '' ";

$result_topics = $conn->query($sql_topics);
?>
