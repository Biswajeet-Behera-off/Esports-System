<?php
//------------------------------>> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "../config/techfestName.php";

// ---------------------------------------->> DB CONFIG
require_once '../config/configPDO.php';

// ---------------------------------------->> START SESSION
session_start();

// ---------------------------------------->> CHECKING ADMIN
if (!isset($_SESSION['adminEmail']) || ($_SESSION['adminType'])) {

    if ($_SESSION['adminType'] !== "Administrator") {
        header("location:adminLogin.php");
    }

}

try {

// --------------------------->> DISPLAY PARTICIPANT COUNT & REVENUE

    $sqlData = "SELECT * FROM event_information";
    $resultData = $conn->query($sqlData);
    $resultData->execute();
    $rowCount = $resultData->rowCount();
    $totalAmount = 0;

    while ($rowData = $resultData->fetch(PDO::FETCH_ASSOC)) {
        $totalAmount = $totalAmount + $rowData['txnAmount'];
    }

//--------------------------->> DISPLAY STUDENT COORDINATOR COUNT FOR COLLEGE

    $sqlDataAdmin = "SELECT * FROM admin_information
    WHERE adminType= :studentCoordinator";
    $resultDataAdmin = $conn->prepare($sqlDataAdmin);
    $resultDataAdmin->bindValue(":studentCoordinator", "Student Coordinator");
    $resultDataAdmin->execute();
    $rowCountAdmin = $resultDataAdmin->rowCount();

// --------------------------->> DISPLAY FACULTY COORDINATOR COUNT FOR COLLEGE

    $sqlDataAdmin2 = "SELECT * FROM admin_information
    WHERE adminType= :facultyCoordinator";
    $resultDataAdmin2 = $conn->prepare($sqlDataAdmin2);
    $resultDataAdmin2->bindValue(":facultyCoordinator", "Faculty Coordinator");
    $resultDataAdmin2->execute();
    $rowCountAdmin2 = $resultDataAdmin2->rowCount();

// --------------------------->> PARTICIPANT COUNT DEPARTMENT WISE

    function count1($department)
    {
        global $conn;
        $sql = "SELECT * FROM event_information WHERE event IN
        (SELECT eventName FROM events_details_information WHERE eventDepartment = :department)";
        $result = $conn->prepare($sql);
        $result->bindValue(":department", $department);
        $result->execute();
        $row = $result->rowCount();
        return $row;
    }

// --------------------------->> STUDENT CORDINATOR COUNT DEPARTMENT WISE

    function countAdmin($department)
    {
        global $conn;
        $sql = "SELECT * FROM admin_information
    WHERE adminType= :studentCoordinator AND adminDepartment = :department";
        $result = $conn->prepare($sql);
        $result->bindValue(":studentCoordinator", "Student Coordinator");
        $result->bindValue(":department", $department);
        $result->execute();
        $row = $result->rowCount();
        return $row;
    }

//--------------------------->> DISPLAY TOTAL REVENUE DEPARTMENT WISE

    function countRevenue($department)
    {
        global $conn;
        $sql = "SELECT SUM(txnAmount) AS totalAmount FROM event_information WHERE event IN
        (SELECT eventName FROM events_details_information WHERE eventDepartment = :department)";
        $result = $conn->prepare($sql);
        $result->bindValue(":department", $department);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $totalAmount = $row['totalAmount'];
        return $totalAmount + 0;
    }

} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
    # Development Purpose Error Only
    echo "Error " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo $techfestName ?> | TRAP ARMY ADMINISTRATOR DASHBOARD</title>

    <!-- Include Admin Header Scripts -->
    <?php include_once "includes/adminHeaderScripts.php";?>

</head>

<body class="sb-nav-fixed">

    <!-- Include Admin Navbar & Common Anchor -->
    <?php
include_once "includes/commonAnchor.php";
include_once "includes/adminNavbar.php";
?>

    <div id="layoutSidenav_content">

        <main class="container">

            <h2 class="mt-4 font-Staatliches-heading text-center text-info">Dashboard for Trap Army Administrator</h2>
            <hr/>

            <div class="row">

                <!-- Total Participation of the Events -->
                <section class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Participations</div>
                                    <div class="h5 mb-0 font-weight-bold"><?php echo $rowCount; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-3x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Total Earnings of Events -->
                <section class="col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Earnings</div>
                                    <div class="h5 mb-0 font-weight-bold">&#8377;
                                        <?php echo $totalAmount; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-rupee-sign text-warning fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <hr>
            </div>

        </main>

        <!-- Include Admin Footer-->
        <?php include_once "includes/adminFooter.php";?>
    </div>

    <!-- First Include Footer Scripts then Close DB Conn -->
<?php
include_once "includes/adminFooterScripts.php";
$conn = null;
?>

</body>

</html>