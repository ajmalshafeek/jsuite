<?php
 $config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");
 if(!isset($_SESSION))
 {
  session_name($config['sessionName']);
	session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/memberDetails.php");

?>
<!DOCTYPE html >

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta https-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/app/favIcon.ico'; ?>' />


    <?php
      require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/importScripts.php");
    ?>
    <!-- datatable -->
    <script src='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/'; ?>adminTheme/datatables/jquery.dataTables.js'></script>
    <script src='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/'; ?>adminTheme/datatables/dataTables.bootstrap4.js'></script>
    <script src='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/'; ?>adminTheme/js/sb-admin-datatables.min.js'></script>
    <!--<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
     <script src='https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js'></script> -->
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js'></script>
    <!-- datatable -->
    <script>


      function clientDelete(str){

        $("#clientIdToDelete").val(str.value);

      }

      function memberEdit(str){

        $("#memberIdToEdit").val(str.value);
        $(".memberIdToEdit").val(str.value);
      }

      $(document).ready(function() {
        $('#memberTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Download Excel' ,
                title:'Member list',
                exportOptions: {
                    columns: [0,1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51],
                }
            }
        ]
    } );
    } );

      function showPassword(pwdId) {

          var x = document.getElementById(pwdId);
          if (x.type === "password") {
              x.type = "text";
          } else {
              x.type = "password";
          }

      }
    </script>
    <style>
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

    .dt-button{
        margin: 5px 0px 0px 10px;
        color:white;
        background: #8A0808;
        border:0px;
        padding: 10px;
        border-radius: 5px;
    }

    #dataTable_paginate{
        color:black !important;
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
        <li class="breadcrumb-item ">Member</li>
        <li class="breadcrumb-item active">View Member</li>
      </ol>
     </div>

      <?php
            if (isset($_SESSION['feedback'])) {
                echo $_SESSION['feedback'];
                unset($_SESSION['feedback']);
            }
        ?>
        <div class='card mb-3'>
		      <div class='card-header'>
					  <i class='fa fa-table'></i>
            Client List
				  </div>
          <?php
          memberListTableEditable();
        ?>
          </div>
        </div>
    </div>
<!--
    <form method="POST" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/memberDetails.php" ?>" >

<div class="modal fade" id="clientDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="clientDeleteModalTitle">REMOVE CLIENT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div id='staffDeleteContent' >
              Are you sure want to remove client ?
            </div>

          <div class="modal-footer">
            <input type="text" hidden name="clientIdToDelete" id="clientIdToDelete" value=""  />

            <button type="submit" name='removeClient' class="btn btn-primary" >YES</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
          </div>
        </div>
      </div>
    </div>
  </form> -->

  <form method="POST" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/memberDetails.php" ?>" >
<div class="modal fade" id="clientEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clientEditModalTitle">ACTIONS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id='staffEditContent' >
              What action do you wish to do for the member?
          </div>
        <div class="modal-footer">
          <input type="text" hidden name="memberIdToEdit" id="memberIdToEdit" value=""  />
          <button type="submit" name='editMember' class="btn btn-primary edit" >EDIT</button>
            <button type="button" data-toggle='modal' data-target='#clientDeleteModal' class="btn btn-primary remove" >Remove</button>
          <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">CANCEL</button>
        </div>
      </div>
    </div>
  </div>
 </div>
</form>

<!-- (START)Show Client Product -->
<div class="modal fade" id="clientProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clientProductModalTitle">Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="clientProductId">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">CLOSE</button>
        </div>
    </div>
  </div>
</div>
<!-- (END)Show Clinet Product -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

          <div class="footer">
            <p>Powered by JSoft Solution Sdn. Bhd</p>
          </div>
  </div>

<form method="POST" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/phpfunctions/memberDetails.php" ?>" >

    <div class="modal fade" id="clientDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productTypeEditModalTitle">DELETE ACTION</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id='staffEditContent' >
                        Are you sure want to delete member?
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" hidden name="memberIdToEdit" class="memberIdToEdit" value=""  />
                    <button type="submit" name='removeMember' class="btn btn-primary edit" >Yes</button>
                    <button type="button" class="btn btn-secondary remove" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>