<?php
// Prepare testimonials
$sql_testimonials = "SELECT caption, ";
$sql_testimonials.= "testimonial, ";
$sql_testimonials.= "full_name, ";
$sql_testimonials.= "ratings, ";
$sql_testimonials.= "photo ";
$sql_testimonials.= "FROM tbl_testimonials ";
$sql_testimonials.= "WHERE status = true ";
$sql_testimonials.= "AND deleted = false ";
$sql_testimonials.= "ORDER by RAND() ";
$sql_testimonials.= "LIMIT 9";

$result_testimonials = $conn->query($sql_testimonials);
?>
