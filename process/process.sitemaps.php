<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once('../includes/constants.php');
require_once(absolutedir.'config/connect.php');
require_once(absolutedir.'config/settings.php');
require_once(absolutedir.'includes/function.class.php');

// Prepare the listings
$sql_listings = "SELECT listing_id, ";
$sql_listings.= "location, ";
$sql_listings.= "sub_location, ";
$sql_listings.= "property, ";
$sql_listings.= "category, ";
$sql_listings.= "property_type, ";
$sql_listings.= "listing_type, ";
$sql_listings.= "title, ";
$sql_listings.= "page_title, ";
$sql_listings.= "building_status, ";
$sql_listings.= "updated_date ";
$sql_listings.= "FROM tbl_listings_portals ";
$sql_listings.= "WHERE listing_status = 'Available' ";
$sql_listings.= "AND permit_number != '' ";
$sql_listings.= "AND permit_expiry >= '".date('Y-m-d')."' ";
$sql_listings.= "AND deleted = false ";
$sql_listings.= "AND published = true ";
$sql_listings.= "AND images != '' ";
$sql_listings.= "ORDER by listing_id ASC";

$result_listings = $conn->query($sql_listings);

// Prepare the projects
$sql_projects = "SELECT project_id, ";
$sql_projects.= "title, ";
$sql_projects.= "location, ";
$sql_projects.= "sub_location, ";
$sql_projects.= "project, ";
$sql_projects.= "category, ";
$sql_projects.= "project_url, ";
$sql_projects.= "chk_url, ";
$sql_projects.= "updated_date ";
$sql_projects.= "FROM tbl_projects ";
$sql_projects.= "WHERE deleted = false ";
$sql_projects.= "AND published = true ";
//$sql_projects.= "AND image != '' ";
//$sql_projects.= "AND permit_number != '' ";
//$sql_projects.= "AND permit_expiry >= '".date('Y-m-d')."' ";
$sql_projects.= "ORDER by project_id ASC";

$result_projects 	= $conn->query($sql_projects);

// Prepare the members
$sql_members = "SELECT user_id, ";
$sql_members.= "full_name, ";
$sql_members.= "designation, ";
$sql_members.= "user_photo, ";
$sql_members.= "other_photo, ";
$sql_members.= "updated_date ";
$sql_members.= "FROM tbl_members ";
$sql_members.= "WHERE user_status = true ";
$sql_members.= "AND publish = true ";
$sql_members.= "AND blocked = false ";
$sql_members.= "ORDER by user_id ASC";

$result_members = $conn->query($sql_members);

// Prepare the news
$sql_news = "SELECT tbl_news.id, ";
$sql_news.= "tbl_news.title, ";
$sql_news.= "tbl_news.category, ";
$sql_news.= "tbl_news.images, ";
$sql_news.= "tbl_news.videos, ";
$sql_news.= "tbl_news.published_date, ";
$sql_news.= "tbl_news.updated_date, ";
$sql_news.= "tbl_news.inserted_date ";
$sql_news.= "FROM tbl_news ";
$sql_news.= "WHERE tbl_news.status = true ";
$sql_news.= "AND tbl_news.deleted = false ";
$sql_news.= "ORDER by tbl_news.published_date DESC";

$result_news = $conn->query($sql_news);

// Prepare the communities
$sql_communities = "SELECT community_id, ";
$sql_communities.= "title, ";
$sql_communities.= "headline, ";
$sql_communities.= "location, ";
$sql_communities.= "developer, ";
$sql_communities.= "description, ";
$sql_communities.= "image, ";
$sql_communities.= "updated_date ";
$sql_communities.= "FROM tbl_communities ";
$sql_communities.= "WHERE published = true ";
$sql_communities.= "AND deleted = false ";
$sql_communities.= "AND image != '' ";
$sql_communities.= "ORDER by location ASC";

$result_communities = $conn->query($sql_communities);

// Prepare vacancies
$sql_vacancies = "SELECT id, ";
$sql_vacancies.= "vacancy, ";
$sql_vacancies.= "address, ";
$sql_vacancies.= "image, ";
$sql_vacancies.= "details, ";
$sql_vacancies.= "updated_date ";
$sql_vacancies.= "FROM tbl_vacancy ";
$sql_vacancies.= "WHERE status = true ";
$sql_vacancies.= "ORDER by vacancy ASC";

