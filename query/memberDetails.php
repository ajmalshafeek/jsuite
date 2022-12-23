<?php

function addMemberCompany($con, $clientName, $emailAddress, $address1, $address2, $postalCode, $city, $state, $contactNo, $createdDate, $createdBy, $orgId, $cStatus, $country, $businessNature, $register)
{

	$compId = 0;

	$query = "INSERT INTO clientcompany (`name`,regNo,emailAddress,address1,address2,postalCode,
		city,`state`,contactNo,createdDate,createdBy,orgId,country,cStatus,businessType)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param(
		$stmt,
		'ssssssssissisis',
		$clientName,
		$register,
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
		$country,
		$cStatus,
		$businessNature
	);
	if (mysqli_stmt_execute($stmt)) {
		$compId = mysqli_insert_id($con);
	}
	mysqli_stmt_close($stmt);
	return $compId;
}


function
addMemberDetails(
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
) {
	$teleId = 0;
	$query = "INSERT INTO client_details (
	support_doc,
	membership_type,
	member_fees,
	website,
	business_nature,
	rep_name,
	rep_address,
	rep_address_line2,
	rep_city,
	rep_state,
	rep_pincode,
	rep_country,
	rep_tel_no_office,
	rep_tel_no_home,
	rep_tel_no_h_p,
	rep_nric_no_old,
	rep_nric_no_new,
	rep_gender,
	rep_dob,
	rep_nationality,
	alt_name,
	alt_address,
	alt_address_line2,
	alt_city,
	alt_state,
	alt_pincode,
	alt_country,
	alt_tel_no_office,
	alt_tel_no_home,
	alt_tel_no_h_p,
	alt_nric_no_old,
	alt_nric_no_new,
	alt_gender,
	alt_dob,
	alt_nationality,
	hrdf_member,
	props_name,
	props_firm,
	props_address,
	props_address_line2,
	props_city,
	props_state,
	props_pincode,
	props_country,
	props_tel_no,
	props_member_no,
	secon_name,
	secon_firm,
	secon_address,
	secon_address_line2,
	secon_city,
	secon_state,
	secon_pincode,
	secon_country,
	secon_tel_no,
	secon_member_no,
	accepted_date,
	ssm_verification,
	remark,
	nid,
	cid ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param(
		$stmt,
		'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssii',
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
	if (mysqli_stmt_execute($stmt)) {
		$teleId = mysqli_insert_id($con);
	}
	mysqli_stmt_close($stmt);
	return $teleId;
}

function updateFMMember($con, $uid, $user, $home, $folder, $clientName)
{
	$teleId = 0;
	$query = "INSERT INTO fm (uid,utype,access,ftype,`path`)
		VALUES (?,?,?,?,?)";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'iiiis', $uid, $user, $home, $folder, $clientName);
	if (mysqli_stmt_execute($stmt)) {
		$teleId = mysqli_insert_id($con);
	}
	mysqli_stmt_close($stmt);
	return $teleId;
}



function deleteMemberCompany($con, $companyId, $orgId)
{

	$success = false;



	$query = "DELETE FROM clientcompany WHERE id=? AND orgId=?";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'ii', $companyId, $orgId);

	if (mysqli_stmt_execute($stmt)) {

		$success = true;

		if (isset($_SESSION['orgType']) && $_SESSION['orgType'] == 6) {

			$querytel = "DELETE FROM clienttelcompany WHERE comid=?";

			$stmttel = mysqli_prepare($con, $querytel);

			mysqli_stmt_bind_param($stmttel, 'i', $companyId);

			if (mysqli_stmt_execute($stmttel)) {

				$_SESSION['deleteTelCompany'] = true;
			}
			mysqli_stmt_close($stmttel);
		}
	}
	mysqli_stmt_close($stmt);
	return $success;
}
function getMemberName($con, $id)
{
	$name = "";
	$query = "SELECT * FROM clientcompany WHERE id='" . $id . "'";
	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($result)) {
		$name = $row['name'];
	}
	return $name;
}

function getMemberCompanyDetailsById($con, $id)
{
	$name = array();

	$query = "SELECT * FROM clientcompany WHERE id='" . $id . "'";
	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($result)) {
		$name = $row;
	}
	return $name;
}


