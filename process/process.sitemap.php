<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once('../includes/constants.php');

$rss_txt = '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
$rss_txt.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xhtml="http://www.w3.org/1999/xhtml" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd http://www.google.com/schemas/sitemap-mobile/1.0/sitemap-mobile.xsd http://www.google.com/schemas/sitemap-video/1.1/sitemap-video.xsd" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>1.0</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'about-gold-mark-real-estate.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.5</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'gold-mark-real-estate-list-property.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.5</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'communities.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.6</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'gold-mark-real-estate-media.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.6</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'gold-mark-real-estate-career.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.5</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'contact-gold-mark-real-estate.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.5</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'gold-mark-real-estate-team.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.5</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'terms-and-conditions.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.3</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'privacy-policy.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.3</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'website-cookies.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.3</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'residentials-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'residentials-for-rent.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'commercials-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'commercials-for-rent.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'developments.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'beachfront-properties.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'waterfront-properties.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'green-nature-living.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'golf-course-properties.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'luxury-living-properties.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'apartments-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'villas-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'offices-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'shops-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'buildings-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'plots-for-sale.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'apartments-for-rent.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'villas-for-rent.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'offices-for-rent.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '<url>'.PHP_EOL;
$rss_txt.= '<loc>'.webhost.'shops-for-rent.html</loc>'.PHP_EOL;
$rss_txt.= '<lastmod>'.date("Y-m-d").'T'.date("H:i:s").'Z</lastmod>'.PHP_EOL;
$rss_txt.= '<changefreq>weekly</changefreq>'.PHP_EOL;
$rss_txt.= '<priority>0.8</priority>'.PHP_EOL;
$rss_txt.= '</url>'.PHP_EOL;

$rss_txt.= '</urlset>'.PHP_EOL;

$xml = "../sitemap_static.xml";

$fh = fopen($xml,'w');
//Write the XML nodes
fwrite($fh,$rss_txt);
//send the xml header to the browser
header("Content-Type:text/xml");
//output the XML data
echo $rss_txt;
?>
