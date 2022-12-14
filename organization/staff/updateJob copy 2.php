
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");
if(!isset($_SESSION))
{
 session_name($config['sessionName']);
   session_start();
}
require($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/clientCompany.php");
require($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/clientComplaint.php");
require($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/orgJobList.php");
require($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/job.php");
require($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/organization/staff/moreForm/form.php");

//(START)FORM DEFAULT VALUE
if (isset($_POST['jobId']) && isset($_POST['jobName']) && isset($_POST['clientName']) && isset($_POST['problemDetails']) && isset($_POST['jobTransId'])) {
  $jobId = $_POST['jobId'];
  $jobName = $_POST['jobName'];
  $client = $_POST['clientName'];
  $problemDetails = $_POST['problemDetails'];
  $jobTransId = $_POST['jobTransId'];
  $clientAddress = $_POST['clientAddress'];
  $clientInstalAddress = $_POST['clientInstalAddress'];
  $_SESSION['clientAddress'] = $_POST['clientAddress'];
  $_SESSION['clientInstalAddress'] = $_POST['clientInstalAddress'];
  $zone = $_POST['zone'];
  $service = $_POST['service'];
  $csName = $_POST['csName'];
}else{
/*  unset($_SESSION['jobId']);
  unset($_SESSION['jobName']);
  unset($_SESSION['client']);
  unset($_SESSION['jobTransId']);
  unset($_SESSION['problemDetails']); */
  $jobId = $_SESSION['jobId'];
  $jobName = $_SESSION['jobName'];
  $client = $_SESSION['client'];
  $jobTransId = $_SESSION['jobTransId'];
  $_POST['jobId'] = $jobId;
  $problemDetails = $_SESSION['problemDetails'];
  $_POST['updateAssignedTask'] = true;
  $clientAddress = $_SESSION['clientAddress'];
  $clientInstalAddress = $_SESSION['clientInstalAddress'];
  $zone = $_SESSION['zone'];
  $service = $_SESSION['service'];
  $csName = $_SESSION['csName'];
}
$meterArray = meterDetails($jobId);
$meter1 = $meterArray[0];
$meter2 = $meterArray[1];
$meter3 = $meterArray[2];
$meter4 = $meterArray[3];
$meterTotal = $meterArray[4];

$action = actionDetail($jobId);
$remarks = remarksDetail($jobId);

//START TIME
if (startTime($jobId)==NULL) {
  $startTime = date('Y-m-d')."T".date("h:i");
}else {
  $startTime = date('Y-m-d', strtotime(startTime($jobId)))."T".date('h:i', strtotime(startTime($jobId)));
}
//(END)FORM DEFAULT VALUE

//BOOING DATE
$con = connectDb();
$rowJob = fetchJobDetails($con,$jobId);
$rowComplaint = fetchComplainDetails($con,$rowJob['complaintId']);
$bookingDate = date("d/m/Y H:i:sa",strtotime($rowComplaint['requireDate']));
//(END)BOOING DATE
?>
<!DOCTYPE >

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link href="../../css/component-custom-switch.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/app/favIcon.ico'; ?>' />


  <!--
    <script src="../js/jquery-3.3.1.slim.min.js" ></script>
        <script src="../../js/bootstrap.min.js" ></script>



    <script type="text/javascript" src="../../js/jquery-3.3.1.min.js"></script>
-->
<?php
      require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/importScripts.php");
    ?>
	  <script>



function dateValueEnd(end){
  return end;
}

    function sparepartDelete(str){
      document.getElementById("sparepartToDelete").value = str;
    }

    function sparepartEdit(str){

      //$("#sparepartToEdit").val(str.value);
      $("#sparepartToEdit").val(str.value);

    }

    function updateTabClass(id){
      if(id=='update'){
        $('#signatureParent').resize();
      }

    }
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

        $(document).ready(function() {
            // Initialize jSignature
            var $sigdiv = $("#signature").jSignature({
              'UndoButton':true

            });

            true

            $('#signature').change(function() {
                var data = $sigdiv.jSignature('getData', 'image');
                // Storing in textarea
                //$('#output').val(data);

                // Alter image source
              //  alert(data);
                $('#imageBase64').attr('value', "data:" + data);
             //   $('#sign_prev').show();
            });
        });

        function toggleJobField(str){

          var id=str;
          if(id==0)
          {
            document.getElementById("jobName").style.display = "block";
          }else{
            document.getElementById("jobName").style.display = "none";
          }

        }

        function requiredButtonChange(){
            var buttonShow = document.getElementById("requiredButton").innerHTML;
            if(buttonShow == "Click here if required"){
            document.getElementById("requiredButton").innerHTML= "Cancle"
            ;}
            else if(buttonShow == "Cancle"){
            document.getElementById("requiredButton").innerHTML= "Click here if required"
            }
        }

        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.watchPosition(showPosition);
          } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
          }
        }

        function showPosition(position){
          document.getElementById("latitude").value = position.coords.latitude;
          document.getElementById("longitude").value = position.coords.longitude;
        }
      </script>
    <style>
    #signature{

      border:solid 1px #E32526;
}
    .buttonAsLink{
      background:none!important;
      color:inherit;
      border:none;
      font: inherit;
      cursor: pointer;

    }

            .bg-red{
                background-color: #E32526;
            }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th{
      background: grey;
      color: black;
    }

    table, th, td {
      border: 1px solid black;
    }
    </style>

</head>
<body class="fixed-nav ">

<?php
  include $_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/navMenu.php";
?>
<script src="../../js/jsignature/jSignature.min.js"></script>

<h1 class="display-4">UPDATE JOB</h1>
<hr/>
<div class="container">
      <form id="mainForm" method="POST" action="../../phpfunctions/job.php" class="needs-validation" novalidate >

        <div id="jobUpdate">
        <?php
        if (isset($_SESSION['feedback'])) {
            echo $_SESSION['feedback'];
            unset($_SESSION['feedback']);
        }

      ?>

      <div class="form-group row">
        <label for="clientCompanyId" class="col-sm-2 col-form-label col-form-label-lg">CLIENT</label>
        <div class="col-sm-10"   >
          <?php
          if (isset($_POST['updateAssignedTask'])) {
           ?>
           <input type="text" readonly class="form-control" id="problem" value="<?php echo $client; ?>">
           <?php
          }
          else{
            dropDownListOrganizationClientCompanyActive3();
        //   dropDownVendorClientCompany();
          }
          ?>

        </div>
      </div>

      <div class="form-group row">
        <label for="clientCompanyId" class="col-sm-2 col-form-label col-form-label-lg">ADDRESS</label>
        <div class="col-sm-10"   >
           <input type="text" readonly class="form-control" id="problem" value="<?php echo $clientAddress; ?>">
        </div>
      </div>

      <div class="form-group row">
        <label for="clientCompanyId" class="col-sm-2 col-form-label col-form-label-lg">INSTAL. ADDRESS</label>
        <div class="col-sm-10"   >
           <input type="text" readonly class="form-control" id="problem" value="<?php echo $clientInstalAddress; ?>">
        </div>
      </div>

      <div class="form-group row">
            <label for="jobName" class="col-sm-2 col-form-label col-form-label-lg">
            <?php
              if (isset($_POST['updateAssignedTask'])) {
                echo "PROBLEM";
              }else{
                echo "JOBNAME";
              }
                ?>
            </label>
            <div class="col-sm-10"   >
              <?php
               if (isset($_POST['updateAssignedTask'])) {
                ?>
                  <input type="text" readonly class="form-control" id="jobName" value="<?php echo $jobName; ?>">
                <?php
                }
                else{
                  dropDownOrgJobList() ;
                }
              ?>

              <input type="text" class="form-control" placeholder="Enter job name" id="jobName" name="jobName" style="display:none;"></input>
              <div class="invalid-feedback">
                Please enter job name
              </div>
            </div>
        </div>

          <?php
               if (isset($_POST['updateAssignedTask'])) {
          ?>
        <div class="form-group row">
            <label for="jobName" class="col-sm-2 col-form-label col-form-label-lg">PROBLEM DETAILS</label>
            <div class="col-sm-10"   >
               <textarea class="form-control" readonly id="problemDetails" name="problemDetails"  ><?php echo $problemDetails; ?></textarea>

            </div>
          </div>
          <?php
               }
          //     dropDownVendorJobList();
          ?>
        <?php
        		if($config['joblistitem']==true){
              require($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/job.php");
              jobItemListForm(null,$_SESSION['orgId']);
            }
        ?>

        <div class="form-group row">
          <label for="startTime" class="col-sm-2 col-form-label col-form-label-lg">BOOKING DATE</label>
          <div class="col-sm-10"   >
            <input type="text" readonly value="<?php echo $bookingDate ?>" name="bookingDate" id="bookingDate" class="form-control" >
            <div class="invalid-feedback">
              Please enter start time
            </div>
          </div>
        </div>

          <div class="form-group row">
            <label for="startTime" class="col-sm-2 col-form-label col-form-label-lg">START TIME</label>
            <div class="col-sm-10"   >
              <input type="datetime-local" readonly onchange="dateValueStart(this.value)" value="<?php echo $startTime ?>" name="startTime" id="startTime" class="form-control" >
              <div class="invalid-feedback">
                Please enter start time
              </div>
            </div>
          </div>

          <input type="datetime-local" hidden onchange="dateValueEnd(this.value)" value="<?php echo date('Y-m-d'); ?>T<?php echo date("h:i")?>" name="endTime" id="endTime" class="form-control" >

          <?php additionalForm($jobId,$meter1,$meter2,$meter3,$meter4,$meterTotal,$zone,$service,$action); ?>
<!--(START)ACTION TAKEN-->
      <div class="form-group row">
       <label for="action" class="col-sm-2 col-form-label col-form-label-lg">ACTION TAKEN</label>
       <div class="col-sm-10"   >
         <textarea name="action" id="action" class="form-control"><?php echo $action ?></textarea>
         <!--<input type="text" value="" name="action" id="action" class="form-control" > -->
         <div class="invalid-feedback">
           Please enter action taken
         </div>
       </div>
      </div>
<!--(END)ACTION TAKEN-->

          <div class="form-group row">
            <label for="remarks" class="col-sm-2 col-form-label col-form-label-lg">REMARKS</label>
            <div class="col-sm-10"   >
              <textarea class="form-control" id="remarks" name="remarks" ><?php echo $remarks ?></textarea>
              <div class="invalid-feedback">
                Please enter job remarks
              </div>
            </div>
          </div>
<?php if($_SESSION['orgType']==1){ ?>
<!--(START)SPAREPART-->
          <div class="form-group row">
            <label for="sparePart" class="col-sm-2 col-form-label col-form-label-lg">SPARE PART</label>
            <div class="col-sm-10"   >
              <table class="table order-list table-responsive  table-hover table-bordered" id="spTable">
              <tr>
                <th style="width:75%;background: gray;">DESCRIPTION</th>
                <th style="width:25%;background: gray;">QUANTITY</th>
              </tr>
              <!-- (START)FETCH FROM JOBSPAREPARTS TALBE -->
                <script> var i = 0;var j = 0; </script>
                <?php
                //$dataList = NULL;
                $dataList = tableSparePart();
                if ($dataList == NULL) {

                }
                else {
                  foreach($dataList as $data) {
                  echo "<tr><td>".$data['description']."</td><td>".$data['qty']."</td><td><i data-toggle='modal' data-target='#sparepartDeleteModal' onclick='sparepartDelete(".$data['id'].")' class='fa fa-trash' style='color:red; font-size: 1.5em;cursor: pointer;'></i></td></tr>";
                  //echo "<tr><td>".$data['description']."</td><td>".$data['qty']."</td><td><i data-toggle='modal' data-target='#sparepartEditModal' onclick='sparepartEdit(this)' class='fa fa-pencil' style='color:green; font-size: 1.5em; cursor: pointer;'></i></td><td><i data-toggle='modal' data-target='#sparepartDeleteModal' onclick='sparepartDelete(this)' class='fa fa-trash' style='color:red; font-size: 1.5em;cursor: pointer;'></i></td></tr>";
                  ?><script> i++; j++</script><?php
                  }
                }
                ?>
              <!-- (END)FETCH FROM JOBSPAREPARTS TABLE -->
              <tr>
                <td><input type="text" name='spDes0' class="form-control"/></td>
                <td><input type="number" name='spQty0' class="form-control"/></td>
              </tr>
              <tr>
                <td><button onclick="addTableRow()" type="button" class="btn btn-lg btn-block btn-success fa fa-plus "></td>
                  <td><button type='button' onclick='removeTableRow()' class='ibtnDel btn btn-md btn-danger fa fa-minus' ></button></td>
              </tr>
              <input type="text" hidden name="jobId" id="jobId" value="<?php echo $jobId ?>"  />
            </table>
            <script>
            //var i=0;
            var n=0
            //COOKIE
            function setCookie(cname,cvalue,exdays) {
              var d = new Date();
              d.setTime(d.getTime() + (exdays*24*60*60*1000));
              var expires = "expires=" + d.toGMTString();
              document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function numRow(){
              i++;
              return i;
            }

            function increment(){
              n++;
              return n;
            }

            function addTableRow() {
              var i=numRow();
              var n=increment();
              var table = document.getElementById("spTable");
              var row = table.insertRow(i+1);
              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              cell1.innerHTML = "<input type='text' name='spDes"+n+"' class='form-control'/>";
              cell2.innerHTML = "<input type='number' name='spQty"+n+"' class='form-control'/>";
              //cell3.innerHTML = n;
            }

            function removeTableRow() {
              if (i!=0 && i>j) {
                document.getElementById("spTable").deleteRow(i+1);
                i--;
              }
            }


            </script>
            <br>
            </div>
          </div>
<!--(END)SPAREPART-->
<?php } ?>
<hr>
<!--(START)CUSTOMER NAME-->
          <div class="form-group row">
            <label for="csName" class="col-sm-2 col-form-label col-form-label-lg">CUSTOMER'S NAME</label>
            <div class="col-sm-10"   >
              <input type="text" value="<?php echo $csName ?>" name="csName" id="csName" class="form-control" >
            </div>
          </div>
<!--(END)CUSTOMER NAME-->
<!--(START)SIGNATURE-->
          <div class='form-group row' id='signatureParent' >
            <label for='signature' class='col-sm-2 col-form-label col-form-label-lg'  >CUSTOMER'S SIGNATURE</label>
              <div class='col-sm-10' >
                <div id="signature" name="signature" ></div>
              </div>
          </div>
<!--(END)SIGNATURE-->

          <div class='form-group row' >
            <label for='status' class='col-sm-2 col-form-label col-form-label-lg' >STATUS</label>
            <div class='col-sm-10'  >
              <select name='status' class='form-control form-control-lg' id='status' required>
                <option value="0" >COMPLETE</option>
                <option value="2" >PENDING</option>
                <option value="3" >IN PROGRESS</option>
              </select>
            </div>
          </div>
          <input type="hidden" value="" id="imageBase64" name="imageBase64" />
          <script type="text/javascript">
          function checkSubmit(){
            var status = document.getElementById("status").value;
            var invoiceNo = <?php echo getInvoiceNo($jobId) ?>;

            if (status == 0 && invoiceNo!= 0) {
              $('#emailInvoiceModal').modal('show');
            }else {
              document.getElementById("submitForm").click();
            }
          }

          function sendEmail(){
            var emails = document.getElementById("emails").value;
            var emailsCc = document.getElementById("emailsCc").value;

            document.getElementById("emailsSubmit").value = emails;
            document.getElementById("emailsCcSubmit").value = emailsCc;

            document.getElementById("submitForm").click();
          }
          </script>
          <div class="form-group row">
              <label class="col-sm-2 col-form-label col-form-label-lg"></label>
              <div class="col-sm-10">
              <?php
               if (isset($_POST['updateAssignedTask'])) {
                ?>
                <input type="text" hidden name="jobId" value="<?php echo $jobId; ?>"  />
                <input type="text" hidden name="jobTransId" value="<?php /* echo $_POST['jobTransId']; */ echo $jobTransId; ?>"  />
                <input id="emailsSubmit" type="text" hidden name="emailsSubmit"/>
                <input id="emailsCcSubmit" type="text" hidden name="emailsCcSubmit"/>
                <input type="text" hidden name="invoiceNo" value="<?php echo getInvoiceNo($jobId) ?>"/>
                <input id="latitude" type="text" name="latitude" hidden>
                <input id="longitude" type="text" name="longitude" hidden>
                <button onclick="checkSubmit()" name="updateAssignedTaskOrgStaff"  class="btn btn-primary btn-lg btn-block" type='button' >SUBMIT</button>
                <input id="submitForm" type="submit" name="updateAssignedTaskOrgStaff" hidden>
               <?php }
               else{
                 ?>
                  <button onclick="checkSubmit()" name='updateImmediateJobOrgStaff'  class="btn btn-primary btn-lg btn-block" type='button' >SUBMIT</button>

                    <?php
                }
                    ?>
              </div>
          </div>

</form>
<!-- (START)EDIT FORM
<form method="POST" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/job.php" ?>" >

<div class="modal fade" id="sparepartEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sparepartEditModalTitle">ACTIONS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div id='sparepartEditContent' >
            <?php
            $dataList = tableSparePart();
            if ($dataList == NULL) {

            }
            else {
              echo "<table class='table order-list table-responsive  table-hover table-bordered'>";
              echo "<tr><th>DESCRIPTION</th><th>QUANTITY</th></tr>";
              $k = 0;
              foreach($dataList as $data) {
              echo "<tr><td style='width: 80%'><input value='".$data['description']."' type='text' name='spDes".$k."' class='form-control'/></td><td style='width: 20%'><input value='".$data['qty']."' type='number' name='spQty".$k."' class='form-control'/></td></tr>";
              $k++;
              }
              echo  "</table>";
            }
            ?>
        </div>

      <div class="modal-footer">
        <input type="text" hidden name="clientIdToEdit" id="sparepartIdToEdit" value=""  />
        <button type="submit" name='editSpareparts' class="btn btn-primary" >SUBMIT</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
      </div>
    </div>
  </div>
</div>
</form>
 (END)EDIT FORM -->

 <!-- (START)EMAIL FORM -->
<form method="POST" action="<?php //echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/job.php" ?>" >
 <div class="modal fade" id="emailInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Email Invoice</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <small><i>NOTE: Add "," in between Emails/CCs if more than 1 receiver</i></small>
         <div class="form-group row">
           <div class="col-md-12">
             <label>Email</label>
             <input id="emails" class="form-control" type="email" name="emails" multiple>
           </div>
         </div>

         <div class="form-group row">
           <div class="col-md-12">
             <label>CC</label>
             <input id="emailsCc" class="form-control" type="email" name="emailsCc" value="" multiple>
           </div>
         </div>

         <div class="form-group row">
           <div class="col-md-12">
             <button onclick="sendEmail()" class="btn btn-primary btn-lg btn-block" type="button" name="button">Send</button>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</form>
 <!-- (END)EMAIL FORM -->

<!-- (START)DELETE FORM -->
<form method="POST" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/job.php" ?>" >

<div class="modal fade" id="sparepartDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sparepartDeleteModalTitle">REMOVE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div id='sparepartDeleteContent' >
          REMOVE THE SELECTED ROW?
        </div>
        <div id="testing">

        </div>
        <div class="modal-footer">
          <input type="text" hidden name="sparepartToDelete" id="sparepartToDelete" value=""  />
          <input type="text" hidden name="jobId" value="<?php echo $jobId ?>"  />
          <input type="text" hidden name="jobName" value="<?php echo $jobName ?>"  />
          <input type="text" hidden name="client" value="<?php echo $client ?>"  />
          <input type="text" hidden name="jobTransId" value="<?php echo $jobTransId ?>"  />

		  <input type="text" hidden name="problemDetails" value="<?php echo $problemDetails ?>"  />

		  <input type="text" hidden name="zone" value="<?php echo $zone ?>" />
		  <input type="text" hidden name="service" value="<?php echo $service ?>" />
		  <input type="text" hidden name="csName" value="<?php echo $csName ?>" />
          <button type="submit" name='deleteSpareparts' class="btn btn-primary" >REMOVE</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
        </div>
      </div>

  </div>
</div>
</form>
<!-- (END)DELETE FORM -->
</div>
<script>
(function() {
  getLocation();
})();
</script>
</body>
</html>
