<?php
@ini_set('max_execution_time',0);
@ini_set('memory_limit', '-1');

if(!empty($_GET['db'])) {
	include_once('../includes/constants.php');
	require_once(absolutedir."config/app-connect.php");
	include_once(absolutedir."includes/function.class.php");

	// 1. Disable foreign key checks
  $conn->query('SET FOREIGN_KEY_CHECKS = 0');
  // 2. Get table names
  $result = $conn->query('SHOW TABLES');
  $tables = [];
  while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
  }
  if(!empty($tables)) {
    // 3. Drop all tables at once
    $tableList = '`' . implode('`, `', $tables) . '`';
    $conn->query("DROP TABLE $tableList");
  }
  // 4. Re-enable foreign key checks
  $conn->query('SET FOREIGN_KEY_CHECKS = 1');

  // Define the file name and the target extraction folder
  $zipFile     = absolutedir.'temp/'.trim($_GET['db']);
  $destination = absolutedir.'temp/';
  // Initialize the ZipArchive class
  $zip = new ZipArchive;
  // Open the archive file
  if($zip->open($zipFile) === TRUE) {
    // Extract the contents to the destination directory
    $zip->extractTo($destination);
    // Close the archive to free up system resources
    $zip->close();
    $backupfile = $destination.str_replace('.zip','',trim($_GET['db']));
    // Construct the MySQL restore command
    // Note: No space between -p and the password
    $command = "mysql -h {$dbhost} -u {$dbuser} -p{$dbpass} {$db} < {$backupfile}";
    // Execute the command
    $output     = [];
    $return_var = null;
    exec($command,$output,$return_var);
    // Check if the execution was successful (0 means success)
    if($return_var === 0) {
			unlink($zipFile);
    }
		unlink($destination.str_replace('.zip','',trim($_GET['db'])));
	}
}
?>
