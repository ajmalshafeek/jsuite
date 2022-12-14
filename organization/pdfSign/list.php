<?php

$config = parse_ini_file(__DIR__ . "/../../jsheetconfig.ini");


if (!isset($_SESSION)) {

    session_name($config['sessionName']);

    session_start();
}
if (isset($_SESSION['pdfFileName'])) {
    unset($_SESSION['pdfFileName']);
}

ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/resources/app/favIcon.ico'; ?>' />


    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/importScripts.php");

    require_once($_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/organization/complaint/moreForm/form.php");


    ?>

    <!-- datatable -->

    <script src='<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/'; ?>adminTheme/datatables/jquery.dataTables.js'></script>

    <script src='<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/'; ?>adminTheme/datatables/dataTables.bootstrap4.js'></script>

    <script src='<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/'; ?>adminTheme/js/sb-admin-datatables.min.js'></script>

    <!-- datatable -->
    <style>
        .wheel {
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #00b7ff;
            border-bottom: 5px solid #00b7ff;
            width: 50px;
            height: 50px;
            margin-left: auto;
            margin-right: auto;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<?php
include $_SERVER['DOCUMENT_ROOT'] . $config['appRoot'] . "/navMenu.php";
?>

<body class="fixed-nav ">
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php echo shortcut() ?>
            <!-- Breadcrumbs-->
            <ol class="breadcrumb col-md-12">
                <li class="breadcrumb-item">
                    <a href="../../home.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item">PDF</li>
                <li class="breadcrumb-item active">PDF LIST</li>
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
                LIST
            </div>
            <div class='card-body' style="padding:0px">
                <div class='table-responsive'>
                    <iframe src="<?php echo "".'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "/document_sign_sow/views/index.php"; ?>" height="1200px" width="100%" style="border:none" ></iframe>

                </div>
            </div>
            <?php /*<div class="btn btn-primary downloadExcel" style="width:150px; background-color: green">Download&nbsp;&nbsp;<img src="<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/'; ?>resources/app/excel.png" width="16px"/></div> */ ?>
        </div>

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    </div>

    <div class="laoder" id="loader" style="display:none;width: 100vw; height: 100vh; position: fixed; top:0;left: 0; background-color: #004187de; z-index: 999999">
        <div style="padding-top: 45vh;text-align:center ;font-size: xx-large;color: #fff;">
            <div class="wheel"></div>
            <br />Loading
        </div>
    </div>

    <form method="POST" action="../../phpfunctions/signPDF.php" class="needs-validation" novalidate>
        <input type='text' hidden value='' name='pfid' id='pfidvalue' />
        <input type='text' hidden value='' name='template' id='templatevalue' />
        <div class="modal fade" id="assignPdfModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignPdfModelTitle">ASSIGN TO SIGNATORY</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Assign To</label>
                            <select name='workerType' class='form-control' id='workerType' onchange="changeUserType(this.value)">
                                <option selected disabled value="default">--Select--</option>
                                <?php //<option value="0">My Staff</option> ?>
                                <option value="1">Directors</option>
                            </select>
                        </div>
                        <div id='selectWorker' class="signatoryuser">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="approve">Send to client for Signature</label>
                            <select name='approve' class='form-control' id='approve' >
                                <option selected value="1">Shared</option>
                                <option value="0">Stop Shared</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_attest">Send to client for Signature</label>
                            <select name='is_attest' class='form-control' id='is_attest' >
                                <option selected value="0">Authorize Sign</option>
                                <option value="1">Attestation</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="assignPDF" name="assignPDF" onclick="loader()" disabled class="btn btn-light">Confirm
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#assignPDF").on("click", function() {
                document.getElementById("loader").style.display = "block";
            });
            document.getElementById("loader").style.display = "none";
        });

        function sendData(path, parameters, method = 'post') {

            const form = document.createElement('form');
            form.method = method;
            form.action = path;
            document.body.appendChild(form);

            for (const key in parameters) {
                const formField = document.createElement('input');
                formField.type = 'hidden';
                formField.name = key;
                formField.value = parameters[key];

                form.appendChild(formField);
            }
            form.submit();
        }

        function pdfclick(id, filename) {
            sendData("https://<?php echo $_SERVER['HTTP_HOST'] . $GLOBALS['config']['appRoot']; ?>/organization/pdfSign/pdf.php", {
                pfid: id,
                pdf: filename
            });
        }

        function pdfsign(id, filename) {
            sendData("https://<?php echo $_SERVER['HTTP_HOST'] . $GLOBALS['config']['appRoot']; ?>/organization/pdfSign/signPdf.php", {
                pfid: id,
                template: filename
            });
        }

        function pdfShared(id, filename) {
            //  sendData("https://<?php echo $_SERVER['HTTP_HOST'] . $GLOBALS['config']['appRoot']; ?>/organization/pdfSign/signPdf.php", {
            $('#pfidvalue').val(id),
                $('#templatevalue').val(filename);
            $('#selectWorker').empty();
            $('#workerType').val('default');
            document.getElementById("assignPDF").disabled = false;
            //  });
            $("#assignPdfModel").modal("show");

        }

        function pdfsetall(id, filename, same) {
            sendData("https://<?php echo $_SERVER['HTTP_HOST'] . $GLOBALS['config']['appRoot']; ?>/organization/pdfSign/pdf.php", {
                pfid: id,
                pdf: filename,
                same: same
            });
        }

        function pdfview(filename) {
            sendData("https://<?php echo $_SERVER['HTTP_HOST'] . $GLOBALS['config']['appRoot']; ?>/organization/pdfSign/viewPdf.php", {
                pdf: filename
            });
        }
    </script>
</body>
<script>
    function changeUserType(str) {
        var id = $('#pfidvalue').val();
        $.ajax({
            type: 'GET',
            url: '../../phpfunctions/digitalSign.php?',
            data: {
                userType: str,
                id: id
            },
            success: function(data) {
                var worker = $('#selectWorker');
                worker.empty().append(data);
                var noOfList = document.getElementById("workerId").length;
                if (noOfList > 0) {
                    document.getElementById("assignPDF").disabled = false;
                    document.getElementById("assignPDF").classList.remove('btn-light');
                    document.getElementById("assignPDF").classList.add('btn-primary');
                } else {
                    document.getElementById("assignPDF").disabled = true;
                }
            }
        });
    }
</script>

</html>