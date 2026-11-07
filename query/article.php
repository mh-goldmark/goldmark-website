<?php
// Prepare the article
$sql_article = "SELECT tbl_news.id, ";
$sql_article.= "tbl_news.title, ";
$sql_article.= "tbl_news.sub_title, ";
$sql_article.= "tbl_news.tags, ";
$sql_article.= "tbl_news.category, ";
$sql_article.= "tbl_news.details, ";
$sql_article.= "tbl_news.images, ";
$sql_article.= "tbl_news.videos, ";
$sql_article.= "tbl_news.source, ";
$sql_article.= "tbl_news.editor, ";
$sql_article.= "tbl_news.published_date ";
$sql_article.= "FROM tbl_news ";
$sql_article.= "WHERE tbl_news.id = '".$_GET['id']."' ";
$sql_article.= "AND tbl_news.status = true ";
$sql_article.= "AND tbl_news.deleted = false ";
$sql_article.= "AND tbl_news.images != '' ";
$sql_article.= "LIMIT 1";

$result_article = $conn->query($sql_article);
$row_article = $result_article->fetch_assoc();
