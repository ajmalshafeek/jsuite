<?php
$config = parse_ini_file(__DIR__ . "/../jsheetconfig.ini");
if (!isset($_SESSION)) {
    session_name($config['sessionName']);
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/isLogin.php");

require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/connect.php");
require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/memberDetails.php");

if (isset($_GET['quotClientId'])) {
    $companyId = $_GET['quotClientId'];
    $clientCompanyDetails = fetchClientCompanyDetail($companyId);
    echo json_encode($clientCompanyDetails);
}

if (isset($_POST['addMemberCompanyOrg'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/organization.php");
    $isInLimit = isInLimit($_SESSION['orgId'], 2, "client");

    $con = connectDb();
    $clientName = "";
    if (isset($_POST['clientName']) && !empty($_POST['clientName']))
        $clientName = trim($_POST['clientName']);
    $tempNum = checkMemberName($con, $clientName);

    if ($tempNum > 0) {
        $_SESSION['feedback'] = "<div class='alert alert-danger' role='alert'>\n
			<strong>FAILED!</strong> MEMBER ALREADY EXIST \n
			</div>\n";
    } else {
        if ($isInLimit) {
            $_SESSION['feedback'] = "<div class='alert alert-warning' role='alert'>\n
				<strong>FAILED!</strong> YOU ALREADY REACH THE LIMIT TO ADD MEMBER \n
				</div>\n
				";
        } else {

            $_SESSION['feedback'] = "<div class='alert alert-danger' role='alert'>\n
			<strong>FAILED!</strong> FAILED TO ADD MEMBER\n
			</div>\n";
            $createdDate = date('Y-m-d H:i:s');
            $createdBy = $_SESSION['userid'];
            $orgId = $_SESSION['orgId'];
            $regNo = "";
            $businessType = NULL;
            if (isset($_POST['bussiType'])) {
                $businessType = $_POST['bussiType'];
            }
            $register = NULL;
            if (isset($_POST['register'])) {
                $register = $_POST['register'];
            }
            $emailAddress = NULL;
            if (isset($_POST['clientEmail'])) {
                $emailAddress = $_POST['clientEmail'];
            }
            $address1 = $_POST['address1'];
            $address2 = $_POST['address2'];
            $postalCode = $_POST['postalCode'];
            $city = $_POST['city'];
            $state = strtoupper($_POST['state']);
            $contactNo = $_POST['clientContactNo'];
            $cStatus = NULL;
            if (isset($_POST['country'])) {
                $country = strtoupper($_POST['country']); //strtoupper() change all letters in string into Country letter
            } else {
                $country = NULL;
            }
            //(END)INSTALLATION ADDRESS
            $compId = addMemberCompany(
                $con,
                $clientName,
                $emailAddress,
                $address1,
                $address2,
                $postalCode,
                $city,
                $state,
                $contactNo,
                $createdDate,
                $createdBy,
                $orgId,
                $cStatus,
                $country,
                $businessType,
                $register
            );
            if ($compId > 0) {
                $support_doc = $_POST['suppDoc'];
                $membership_type = $_POST['memberType'];
                $member_fees = $_POST['member_fees'];
                $website = $_POST['website'];
                $business_nature = $_POST['business'];
                $rep_name = $_POST['representative'];
                $rep_address = $_POST['repaddress1'];
                $rep_address_line2 = $_POST['repaddress2'];
                $rep_city = $_POST['repcity'];
                $rep_state = $_POST['repstate'];
                $rep_pincode = $_POST['reppostalCode'];
                $rep_country = $_POST['repcountry'];
                $rep_tel_no_office = $_POST['repOfficeTelNo'];
                $rep_tel_no_home = $_POST['repHomeTelNo'];
                $rep_tel_no_h_p = $_POST['repHPTelNo'];
                $rep_nric_no_old = $_POST['repNRIC_old'];
                $rep_nric_no_new = $_POST['repNRIC_new'];
                $rep_gender = $_POST['repGender'];
                $rep_dob = $_POST['repDOB'];
                $rep_nationality = $_POST['repNationality'];
                $alt_name = $_POST['altresentative'];
                $alt_address = $_POST['altaddress1'];
                $alt_address_line2 = $_POST['altaddress2'];
                $alt_city = $_POST['altcity'];
                $alt_state = $_POST['altstate'];
                $alt_pincode = $_POST['altpostalCode'];
                $alt_country = $_POST['altcountry'];
                $alt_tel_no_office = $_POST['altOfficeTelNo'];
                $alt_tel_no_home = $_POST['altHomeTelNo'];
                $alt_tel_no_h_p = $_POST['altHPTelNo'];
                $alt_nric_no_old = $_POST['altNRIC_old'];
                $alt_nric_no_new = $_POST['altNRIC_new'];
                $alt_gender = $_POST['altGender'];
                $alt_dob = $_POST['altDOB'];
                $alt_nationality = $_POST['altNationality'];
                $hrdf_member = $_POST['hrdf'];
                $props_name = $_POST['proposer'];
                $props_firm = $_POST['propfirm'];
                $props_address = $_POST['propaddress1'];
                $props_address_line2 = $_POST['propaddress2'];
                $props_city = $_POST['propcity'];
                $props_state = $_POST['propstate'];
                $props_pincode = $_POST['proppostalCode'];
                $props_country = $_POST['propcountry'];
                $props_tel_no = $_POST['propTelNo'];
                $props_member_no = $_POST['propMemberNo'];
                $secon_name = $_POST['seconder'];
                $secon_firm = $_POST['seconfirm'];
                $secon_address = $_POST['seconaltaddress1'];
                $secon_address_line2 = $_POST['seconaddress2'];
                $secon_city = $_POST['seconcity'];
                $secon_state = $_POST['seconstate'];
                $secon_pincode = $_POST['seconpostalCode'];
                $secon_country = $_POST['seconcountry'];
                $secon_tel_no = $_POST['seconTelNo'];
                $secon_member_no = $_POST['seconMemberNo'];
                $accepted_date = $_POST['dateAccepted'];
                $ssm_verification = $_POST['ssmVerification'];
                $remark = $_POST['remarks'];
                $nid = $_POST['tid'];
                $cid = $compId;
                $detailsSave = addMemberDetails(
                    $con,
                    $support_doc,
                    $membership_type,
                    $member_fees,
                    $website,
                    $business_nature,
                    $rep_name,
                    $rep_address,
                    $rep_address_line2,
                    $rep_city,
                    $rep_state,
                    $rep_pincode,
                    $rep_country,
                    $rep_tel_no_office,
                    $rep_tel_no_home,
                    $rep_tel_no_h_p,
                    $rep_nric_no_old,
                    $rep_nric_no_new,
                    $rep_gender,
                    $rep_dob,
                    $rep_nationality,
                    $alt_name,
                    $alt_address,
                    $alt_address_line2,
                    $alt_city,
                    $alt_state,
                    $alt_pincode,
                    $alt_country,
                    $alt_tel_no_office,
                    $alt_tel_no_home,
                    $alt_tel_no_h_p,
                    $alt_nric_no_old,
                    $alt_nric_no_new,
                    $alt_gender,
                    $alt_dob,
                    $alt_nationality,
                    $hrdf_member,
                    $props_name,
                    $props_firm,
                    $props_address,
                    $props_address_line2,
                    $props_city,
                    $props_state,
                    $props_pincode,
                    $props_country,
                    $props_tel_no,
                    $props_member_no,
                    $secon_name,
                    $secon_firm,
                    $secon_address,
                    $secon_address_line2,
                    $secon_city,
                    $secon_state,
                    $secon_pincode,
                    $secon_country,
                    $secon_tel_no,
                    $secon_member_no,
                    $accepted_date,
                    $ssm_verification,
                    $remark,
                    $nid,
                    $cid
                );
                if($detailsSave==0){
                    deleteMemberCompany($con,$compId,2);
                    $_SESSION['feedback'] = "<div class='alert alert-danger' role='alert'>\n
			        <strong>FAILED!</strong> FAILED TO ADD MEMBER\n
			        </div>\n";
                    header("Location:  https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/organization/member/addMember.php");
                }

                require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/clientUser.php");
                require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/memberDetails.php");
                $name = "";
                $identification = "";
                $userName = $_POST['clientEmail'];
                $password = "12345678";
                $email = $_POST['clientEmail'];
                $status = 1;
                if (isset($_POST['status'])) {
                    $status = $_POST['status'];
                }
                $fullName="";
                $role = 9999;
                $companyId = $compId;
                $saveSuccess = addClientUser($con, $fullName, $name, $identification, $userName, $password, $email, $status, $role, $companyId, $orgId);
                if ($saveSuccess) {
                    if ($_SESSION['memberReg']) {
                        require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/subscriber.php");
                        require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/registration.php");
                        $tid = $_POST['tid'];
                        if (empty($tid)) {
                            $price = null;
                            $payNow = 0;
                            $transactionID = null;
                            $planList = array();
                            $title = "";
                            $description = "";
                            $duration = 0;
                            $memebershipStatus = 0;
                            $memebershipPaid = 0;
                            $name = $name;
                            $date = date("Y-m-d h:i:s");
                            $payStatus = newClientTransaction($con, $date, $duration, $memebershipStatus, $memebershipPaid, $title, $description, $price, $transactionID, $companyId);
                        } else {
                            updateClientId($con, $companyId, $tid);
                        }
                    }
                    /*
                    if (isset($_SESSION['orgType']) && $_SESSION['orgType'] == 3) {

                        $ClientDetails = getClientDetailsByUsername($con, $userName);
                        $folder = updateFMMember($con, $ClientDetails['id'], 1, 0, 0, $clientName);
                        if ($folder > 0) {
                            $path = $_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/resources/files/" . $clientName;
                            if (!is_dir($path)) {
                                mkdir($path, 0777, true);
                            }
                        }
                    }*/
                    /* start of CLEANTO ADD USER */
                    /*
                    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/cleanto/objects/class_users.php");
                    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/cleanto/objects/class_connection.php");

                    $database = new cleanto_db();

                    $user = new cleanto_users();
                    $user->conn = $database->connect();
                    $user->user_pwd = md5($password);
                    $user->first_name = ucwords("");
                    $user->last_name = ucwords("");
                    $user->user_email = $email;
                    $user->phone = $contactNo;

                    $user->address = $address1 . " " . $address2;
                    $user->zip = $postalCode;
                    $user->city = $city;
                    $user->state = $state;

                    $user->notes = "";
                    $user->vc_status = "-";
                    $user->p_status = "-";
                    $user->status = 'E';
                    $user->usertype = serialize(array('client'));
                    $user->contact_status = "";
                    $add_user = $user->add_user();
                    */
                    /* end of CLEANTO ADD USER */

                    $_SESSION['feedback'] = "<div class='alert alert-success' role='alert'>\n
					<strong>SUCCESS!</strong> SUCCESSFULLY ADDED " . $clientName . "\n
					<br/><strong>Email : </strong>" . $email . "\n
					<br/><strong>Password : </strong>" . $password . "
					</div>\n";
                    if ($_SESSION['orgType'] == 8 || $_SESSION['orgType'] == 3) {
                        $rq = removeFromNewMemberRequest($con, $_POST['id']);
                    }
                    if (checkIfEmailSentSetModule($con, $_SESSION['role'])) {
                        require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/mail.php");
                        require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/organization.php");
                        $orgDetails = fetchOrganizationDetails($_SESSION['orgId']);
                        $from = $orgDetails['supportEmail'];
                        $fromName = $orgDetails['name'];
                        $subject = "Your Account is created successful";
                        $body = "<h4 style='text-align: center'>THANK YOU FOR JOINING!</h4>";
                        $body .= "<p style='text-align: center'>Hi " . $clientName . ",<br/><br/>Your account has been successfully created. We welcome you to the community of KLSICCI. It is our privilege to have you as our member.</p>
                        <br />Below are your login credentials.
						<br/><strong>Email : </strong>" . $email . "
						<br/><strong>Password : </strong>" . $password . "
                            <br />Click the <a href='https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "'>link</a>  to login to your account! <br/><br/>";
                        if ($_SESSION['memberReg']) {
                            require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/subscriber.php");
                            $myPlan = getMembershipDetails($con, $companyId);
                            $plan = "";
                            if (strlen($myPlan['title']) > 3) {
                                $plan .= "Subscription Date : " . $myPlan['pay'] . "<br/>";
                                $plan .= "Your Plan         : " . $myPlan['title'] . "<br/>";
                                $plan .= "Plan Detail       : " . $myPlan['description'] . "<br/>";
                                $plan .= "Plan Price        : RM " . $myPlan['price'] . "<br/>";
                                $plan .= "Plan Duration     : " . $myPlan['end'] . " Months<br/><br/><br/><br/>";
                            } else {
                                $plan = "Your free subscription is created now you can select any plan.<br/><br/><br/>";
                            }
                        }
                        $body .= $plan;
                        mailsend($from, $fromName, $email, $subject, $body);
                    }
                }
            }
        }
    }
    header("Location:  https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/organization/member/addMember.php");
}


if (isset($_POST['editMember'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/phpfunctions/organization.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/connect.php");
    $memberId = $_POST['memberIdToEdit'];
    $con = connectDb();
    $sql = "SELECT `clientcompany`.*,`clientuser`.`status` as app ,`client_details`.* FROM `clientcompany`, `clientuser`, `client_details` WHERE `clientcompany`.`id` = ".$memberId." AND `clientcompany`.`id` = `clientuser`.`companyId` AND `client_details`.`cid`= `clientcompany`.`id`;";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $orgId = $_SESSION['orgId'];
    $sessionId = null;
    $userType = $orgId;
    $_SESSION['idEdit'] = $memberId;
    $name = "";
    if (isset($row['name']) && !empty($row['name']))
        $name = trim($row['name']);
    $_SESSION['memberNameEdit'] = $name;
    $_SESSION['clientAddress1Edit'] = $row['address1'];
    $_SESSION['clientAddress2Edit'] = $row['address2'];
    $_SESSION['clientCityEdit'] = $row['city'];
    $_SESSION['clientPostalCodeEdit'] = $row['postalCode'];
    $_SESSION['clientStateEdit'] = $row['state'];
    $_SESSION['clientPhoneNumberEdit'] = $row['contactNo'];
    $_SESSION['clientFaxNoEdit'] = $row['faxNo'];
    $_SESSION['clientEmailAddressEdit'] = $row['emailAddress'];
    $_SESSION['cStatusEdit'] = $row['cStatus'];
    $_SESSION['country'] = $row['country'];
    $_SESSION['nameEdit'] = $row['customer'];
    $_SESSION['businessEdit'] = $row['businessType'];
    $_SESSION['incorpEdit'] = $row['incorpDate'];
    $_SESSION['finYearEdit'] = $row['FinancialMonth'];
    $_SESSION['registerEdit'] = $row['regNo'];
    $_SESSION['app'] = $row['app'];
    $_SESSION['support_doc'] = $row['support_doc'];
    $_SESSION['membership_type'] = $row['membership_type'];
    $_SESSION['member_fees'] = $row['member_fees'];
    $_SESSION['website'] = $row['website'];
    $_SESSION['business_nature'] = $row['business_nature'];
    $_SESSION['rep_name'] = $row['rep_name'];
    $_SESSION['rep_address'] = $row['rep_address'];
    $_SESSION['alt_address_line2'] = $row['alt_address_line2'];
    $_SESSION['alt_city'] = $row['alt_city'];
    $_SESSION['rep_state'] = $row['rep_state'];
    $_SESSION['rep_pincode'] = $row['rep_pincode'];
    $_SESSION['rep_country'] = $row['rep_country'];
    $_SESSION['rep_tel_no_office'] = $row['rep_tel_no_office'];
    $_SESSION['rep_tel_no_home'] = $row['rep_tel_no_home'];
    $_SESSION['rep_tel_no_h_p'] = $row['rep_tel_no_h_p'];
    $_SESSION['rep_nric_no_old'] = $row['rep_nric_no_old'];
    $_SESSION['rep_nric_no_new'] = $row['rep_nric_no_new'];
    $_SESSION['rep_gender'] = $row['rep_gender'];
    $_SESSION['rep_dob'] = $row['rep_dob'];
    $_SESSION['rep_nationality'] = $row['rep_nationality'];
    $_SESSION['alt_name'] = $row['alt_name'];
    $_SESSION['alt_address'] = $row['alt_address'];
    $_SESSION['alt_address_line2'] = $row['alt_address_line2'];
    $_SESSION['alt_city'] = $row['alt_city'];
    $_SESSION['alt_state'] = $row['alt_state'];
    $_SESSION['alt_pincode'] = $row['alt_pincode'];
    $_SESSION['alt_country'] = $row['alt_country'];
    $_SESSION['alt_tel_no_office'] = $row['alt_tel_no_office'];
    $_SESSION['alt_tel_no_home'] = $row['alt_tel_no_home'];
    $_SESSION['alt_tel_no_h_p'] = $row['alt_tel_no_h_p'];
    $_SESSION['alt_nric_no_old'] = $row['alt_nric_no_old'];
    $_SESSION['alt_nric_no_new'] = $row['alt_nric_no_new'];
    $_SESSION['alt_gender'] = $row['alt_gender'];
    $_SESSION['alt_dob'] = $row['alt_dob'];
    $_SESSION['alt_nationality'] = $row['alt_nationality'];
    $_SESSION['hrdf_member'] = $row['hrdf_member'];
    $_SESSION['props_name'] = $row['props_name'];
    $_SESSION['props_firm'] = $row['props_firm'];
    $_SESSION['props_address'] = $row['props_address'];
    $_SESSION['props_address_line2'] = $row['props_address_line2'];
    $_SESSION['props_city'] = $row['props_city'];
    $_SESSION['props_state'] = $row['props_state'];
    $_SESSION['props_pincode'] = $row['props_pincode'];
    $_SESSION['props_country'] = $row['props_country'];
    $_SESSION['props_tel_no'] = $row['props_tel_no'];
    $_SESSION['props_member_no'] = $row['props_member_no'];
    $_SESSION['secon_name'] = $row['secon_name'];
    $_SESSION['secon_firm'] = $row['secon_firm'];
    $_SESSION['secon_address'] = $row['secon_address'];
    $_SESSION['secon_address_line2'] = $row['secon_address_line2'];
    $_SESSION['secon_city'] = $row['secon_city'];
    $_SESSION['secon_state'] = $row['secon_state'];
    $_SESSION['secon_pincode'] = $row['secon_pincode'];
    $_SESSION['secon_country'] = $row['secon_country'];
    $_SESSION['secon_tel_no'] = $row['secon_tel_no'];
    $_SESSION['secon_member_no'] = $row['secon_member_no'];
    $_SESSION['receive_date'] = $row['receive_date'];
    $_SESSION['con_approve_date'] = $row['con_approve_date'];
    $_SESSION['ssm_verification'] = $row['ssm_verification'];
    $_SESSION['accepted_date'] = $row['accepted_date'];
    $_SESSION['remark'] = $row['remark'];
    $_SESSION['category'] = $row['category'];
    $_SESSION['District'] = $row['District'];
    $_SESSION['wedc'] = $row['wedc'];
    $_SESSION['stage'] = $row['stage'];

    header("Location:  https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/organization/member/editMember.php");
    die();
}
if (isset($_POST['editMemberCompanyProcess'])) {
    $memberId = $_SESSION['idEdit'];
    $name = "";
    if (isset($_POST['clientName']) && !empty($_POST['clientName']))
        $name = trim($_POST['clientName']);
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $postalCode = $_POST['postalCode'];
    $state = $_POST['state'];
    $contactNo = $_POST['clientContactNo'];
    $cStatusS = NULL; //This value is unused
    if (isset($_POST['clientContactNo'])) {
        $contactNo = $_POST['clientContactNo'];
    } else {
        $contactNo = NULL;
    }
    $businessType = NULL;
    if (isset($_POST['business'])) {
        $businessType = $_POST['business'];
    }
    $incorpDate = NULL;
    if (isset($_POST['incorp'])) {
        $incorpDate = $_POST['incorp'];
    }
    $financialYear = NULL;
    if (isset($_POST['financialYear'])) {
        $financialYear = $_POST['financialYear'];
    }
    $register = NULL;
    if (isset($_POST['register'])) {
        $register = $_POST['register'];
    }
    $fullName = NULL;
    if (isset($_POST['name'])) {
        $fullName = $_POST['name'];
    }
    $appUser = NULL;
    if (isset($_POST['status'])) {
        $appUser = $_POST['status'];
    }

    if (isset($_POST['clientFaxNo'])) {
        $faxNo = $_POST['clientFaxNo'];
    } else {
        $faxNo = NULL;
    }
    $emailAddress = $_POST['clientEmail'];
    //(START)NEW
    //(START)INSTALLATION ADDRESS
    if (isset($_POST['instalAddress1'])) {
        $instalAddress1 = $_POST['instalAddress1'];
    } else {
        $instalAddress1 = NULL;
    }

    if (isset($_POST['instalAddress2'])) {
        $instalAddress2 = $_POST['instalAddress2'];
    } else {
        $instalAddress2 = NULL;
    }

    if (isset($_POST['instalPCode'])) {
        $instalPCode = $_POST['instalPCode'];
    } else {
        $instalPCode = NULL;
    }

    if (isset($_POST['instalCity'])) {
        $instalCity = $_POST['instalCity'];
    } else {
        $instalCity = NULL;
    }

    if (isset($_POST['instalState'])) {
        $instalState = strtoupper($_POST['instalState']); //strtoupper() change all letters in string into capital letter
    } else {
        $instalState = NULL;
    }
    if (isset($_POST['country'])) {
        $country = strtoupper($_POST['country']); //strtoupper() change all letters in string into capital letter
    } else {
        $country = NULL;
    }
    if (isset($_POST['instalCountry'])) {
        $instalCountry = strtoupper($_POST['instalCountry']); //strtoupper() change all letters in string into capital letter
    } else {
        $instalCountry = NULL;
    }
    //(END)INSTALLATION ADDRESS
    //$cStatus = $_POST['cStatus'];



    //END PRODUCT
    //(END)NEW

    $sql = "UPDATE `clientcompany` SET `name`='$name',`address1`='$address1',`address2`='$address2',`city`='$city',`postalCode`='$postalCode',`state`='$state',`contactNo`='$contactNo',`faxNo`='$faxNo',`emailAddress`='$emailAddress',`instalAddress1`='$instalAddress1',`instalAddress2`='$instalAddress2', `instalCity`='$instalCity', `instalPCode`='$instalPCode',`instalState`='$instalState',`country`='$country', `instalCountry`='$instalCountry',`customer`='$fullName', `businessType`='$businessType', `incorpDate`='$incorpDate', `FinancialMonth`='$financialYear', `regNo`='$register' WHERE `id`='$memberId'";

    $con = connectDb();
    //$result = mysqli_query($con,$sql);
    if (mysqli_query($con, $sql)) {
        if (isset($_SESSION['orgType']) && $_SESSION['orgType'] != 3 || isset($_SESSION['orgType']) && $_SESSION['orgType'] != 8) {
            $appUser = NULL;
        }
        $sqlupdate = "UPDATE `clientuser` SET `status`='$appUser', `username`='$emailAddress', `email`='$emailAddress' WHERE `companyId`='$memberId'";
        $result = mysqli_query($con, $sqlupdate);

        $support_doc = $_POST['suppDoc'];
        $membership_type = $_POST['memberType'];
        $member_fees = $_POST['member_fees'];
        $website = $_POST['website'];
        $business_nature = $_POST['business'];
        $rep_name = $_POST['representative'];
        $rep_address = $_POST['repaddress1'];
        $rep_address_line2 = $_POST['repaddress2'];
        $rep_city = $_POST['repcity'];
        $rep_state = $_POST['repstate'];
        $rep_pincode = $_POST['reppostalCode'];
        $rep_country = $_POST['repcountry'];
        $rep_tel_no_office = $_POST['repOfficeTelNo'];
        $rep_tel_no_home = $_POST['repHomeTelNo'];
        $rep_tel_no_h_p = $_POST['repHPTelNo'];
        $rep_nric_no_old = $_POST['repNRIC_old'];
        $rep_nric_no_new = $_POST['repNRIC_new'];
        $rep_gender = $_POST['repGender'];
        $rep_dob = $_POST['repDOB'];
        $rep_nationality = $_POST['repNationality'];
        $alt_name = $_POST['altresentative'];
        $alt_address = $_POST['altaddress1'];
        $alt_address_line2 = $_POST['altaddress2'];
        $alt_city = $_POST['altcity'];
        $alt_state = $_POST['altstate'];
        $alt_pincode = $_POST['altpostalCode'];
        $alt_country = $_POST['altcountry'];
        $alt_tel_no_office = $_POST['altOfficeTelNo'];
        $alt_tel_no_home = $_POST['altHomeTelNo'];
        $alt_tel_no_h_p = $_POST['altHPTelNo'];
        $alt_nric_no_old = $_POST['altNRIC_old'];
        $alt_nric_no_new = $_POST['altNRIC_new'];
        $alt_gender = $_POST['altGender'];
        $alt_dob = $_POST['altDOB'];
        $alt_nationality = $_POST['altNationality'];
        $hrdf_member = $_POST['hrdf'];
        $props_name = $_POST['proposer'];
        $props_firm = $_POST['propfirm'];
        $props_address = $_POST['propaddress1'];
        $props_address_line2 = $_POST['propaddress2'];
        $props_city = $_POST['propcity'];
        $props_state = $_POST['propstate'];
        $props_pincode = $_POST['proppostalCode'];
        $props_country = $_POST['propcountry'];
        $props_tel_no = $_POST['propTelNo'];
        $props_member_no = $_POST['propMemberNo'];
        $secon_name = $_POST['seconder'];
        $secon_firm = $_POST['seconfirm'];
        $secon_address = $_POST['seconaltaddress1'];
        $secon_address_line2 = $_POST['seconaddress2'];
        $secon_city = $_POST['seconcity'];
        $secon_state = $_POST['seconstate'];
        $secon_pincode = $_POST['seconpostalCode'];
        $secon_country = $_POST['seconcountry'];
        $secon_tel_no = $_POST['seconTelNo'];
        $secon_member_no = $_POST['seconMemberNo'];
        $accepted_date = $_POST['dateAccepted'];
        $ssm_verification = $_POST['ssmVerification'];
        $remark = $_POST['remarks'];
        $nid = $_POST['tid'];
        $cid = $memberId;

           $dataUpdate="`support_doc`='$support_doc',
            `membership_type`='$membership_type',
            `member_fees`='$member_fees',
            `website`='$website',
            `business_nature`='$business_nature',
            `rep_name`='$rep_name',
            `rep_address`='$rep_address',
            `rep_address_line2`='$rep_address_line2',
            `rep_city`='$rep_city',
            `rep_state`='$rep_state',
            `rep_pincode`='$rep_pincode',
            `rep_country`='$rep_country',
            `rep_tel_no_office`='$rep_tel_no_office',
            `rep_tel_no_home`='$rep_tel_no_home',
            `rep_tel_no_h_p`='$rep_tel_no_h_p',
            'rep_nric_no_old`='$rep_nric_no_old',
            `rep_nric_no_new`='$rep_nric_no_new',
            `rep_gender`='$rep_gender',
            `rep_dob`='$rep_dob',
            `rep_nationality`='$rep_nationality',
            `alt_name`='$alt_name',
            `alt_address`='$alt_address',
            `alt_address_line2`='$alt_address_line2',
            `alt_city`='$alt_city',
            `alt_state`='$alt_state',
            `alt_pincode`='$alt_pincode',
            `alt_country`='$alt_country',
            `alt_tel_no_office`='$alt_tel_no_office',
            `alt_tel_no_home`='$alt_tel_no_home',
            `alt_tel_no_h_p`='$alt_tel_no_h_p',
            `alt_nric_no_old`='$alt_nric_no_old',
            `alt_nric_no_new`='$alt_nric_no_new',
            'alt_gender`='$alt_gender',
            `alt_dob`='$alt_dob',
            `alt_nationality`='$alt_nationality',
            `hrdf_member`='$hrdf_member',
            `props_name`=`$props_name`,
            `props_firm`='props_firm',
            `props_address`='$props_address',
            `props_address_line2`='$props_address_line2',
            `props_city`='$props_city',
            `props_state`='$props_state',
            `props_pincode`='$props_pincode',
            `props_country`='$props_country',
            `props_tel_no`='$props_tel_no',
            `props_member_no`='$props_member_no',
            `secon_name`='$secon_name',
            `secon_firm`='$secon_firm',
            `secon_address`='$secon_address',
            `secon_address_line2`='$secon_address_line2',
            `secon_city`='$secon_city',
            `secon_state`='$secon_state',
            `secon_pincode`='$secon_pincode',
            `secon_country`='$secon_country',
            `secon_tel_no`='$secon_tel_no',
            `secon_member_no`='$secon_member_no',
            `accepted_date`='$accepted_date',
            `ssm_verification`='$ssm_verification',
            `remark`='$remark'";
         

        $sqlupdateDetails = "UPDATE `client_details` SET ".$dataUpdate." WHERE `cid`='$memberId'";
        $result = mysqli_query($con, $sqlupdateDetails);
        $_SESSION['feedback'] = "<div class='alert alert-success' role='alert'>\n
    <strong>SUCCESS!</strong> MEMBER INFORMATIONS SUCCESSFULLY UPDATED\n
    <br/><strong>NAME : </strong>" . $name . "\n
    <br/><strong>EMAIL : </strong>" . $emailAddress . "\n
    </div>\n"; //TROUBLESHOOT
    } else {
        $_SESSION['feedback'] = "<div class='alert alert-warning' role='alert'>\n
			<strong>FAILED!</strong>FAILED TO EDIT MEMBER'S INFORMATIONS\n
			</div>\n
			";
    }


    header("Location:  https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/organization/client/viewClient.php");
}

if (isset($_POST['removeMember'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/clientUser.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/clientComplaint.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/vendorClient.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/session.php");


    $_SESSION['feedback'] = "<div class='alert alert-warning' role='alert'>\n
			<strong>FAILED!</strong>FAILED TO DELETE CLIENT \n
			</div>\n
			";
    $saveSuccess = false;
    $con = connectDb();
    $staffId = null;
    $companyId = $_POST['memberIdToEdit'];
    $orgId = $_SESSION['orgId'];

    $clientUserList = fetchClientUserList($con, $companyId, $orgId);
    $sessionId = null;
    $userType = -1;
    foreach ($clientUserList as $user) {
        $saveSuccess = deleteUserSession($con, $user['id'], $sessionId, $userType, $orgId);
    }

    $saveSuccess = deleteClientUser($con, $staffId, $companyId, $orgId);
    if ($saveSuccess) {
        $saveSuccess = deleteClientCompany($con, $companyId, $orgId);
        if ($saveSuccess) {
            $messageStatus = null;
            $status = 2;
            $complaintId = null;
            $vendorId = null;
            $saveSuccess = deleteVendorClient($con, $companyId, $vendorId, $orgId);
            $saveSuccess = deleteClientComplaint($con, $complaintId, $messageStatus, $status, $companyId, $orgId);
        }
    }

    if ($saveSuccess) {
        $_SESSION['feedback'] = "<div class='alert alert-success' role='alert'>\n
			<strong>SUCCESS!</strong> MEMBER SUCCESSFULLY REMOVED \n
			</div>\n";
    }
    header("Location:  https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/organization/member/viewClient.php");
}


function memberListTable()
{
    $con = connectDb();

    $table = "<div class='table-responsive'>\n";
    $table .= "<table  class='table' id='dataTable' width='100%' cellspacing='0' >\n";
    $table .= "<thead class='thead-dark'>\n";
    $table .= "<tr>\n";
    $table .= "<th>\n";
    $table .= "#\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "CLIENT NAME\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "USERNAME\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "PASSWORD\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "ACTION\n";
    $table .= "</th>\n";

    $table .= "</tr>\n";
    $table .= "</thead >\n";

    $i = 1;
    $orgId = $_SESSION['orgId'];
    $dataList = fetchClientCompanyListByCreatedOrg($con, 1, $orgId);
    $config = parse_ini_file(__DIR__ . "/../jsheetconfig.ini");

    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/clientUser.php");

    foreach ($dataList as $data) {
        $clientAdminDetails = fetchClientAdminDetails($con, $data['id'], $orgId);
        $table .= "<tr ";
        if ($i % 2 == 0)
            $table .= "style='background-color:#FFF5EB;'";
        else {
            $table .= "style='background-color:#F9F9F9;'";
        }
        $table .= ">";

        $table .= "<td style='font-weight:bold'>";
        $table .= $i++;
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['name'];
        $table .= "</td>";

        $table .= "<td>";
        $table .= $clientAdminDetails['username'];
        $table .= "</td>";

        $table .= "<td>";
        $table .= "<input type='password' class='form-control' style='width:70%' id='" . $data['id'] . "' disabled value='" . $clientAdminDetails['password'] . "' /><span style='cursor:pointer' onclick='showPassword(" . $data['id'] . ")' > show</span>";
        $table .= "</td>";

        $table .= "<td>";
        $table .= "<div class='dropdown'>";
        $table .= "<button type='button' class='btn  dropdown-toggle' data-toggle='dropdown'>
				OPTION
				</button>
				<div class='dropdown-menu'>";

        $table .= "<button type='button' data-toggle='modal' data-target='#clientDeleteModal' class='dropdown-item' onclick='clientEdit(this)' value='$data[id]' style='cursor:pointer'>REMOVE</button>";
        $table .= "</div>
					</div>";
        $table .= "</td>";

        $table .= "</tr>";
    }
    $table .= "</table>";
    $table .= "</div>";

    echo $table;
}

function dropDownListOrganizationMemberCompanyActiveUnlinked()
{
    $con = connectDb();
    $status = 1;
    $client = fetchOrganizationClientCompanyListUnlinked($con, $status);
    echo "<div class='form-group row' >\n";
    echo "<label for='cliendCompanyId' class='col-sm-2 col-form-label col-form-label-lg'  >Member</label>";
    echo "<div class='col-sm-10' >\n";
    echo "<select name='cliendCompanyId' class='form-control' id='cliendCompanyId' required>";
    echo "<option selected disabled >--SELECT--</option>\n";
    foreach ($client as $data) {
        echo "<option value=" . $data['id'] . " >" . $data['name'] . "</option>";
    }


    echo "</select>";
    echo "</div>";
    echo "</div>";
}

function dropDownOptionListOrganizationMemberCompanyActive()
{
    $con = connectDb();
    $optionList = "";
    $status = 1;
    $orgId = $_SESSION['orgId'];
    $client = fetchOrganizationMemberCompanyList($con, $status, $orgId);
    //echo "<div class='form-group row' >\n" ;
    //echo "<label for='cliendCompanyId' class='col-sm-2 col-form-label col-form-label-lg'  >CLIENT</label>";
    echo "<div class='col-sm-10' >\n";
    //echo "<select name='cliendCompanyId' class='form-control' id='cliendCompanyId' required>";
    //echo "<option selected disabled >--SELECT--</option>\n";
    foreach ($client as $data) {
        $organization = "organization";
        $optionList .= "<option value=" . $data['id'] . ">" . $data['name'] . "</option>";
    }


    //echo	"</select>";
    //echo "</div>";
    //echo "</div>";
    return $optionList;
}

function dropDownListOrganizationMemberCompanyActive()
{
    $con = connectDb();
    $status = 1;
    $orgId = $_SESSION['orgId'];
    $client = fetchOrganizationClientCompanyList($con, $status, $orgId);
    echo "<div class='form-group row' >\n";
    echo "<label for='cliendCompanyId' class='col-sm-2 col-form-label col-form-label-lg'  >Member</label>";
    echo "<div class='col-sm-10' >\n";
    echo "<select name='cliendCompanyId' class='form-control' id='cliendCompanyId' required>";
    echo "<option selected disabled >--Select--</option>\n";
    foreach ($client as $data) {
        echo "<option value=" . $data['id'] . " >" . $data['name'] . "</option>";
    }


    echo "</select>";
    echo "</div>";
    echo "</div>";
}

function dropDownListOrganizationMemberCompanyActive3()
{
    $con = connectDb();
    $status = 1;
    $orgId = $_SESSION['orgId'];
    $client = fetchOrganizationClientCompanyList($con, $status, $orgId);

    echo "<select onchange='clientId()' name='clientCompanyId' class='form-control' id='clientCompanyId'>";
    echo "<option selected >--Select--</option>\n";
    foreach ($client as $data) {
        echo "<option value=" . $data['id'] . " >" . $data['name'] . "</option>";
    }
    echo "</select>";
}

function dropDownListOrganizationMemberCompanyName()
{
    $con = connectDb();
    $status = 1;
    $orgId = $_SESSION['orgId'];
    $client = fetchOrganizationClientCompanyList($con, $status, $orgId);

    echo "<select onchange='clientId()' name='clientCompanyName' class='form-control' id='clientCompanyName' required>";
    echo "<option selected disabled >--Select--</option>\n";
    foreach ($client as $data) {
        echo "<option value=\"" . trim($data['name']) . "\" >" . $data['name'] . "</option>";
    }

    echo "</select>";
}

function dropDownListMemberCompanyActive()
{
    $con = connectDb();
    $vendorId = $_SESSION['vendorId'];
    $status = 1;
    $client = fetchMemberCompanyList($con, $vendorId, $status);
    echo "<div class='form-group row' >\n";
    echo "<label for='cliendCompanyId' class='col-sm-2 col-form-label col-form-label-lg'  >CLIENT</label>";
    echo "<div class='col-sm-10' >\n";
    echo "<select name='cliendCompanyId' class='form-control' id='cliendCompanyId' required>";

    foreach ($client as $data) {
        echo "<option value=" . $data['id'] . " >" . $data['name'] . "</option>";
    }


    echo "</select>";
    echo "</div>";
    echo "</div>";
}

function fetchMemberCompanyDetail($companyId)
{
    $con = connectDb();
    $clientCompanyDetails = fetchMemberCompanyDetails($con, $companyId);
    return $clientCompanyDetails;
}

function memberListTableEditable()
{
    $con = connectDb();

    $table = "<div class='table-responsive'>\n";
    $table .= "<table  class='table' id='memberTable' width='100%' cellspacing='0' >\n";
    $table .= "<thead class='thead-dark'>\n";
    $table .= "<tr>\n";
    $table .= "<th>\n";
    $table .= "#\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= $_SESSION['clientas'] . " Name\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Email";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Contact";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Address";
    $table .= "</th>\n";
    if ($_SESSION['clientpasscol'] == 1) {
        $table .= "<th>\n";
        $table .= "Password\n";
        $table .= "</th>\n";
    }

    $table .= "<th>\n";
    $table .= "support_doc";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "membership_type";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "member_fees";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "website";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "business_nature";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_name";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_address";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_tel_no_office";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_tel_no_home";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_tel_no_h_p";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_nric_no_old";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_nric_no_new";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_gender";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_dob";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "rep_nationality";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_name";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_address";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_tel_no_office";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_tel_no_home";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_tel_no_h_p";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_nric_no_old";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_nric_no_new";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_gender";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_dob";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "alt_nationality";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "acknow_date";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "hrdf_member";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "props_name";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "props_firm";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "props_address";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "props_tel_no";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "props_member_no";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "secon_name";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "secon_firm";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "secon_address";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "secon_tel_no";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "secon_member_no";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "receive_date";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "con_approve_date";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "ssm_verification";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "accepted_date";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "remark";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "category";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "District";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "wedc";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "stage";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "Action\n";
    $table .= "</th>\n";

    $table .= "</tr>\n";
    $table .= "</thead >\n";
    $i = 1;
    $orgId = $_SESSION['orgId'];
    $dataList = fetchMemberCompanyListByCreatedOrg($con, 1, $orgId);
    $config = parse_ini_file(__DIR__ . "/../jsheetconfig.ini");

    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/clientUser.php");
    $address = "";

    foreach ($dataList as $data) {
        $clientAdminDetails = fetchClientAdminDetails($con, $data['id'], $orgId);
        if (!empty($data['address1'])) {
            $address = $data['address1'];
        }
        if (!empty($data['address2'])) {
            $address .= ", " . $data['address2'];
        }
        if (!empty($data['city'])) {
            $address .= ", " . $data['city'];
        }
        if (!empty($data['postalCode'])) {
            $address .= " " . $data['postalCode'];
        }
        if (!empty($data['state'])) {
            $address .= ", " . $data['state'];
        }
        if (!empty($data['country'])) {
            $address .= " " . $data['country'];
        }
        $table .= "<tr ";
        if ($i % 2 == 0)
            $table .= "style='background-color:#FFF5EB;'";
        else {
            $table .= "style='background-color:#F9F9F9;'";
        }
        "onclick='clientProduct(" . $data['id'] . ")' data-toggle='modal' data-target='#clientProductModal' >";
        $table .= ">";

        $table .= "<td style='font-weight:bold' >";
        $table .= $i++;
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['name'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['emailAddress'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['contactNo'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $address;
        $table .= "</td>";
        if ($_SESSION['clientpasscol'] == 1) {

                $table.=	"<td>";
                $table.="<input type='password' class='form-control' style='width:70%' id='".$data['id']."' disabled value='".$clientAdminDetails['password']."' /><span style='cursor:pointer' onclick='showPassword(".$data['id'].")' > show</span>";
                $table.=	"</td>";
        }
        $table .= "<td>";
        $table .= $data['support_doc'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['membership_type'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['member_fees'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['website'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['business_nature'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_name'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_address']." ". $data['rep_address_line2']." ".$data['rep_city']." ".$data['rep_state']." ".$data['rep_pincode']." ".$data['rep_country'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_tel_no_office'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_tel_no_home'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_tel_no_h_p'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_nric_no_old'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_nric_no_new'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_gender'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_dob'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['rep_nationality'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_name'];
        $table .= "</td>";
        $table .= "<td>";
        $table .=$data['alt_address']. " ".$data['alt_address_line2']." ". $data['alt_city']." ". $data['alt_state']." ".$data['alt_pincode']." ".$data['alt_country'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_tel_no_office'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_tel_no_home'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_tel_no_h_p'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_nric_no_old'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_nric_no_new'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_gender'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_dob'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['alt_nationality'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['acknow_date'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['hrdf_member'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['props_name'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['props_firm'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['props_address']. " ".$data['props_address_line2']." ". $data['props_city']." ". $data['props_state']." ". $data['props_pincode']." ".$data['props_country'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['props_tel_no'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['props_member_no'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['secon_name'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['secon_firm'];
        $table .= "</td>";
        $table .= "<td>";
        $table .=$data['secon_address']. " ".$data['secon_address_line2']." ". $data['secon_city']." ". $data['secon_state']." ".$data['secon_pincode']." ".$data['secon_country'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['secon_tel_no'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['secon_member_no'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['receive_date'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['con_approve_date'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['ssm_verification'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['accepted_date'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['remark'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['category'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['District'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['wedc'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= $data['stage'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= "<div class='dropdown'>";
        $table .= "<button type='button' class='btn  dropdown-toggle' data-toggle='dropdown'>
				OPTION
				</button>
				<div class='dropdown-menu'>";

        $table .= "<button type='button' data-toggle='modal' data-target='#clientEditModal' class='dropdown-item' onclick='memberEdit(this)' value='$data[cid]' style='cursor:pointer'>ACTIONS</button>";
        $table .= "</div>
					</div>";
        $table .= "</td>";

        $table .= "</tr>";
    }
    $table .= "</table>";
    $table .= "</div>";

    echo $table;
}




function memberListDataTable()
{
    $con = connectDb();

    $table = "<div class='table-responsive'>\n";
    $table .= "<table  class='table' id='dataTable2' width='100%' cellspacing='0' >\n";
    $table .= "<thead class='thead-dark'>\n";
    $table .= "<tr>\n";
    $table .= "<th>\n";
    $table .= "#\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "COMPANY NAME\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "PERSON IN CHARGE\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "ADDRESS\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "CONTACT NO\n";
    $table .= "</th>\n";

    $table .= "<th>\n";
    $table .= "EMAIL\n";
    $table .= "</th>\n";

    $table .= "</tr>\n";
    $table .= "</thead>\n";
    $table .= "<tbody>\n";
    $i = 1;
    $orgId = $_SESSION['orgId'];
    $dataList = fetchMemberCompanyListAll($con);
    $config = parse_ini_file(__DIR__ . "/../jsheetconfig.ini");

    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/memberDetails.php");

    foreach ($dataList as $data) {
        $clientAdminDetails = fetchClientAdminDetails($con, $data['id'], $orgId);
        $table .= "<tr>\n";
        $table .= "<td>\n";
        $table .= $i . "\n";
        $table .= "</td>\n";
        $table .= "<td>\n";
        $table .= $data['name'] . "\n";
        $table .= "</td>\n";

        $table .= "<td>\n";
        $table .= $clientAdminDetails['username'] . "\n";
        $table .= "</td>\n";

        $table .= "<td>\n";
        $table .= $data['address1'] . "," . $data['address2'] . "," . $data['postalCode'] . "," . $data['city'] . "," . $data['state'] . "\n";
        $table .= "</td>\n";

        $table .= "<td>\n";
        $table .= $data['contactNo'] . "\n";
        $table .= "</td>\n";

        $table .= "<td>\n";
        $table .= $data['emailAddress'] . "\n";
        $table .= "</td>\n";

        $table .= "</tr>\n";
        $i++;
    }
    $table .= "</tbody>\n";
    $table .= "</table>";
    $table .= "</div>";

    echo $table;
}

function newMemberRequestListTableEditable($value)
{
    $con = connectDb();

    $table = "<div class='table-responsive'>\n";
    $table .= "<table  class='table' id='dataTable' width='100%' cellspacing='0' >\n";
    $table .= "<thead class='thead-dark'>\n";
    $table .= "<tr>\n";
    $table .= "<th>\n";
    $table .= "#\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= " Name\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Company";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Email";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Country\n";
    $table .= "</th>\n";
    $table .= "<th>\n";
    $table .= "Action\n";
    $table .= "</th>\n";

    $table .= "</tr>\n";
    $table .= "</thead >\n";

    $i = 1;
    $orgId = $_SESSION['orgId'];
    $dataList = fetchNewMemberCompanyList($con, $value);
    $config = parse_ini_file(__DIR__ . "/../jsheetconfig.ini");

    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/query/clientUser.php");

    foreach ($dataList as $data) {
        $table .= "<tr ";
        if ($i % 2 == 0)
            $table .= "style='background-color:#FFF5EB;'";
        else {
            $table .= "style='background-color:#F9F9F9;'";
        }
        $table .= ">";

        $table .= "<td style='font-weight:bold' onclick='clientProduct(" . $data['id'] . ")' data-toggle='modal' data-target='#clientProductModal' >";
        $table .= $i++;
        $table .= "</td>";
        $table .= "<td onclick='clientProduct(" . $data['id'] . ")' data-toggle='modal' data-target='#clientProductModal' >";
        $table .= $data['name'];
        $table .= "</td>";
        $table .= "<td onclick='clientProduct(" . $data['id'] . ")' data-toggle='modal' data-target='#clientProductModal' >";
        $table .= $data['company'];
        $table .= "</td>";
        $table .= "<td onclick='clientProduct(" . $data['id'] . ")' data-toggle='modal' data-target='#clientProductModal' >";
        $table .= $data['email'];
        $table .= "</td>";
        $table .= "<td onclick='clientProduct(" . $data['id'] . ")' data-toggle='modal' data-target='#clientProductModal' >";
        $table .= $data['country'];
        $table .= "</td>";
        $table .= "<td>";
        $table .= "<div class='dropdown'>";
        $table .= "<button type='button' class='btn  dropdown-toggle' data-toggle='dropdown'>
				OPTION
				</button>
				<div class='dropdown-menu'>";
        $table .= "<button type='button' data-toggle='modal' data-target='#clientEditModal' class='dropdown-item' onclick='clientEdit(this)' value='$data[id]' style='cursor:pointer'>ACTIONS</button>";
        $table .= "</div>
					</div>";
        $table .= "</td>";

        $table .= "</tr>";
    }
    $table .= "</table>";
    $table .= "</div>";

    echo $table;
}

function getNewMemberDetails($id)
{
    $con = connectDb();
    $data = fetchNewMemberDetails($con, $id);
    return $data;
}

function updatePotantialMember($id, $value)
{
    $con = connectDb();
    $res = addPotantialMember($con, $id, $value);

    if ($res) {
        header("Location:  https://" . $_SERVER['HTTP_HOST'] . $GLOBALS['config']['appRoot'] . "/organization/client/newClientRequest.php");
    }
}
