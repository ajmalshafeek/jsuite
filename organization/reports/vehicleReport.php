<?php
$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");
if(!isset($_SESSION))
{
    session_name($config['sessionName']);
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/clientCompany.php");
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/maintenance.php");
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/bill.php");
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/vehicle.php");

?>
<!DOCTYPE HTML>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/app/favIcon.ico'; ?>' />

    <?php //  <link rel='stylesheet' type='text/css' href='css/myQuotationStyle.css' /> ?>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/importScripts.php");
    ?>
    <!-- Data Table Import -->
    <link rel="stylesheet" type="text/css" href="../../adminTheme/dataTable15012020/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="../../adminTheme/dataTable15012020/jquery.dataTables.js"></script>

    <script src='https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js'></script>

    <script type="text/javascript">
        $(document).ready( function () {
            $('#invoicereport').DataTable({
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
            document.getElementById("inputDate").style.display = "none";
        } );

        function changeInputType(){
            document.getElementsByName("dateMonth")[0].value = null;
            document.getElementsByName("dateYear")[0].value = null;
            document.getElementsByName("sdate")[0].value = null;


            var val = document.getElementById("selectDateType").value;
            if (val == 0) {
                document.getElementById("inputMonth").style.display = "block";
                document.getElementById("inputYear").style.display = "none";
                document.getElementById("inputDate").style.display = "none";

                document.getElementById("inputMonthForm").required = true;
                document.getElementById("inputYearForm").required = false;
                document.getElementById("inputDateForm").required = false;

            }else if(val==1){
                document.getElementById("inputMonth").style.display = "none";
                document.getElementById("inputDate").style.display = "none";
                document.getElementById("inputYear").style.display = "block";

                document.getElementById("inputMonthForm").required = false;
                document.getElementById("inputDateForm").required = false;
                document.getElementById("inputYearForm").required = true;


                var i = 10;
                var d = new Date();
                var year = d.getFullYear();

                for(i=1;i<=10;i++){
                    document.getElementById("year"+i).value = year;
                    document.getElementById("year"+i).innerHTML = year;
                    year--;
                }
            }
            else if(val==2){
                document.getElementById("inputMonth").style.display = "none";
                document.getElementById("inputYear").style.display = "none";
                document.getElementById("inputDate").style.display = "block";

                document.getElementById("inputMonthForm").required = false;
                document.getElementById("inputYearForm").required = false;
                document.getElementById("inputDateForm").required = true;
            }
        }
        function showSubcategoryOptions(){
            var billCategoryId = document.getElementById("category").value;
            $.ajax({

                type  : 'GET',
                url  : '../../phpfunctions/bill.php?',
                data : {showSubcategoryOptions:billCategoryId},
                success: function (data) {
                    document.getElementById("subcategory").innerHTML = data;
                }
            });
        }
    </script>
    <style>
        button.dt-button {
            padding: 5px 15px;
            border: 0px;
            border-radius: 3px;
            margin-bottom: 10px;
            color: #fff;
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
            <li class="breadcrumb-item ">Vehicle Expense Report</li>
        </ol>
    </div>
    <div class="container">
        <form method="POST" action="../../phpfunctions/vehicle.php" class="needs-validation">
            <?php
            if (isset($_SESSION['feedback'])) {
                echo $_SESSION['feedback'];
                unset($_SESSION['feedback']);
            }
            ?>
            <div class="form-group row">
               <div class="col-md-6">
                    <label>Driver</label>
                    <select name="driver" id="driver" class="form-control">
                        <option value="" selected disabled>--Select Driver--</option>
                        <?php getDropDownListOrgStaffListNamesForVehicles(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Vehicle Number</label>
                    <select id="selectVehicleNo" class="form-control" name="vehicleNo">
                        <option value="" selected disabled>-- Select Vehicle No --</option>
                        <?php getVehicleNumberListForReport(); ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8">
                    <label>Report Format</label>
                    <select id="selectDateType" class="form-control" onchange="changeInputType()" name="timeCategory">
                        <option value="">-- Select Month --</option>
                        <option value="2">Date</option>
                        <option value="0">Monthly</option>
                        <option value="1">Yearly</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <div id="inputMonth">
                        <label id="label">By Month</label>
                        <input id="inputMonthForm" class="form-control" type="month" name="dateMonth" required>
                    </div>
                    <div id="inputDate">
                        <label id="label">By Date</label>
                        <input id="inputDateForm" class="form-control" type="date" name="sdate" required>
                    </div>
                    <div id="inputYear" style="display:none">
                        <div class="form-group row">
                            <label id="label">By Year</label>
                            <select id="inputYearForm" class="form-control" name="dateYear" required>
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
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="vehiclesReport">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <?php if (isset($_SESSION['datesearch'])) { ?>
            <h4 style="text-align: center;"><?php if (isset($_SESSION['datesearch'])){echo $_SESSION['datesearch'];unset($_SESSION['datesearch']);} ?></h4>
        <?php } ?>
    </div>
    <div class="container">
        <?php
        if (isset($_SESSION['MRTable'])) {
            echo $_SESSION['MRTable'];
            unset($_SESSION['MRTable']);
        }
        ?>
    </div>
</div>
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vehicle Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body detail" id="printTable">
                <center></table>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" value='Print' onclick='printDiv();' >Print</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
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
        let current = new Date();
        let cDate = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate();
        let cTime = current.getHours() + ":" + current.getMinutes() + ":" + current.getSeconds();
        let dateTime = cDate + ' ' + cTime;
        var temp="Vehicle Report "+dateTime;
        $('#dtable').DataTable( {
            dom: 'Blfrtip',
            buttons: [
                { extend: 'excel',title: temp,text: 'EXCEL'},
                { extend: 'copyHtml5',title: temp,text: 'COPY'},
                { extend: 'print',title: temp,text: 'PRINT', autoPrint: true},
                { extend: 'pdfHtml5',title: temp,text: 'PDF'}]
        } );


    } );
    function viewDetails(sclass,vehicle){
        $('.detail').html("");
        $.ajax({
            type  : 'GET',
            url  : '../../phpfunctions/vehicle.php?',
            data : {vehicleExpenses:vehicle,query:sclass},
            success: function (res) {
                //  alert(res);
                if(res.length>0){
                    $('.detail').append(res);
                }else{
                    console.log("empty");
                }
            }
        });
    }
    function printDiv()
    {
        var divContents = document.getElementById("printTable").innerHTML;
        var a = window.open('', '', 'height=720, width=1024');
        a.document.write('<html>');
        a.document.write('<body>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }
</script>
</body>
</html>