$result_vacancies = $conn->query($sql_vacancies);

$rss_txt = '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
$rss_txt.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xhtml="http://www.w3.org/1999/xhtml" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd http://www.google.com/schemas/sitemap-mobile/1.0/sitemap-mobile.xsd http://www.google.com/schemas/sitemap-video/1.1/sitemap-video.xsd" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">'.PHP_EOL;

while($row_listings = $result_listings->fetch_assoc()){

	if(!empty($row_listings['page_title'])) {
    $page_title = $row_listings['page_title'];
  } else {
    $page_title = $row_listings['title'];
  }

	if($row_listings['category'] == 'Commercial') {
    $url_category = 'commercials';
  } else {
    $url_category = 'residentials';
  }
	if(in_array($row_listings['property_type'],$property_type_apartment)) {
    $url_type = 'apartments';
	} elseif(in_array($row_listings['property_type'],$property_type_villa)) {
		$url_type = 'villas';
	} elseif(in_array($row_listings['property_type'],$property_type_office)) {
		$url_type = 'offices';
  } elseif($row_listings['property_type'] == "Retail") {
    $url_type = 'shops';
	} elseif($row_listings['property_type'] == "Building") {
    $url_type = 'buildings';
	} elseif($row_listings['property_type'] == "Land") {
    $url_type = 'plots';
  } else {
		$url_type = 'apartments';
	}

	if(!empty($row_listings['building_name'])) {
    $listing_url = webhost.$url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['building_name'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
  } elseif(!empty($row_listings['property'])) {
    $listing_url = webhost.$url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['property'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
  } elseif(!empty($row_listings['sub_location'])) {
    $listing_url = webhost.$url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['sub_location'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
  } else {
    $listing_url = webhost.$url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
  }

	$listings_images = $conn->query("SELECT image_name, image_caption, watermark FROM tbl_images WHERE reference = '".$row_listings['listing_id']."' ORDER by image_order ASC");

	$rss_txt.= '<url>'.PHP_EOL;
	$rss_txt.= '<loc>'.$listing_url.'</loc>'.PHP_EOL;
	$rss_txt.= '<lastmod>'.date("Y-m-d", strtotime($row_listings['updated_date'])).'T'.date("H:i:s", strtotime($row_listings['updated_date'])).'Z</lastmod>'.PHP_EOL;
	$rss_txt.= '<changefreq>daily</changefreq>'.PHP_EOL;
	$rss_txt.= '<priority>0.7</priority>'.PHP_EOL;
	while($row_listings_images = $listings_images->fetch_assoc()) {
		$rss_txt.= '<image:image>'.PHP_EOL;
		$rss_txt.= '<image:loc>'.localhost.'images/listings/'.$row_listings['listing_id'].'/'.$row_listings_images['image_name'].'</image:loc>'.PHP_EOL;
		if(!empty($row_listings_images['image_caption'])) {
			$rss_txt.= '<image:title>'.encodeData($row_listings_images['image_caption']).'</image:title>'.PHP_EOL;
		} else {
			$rss_txt.= '<image:title>'.encodeData($page_title).'</image:title>'.PHP_EOL;
		}
  	$rss_txt.= '</image:image>'.PHP_EOL;
	}
	$rss_txt.= '</url>'.PHP_EOL;
	unset($listing_url,$url_category,$page_title,$listings_images,$row_listings_images);
}

while($row_projects = $result_projects->fetch_assoc()){

	$page_title = $row_projects['title'];

  if(!empty($row_projects['project'])) {
    $project_url = webhost."new-developments/".cleanString($row_projects['location'])."/".cleanString($row_projects['project'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
  } elseif(!empty($row_listings['sub_location'])) {
    $project_url = webhost."new-developments/".cleanString($row_projects['location'])."/".cleanString($row_projects['sub_location'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
  } else {
    $project_url = webhost."new-developments/".cleanString($row_projects['location'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
  }

	$project_images = $conn->query("SELECT image_name, caption, watermark FROM tbl_projects_images WHERE reference = '".$row_projects['project_id']."' ORDER by image_order ASC");

	$rss_txt.= '<url>'.PHP_EOL;
	$rss_txt.= '<loc>'.$project_url.'</loc>'.PHP_EOL;
	$rss_txt.= '<lastmod>'.date("Y-m-d", strtotime($row_projects['updated_date'])).'T'.date("H:i:s", strtotime($row_projects['updated_date'])).'Z</lastmod>'.PHP_EOL;
	$rss_txt.= '<changefreq>daily</changefreq>'.PHP_EOL;
	$rss_txt.= '<priority>0.7</priority>'.PHP_EOL;
	if(!empty($row_projects['image'])) {
		$rss_txt.= '<image:image>'.PHP_EOL;
  	$rss_txt.= '<image:loc>'.localhost.'images/developments/default/'.$row_projects['project_id'].'/'.$row_projects['image'].'</image:loc>'.PHP_EOL;
  	$rss_txt.= '<image:title>'.encodeData($page_title).'</image:title>'.PHP_EOL;
  	$rss_txt.= '</image:image>'.PHP_EOL;
	}
	while($row_project_images = $project_images->fetch_assoc()) {
		$rss_txt.= '<image:image>'.PHP_EOL;
		$rss_txt.= '<image:loc>'.localhost.'images/developments/'.$row_projects['project_id'].'/'.$row_project_images['image_name'].'</image:loc>'.PHP_EOL;
		if(!empty($row_project_images['caption'])) {
			$rss_txt.= '<image:title>'.encodeData($row_project_images['caption']).'</image:title>'.PHP_EOL;
		} else {
			$rss_txt.= '<image:title>'.encodeData($page_title).'</image:title>'.PHP_EOL;
		}
  	$rss_txt.= '</image:image>'.PHP_EOL;
	}
	$rss_txt.= '</url>'.PHP_EOL;
	unset($project_url,$page_title,$project_images,$row_project_images);
}

while($row_members = $result_members->fetch_assoc()){
	$rss_txt.= '<url>'.PHP_EOL;
	$rss_txt.= '<loc>'.webhost.'the-expert/'.cleanString($row_members['designation']).'/'.cleanString($row_members['full_name']).'-'.$row_manager['user_id'].'.html</loc>'.PHP_EOL;
	$rss_txt.= '<lastmod>'.date("Y-m-d", strtotime($row_members['updated_date'])).'T'.date("H:i:s", strtotime($row_members['updated_date'])).'Z</lastmod>'.PHP_EOL;
	$rss_txt.= '<changefreq>daily</changefreq>'.PHP_EOL;
	$rss_txt.= '<priority>1.00</priority>'.PHP_EOL;
	$rss_txt.= '</url>'.PHP_EOL;
}

while($row_news = $result_news->fetch_assoc()){
	$rss_txt.= '<url>'.PHP_EOL;
	$rss_txt.= '<loc>'.webhost.'media-room/'.cleanString($row_news['title']).'-'.$row_news['id'].'.html</loc>'.PHP_EOL;
	$rss_txt.= '<lastmod>'.date("Y-m-d", strtotime($row_news['updated_date'])).'T'.date("H:i:s", strtotime($row_news['updated_date'])).'Z</lastmod>'.PHP_EOL;
	$rss_txt.= '<news:news>'.PHP_EOL;
	$rss_txt.= '<news:publication>'.PHP_EOL;
	$rss_txt.= '<news:name>'.$row_news['category'].'</news:name>'.PHP_EOL;
	$rss_txt.= '<news:language>en</news:language>'.PHP_EOL;
	$rss_txt.= '</news:publication>'.PHP_EOL;
	$rss_txt.= '<news:publication_date>'.$row_news['published_date'].'</news:publication_date>'.PHP_EOL;
	$rss_txt.= '<news:title>'.encodeData($row_news['title']).'</news:title>'.PHP_EOL;
	$rss_txt.= '</news:news>'.PHP_EOL;
	$rss_txt.= '<changefreq>daily</changefreq>'.PHP_EOL;
	$rss_txt.= '<priority>0.7</priority>'.PHP_EOL;
	if(!empty($row_news['images'])) {
		$rss_txt.= '<image:image>'.PHP_EOL;
  	$rss_txt.= '<image:loc>'.localhost.'images/news/'.$row_news['id'].'/'.$row_news['images'].'</image:loc>'.PHP_EOL;
  	$rss_txt.= '<image:title>'.encodeData($row_news['title']).'</image:title>'.PHP_EOL;
  	$rss_txt.= '</image:image>'.PHP_EOL;
	}
	$rss_txt.= '</url>'.PHP_EOL;
}

while($row_communities = $result_communities->fetch_assoc()){
	if(!empty($row_communities['headline'])) {
     $page_communities_title = $row_communities['headline'];
  } else {
     $page_communities_title = decodeData($row_communities['location']). ' | Community Guide';
  }

	$communities_images = $conn->query("SELECT image_name, caption, watermark FROM tbl_communities_images WHERE reference = '".$row_communities['community_id']."' ORDER by image_order ASC");

	$rss_txt.= '<url>'.PHP_EOL;
	$rss_txt.= '<loc>'.webhost.'community-guides/'.cleanString($row_communities['location']).'/'.cleanString($page_communities_title).'-'.$row_communities['community_id'].'.html</loc>'.PHP_EOL;
	$rss_txt.= '<lastmod>'.date("Y-m-d", strtotime($row_communities['updated_date'])).'T'.date("H:i:s", strtotime($row_communities['updated_date'])).'Z</lastmod>'.PHP_EOL;
	$rss_txt.= '<changefreq>daily</changefreq>'.PHP_EOL;
	$rss_txt.= '<priority>0.7</priority>'.PHP_EOL;
	if(!empty($row_communities['image'])) {
		$rss_txt.= '<image:image>'.PHP_EOL;
		$rss_txt.= '<image:loc>'.localhost.'images/communities/default/'.$row_communities['community_id'].'/'.$row_communities['image'].'</image:loc>'.PHP_EOL;
		$rss_txt.= '<image:title>'.encodeData($page_communities_title).'</image:title>'.PHP_EOL;
		$rss_txt.= '</image:image>'.PHP_EOL;
	}
	while($row_communities_images = $communities_images->fetch_assoc()) {
		$rss_txt.= '<image:image>'.PHP_EOL;
		$rss_txt.= '<image:loc>'.localhost.'images/communities/'.$row_communities['community_id'].'/'.$row_communities_images['image_name'].'</image:loc>'.PHP_EOL;
		if(!empty($row_communities_images['caption'])) {
			$rss_txt.= '<image:title>'.encodeData($row_communities_images['caption']).'</image:title>'.PHP_EOL;
		} else {
			$rss_txt.= '<image:title>'.encodeData($page_communities_title).'</image:title>'.PHP_EOL;
		}
		$rss_txt.= '</image:image>'.PHP_EOL;
	}
	$rss_txt.= '</url>'.PHP_EOL;
	unset($page_communities_title,$communities_images,$row_communities_images);
}

while($row_vacancies = $result_vacancies->fetch_assoc()){
	$rss_txt.= '<url>'.PHP_EOL;
	$rss_txt.= '<loc>'.webhost.'vacancies/'.cleanString($row_vacancies['vacancy']).'-'.$row_vacancies['id'].'.html</loc>'.PHP_EOL;
	$rss_txt.= '<lastmod>'.date("Y-m-d", strtotime($row_vacancies['updated_date'])).'T'.date("H:i:s", strtotime($row_vacancies['updated_date'])).'Z</lastmod>'.PHP_EOL;
	$rss_txt.= '<changefreq>daily</changefreq>'.PHP_EOL;
	$rss_txt.= '<priority>0.7</priority>'.PHP_EOL;
	if(!empty($row_vacancies['image'])) {
		$rss_txt.= '<image:image>'.PHP_EOL;
  	$rss_txt.= '<image:loc>'.localhost.'images/vacancies/'.$row_vacancies['id'].'/'.$row_vacancies['image'].'</image:loc>'.PHP_EOL;
  	$rss_txt.= '<image:title>'.encodeData($row_vacancies['vacancy']).'</image:title>'.PHP_EOL;
  	$rss_txt.= '</image:image>'.PHP_EOL;
	}
	$rss_txt.= '</url>'.PHP_EOL;
}

$rss_txt.= '</urlset>'.PHP_EOL;

$xml = "../sitemap_dynamic.xml";

$fh = fopen($xml,'w');
//Write the XML nodes
fwrite($fh,$rss_txt);
//send the xml header to the browser
header("Content-Type:text/xml");
//output the XML data
echo $rss_txt;

// Close database connection
$conn->close();
?>