function fetchOrganizationMeberCompanyListUnlinked($con, $status)
{

	$dataList = array();

	$vendorCreated = 0;

	$query = "SELECT * FROM clientcompany

		WHERE status=? AND isVendorCreated=? AND clientcompany.id NOT IN (

			SELECT clientcompanyid from vendorclient

			)";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'ii', $status, $vendorCreated);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	while ($row = $result->fetch_assoc()) {

		$dataList[] = $row;
	}

	mysqli_stmt_close($stmt);



	return $dataList;
}





function fetchOrganizationMemberCompanyList($con, $status, $orgId)
{

	$dataList = array();

	$vendorCreated = 0;

	$query = "SELECT * FROM clientcompany WHERE status=? AND isVendorCreated=? AND orgId=? ORDER BY name";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'iii', $status, $vendorCreated, $orgId);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	while ($row = $result->fetch_assoc()) {

		$dataList[] = $row;
	}

	mysqli_stmt_close($stmt);



	return $dataList;
}



function fetchMemberCompanyListByCreatedOrg($con, $status, $orgId)
{

	$dataList = array();



	$query = "SELECT * FROM clientcompany as c ,client_details as cd WHERE c.status=? AND c.orgId=? AND c.id=cd.cid;";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'ii', $status, $orgId);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	while ($row = $result->fetch_assoc()) {

		$dataList[] = $row;
	}

	mysqli_stmt_close($stmt);



	return $dataList;
}

function fetchMemberCompanyListByCreatedBy($con, $createdBy, $status, $orgId)
{

	$dataList = array();



	$query = "SELECT * FROM clientcompany WHERE createdBy=? AND status=? AND orgId=?";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'iii', $createdBy, $status, $orgId);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	while ($row = $result->fetch_assoc()) {

		$dataList[] = $row;
	}

	mysqli_stmt_close($stmt);



	return $dataList;
}



function fetchMemberCompanyList($con, $vendorId, $status)
{

	$dataList = array();



	$query = "SELECT * FROM clientcompany WHERE vendorId=? AND status=?";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'ii', $vendorId, $status);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	while ($row = $result->fetch_assoc()) {

		$dataList[] = $row;
	}

	mysqli_stmt_close($stmt);



	return $dataList;
}



function fetchMemberCompanyDetails($con, $clientCompanyId)
{

	$query = "SELECT * FROM clientcompany WHERE id=? ";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'i', $clientCompanyId);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$value = "";
	while ($row = $result->fetch_assoc()) {
		$value = $row;
	}
	//	$row=$result->fetch_assoc();
	mysqli_stmt_close($stmt);
	return $value;
}



function noOfMember($con, $orgId)
{

	$query = "SELECT * FROM clientcompany WHERE  orgId=?";

	$stmt = mysqli_prepare($con, $query);

	mysqli_stmt_bind_param($stmt, 'i', $orgId);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	$num_rows = mysqli_num_rows($result);



	return $num_rows;
}




function fetchMeberCompanyListAll($con)
{

	$dataList = array();

	$query = "SELECT * FROM clientcompany WHERE 1";

	$stmt = mysqli_prepare($con, $query);

	//mysqli_stmt_bind_param($stmt,'ii',$vendorId,$status);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	while ($row = $result->fetch_assoc()) {

		$dataList[] = $row;
	}

	mysqli_stmt_close($stmt);



	return $dataList;
}

function checkMemberName($con, $clientName)
{
	$query = "SELECT COUNT(name) as num FROM `clientcompany` WHERE `name`=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 's', $clientName);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_array($result);
	$success = $row['num'];
	mysqli_stmt_close($stmt);
	return $success;
}

function fetchNewMemberCompanyList($con, $value)
{
	$dataList = array();
	$query = "SELECT * FROM `newrequest` WHERE `clientType`=" . $value . " ORDER BY id DESC";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	while (($row = $result->fetch_assoc()) != false) {
		$dataList[] = $row;
	}
	return $dataList;
}

