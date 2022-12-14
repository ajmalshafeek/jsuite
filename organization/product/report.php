<?php
$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");
if(!isset($_SESSION))
{
  session_name($config['sessionName']);
  session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/attendancereport.php");
?>
<!DOCTYPE HTML>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/app/favIcon.ico'; ?>' />

    <!-- <link rel='stylesheet' type='text/css' href='css/myQuotationStyle.css' /> -->
    <?php
      require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/importScripts.php");
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
    var printCounter = 0;

 <?php 
 $totalshow=false;
 if(isset($_SESSION['total'])){
   $totalshow=true;
?>
//$('#attendancereport').append('<caption style="caption-center: bottom">Total Salary <?php echo number_format($_SESSION['total'],2); ?> </caption>');
<?php
 } ?>
 // Append a caption to the table before the DataTables initialisation
  var d = new Date();
 var filname="Store Order Report "+(d.getDate()+1)+"/"+(d.getMonth()+1)+"/"+d.getFullYear()+"-"+d.getHours()+":"+d.getMinutes();
 $('#report').DataTable( {
 
        dom: 'Bfrtip',
     buttons: [
         'copy',
         {
             extend: 'excel',
             title:''+filname,
             messageTop: 'This is Order report table generated by automated system'
	         <?php /*,
             messageBottom: 'Total Salary <?php if($totalshow){ echo number_format($_SESSION['total'],2);;} ?>' */ ?>
         },
         {
             extend: 'pdf',
             title:''+filname,
             messageTop: 'This is Order report table generated by automated system'
	         <?php /*,
             messageBottom: 'Total Salary <?php if($totalshow){ echo number_format($_SESSION['total'],2);;} ?>' */ ?>
         },
         {
             extend: 'print',
             title:''+filname,
             messageTop: function () {
                 printCounter++;

                 if ( printCounter === 1 ) {
                     return 'This is the first time you have printed this order report.';
                 }
                 else {
                     return 'You have printed this order report '+printCounter+' times';
                 }
             }
	         <?php /* ,
             messageBottom: 'Total Salary <?php if($totalshow){echo number_format($_SESSION['total'],2);unset($_SESSION['total']);} ?>'
            */ ?>
         }
     ],
     "pageLength": 50
 } );
 var data = table.buttons.exportData();
    } );

    function changeInputType(){
      document.getElementsByName("dateMonth")[0].value = null;
      document.getElementsByName("dateYear")[0].value = null;
	  document.getElementsByName("dateSingle")[0].value = null;

      var val = document.getElementById("selectDateType").value;
      if (val == 0) {
        document.getElementById("inputMonth").style.display = "block";
        document.getElementById("inputYear").style.display = "none";
		document.getElementById("inputDate").style.display = "none";

        document.getElementById("inputMonthForm").required = true;
        document.getElementById("inputYearForm").required = false;
		document.getElementById("inputDateForm").required = false;
	      document.getElementById("selectGroupType").disabled = false;
      }
      else if(val == 2){
		    document.getElementById("inputMonth").style.display = "none";
		    document.getElementById("inputYear").style.display = "none";
		    document.getElementById("inputDate").style.display = "block";


		    document.getElementById("inputMonthForm").required = false;
		    document.getElementById("inputYearForm").required = false;
		    document.getElementById("inputDateForm").required = true;
	        document.getElementById("selectGroupType").disabled = true;
	    }
      else {
		document.getElementById("inputDate").style.display = "none";
        document.getElementById("inputMonth").style.display = "none";
        document.getElementById("inputYear").style.display = "block";

        document.getElementById("inputMonthForm").required = false;
        document.getElementById("inputYearForm").required = true;
		document.getElementById("inputDateForm").required = false;
	      document.getElementById("selectGroupType").disabled = false;

        var i = 10;
        var d = new Date();
        var year = d.getFullYear();

        for(i=1;i<=10;i++){
          document.getElementById("year"+i).value = year;
          document.getElementById("year"+i).innerHTML = year;
          year--;
        }
      }
    }
    </script>
    <style>
        caption {
            font-size: 1.5em !important;
            color: #000 !important;
        }
        .dt-buttons button {
            padding: 5px 15px;
            border: none;
            background-color: #00bcd4 !important;
            border-radius: 5px;
            cursor: pointer;
        }
        thead {
            background-color: #ffc84c;
        }
        tr.odd{background-color: #fff !important;}
        tr.odd:hover{background-color: #eaeaea !important;}
        tr.even td {
            background-color: #ffe3bb !important;
        }
        tr.even:hover td{
            background-color: #ffd79b !important;
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
        <li class="breadcrumb-item ">Order Report</li>
      </ol>
    </div>
    <div class="container">
      <form method="POST" action="../../phpfunctions/product.php" class="needs-validation">
      <?php
        if (isset($_SESSION['feedback'])) {
            echo $_SESSION['feedback'];
            unset($_SESSION['feedback']);
        }
      ?>

      <div class="form-group row">
          <div class="col-md-4">
            <label>ID</label>
                  <input type="text" name="oid" class="form-control">
          </div>

          <div class="col-md-4">
		      <label>Name</label>
              <input type="text" name="name" class="form-control">
	      </div>
          <div class="col-sm-4"><label >Status</label>
              <select name="status" class="form-control">
                  <option disabled selected>--Select--</option>
                  <option value="0">All Order</option>
                  <option value="1">Received Order</option>
                  <option value="2">Processed Order</option>
                  <option value="3">Shipped Order</option>
                  <option value="4">Delivered Order</option>
                  <option value="-1">Canceled Ordered</option>
              </select></div>
      </div>
      <div class="form-group row">
          <div class="col-md-3">
            <label>Report Format (Required)</label>
            <select id="selectDateType" class="form-control" onchange="changeInputType()" name="timeCategory">
	            <option value="" disabled selected>--- ---</option>
	            <option value="0">Monthly</option>
                <option value="1">Yearly</option>
            </select>
          </div>

          <div class="col-md-3">
            <div id="inputMonth">
              <label id="label">By Month (Required)</label>
              <input id="inputMonthForm" class="form-control" type="month" name="dateMonth" required>
            </div>
	          <div id="inputDate" style="display:none">
		          <label id="label">By Date (Required)</label>
		          <input id="inputDateForm" class="form-control" type="date" name="dateSingle" required>
	          </div>
            <div id="inputYear" style="display:none">
              <div class="form-group row">
                <label id="label">By Year (Required)</label>
                <select id="inputYearForm" class="form-control" name="dateYear">
                  <option id="year1"></option>
                  <option id="year2"></option>
                  <option id="year3"></option>
                  <option id="year4"></option>
                  <option id="year5"></option>
                  <option id="year6"></option>
                  <option id="year7"></option>
                  <option id="year8"></option>
                  <option id="year9"></option>
                  <option id="year10"></option>
                </select>
              </div>

            </div>
          </div>
	      <div class="col-md-3">
		      <label>List Order</label>
		      <select id="selectGroupType" class="form-control" name="orderby">
			      <option value="ORDER BY id ASC">ID</option>
			      <option value="ORDER BY name ASC">Client Name</option>
                  <option value="ORDER BY orderdate ASC">Month</option>
		      </select>
	      </div>
          <div class="col-md-3">
              <label>Report Type</label>
              <select id="selectGroupType" class="form-control" name="rtype">
                  <option value="0"selected>Default(Normal)</option>
                  <option value="1">Detailed</option>
              </select>
          </div>
      </div>
      <div class="form-group row">
        <div class="col-md-12">
            <button class="btn btn-primary btn-lg btn-block" type="submit" name="storeReportGenerate">Search</button>
        </div>
      </div>
      </form>
    </div>
    <div class="container">
        <?php if (isset($_SESSION['datesearch'])){ ?><h4 style="text-align: center;background-color: #009688;padding: 0.5em;color: #fff;"><?php if (isset($_SESSION['datesearch'])){echo "Order Report ".$_SESSION['datesearch'];unset($_SESSION['datesearch']);} ?></h4> <?php } ?>
    </div>
    <div class="container">
      <?php
      if (isset($_SESSION['storeReport'])) {
          echo $_SESSION['storeReport'];
          unset($_SESSION['storeReport']);
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
</body>
</html>