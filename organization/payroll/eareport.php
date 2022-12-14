<?php
$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");
if(!isset($_SESSION))
{
  session_name($config['sessionName']);
  session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/payrollreport.php");
?>
<!DOCTYPE HTML>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/app/favIcon.ico'; ?>' />

    <!-- <link rel='stylesheet' type='text/css' href='css/myQuotationStyle.css' /> -->
    <?php
      require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/importScripts.php");
	    require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/eaForm.php");
	    require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/organizationUser.php");

    ?>
    <!-- Data Table Import -->
    <link rel="stylesheet" type="text/css" href="../../adminTheme/dataTable15012020/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="../../adminTheme/dataTable15012020/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <script type="text/javascript">
    $(document).ready( function () {
      $('#profitLossTable').DataTable({
        searching: false,
        "ordering": false,
        "pageLength": 21,
        "bLengthChange": false,
        "bInfo": false,
        "language": {
          "paginate": {
            "previous": "Previous Month",
            "next": "Next Month"
          }
        }
      });


         /*   $('#payrollreport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]
            });
            */
        
        var printCounter = 0;

 <?php 
 $totalshow=false;
 if(isset($_SESSION['total'])){
   $totalshow=true;
?>
$('#payrollreport').append('<caption style="caption-center: bottom">Total Salary <?php echo number_format($_SESSION['total'],2); ?> </caption>');
<?php
 } ?>
 // Append a caption to the table before the DataTables initialisation
 
 var d = new Date();
 var filname="Payslip Report "+(d.getDate()+1)+"/"+(d.getMonth()+1)+"/"+d.getFullYear()+"-"+d.getHours()+":"+d.getMinutes();
 $('#payrollreport').DataTable( {
 
        dom: 'Bfrtip',
     buttons: [
         'copy',
         {
             extend: 'excel',
             title:''+filname,
             messageTop: 'This is EA report table generated by automated system'
            },
         {
             extend: 'pdf',
             title:''+filname,
             messageTop: 'This is EA report table generated by automated system'
            },
         {
             extend: 'print',
             title:''+filname,
             messageTop: function () {
                 printCounter++;

                 if ( printCounter === 1 ) {
                     return 'This is the first time you have printed this EA Report.';
                 }
                 else {
                     return 'You have printed this EA report '+printCounter+' times';
                 }
             },
             messageBottom: 'Total Salary <?php if($totalshow){echo number_format($_SESSION['total'],2);unset($_SESSION['total']);} ?>'
         }
     ],
     "pageLength": 50
 } );
 var data = table.buttons.exportData();
    } );

*
    </script>
    <style>
        caption {
            font-size: 1.5em !important;
            color: #000 !important;
        }
    </style>
</head>
<body class="fixed-nav ">

<?php
  include $_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/navMenu.php";
?>

  <div class="content-wrapper">
    <div class="container-fluid">
        <?php echo shortcut() ?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb col-md-12">
        <li class="breadcrumb-item">
          <a href="../../home.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item ">Payroll</li>
	      <li class="breadcrumb-item active">EA Report</li>
      </ol>
    </div>
    <div class="container">
      <form method="POST" action="../../phpfunctions/eaForm.php" class="needs-validation">
      <?php
        if (isset($_SESSION['feedback'])) {
	        echo '<div class="container">'.$_SESSION['feedback'].'</div>';
            unset($_SESSION['feedback']);
        }
      ?>
          <div class="form-group row">
              <!-- STAFF -->
              <label for="staffNum" class="col-sm-2 col-form-label col-form-label-lg">*Staff</label>
              <div class="col-sm-4"   >
	              <select name="staffNum" class="form-control" id="staffNum">
	              <option selected disabled value="">--Select--</option>
	              <?php dropDownListOrgStaffListEANames(); ?>
		              </select>
                  <div class="invalid-feedback">
		              Please choose staff
	              </div>
              </div>


	      <label for="year" class="col-sm-2 col-form-label col-form-label-lg">By Year</label>
          <div class="col-md-4">
                    <div id="inputYear">
              <div class="form-group row">
                <select id="inputYearForm" class="form-control" name="year">
                  <option disabled selected value="">--Year--</option>
	                <?php
		                $date=(int)Date("Y");
		                for($i=9;$i>-1;$i--){
			                echo '<option value="'.$date.'">'.$date.'</option>>';
			                $date--;
		                }
	                ?>
                </select>
              </div>

            </div>
          </div>
      </div>
          <div class="form-group row">
        <div class="col-md-12">
            <button class="btn btn-primary btn-lg btn-block" type="submit" name="eaReportGenerate">Search</button>
        </div>
      </div>
      </form>
    </div>
    <div class="container">
    <h4 style="text-align: center;"><?php if (isset($_SESSION['eaformsearch'])){echo "Payslip Report ".$_SESSION['eaformsearch'];unset($_SESSION['eaformsearch']);} ?></h4>
    </div>
    <div class="container">

      <?php
      if (isset($_SESSION['eaTable'])) {
          echo $_SESSION['eaTable'];
          unset($_SESSION['eaTable']);
      }
      ?>
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


<!-- EDIT -->
<form method="POST" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/eaForm.php" ?>" >

	<div class="modal fade" id="staffEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staffEditModalTitle">ACTIONS</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div id='staffEditContent' >
						What action do you wish to do for the user?
					</div>
				</div>
				<div class="modal-footer">
					<input type="text" hidden name="eaIdToEdit" id="eaIdToEdit" value=""  />
					<button type="submit" name='printView' class="btn btn-primary" >VIEW</button>
					<button type="submit" name='pdfDownload' class="btn btn-primary" >PDF</button>
					<button type="submit" name='printView' class="btn btn-primary" >PRINT</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
function eaEdit(str){

$("#eaIdToEdit").val(str.value);

}
</script>
</body>
</html>