function fetchNewMemberDetails($con, $id)
{
	$dataList = array();
	$query = "SELECT * FROM `newrequest` WHERE `id`=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	while ($row = $result->fetch_assoc()) {
		$dataList = $row;
	}
	return $dataList;
}
function removeFromNewMemberRequest($con, $id)
{
	$success = false;
	$query = 'DELETE FROM `newrequest` WHERE id=?';
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $id);
	if (mysqli_stmt_execute($stmt)) {
		$success = true;
	}
	return $success;
}
function addPotantialMember($con, $id, $value)
{
	$success = false;
	$query = "UPDATE `newrequest` SET clientType=? WHERE id=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'ii', $value, $id);
	if (mysqli_stmt_execute($stmt)) {
		$success = true;
	}
	mysqli_stmt_close($stmt);
	return $success;
}
/*

	function fetchUserCriteria($con,$uid,$criteriaDate){

		$query="SELECT * FROM criteria WHERE userId=? AND date(createdTime)=? LIMIT 1";

		$stmt=mysqli_prepare($con,$query);

		mysqli_stmt_bind_param($stmt,'is',$uid,$criteriaDate);

		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);



		$row=$result->fetch_assoc();

		mysqli_stmt_close($stmt);



		return $row;

	}

	function isExistCriteria($con,$uid,$criteriaDate){



		$exist=false;

		$query="SELECT * FROM criteria WHERE userId=? AND date(createdTime)=?";

		$stmt=mysqli_prepare($con,$query);

		mysqli_stmt_bind_param($stmt,'is',$uid,$criteriaDate);

		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		$num_rows = mysqli_num_rows($result);

		if($num_rows>0){

			$exist=true;

		}

		mysqli_stmt_close($stmt);



		return $exist;

	}

	function fetchMyGroupMemberCriteria($con,$groupId,$criteriaDate){

		$dataList=array();



		$query="SELECT * FROM criteria as c inner join users as u

		WHERE c.userid=u.id AND u.groupId=?

		and Date(c.createdTime)=?";

		$stmt=mysqli_prepare($con,$query);

		mysqli_stmt_bind_param($stmt,'is',$groupId,$criteriaDate);

		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		while($row=$result->fetch_assoc()){

			$dataList[]=$row;

		}

		mysqli_stmt_close($stmt);



		return $dataList;

	}



	function updateToCriteria($con,$user,$criteria,$criteriaDate,$createdBy,$weeklyTotal){

		$success=false;

		$attendance=$criteria[0];

		$visitor=$criteria[1];

		$commitment=$criteria[2];

		$presentation=$criteria[3];

		$training=$criteria[4];

		$referal=$criteria[5];

		$query="UPDATE criteria SET attendance=?,visitors=?, commitment=?, presentation=?,training=?,referal=?,weeklyTotal=?

		WHERE userId=? AND date(createdTime)=?";

		$stmt=mysqli_prepare($con,$query);

		mysqli_stmt_bind_param($stmt,'iiiiiiiis',$attendance,$visitor,$commitment,$presentation,$training,$referal,$weeklyTotal,$user,$criteriaDate);

		if(mysqli_stmt_execute($stmt)){

			$success=true;

		}

		mysqli_stmt_close($stmt);

		return $success;

	}

	function insertToCriteria($con,$user,$criteria,$createdTime,$createdBy,$weeklyTotal){

		$success=false;

		$attendance=$criteria[0];

		$visitor=$criteria[1];

		$commitment=$criteria[2];

		$presentation=$criteria[3];

		$training=$criteria[4];

		$referal=$criteria[5];

		$query="INSERT INTO criteria (userId,attendance,visitors,commitment,presentation,training,referal,createdTime,createdBy,weeklyTotal) VALUES (?,?,?,?,?,?,?,?,?,?)";

		$stmt=mysqli_prepare($con,$query);

		mysqli_stmt_bind_param($stmt,'iiiiiiisii',$user,$attendance,$visitor,$commitment,$presentation,$training,$referal,$createdTime,$createdBy,$weeklyTotal);

		if(mysqli_stmt_execute($stmt)){

			$success=true;

		}

		mysqli_stmt_close($stmt);

		return $success;

	}









*/
