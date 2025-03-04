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

// Base query
$strQuery = "SELECT vi.id, vi.firstname, vi.tomeet, vi.companyname, vi.comingfrom, vi.mobile, vi.emailid, vi.checkin, vi.checkout, vi.status FROM visitorinfo vi";

// Checking the condition for Date field
if (!empty($_POST['DATE1']) && !empty($_POST['DATE2'])) {
    $s_date = $_POST['DATE1'];
    $s_time = empty($_POST['starttime']) ? '00:00:00' : $_POST['starttime'] . ':00:00';
    $e_date = $_POST['DATE2'];
    $e_time = empty($_POST['endtime']) ? '23:59:59' : $_POST['endtime'] . ':00:00';

    // Convert dates to Y-m-d format
    $s_date = DateTime::createFromFormat('d/m/Y', $s_date)->format('Y-m-d');
    $e_date = DateTime::createFromFormat('d/m/Y', $e_date)->format('Y-m-d');

    $strQuery .= " WHERE vi.checkin >= '$s_date $s_time' AND vi.checkin <= '$e_date $e_time'";
}

// Execute query
$result = $con->query($strQuery);

if ($result) {
    $count = $result->num_rows;
    $strResult = '';

    while ($row = $result->fetch_assoc()) {
        $status = ($row['status'] == 1) ? 'in' : 'out';

        $strResult .= json_encode([
            'sno' => $count,
            'visitorid' => $row['id'],
            'firstname' => $row['firstname'],
            'tomeet' => $row['tomeet'],
            'companyname' => $row['companyname'],
            'comingfrom' => $row['comingfrom'],
            'mobile' => $row['mobile'],
            'emailid' => $row['emailid'],
            'checkin' => $row['checkin'],
            'checkout' => $row['checkout'],
            'status' => $status
        ]) . ',';
    }

    $strResult = rtrim($strResult, ',');
    echo '{"total":"' . $count . '","results":[' . $strResult . ']}';
} else {
    echo 'Error: ' . $con->error;
}

// Close the connection
$con->close();

?>
