<script type="text/javascript">
var nooGmapL10n = {
  "latitude"                : "<?php echo $geolatitude; ?>",
  "longitude"               : "<?php echo $geolongitude; ?>",
  "maxZoom_MarkerClusterer" : "10",
  "zoom"                    : "13",
  "default_label"           : "",
  "fullscreen_label"        : "",
  "no_geolocation_pos"      : "The browser couldn't detect your position!",
  "no_geolocation_msg"      : "Geolocation is not supported by this browser.",
  "markers": [
    <?php $i = 1; ?>
    <?php while($row_projects = $result_projects->fetch_assoc())	{

      if(!empty($row_projects['coordinates'])) {
        $coordinates = explode(',',$row_projects['coordinates']);
      }

      $page_title = $row_projects['title'];

      if(!empty($row_projects['project'])) {
        $project_url = "new-developments/".cleanString($row_projects['location'])."/".cleanString($row_projects['project'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
        $project_caption = decodeData($row_projects['project']);
      } elseif(!empty($row_listings['sub_location'])) {
        $project_url = "new-developments/".cleanString($row_projects['location'])."/".cleanString($row_projects['sub_location'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
        $project_caption = decodeData($row_project['sub_location']);
      } else {
        $project_url = "new-developments/".cleanString($row_projects['location'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
        $project_caption = decodeData($row_projects['location']);
      }

      if(!empty($row_projects['project'])) {
        $location = decodeData($row_projects['project']);
      } elseif(!empty($row_projects['sub_location'])) {
        $location = decodeData($row_projects['sub_location']);
      } else {
        $location = decodeData($row_projects['location']);
      }

      $image = localhost.'images/developments/thumbnails/'.$row_projects['project_id'].'/'.$row_projects['image'];

      if($row_projects['completion'] != '0000-00-00') {
        $completion = 'Q'.date_quarter($row_projects['completion']).', '.date("Y", strtotime($row_projects['completion']));
      } else {
        $completion = '-';
      }

      $icon = webhost."images/icons/marker-icon.png";

      ?>
      {
        "latitude"   : "<?php echo $coordinates[0]; ?>",
        "longitude"  : "<?php echo $coordinates[1]; ?>",
        "image"      : "<?php echo $image; ?>",
        "caption"    : "<?php echo $project_caption; ?>",
        "price"      : "",
        "size_price" : "",
        "location"   : "<?php echo $location; ?>",
        "category"   : "Project",
        "developer"  : "<?php echo decodeData($row_projects['developer']); ?>",
        "completion" : "<?php echo $completion; ?>",
        "title"      : "<?php echo $page_title; ?>",
        "refno"      : "",
        "class"      : "",
        "type"       : "<?php echo decodeData($row_projects['sub_type']); ?>",
        "bedroom"    : "",
        "bathroom"   : "",
        "size"       : "",
        "url"        : "<?php echo $project_url; ?>",
        "icon"       : "<?php echo $icon; ?>"
      }<?php if($i++ < $result_projects->num_rows) { echo ','; } ?>
        <?php unset($coordinates,$project_url,$project_caption,$image,$completion,$location,$icon); ?>
        <?php } ?>
        ],
        "ajax_finishedMsg"  : "All posts displayed"
      };
</script>
