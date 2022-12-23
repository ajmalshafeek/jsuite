<?php
$config = parse_ini_file(__DIR__ . "/../../jsheetconfig.ini");
if (!isset($_SESSION)) {
    session_name($config['sessionName']);
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/clientCompany.php");
require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/mail.php");
$id = "";
if (isset($_POST['addNewClient'])) {
    $id = $_POST['clientIdToEdit'];
    if ($_POST['addNewClient'] == 0) {
        updatePotantialClient($id, $_POST['addNewClient']);
    }
}
if (isset($_POST['sendForm'])) {
    $id = $_POST['clientIdToEdit'];
    sendFormEmail($id);
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/organization/client/potentialClients.php");
}
if (!empty($id)) {
    $data = getNewClientDetails($id);
}

require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/vendor.php");
require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/organization/client/moreForm/form.php");
require($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/product.php");

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/resources/app/favIcon.ico'; ?>' />
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/importScripts.php");
    ?>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <style>
        .buttonAsLink {
            background: none !important;
            color: inherit;
            border: none;
            font: inherit;
            cursor: pointer;
        }

        .bg-red {
            background-color: #E32526;
        }
    </style>

</head>

<body class="fixed-nav ">

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/navMenu.php";
    ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <?php echo shortcut() ?>
            <!-- Breadcrumbs-->
            <ol class="breadcrumb col-md-12">
                <li class="breadcrumb-item">
                    <a href="../../home.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Member</li>
                <li class="breadcrumb-item active">Add Member</li>
            </ol>
        </div>
        <div class="container">
            <div class="col-sm-12">
                <form method="POST" action="../../phpfunctions/memberDetails.php" class="needs-validation" novalidate>
                    <?php
                    if (isset($_SESSION['feedback'])) {
                        echo $_SESSION['feedback'];
                        unset($_SESSION['feedback']);
                    }
                    ?>
                    <div id="clientForm">

                        <div class="form-group row">
                            <label for="clientName" class="col-sm-2 col-form-label col-form-label-lg">Supporting Doc</label>
                            <div class="col-sm-10">
                                <label class="col-form-label col-form-label-lg"><input type="checkbox" class="" id="suppDoc" name="suppDoc" value="Form 9/ 24/ 49(Sdn.Bhd. Only)" /> Form 9, 24, 49(Sdn.Bhd. Only)</label>
                                <label class="col-form-label col-form-label-lg"><input type="checkbox" class="" id="suppDoc" name="suppDoc" value="SSM Docs(for Sale Prop/LLP only)" /> SSM Docs (for Sale Prop/LLP only)</label>
                                <label class="col-form-label col-form-label-lg"><input type="checkbox" class="" id="suppDoc" name="suppDoc" value="NRIC Copy" /> NRIC Copy</label>
                                <label class="col-form-label col-form-label-lg"><input type="checkbox" class="" id="suppDoc" name="suppDoc" value="Business Card" /> Business Card</label>
                                <label class="col-form-label col-form-label-lg"><input type="checkbox" class="" id="suppDoc" name="suppDoc" value="Photograph" /> Photograph</label>
                                <div class="invalid-feedback">
                                    Please select Supporting Doc
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="memberType" class="col-sm-2 col-form-label col-form-label-lg">Membership Type
                            </label>
                            <div class="col-sm-4">
                                <select name="memberType" id="memberType" class="form-control">
                                    <?php if (!isset($data['membership_type'])) { ?><option value="" <?php if (!isset($data['membership_type'])) {
                                                                                                            echo " " . 'selected disabled';
                                                                                                        } ?>>--Select A State--</option><?php } ?>
                                    <?php if (isset($data['membership_type'])) { ?><option value="<?php if (isset($data['membership_type'])) {
                                                                                                        echo $data['membership_type'] . " " . 'selected';
                                                                                                    } ?>"><?php if (isset($data['membership_type'])) {
                                                                                                                echo $data['membership_type'];
                                                                                                            } ?></option><?php } ?>
                                    <option value="ORDINARY">ORDINARY</option>
                                    <option value="ASSOCIATE">ASSOCIATE</option>
                                    <option value="HONORARY">HONORARY</option>
                                    <option value="LIFE MEMBER">LIFE MEMBER</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please enter Membership Type
                                </div>
                            </div>
                            <label for="memberFees" class="col-sm-2 col-form-label col-form-label-lg">Member Fees
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" placeholder="Enter member fees" id="memberFees" name="memberFees" step="0.01" required />
                                <div class="invalid-feedback">
                                    Please enter Member Fees
                                </div>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Company Details:</legend>
                            <div class="form-group row">
                                <label for="clientName" class="col-sm-2 col-form-label col-form-label-lg">Company Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter company name" id="clientName" name="clientName" required />
                                    <div class="invalid-feedback">
                                        Please enter company name
                                    </div>
                                </div>
                            </div>
                            <!--(START)BILLING ADDRESS-->
                            <?php /*
                  <div class="form-group row" style="background: #ADD8E6;padding-top:15px;border-radius:5px;">
                      <label for="address1" class="col-sm-2 col-form-label col-form-label-lg">Address:</label>
                      <div class="col-sm-10"> */ ?>
                            <!--(START)BILLING ADDRESS1-->
                            <div class="form-group row">
                                <label for="address1" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Street address, P.O box, C/O" id="address1" name="address1" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 1.
                                    </div>
                                </div>
                            </div>
                            <!--(END)BILLING ADDRESS1-->
                            <!--(START)BILLING ADDRESS2-->
                            <div class="form-group row">
                                <label for="address2" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Building, Suite, Unit, Floor" id="address2" name="address2" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 2.
                                    </div>
                                </div>
                            </div>
                            <!--(END)BILLING ADDRESS2-->
                            <!--(START)CITY/TOWN-->
                            <div class="form-group row">
                                <label for="city" class="col-sm-2 col-form-label col-form-label-lg">&bull;City/Town</label>
                                <div class="col-sm-4">
                                    <input type="text" name="city" class="form-control" placeholder="City/Town" id="city" name="city" />
                                    <div class="invalid-feedback">
                                        Please enter city/town
                                    </div>
                                </div>
                                <!--(END)CITY/TOWN-->
                                <!--(START)ZIP/POSTAL CODE-->
                                <label for="postalCode" class="col-sm-2 col-form-label col-form-label-lg">&bull;Zip/Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Zip/Postal Code" id="postalCode" name="postalCode" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter postal code
                                    </div>
                                </div>
                            </div>
                            <!--(END)ZIP/POSTAL CODE-->

                            <div class="form-group row">
                                <label for="statemnot" class="col-sm-2 col-form-label col-form-label-lg">&bull;Enter State Manually</label>
                                <div class="col-sm-10">
                                    <label><input type="radio" name="statemnot" id="statemnot1" class="statemnot1" value="1" />&nbsp;Yes</label>&nbsp;&nbsp;
                                    <label><input type="radio" name="statemnot" id="statemnot2" class="statemnot2" value="0" checked="checked" />&nbsp;No</label>
                                    <div class="invalid-feedback">
                                        Please select manual or not
                                    </div>
                                </div>
                            </div>
                            <!--(START)STATE-->
                            <div class="form-group row">
                                <label for="state" class="col-sm-2 col-form-label col-form-label-lg">&bull;State</label>
                                <div class="col-sm-4 statemop">
                                    <select name="state" id="state" class="form-control">
                                        <?php if (!isset($data['state'])) { ?><option value="" <?php if (!isset($data['state'])) {
                                                                                                    echo " " . 'selected disabled';
                                                                                                } ?>>--Select A State--</option><?php } ?>
                                        <?php if (isset($data['state'])) { ?><option value="<?php if (isset($data['state'])) {
                                                                                                echo $data['state'] . " " . 'selected';
                                                                                            } ?>"><?php if (isset($data['state'])) {
                                                                                                        echo $data['state'];
                                                                                                    } ?></option><?php } ?>
                                        <option value="Johor">Johor</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Perak">Perak</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Penang">Penang</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Terengganu">Terengganu</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>
                                <div class="col-sm-4 statemop1">
                                    <input type="text" name="state" id="state" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>

                                <label for="country" class="col-sm-2 col-form-label col-form-label-lg">&bull;Country</label>
                                <div class="col-sm-4">
                                    <input type="text" name="country" id="country" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select country
                                    </div>
                                </div>
                            </div>
                            <!--(END)STATE-->
                            <?php /*</div>
                  </div> */ ?>
                            <!--(END)BILLING ADDRESS-->
                            <div class="form-group row">
                                <label for="clientContactNo" class="col-sm-2  col-form-label col-form-label-lg">Phone No.</label>
                                <div class="col-sm-4">

                                    <input type="text" class="form-control" placeholder="xx-xxx xxxx" id="clientContactNo" name="clientContactNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter client phone no.
                                    </div>
                                </div>
                                <label for="register" class="col-sm-2 col-form-label col-form-label-lg">Registration Number</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Enter Registration No" id="register" name="register" />
                                    <div class="invalid-feedback">
                                        Please enter Registration No
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="clientEmail" class="col-sm-2 col-form-label col-form-label-lg">Client Email</label>
                                <div class="col-sm-4">
                                    <input type="email" placeholder="Email Address" class="form-control" id="clientEmail" name="clientEmail" />
                                    <div class="invalid-feedback">
                                        Please enter client email address
                                    </div>
                                </div>
                                <label for="website" class="col-sm-2 col-form-label col-form-label-lg">Website</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Enter www.website.com" id="website" name="website" />
                                    <div class="invalid-feedback">
                                        Please enter website
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="bussiType" class="col-sm-2 col-form-label col-form-label-lg">Business Sector</label>
                            <div class="col-sm-10">
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="MANUFACTURER" /> MANUFACTURER</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="TRADE" /> TRADE</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="EXPORT" /> EXPORT</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="IMPORT" /> IMPORT</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="SERVICES" /> SERVICES</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="WHOLESALE" /> WHOLESALE</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="RETAIL" /> RETAIL</label>
                                <label class="col-form-label col-form-label-lg"><input type="radio" class="" id="bussiType" name="bussiType" value="AGENT" /> AGENT</label>
                                <div class="invalid-feedback">
                                    Please enter business sector
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="business" class="col-sm-2 col-form-label col-form-label-lg">Nature of Business</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Nature of Business" id="business" name="business" />
                                <div class="invalid-feedback">
                                    Please enter nature of business
                                </div>
                            </div>
                        </div>

                        <fieldset>
                            <legend>Personal Information:</legend>
                            <div class="form-group row">
                                <label for="Representative" class="col-sm-2 col-form-label col-form-label-lg">Representative</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter representative" id="representative" name="representative" />
                                    <div class="invalid-feedback">
                                        Please enter representative
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP ADDRESS1-->
                            <div class="form-group row">
                                <label for="repaddress1" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Street address, P.O box, C/O" id="repaddress1" name="repaddress1" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 1.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS1-->
                            <!--(START)REP ADDRESS2-->
                            <div class="form-group row">
                                <label for="repaddress2" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Building, Suite, Unit, Floor" id="repaddress2" name="repaddress2" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 2.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS2-->
                            <!--(START)REP CITY/TOWN-->
                            <div class="form-group row">
                                <label for="repcity" class="col-sm-2 col-form-label col-form-label-lg">&bull;City/Town</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="repcity" placeholder="City/Town" name="repcity" />
                                    <div class="invalid-feedback">
                                        Please enter city/town
                                    </div>
                                </div>
                                <!--(END)REP CITY/TOWN-->
                                <!--(START)REP ZIP/POSTAL CODE-->
                                <label for="reppostalCode" class="col-sm-2 col-form-label col-form-label-lg">&bull;Zip/Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Zip/Postal Code" id="reppostalCode" name="reppostalCode" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter postal code
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ZIP/POSTAL CODE-->

                            <div class="form-group row">
                                <label for="statemnotrep" class="col-sm-2 col-form-label col-form-label-lg">&bull;Enter State Manually</label>
                                <div class="col-sm-10">
                                    <label><input type="radio" name="statemnotrep" id="statemnot1rep" class="statemnot1rep" value="1" />&nbsp;Yes</label>&nbsp;&nbsp;
                                    <label><input type="radio" name="statemnotrep" id="statemnot2rep" class="statemnot2rep" value="0" checked="checked" />&nbsp;No</label>
                                    <div class="invalid-feedback">
                                        Please select manual or not
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP STATE-->
                            <div class="form-group row">
                                <label for="repstate" class="col-sm-2 col-form-label col-form-label-lg">&bull;State</label>
                                <div class="col-sm-4 statemoprep">
                                    <select name="repstate" id="repstate" class="form-control">
                                        <?php if (!isset($data['state'])) { ?><option value="" <?php if (!isset($data['state'])) {
                                                                                                    echo " " . 'selected disabled';
                                                                                                } ?>>--Select A State--</option><?php } ?>
                                        <?php if (isset($data['state'])) { ?><option value="<?php if (isset($data['state'])) {
                                                                                                echo $data['state'] . " " . 'selected';
                                                                                            } ?>"><?php if (isset($data['state'])) {
                                                                                                        echo $data['state'];
                                                                                                    } ?></option><?php } ?>
                                        <option value="Johor">Johor</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Perak">Perak</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Penang">Penang</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Terengganu">Terengganu</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>
                                <div class="col-sm-4 statemop1rep">
                                    <input type="text" name="repstate" id="repstate" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>

                                <label for="repcountry" class="col-sm-2 col-form-label col-form-label-lg">&bull;Country</label>
                                <div class="col-sm-4">
                                    <input type="text" name="repcountry" id="repcountry" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select country
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP STATE-->
                            <!--(END)REP BILLING ADDRESS-->
                            <div class="form-group row">
                                <label for="repOfficeTelNo" class="col-sm-2  col-form-label col-form-label-lg">Office Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="repOfficeTelNo" name="repOfficeTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter Office tel no .
                                    </div>
                                </div> <label for="repHomeTelNo" class="col-sm-2  col-form-label col-form-label-lg">Home Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="repHomeTelNo" name="repHomeTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter Home tel no .
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="repHPTelNo" class="col-sm-2  col-form-label col-form-label-lg">H/P Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="repHPTelNo" name="repHPTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter h/p tel no.
                                    </div>
                                </div>
                                <label for="repNRIC_old" class="col-sm-2  col-form-label col-form-label-lg">NRIC old</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="NRIC old" id="repNRIC_old" name="repNRIC_old" />
                                    <div class="invalid-feedback">
                                        Please enter NRIC old
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="repNRIC_new" class="col-sm-2  col-form-label col-form-label-lg">NRIC new</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="NRIC new" id="repNRIC_new" name="repNRIC_new" />
                                    <div class="invalid-feedback">
                                        Please enter NRIC new
                                    </div>
                                </div>
                                <label for="repGender" class="col-sm-2  col-form-label col-form-label-lg">Gender</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Gender" id="repGender" name="repGender" />
                                    <div class="invalid-feedback">
                                        Please enter gender
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="repDOB" class="col-sm-2  col-form-label col-form-label-lg">Date Of Birth</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" placeholder="Date of Birth" id="repDOB" name="repDOB" />
                                    <div class="invalid-feedback">
                                        Please enter date of birth
                                    </div>
                                </div>
                                <label for="repNationality" class="col-sm-2  col-form-label col-form-label-lg">Nationality</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Nationality" id="repNationality" name="repNationality" />
                                    <div class="invalid-feedback">
                                        Please enter nationality
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Alternate Information:</legend>
                            <div class="form-group row">
                                <label for="altresentative" class="col-sm-2 col-form-label col-form-label-lg">Alternate</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter Alternate" id="altresentative" name="altresentative" />
                                    <div class="invalid-feedback">
                                        Please enter Alternate
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP ADDRESS1-->
                            <div class="form-group row">
                                <label for="altaddress1" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Street address, P.O box, C/O" id="altaddress1" name="altaddress1" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 1.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS1-->
                            <!--(START)REP ADDRESS2-->
                            <div class="form-group row">
                                <label for="altaddress2" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Building, Suite, Unit, Floor" id="altaddress2" name="altaddress2" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 2.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS2-->
                            <!--(START)REP CITY/TOWN-->
                            <div class="form-group row">
                                <label for="altcity" class="col-sm-2 col-form-label col-form-label-lg">&bull;City/Town</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="altcity" name="altcity" placeholder="City/Town" />
                                    <div class="invalid-feedback">
                                        Please enter city/town
                                    </div>
                                </div>
                                <!--(END)REP CITY/TOWN-->
                                <!--(START)REP ZIP/POSTAL CODE-->
                                <label for="altpostalCode" class="col-sm-2 col-form-label col-form-label-lg">&bull;Zip/Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Zip/Postal Code" id="altpostalCode" name="altpostalCode" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter postal code
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ZIP/POSTAL CODE-->

                            <div class="form-group row">
                                <label for="statemnotalt" class="col-sm-2 col-form-label col-form-label-lg">&bull;Enter State Manually</label>
                                <div class="col-sm-10">
                                    <label><input type="radio" name="statemnotalt" id="statemnot1alt" class="statemnot1alt" value="1" />&nbsp;Yes</label>&nbsp;&nbsp;
                                    <label><input type="radio" name="statemnotalt" id="statemnot2alt" class="statemnot2alt" value="0" checked="checked" />&nbsp;No</label>
                                    <div class="invalid-feedback">
                                        Please select manual or not
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP STATE-->
                            <div class="form-group row">
                                <label for="altstate" class="col-sm-2 col-form-label col-form-label-lg">&bull;State</label>
                                <div class="col-sm-4 statemopalt">
                                    <select name="altstate" id="altstate" class="form-control">
                                        <?php if (!isset($data['state'])) { ?><option value="" <?php if (!isset($data['state'])) {
                                                                                                    echo " " . 'selected disabled';
                                                                                                } ?>>--Select A State--</option><?php } ?>
                                        <?php if (isset($data['state'])) { ?><option value="<?php if (isset($data['state'])) {
                                                                                                echo $data['state'] . " " . 'selected';
                                                                                            } ?>"><?php if (isset($data['state'])) {
                                                                                                        echo $data['state'];
                                                                                                    } ?></option><?php } ?>
                                        <option value="Johor">Johor</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Perak">Perak</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Penang">Penang</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Terengganu">Terengganu</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>
                                <div class="col-sm-4 statemop1alt">
                                    <input type="text" name="altstate" id="altstate" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>

                                <label for="altcountry" class="col-sm-2 col-form-label col-form-label-lg">&bull;Country</label>
                                <div class="col-sm-4">
                                    <input type="text" name="altcountry" id="altcountry" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select country
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP STATE-->
                            <!--(END)REP BILLING ADDRESS-->
                            <div class="form-group row">
                                <label for="altOfficeTelNo" class="col-sm-2  col-form-label col-form-label-lg">Office Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="altOfficeTelNo" name="altOfficeTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter Office tel no .
                                    </div>
                                </div> <label for="altHomeTelNo" class="col-sm-2  col-form-label col-form-label-lg">Home Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="altHomeTelNo" name="altHomeTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter Home tel no .
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="altHPTelNo" class="col-sm-2  col-form-label col-form-label-lg">H/P Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="altHPTelNo" name="altHPTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter h/p tel no.
                                    </div>
                                </div>

                                <label for="altNRIC_old" class="col-sm-2  col-form-label col-form-label-lg">NRIC Old</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="NRIC old" id="altNRIC_old" name="altNRIC_old" />
                                    <div class="invalid-feedback">
                                        Please enter NRIC old
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="altNRIC_new" class="col-sm-2  col-form-label col-form-label-lg">NRIC New</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="NRIC new" id="altNRIC_new" name="altNRIC_new" />
                                    <div class="invalid-feedback">
                                        Please enter NRIC new
                                    </div>
                                </div>
                                <label for="altGender" class="col-sm-2  col-form-label col-form-label-lg">Gender</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Gender" id="altGender" name="altGender" />
                                    <div class="invalid-feedback">
                                        Please enter gender
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="altDOB" class="col-sm-2  col-form-label col-form-label-lg">Date Of Birth</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" placeholder="Date of Birth" id="altDOB" name="altDOB" />
                                    <div class="invalid-feedback">
                                        Please enter date of birth
                                    </div>
                                </div>
                                <label for="altNationality" class="col-sm-2  col-form-label col-form-label-lg">Nationality</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Nationality" id="altNationality" name="altNationality" />
                                    <div class="invalid-feedback">
                                        Please enter nationality
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group row">
                            <label for="hrdf" class="col-sm-2 col-form-label col-form-label-lg"></label>
                            <div class="col-sm-10">
                                <label for="hrdf" class="col-form-label col-form-label-lg">Are you currently an HRDF Member</label>
                                <label><input type="radio" name="hrdf" id="hrdf" class="hrdf" value="Yes" />&nbsp;Yes</label>&nbsp;&nbsp;
                                <label><input type="radio" name="hrdf" id="hrdf" class="hrdf" value="No" checked="checked" />&nbsp;No</label>
                                <div class="invalid-feedback">
                                    Please select manual or not
                                </div>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Sponsor Information:</legend>
                            <h5>Proposer</h5>
                            <div class="form-group row">
                                <label for="proposer" class="col-sm-2 col-form-label col-form-label-lg">Proposer</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter proposer" id="proposer" name="proposer" />
                                    <div class="invalid-feedback">
                                        Please enter proposer
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="propfirm" class="col-sm-2 col-form-label col-form-label-lg">Firm</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter firm" id="propfirm" name="propfirm" />
                                    <div class="invalid-feedback">
                                        Please enter firm
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP ADDRESS1-->
                            <div class="form-group row">
                                <label for="propsaddress1" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Street address, P.O box, C/O" id="propaddress1" name="propaddress1" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 1.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS1-->
                            <!--(START)REP ADDRESS2-->
                            <div class="form-group row">
                                <label for="propaddress2" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Building, Suite, Unit, Floor" id="propaddress2" name="propaddress2" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 2.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS2-->
                            <!--(START)REP CITY/TOWN-->
                            <div class="form-group row">
                                <label for="propcity" class="col-sm-2 col-form-label col-form-label-lg">&bull;City/Town</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="propcity" name="propcity" placeholder="City/Town" />
                                    <div class="invalid-feedback">
                                        Please enter city/town
                                    </div>
                                </div>
                                <!--(END)REP CITY/TOWN-->
                                <!--(START)REP ZIP/POSTAL CODE-->
                                <label for="proppostalCode" class="col-sm-2 col-form-label col-form-label-lg">&bull;Zip/Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Zip/Postal Code" id="proppostalCode" name="proppostalCode" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter postal code
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ZIP/POSTAL CODE-->

                            <div class="form-group row">
                                <label for="statemnotprop" class="col-sm-2 col-form-label col-form-label-lg">&bull;Enter State Manually</label>
                                <div class="col-sm-10">
                                    <label><input type="radio" name="statemnotprop" id="statemnot1prop" class="statemnot1prop" value="1" />&nbsp;Yes</label>&nbsp;&nbsp;
                                    <label><input type="radio" name="statemnotprop" id="statemnot2prop" class="statemnot2prop" value="0" checked="checked" />&nbsp;No</label>
                                    <div class="invalid-feedback">
                                        Please select manual or not
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP STATE-->
                            <div class="form-group row">
                                <label for="propstate" class="col-sm-2 col-form-label col-form-label-lg">&bull;State</label>
                                <div class="col-sm-4 statemopprop">
                                    <select name="propstate" id="propstate" class="form-control">
                                        <?php if (!isset($data['state'])) { ?><option value="" <?php if (!isset($data['state'])) {
                                                                                                    echo " " . 'selected disabled';
                                                                                                } ?>>--Select A State--</option><?php } ?>
                                        <?php if (isset($data['state'])) { ?><option value="<?php if (isset($data['state'])) {
                                                                                                echo $data['state'] . " " . 'selected';
                                                                                            } ?>"><?php if (isset($data['state'])) {
                                                                                                        echo $data['state'];
                                                                                                    } ?></option><?php } ?>
                                        <option value="Johor">Johor</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Perak">Perak</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Penang">Penang</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Terengganu">Terengganu</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>
                                <div class="col-sm-4 statemop1prop">
                                    <input type="text" name="propstate" id="propstate" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>

                                <label for="altcountry" class="col-sm-2 col-form-label col-form-label-lg">&bull;Country</label>
                                <div class="col-sm-4">
                                    <input type="text" name="propcountry" id="propcountry" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select country
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP STATE-->
                            <!--(END)REP BILLING ADDRESS-->
                            <div class="form-group row">
                                <label for="propTelNo" class="col-sm-2  col-form-label col-form-label-lg">Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="propTelNo" name="propTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter Office tel no .
                                    </div>
                                </div> <label for="propMemberNo" class="col-sm-2  col-form-label col-form-label-lg">Membership No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="propMemberNo" name="propMemberNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter membership no .
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Sponsor Information:</legend>
                            <h5>Seconder</h5>
                            <div class="form-group row">
                                <label for="seconder" class="col-sm-2 col-form-label col-form-label-lg">Seconder</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter seconder" id="seconder" name="seconder" />
                                    <div class="invalid-feedback">
                                        Please enter seconder
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="seconfirm" class="col-sm-2 col-form-label col-form-label-lg">Firm</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter firm" id="seconfirm" name="seconfirm" />
                                    <div class="invalid-feedback">
                                        Please enter firm
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP ADDRESS1-->
                            <div class="form-group row">
                                <label for="seconsaddress1" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Street address, P.O box, C/O" id="seconaddress1" name="seconaltaddress1" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 1.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS1-->
                            <!--(START)REP ADDRESS2-->
                            <div class="form-group row">
                                <label for="seconaddress2" class="col-sm-2 col-form-label col-form-label-lg">&bull;Address 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Building, Suite, Unit, Floor" id="seconaddress2" name="seconaddress2" />
                                    <div class="invalid-feedback">
                                        Please enter billing address 2.
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ADDRESS2-->
                            <!--(START)REP CITY/TOWN-->
                            <div class="form-group row">
                                <label for="seconcity" class="col-sm-2 col-form-label col-form-label-lg">&bull;City/Town</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="seconcity" name="seconcity" placeholder="City/Town" />
                                    <div class="invalid-feedback">
                                        Please enter city/town
                                    </div>
                                </div>
                                <!--(END)REP CITY/TOWN-->
                                <!--(START)REP ZIP/POSTAL CODE-->
                                <label for="seconpostalCode" class="col-sm-2 col-form-label col-form-label-lg">&bull;Zip/Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Zip/Postal Code" id="seconpostalCode" name="seconpostalCode" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter postal code
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP ZIP/POSTAL CODE-->

                            <div class="form-group row">
                                <label for="statemnotsecon" class="col-sm-2 col-form-label col-form-label-lg">&bull;Enter State Manually</label>
                                <div class="col-sm-10">
                                    <label><input type="radio" name="statemnotsecon" id="statemnot1secon" class="statemnot1secon" value="1" />&nbsp;Yes</label>&nbsp;&nbsp;
                                    <label><input type="radio" name="statemnotsecon" id="statemnot2secon" class="statemnot2secon" value="0" checked="checked" />&nbsp;No</label>
                                    <div class="invalid-feedback">
                                        Please select manual or not
                                    </div>
                                </div>
                            </div>
                            <!--(START)REP STATE-->
                            <div class="form-group row">
                                <label for="seconstate" class="col-sm-2 col-form-label col-form-label-lg">&bull;State</label>
                                <div class="col-sm-4 statemopsecon">
                                    <select name="seconstate" id="seconstate" class="form-control">
                                        <?php if (!isset($data['state'])) { ?><option value="" <?php if (!isset($data['state'])) {
                                                                                                    echo " " . 'selected disabled';
                                                                                                } ?>>--Select A State--</option><?php } ?>
                                        <?php if (isset($data['state'])) { ?><option value="<?php if (isset($data['state'])) {
                                                                                                echo $data['state'] . " " . 'selected';
                                                                                            } ?>"><?php if (isset($data['state'])) {
                                                                                                        echo $data['state'];
                                                                                                    } ?></option><?php } ?>
                                        <option value="Johor">Johor</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Perak">Perak</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Penang">Penang</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Terengganu">Terengganu</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>
                                <div class="col-sm-4 statemop1secon">
                                    <input type="text" name="seconstate" id="seconstate" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select state
                                    </div>
                                </div>

                                <label for="altcountry" class="col-sm-2 col-form-label col-form-label-lg">&bull;Country</label>
                                <div class="col-sm-4">
                                    <input type="text" name="seconcountry" id="seconcountry" class="form-control" />
                                    <div class="invalid-feedback">
                                        Please select country
                                    </div>
                                </div>
                            </div>
                            <!--(END)REP STATE-->
                            <!--(END)REP BILLING ADDRESS-->
                            <div class="form-group row">
                                <label for="seconTelNo" class="col-sm-2  col-form-label col-form-label-lg">Tel No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="seconTelNo" name="seconTelNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter Office tel no .
                                    </div>
                                </div> <label for="seconMemberNo" class="col-sm-2  col-form-label col-form-label-lg">Membership No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="xx-xxx xxx" id="seconMemberNo" name="seconMemberNo" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                                    <div class="invalid-feedback">
                                        Please enter membership no .
                                    </div>
                                </div>
                            </div>
                        </fieldset>




                        <div class="form-group row">
                            <label for="dateAccepted" class="col-sm-2  col-form-label col-form-label-lg">Date Accepted</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="dateAccepted" name="dateAccepted" />
                                <div class="invalid-feedback">
                                    Please enter date accepted.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ssmVerification" class="col-sm-2 col-form-label col-form-label-lg">SSM Verification</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="SSM Verification" id="ssmVerification" name="ssmVerification" />
                                <div class="invalid-feedback">
                                    Please enter ssm verification
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks" class="col-sm-2 col-form-label col-form-label-lg">Remarks</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter remarks" id="remarks" name="remarks" />
                                <div class="invalid-feedback">
                                    Please enter remarks
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clientName" class="col-sm-2 col-form-label col-form-label-lg">Application Role</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="2" selected>Frontend Client</option>
                                    <?php /*    <option value="2" <?php if(isset($data['status'])&&$data['status']==2){echo 'selected';} ?>>Frontend Client</option>
                                <option value="1" <?php if(isset($data['status'])&&$data['status']==1){echo 'selected';} ?>>Client User</option> */ ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please enter client user<?php if (isset($data['status'])) {
                                                                echo 'selected';
                                                            } ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php if (isset($data['id'])) {
                                                                    echo $data['id'];
                                                                } ?>">

                        <?php additionalForm($_SESSION['orgType']); ?>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg"></label>
                            <div class="col-sm-10">
                                <input type="hidden" name="tid" value="<?php if (isset($data['id'])) {
                                                                            echo $data['id'];
                                                                        } ?>">
                                <button name='addMemberCompanyOrg' <?php
                                                                    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/organization.php");

                                                                    $isInLimit = isInLimit($_SESSION['orgId'], 2, "client");
                                                                    if ($isInLimit) {
                                                                    ?> disabled class="btn btn-secondary btn-lg btn-block" <?php
                                                                                                                        } else {
                                                                                                                            ?> class="btn btn-primary btn-lg btn-block" <?php
                                                                                                                                                                    }
                                                                                                                                                                        ?> type='submit'>SUBMIT</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

        </div>

    </div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <div class="footer">
        <p>Powered by JSoft Solution Sdn. Bhd</p>
    </div>

    </div>
    <script>
        $(document).ready(function() {
            $('.statemop1').css('display', 'none');
            $('.stateop1').css('display', 'none');
            $('input[type=radio][name="statenot"]').change(function() {
                if ($(this).val() == 1) {
                    $('.stateop').css('display', 'none');
                    $('.stateop1').css('display', 'flex');
                } else {
                    $('.stateop').css('display', 'flex');
                    $('.stateop1').css('display', 'none');
                }
            });

            $('input[type=radio][name="statemnot"]').change(function() {
                if ($(this).val() == 1) {
                    $('.statemop').css('display', 'none');
                    $('.statemop1').css('display', 'flex');
                } else {
                    $('.statemop').css('display', 'flex');
                    $('.statemop1').css('display', 'none');
                }
            });
            $('.statemop1rep').css('display', 'none');
            $('.stateop1rep').css('display', 'none');
            $('input[type=radio][name="statenotrep"]').change(function() {
                if ($(this).val() == 1) {
                    $('.stateoprep').css('display', 'none');
                    $('.stateop1rep').css('display', 'flex');
                } else {
                    $('.stateoprep').css('display', 'flex');
                    $('.stateop1rep').css('display', 'none');
                }
            });

            $('input[type=radio][name="statemnotrep"]').change(function() {
                if ($(this).val() == 1) {
                    $('.statemoprep').css('display', 'none');
                    $('.statemop1rep').css('display', 'flex');
                } else {
                    $('.statemoprep').css('display', 'flex');
                    $('.statemop1rep').css('display', 'none');
                }
            });
            $('.statemop1alt').css('display', 'none');
            $('.stateop1alt').css('display', 'none');
            $('input[type=radio][name="statenotalt"]').change(function() {
                if ($(this).val() == 1) {
                    $('.stateopalt').css('display', 'none');
                    $('.stateop1alt').css('display', 'flex');
                } else {
                    $('.stateopalt').css('display', 'flex');
                    $('.stateop1alt').css('display', 'none');
                }
            });

            $('input[type=radio][name="statemnotalt"]').change(function() {
                if ($(this).val() == 1) {
                    $('.statemopalt').css('display', 'none');
                    $('.statemop1alt').css('display', 'flex');
                } else {
                    $('.statemopalt').css('display', 'flex');
                    $('.statemop1alt').css('display', 'none');
                }
            });
            $('.statemop1prop').css('display', 'none');
            $('.stateop1prop').css('display', 'none');
            $('input[type=radio][name="statenotprop"]').change(function() {
                if ($(this).val() == 1) {
                    $('.stateopprop').css('display', 'none');
                    $('.stateop1prop').css('display', 'flex');
                } else {
                    $('.stateopprop').css('display', 'flex');
                    $('.stateop1prop').css('display', 'none');
                }
            });

            $('input[type=radio][name="statemnotprop"]').change(function() {
                if ($(this).val() == 1) {
                    $('.statemopprop').css('display', 'none');
                    $('.statemop1prop').css('display', 'flex');
                } else {
                    $('.statemopprop').css('display', 'flex');
                    $('.statemop1prop').css('display', 'none');
                }
            });
            $('.statemop1secon').css('display', 'none');
            $('.stateop1secon').css('display', 'none');
            $('input[type=radio][name="statenotsecon"]').change(function() {
                if ($(this).val() == 1) {
                    $('.stateopsecon').css('display', 'none');
                    $('.stateop1secon').css('display', 'flex');
                } else {
                    $('.stateopsecon').css('display', 'flex');
                    $('.stateop1secon').css('display', 'none');
                }
            });

            $('input[type=radio][name="statemnotsecon"]').change(function() {
                if ($(this).val() == 1) {
                    $('.statemopsecon').css('display', 'none');
                    $('.statemop1secon').css('display', 'flex');
                } else {
                    $('.statemopsecon').css('display', 'flex');
                    $('.statemop1secon').css('display', 'none');
                }
            });

            $('#sameAddress').on('click', function() {
                $('#instalAddress1').val($('#address1').val());
                $('#instalAddress2').val($('#address2').val());
                $('#instalCity').val($('#city').val());
                $('#instalState').val($('#state').val());
                $('#instalPCode').val($('#postalCode').val());
                $('#instalCountry').val($('#country').val());
            });

        });
    </script>
</body>
</html>