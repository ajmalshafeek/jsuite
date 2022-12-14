<?php
$config = parse_ini_file(__DIR__ . "/../../jsheetconfig.ini");
if (!isset($_SESSION)) {
    session_name($config['sessionName']);
    session_start();
} ?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Document Sign</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    /* Remove the jumbotron's default bottom margin */
     .jumbotron {
      margin-bottom: 0;
    }
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
	  .navbar-inverse {
    background-color: #3c8dbc !important;;
    border-color: #3c8dbc !important;
}
.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover {
    color: #fff;
    background-color: #3c8dbc !important;
}
	  .header{
	color: #fff !important;
    background-color: #3c8dbc !important;
    border-color: #abb6c2!important;
    border-bottom-color: #3c8dbc !important;
    border-top-color: #3c8dbc !important;
	  }

		table.dataTable tr:nth-child(odd)  { background-color: #f9d3e0;  }
		table.dataTable tr:nth-child(even)  { background-color: #e91e63;  }
	  
  </style>
</head>
<body>
  <div class="container-fluid text-center" style="margin-bottom: 20px;background-color: #6ac2f5;">
    <h1>E-Sign</h1>
</div>
    <?php if(isset($_SESSION['message'])){echo $_SESSION['message']; unset($_SESSION['message']); }?>
<div class="container mt-3">
  <div class="row">
    <div class="col-sm-12">
      <table id="example" class="display" style="width:100%">
          <thead>
              <tr class="header">
                  <th>File Name</th>
                  <th>Size</th>
                  <th>Date Uploaded</th>
                  <th>Upload By</th>
                  <th>User</th>
                  <th>Sign</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tfoot>
              <tr class="header">
                  <th>File Name</th>
                  <th>Size</th>
                  <th>Date Uploaded</th>
                  <th>Upload By</th>
                  <th>User</th>
                  <th>Sign</th>
                  <th>Actions</th>
              </tr>
          </tfoot>
      </table>
    </div>
  </div>
</div><br>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
    $('#example').DataTable({
        ajax: '<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/'; ?>document_sign_sow/get_pdf_client_listings',
    });

  });
  function copylink(id) {
    // Get the text field
    var copyText = $("#copy_link_doc"+id).val();
    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText);
    // Alert the copied text
    alert("Copied the text: " + copyText);
  }
</script>
</body>
</html>