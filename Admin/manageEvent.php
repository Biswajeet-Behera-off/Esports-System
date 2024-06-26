<?php
//--------------------->> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "../config/techfestName.php";

//--------------------->> DB CONFIG
require_once '../config/configPDO.php';

//--------------------->> START SESSION
session_start();

$admin = $_SESSION['adminEmail'];

if (!isset($_SESSION['adminEmail'])) {
    header('location:adminLogin.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="Vishal Bait" />

    <title><?php echo $techfestName ?> | ADMINISTARTOR MANAGE EVENTS DETAILS</title>

    <!-- Include Admin Header Scripts -->
    <?php include_once "includes/adminHeaderScripts.php";?>

</head>

<body class="sb-nav-fixed">

    <!-- Include Common Anchor & Admin Navbar -->
    <?php
include_once "includes/commonAnchor.php";
include_once "includes/adminNavbar.php";
?>

    <main id="layoutSidenav_content">
        <div class="container mt-3">
            <h1 class="font-Staatliches-heading text-center text-info mb-1">MANAGE EVENTS</h1>
            <hr />
            <div class="row">

                <!-- Button trigger modal -->
                <button type="button" class="btn justify-content-end btn-primary my-2" data-toggle="modal"
                    data-target="#addModal">
                    Click Here to Add Event Details
                </button>

                <!-- Add Response Message -->
                <div id="addResponse"></div>

                <!-- Delete Response Message -->
                <div id="deleteResponse"></div>

                <!-- Update Response Message -->
                <div id="updateResponse"></div>


                <!-- Add Event Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">ADD EVENTS</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <form action="ajaxManageEvent.php" method="post" id="addEventForm" class="my-1"
                                    enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Event Image</label> <br />
                                        <input type="file" name="eventImage" id="eventImage" accept=".jpg, .jpeg, .png">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Name</label>
                                        <input type="text" name="eventName" id="eventName" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Entry Fee</label>
                                        <input type="text" name="eventPrice" id="eventPrice" class="form-control">
                                    </div>

                                      <div class="form-group">
                                        <label>Promocode</label>
                                        <input type="text" name="promocode" id="promocode" class="form-control">
                                        <small class="text-warning">If You don't want to add promocode Simply type Not Applicable </small>
                                    </div>

                                      <div class="form-group">
                                        <label>Event Fee Discount in %</label>
                                        <input min = "1" max= "100" type="number" name="discount" id="discount" class="form-control">
                                        <small class="text-warning">If promocode not available type 0 as Discount</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Event Prize</label>
                                        <input type="text" name="eventPrize" id="eventPrize" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Sponsor</label>
                                        <input type="text" name="eventSponsor" id="eventSponsor" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Department</label>
                                        <select name="eventDepartment" class="form-control" id="eventDepartment">
                                            <option selected disabled>Chooes...</option>
                                            <option value="BGMI">BGMI</option>
                                            <option value="FREEFIRE">FREEFIRE</option>
                                            <option value="VALORENT">VALORENT</option>
                                            <option value="MOBILE">MOBILE LEGENDS BANG BANG</option>
                                            <option value="POKEMON">POKEMON UNITE</option>
                                            <option value="PUBGNEW">PUBG NEW STATE</option>
                                            <option value="CSGO">CSGO</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Event Description</label>
                                        <textarea name="eventDescription" cols="30" rows="5" id="eventDescription"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Event Rules</label>
                                        <textarea name="eventRules" cols="30" rows="5" id="eventRules"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Event Start Date</label>
                                        <input type="date" name="eventStartDate" id="eventStartDate"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event End Date</label>
                                        <input type="date" name="eventEndDate" id="eventEndDate" class="form-control">
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>

                                        <button type="submit" class="btn btn-primary" id="addEvent" name="addEvent">Add
                                            Event</button>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>




                <!-- Update Event Modal -->
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">UPDATE EVENTS</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <form action="" method="post" id="updateEventForm" class="my-1">

                                    <div class="form-group">
                                        <label>Event Name</label>
                                        <input type="text" name="updateEventName" id="updateEventName"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Entry Fee</label>
                                        <input type="text" name="updateEventPrice" id="updateEventPrice"
                                            class="form-control">
                                    </div>

                                         <div class="form-group">
                                        <label>Promocode</label>
                                        <input type="text" name="updatePromocode" id="updatePromocode" class="form-control">
                                        <small class="text-warning">If You don't want to add promocode Simply type Not Applicable </small>
                                    </div>

                                      <div class="form-group">
                                        <label>Event Fee Discount in %</label>
                                        <input min = "1" max= "100" type="number" name="updateDiscount" id="updateDiscount" class="form-control">
                                        <small class="text-warning">If promocode not available type 0 as Discount</small>
                                    </div>


                                    <div class="form-group">
                                        <label>Event Prize</label>
                                        <input type="text" name="updateEventPrize" id="updateEventPrize"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Sponsor</label>
                                        <input type="text" name="updateEventSponsor" id="updateEventSponsor"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event Department</label>
                                        <select name="updateEventDepartment" class="form-control"
                                            id="updateEventDepartment">
                                            <option selected disabled>Chooes...</option>
                                            <option value="BGMI">BGMI</option>
                                            <option value="FREEFIRE">FREEFIRE</option>
                                            <option value="VALORENT">VALORENT</option>
                                            <option value="MOBILE">MOBILE LEGENDS BANG BANG</option>
                                            <option value="POKEMON">POKEMON UNITE</option>
                                            <option value="PUBGNEW">PUBG NEW STATE</option>
                                            <option value="CSGO">CSGO</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Event Description</label>
                                        <textarea name="updateEventDescription" cols="30" rows="5"
                                            id="updateEventDescription" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Event Rules</label>
                                        <textarea name="updateEventRules" cols="30" rows="5" id="updateEventRules"
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Event Start Date</label>
                                        <input type="date" name="updateEventStartDate" id="updateEventStartDate"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Event End Date</label>
                                        <input type="date" name="updateEventEndDate" id="updateEventEndDate"
                                            class="form-control">
                                    </div>

                                    <div id="hiddenId"></div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" name="updateAdmin" id="updateAdmin" data-dismiss="modal"
                                            onclick="updateEvent()" class="btn btn-primary">Update Event</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <!--Response Message -->
                    <div id="responseMessage"></div>
                </div>

            </div>
        </div>
        <!--Include Admin Footer-->
        <?php include_once "includes/adminFooter.php";?>
    </main>

    <!-- Include Admin Footer Scripts -->
    <?php include_once "includes/adminFooterScripts.php";?>

     <script>
        CKEDITOR . replace('eventDescription');
        CKEDITOR . replace('eventRules');
        CKEDITOR . replace('updateEventDescription');
        CKEDITOR . replace('updateEventRules');
    </script>

    <!-- javascript -->
    <script src="js/manageEvent.js"></script>

    <!-- Close Database Connection -->
    <?php $conn = null;?>

</body>

</html>