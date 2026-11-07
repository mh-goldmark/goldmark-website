<?php
/********************************************************
Copyright © 2025 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once('../includes/constants.php');

$rss_txt = '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
$rss_txt.= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
$rss_txt.= '<sitemap>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'sitemap_static.xml</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '</sitemap>'.PHP_EOL;
$rss_txt.= '<sitemap>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'sitemap_dynamic.xml</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '</sitemap>'.PHP_EOL;
$rss_txt.= '</sitemapindex>'.PHP_EOL;

$xml = "../sitemap_index.xml";

$fh = fopen($xml,'w');
//Write the XML nodes
fwrite($fh,$rss_txt);
//send the xml header to the browser
header("Content-Type:text/xml");
//output the XML data
echo $rss_txt;
?>
