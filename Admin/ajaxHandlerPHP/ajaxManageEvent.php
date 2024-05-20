<?php
//----------------------->> DB CONFIG
require_once "../../config/configPDO.php";

// ---------------------->> STARTING SESSION
session_start();

extract($_POST);

# CHECKING ADMIN

if (!isset($_SESSION['adminType'])) {
    header("location:../adminLogin.php");
}


try {

//-------------------------------->> READING OPERATION
    if (isset($_POST["readRecord"])) {

        # Query
        $sql = "SELECT * FROM events_details_information";

        #  Preparing Query
        $result = $conn->prepare($sql);

        # Executing Value
        $result->execute();

        $data = '<table class= "table table-striped table-bordered" id= "dataTable" width= "100%" cellspacing="0">
                        <thead class="text-center">
                            <th>Sr.No.</th>
                            <th>Event Name</th>
                            <th>Event Fee</th>
                            <th>Promocode</th>
                            <th>Discount</th>
                            <th>Event Prize</th>
                            <th>Event Sponsor</th>
                            <th>Event Department</th>
                            <th>Event Description</th>
                            <th>Event Rules</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th >Edit</th>
                            <th >Delete</th>
                        </thead>
                        <tbody>';

        if ($result->rowCount() > 0) {

            $number = 1;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                $data .= '<tr>
            <td>' . $number . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['eventPrice'] . '</td>
            <td>' . $row['promocode'] . '</td>
            <td>' . $row['discount'] . '</td>
            <td>' . $row["eventPrize"] . '</td>
            <td>' . $row['eventSponsor'] . '</td>
            <td>' . $row['eventDepartment'] . '</td>
            <td>' . substr($row["eventDescription"], 0, 100) . ' .....</td>
            <td>' . substr($row['eventRules'], 0, 100) . ' .....</td>
            <td>' . $row['eventStartDate'] . '</td>
            <td>' . $row["eventEndDate"] . '</td>
            <td><button class="btn btn-primary" onclick= "getEventInformation(' . $row['id'] . ')"><i class="fas fa-edit"></i></button></td>
            <td><button class="btn btn-danger" onclick= "deleteEventInformation(' . $row['id'] . ')"><i class="fa fa-trash-alt"></i></button></td>
             </tr>';
                $number++;
            }

        } else {
            $data .= '<tr class="text-center">
    <td colspan="12">No Records Found</td>
    </tr>';
        }

        $data .= '</tbody>
        </table>';

        echo $data;

    }

    extract($_FILES);

//---------------------------------------->> CREATE OPERATION

    if (isset($_POST['eventName'])) {
        # Avoid XSS Attack
        $eventName = htmlspecialchars($_POST['eventName']);
        $eventPrice = htmlspecialchars($_POST['eventPrice']);
        $promocode = htmlspecialchars($_POST['promocode']);
        $discount = htmlspecialchars($_POST['discount']);
        $eventPrize = htmlspecialchars($_POST['eventPrize']);
        $eventSponsor = htmlspecialchars($_POST['eventSponsor']);
        $eventDepartment = htmlspecialchars($_POST['eventDepartment']);
        $eventDescription = $_POST['eventDescription'];
        $eventRules = $_POST['eventRules'];
        $eventStartDate = htmlspecialchars($_POST['eventStartDate']);
        $eventEndDate = htmlspecialchars($_POST['eventEndDate']);

        $eventImage = $_FILES['eventImage'];
        $eventImageName = $_FILES['eventImage']['name'];
        $eventImageSize = $_FILES['eventImage']['size'];
        $eventImageTmpDir = $_FILES['eventImage']['tmp_name'];

        if ($eventImageName == "") {
            echo "<script>Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please Select Proper Image'
                    })</script>";
        } else {
            if ($eventImageSize <= 2097152) {
                // Read the image file content
                $eventImageContent = file_get_contents($eventImageTmpDir);

                if ($eventImageContent === false) {
                    // Failed to read image file
                    // Handle the error here
                    echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to read image file'
                    })</script>";
                } else {
                    # Query
                    $sql = "INSERT INTO events_details_information( eventImage, eventName, eventPrice, promocode, discount, eventPrize, eventSponsor,
                    eventDepartment, eventDescription, eventRules, eventStartDate, eventEndDate)
                    VALUES (:eventImage, :eventName, :eventPrice, :promocode, :discount, :eventPrize, :eventSponsor, :eventDepartment,
                    :eventDescription, :eventRules, :eventStartDate, :eventEndDate)";

                    # Preparing Query
                    $result = $conn->prepare($sql);

                    # Binding Values
                    $result->bindParam(':eventImage', $eventImageContent, PDO::PARAM_LOB);
                    $result->bindParam(':eventName', $eventName);
                    $result->bindParam(':eventPrice', $eventPrice);
                    $result->bindParam(':promocode', $promocode);
                    $result->bindParam(':discount', $discount);
                    $result->bindParam(':eventPrize', $eventPrize);
                    $result->bindParam(':eventSponsor', $eventSponsor);
                    $result->bindParam(':eventDepartment', $eventDepartment);
                    $result->bindParam(':eventDescription', $eventDescription);
                    $result->bindParam(':eventRules', $eventRules);
                    $result->bindParam(':eventStartDate', $eventStartDate);
                    $result->bindParam(':eventEndDate', $eventEndDate);

                    # Executing Query
                    if ($result->execute()) {
                        echo "<script>Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Added Event Successfully'
                        })</script>";
                    } else {
                        echo "<script>Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to Add Event'
                        })</script>";
                    }
                }
            } else {
                echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Image size exceeded',
                    text: 'Please upload a file less than 2MB'
                })</script>";
            }
        }
    }


