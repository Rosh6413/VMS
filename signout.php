<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','visitorinfo');

// Establish database connection.
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";port=3308;dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

// MySQLi connection
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, 3308);

if (mysqli_connect_errno()) {
    echo "Connection Fail" . mysqli_connect_error();
}

$vid = 0;
if(isset($_REQUEST['vid'])){
    $vid = $_REQUEST['vid'];
}else{
    echo 'visitor id is empty';
    exit(0);
}

$timeInSec = time();
$currtime = date('Y-m-d H:i:s', $timeInSec);

$sql = "UPDATE visitorinfo SET status=0, checkout='$currtime' WHERE id=$vid";

// Execute query
try {
    $result = mysqli_query($con, $sql);
    if(!$result){
        echo 'Error: ' . mysqli_error($con);
        exit(0);
    }
    $count = mysqli_affected_rows($con);
    if(!$count){
        echo 'Invalid';
    }else{
        echo $vid;
    }
} catch(Exception $e) {
    echo 'Exception: ' . $e->getMessage();
}

// Close the connection
mysqli_close($con);
?>