//---------------------------------------->>  DELETING OPERATION

    if (isset($_POST['deleteId'])) {

        # Query
        $sql = "DELETE FROM events_details_information WHERE id = :deleteId";

        # Preapring query
        $result = $conn->prepare($sql);

        # Binding Values
        $result->bindValue(":deleteId", $deleteId);

        # Executing Query
        $result->execute();

        if ($result) {
            echo "<script>Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Event Data successfully deleted'
          })</script>";

        } else {
            echo "<script>Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'We failed to delete data'
          })</script>";

        }
    }

//---------------------------------------------->> EDIT OPERATION

    if (isset($_POST['editId'])) {

        # Query
        $sql = "SELECT * FROM events_details_information WHERE id= :editId";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Value
        $result->bindValue(":editId", $editId);

        # Executing Query
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        $response = json_encode($row);

        echo $response;

    }

// ------------------------------------->> UPDATE OPERATION

    if (isset($_POST['hiddenId'])) {

        $updateEventName = htmlspecialchars($_POST["updateEventName"]);
        $updateEventPrice = htmlspecialchars($_POST["updateEventPrice"]);
        $updatePromocode = htmlspecialchars($_POST["updatePromocode"]);
        $updateDiscount = htmlspecialchars($_POST["updateDiscount"]);
        $updateEventPrize = htmlspecialchars($_POST["updateEventPrize"]);
        $updateEventSponsor = htmlspecialchars($_POST["updateEventSponsor"]);
        $updateEventDescription = $_POST["updateEventDescription"];
        $updateEventRules = $_POST["updateEventRules"];
        
        $updateEventStartDate = htmlspecialchars($_POST["updateEventStartDate"]);
        $updateEventEndDate = htmlspecialchars($_POST["updateEventEndDate"]);

        # Query
        $sql = "UPDATE events_details_information SET eventName = :updateEventName,
    eventPrice = :updateEventPrice, promocode = :updatePromocode, discount = :updateDiscount,
    eventPrize = :updateEventPrize, eventSponsor = :updateEventSponsor,
    eventDepartment = :updateEventDepartment, eventDescription = :updateEventDescription,
    eventRules = :updateEventRules,
    eventStartDate = :updateEventStartDate, eventEndDate = :updateEventEndDate
    WHERE id = :hiddenId";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Value
        $result->bindValue(":updateEventName", $updateEventName);
        $result->bindValue(":updateEventPrice", $updateEventPrice);
        $result->bindValue(":updatePromocode", $updatePromocode);
        $result->bindValue(":updateDiscount", $updateDiscount);
        $result->bindValue(":updateEventPrize", $updateEventPrize);
        $result->bindValue(":updateEventSponsor", $updateEventSponsor);
        $result->bindValue(":updateEventDepartment", $updateEventDepartment);
        $result->bindValue(":updateEventDescription", $updateEventDescription);
        $result->bindValue(":updateEventRules", $updateEventRules);
        
        $result->bindValue(":updateEventStartDate", $updateEventStartDate);
        $result->bindValue(":updateEventEndDate", $updateEventEndDate);
        $result->bindValue(":hiddenId", $hiddenId);

        # Executing Query
        $result->execute();

        if ($result) {
            echo "<script>Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Event Details successfully updated'
          })</script>";

        } else {
            echo "<script>Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'We failed to update event details'
          })</script>";

        }

    }

} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
# Development Purpose Error Only
    echo "Error " . $e->getMessage();
}

// Close Database Connection
$conn = null;
