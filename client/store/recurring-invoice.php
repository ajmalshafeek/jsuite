<?php
$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");
if(!isset($_SESSION))
{
    session_name($config['sessionName']);
    session_start();




}?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Jsuit Enterprise Solutions and Integrated Digital Signature (JES-IDS) - Recurring Invoice</title>
 <?php require("./assets/css.php"); ?>
  <link rel="stylesheet" href="./css/profile.css">
  <style>
      div#invoicePDFModal {
          background-color: #fff;
      }
      .modal-content{
          width: 900px;
          max-width: 900px;
          min-width: 300px;
      }
      a.btn.btn-default.paybill {
          padding: 7px 20px;
      }
  </style>

</head>
<body>
<?php
// header menu
require("./assets/top-menu.php");
// side menu
require("./assets/side-menu.php");
// cart side menu
require("./assets/cart-side-menu.php");
?>
  <section class="single-banner" style="background: url(./img/research-grant.jpg) no-repeat center; background-size: cover;">
    <div class="container">
      <h2>Professional Development Inquiry</h2>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./store.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recurring Invoice</li>
      </ol>
    </div>
  </section>
  <section class="profile-part">
    <div class="container">
      <div class="row">
          <?php
          if(isset($_SESSION['message'])) {
              echo '<div class="col-12">'. $_SESSION['message'] . '</div>';
              unset($_SESSION['message']);
          } ?>
        <div class="col-lg-12">
          <div class="account-card">
            <div class="account-title">
              <h4>Recurring Invoice</h4><!--<button data-toggle="modal" data-target="#profile-edit">request</button>-->
            </div>
            <div class="account-content">
                <div class="row">
                    <div class="col-12 text-center">
                        <?php
                        require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/invoice.php");
                        $table=recurringInvoiceClientListTable(null,null,null,null,$_SESSION['companyId'],null,null,null,null,$_SESSION['orgId']);
                        echo $table;
                        ?>
                    </div>
                </div>

        </div>
    </div>
  </section>

<!-- INVOICE PDF Modal START-->
<div class="modal fade "  id="invoicePDFModal" tabindex="-1" role="dialog" aria-labelledby="invoicePDFModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoicePDFModalTitle">QUOTATION  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div id='invoicePDFModalContent' >
                    <object id="invoicePDFObject" data="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/resources/2/quotation/0000000003.pdf"; ?>" frameborder="0" width="100%" height="400px" style="height: 85vh;">
                        <p>Your web browser doesn't have a PDF plugin.
                            Instead you can
                            <a id="invoicePDFAnchor" target="_blank" href="<?php echo "https://".$_SERVER['HTTP_HOST'].$config['appRoot']."/resources/2/quotation/0000000003.pdf"; ?>">click here to
                                download the PDF file.</a>
                        </p>
                    </object>
                    <!--
                          <embed id="invoicePDFEmbed" src="" frameborder="0" width="100%" height="400px" style="height: 85vh;">
              -->
                </div>

            </div>
            <div class="modal-footer">
                <a  href="#" class="btn btn-success btn-lg whats" target="_blank">
                    <i style='' class='fa fa-whatsapp' aria-hidden='true'></i>
                    What'sapp
                </a>

                <button type="button" class="btn btn-secondary btn-lg" title="CLOSE DIALOG" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

  <footer class="footer-part">
      <?php require("./assets/footer-content.php"); ?>
  </footer>
<?php require("./assets/js.php"); ?>
<script>
    $(document).ready(function() {
        $('#invoiceListTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        $('#invoiceListTable tbody').on('click', 'td', function () {

            if ($(this).index() == 0) {
                /* var checkBox=$(this).closest('td').find('[type=checkbox]');
                 if(checkBox.prop('checked')){
                   checkBox.prop('checked', false);
                 }else{
                   checkBox.prop('checked', true);
                 } */
                return;
            }
            var invNo = $(this).closest('tr').find('td:eq(2)').text();
            var fileName = $(this).closest('tr').data('value');

            //var path=<?php echo "'https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . "'"; ?>+'/resources/'+<?php echo $_SESSION['orgId']; ?>+'/invoice/';
            var path =<?php echo "'https://" . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/resources/' . $_SESSION['orgId'] . '/invoice/' . "'"; ?>;
            var invPDF = path + fileName + ".pdf";
            $('#invoicePDFModalTitle').text('INVOICE # ' + invNo);
            //$('#invoicePDFEmbed').prop('src', invPDF);
            $('#invoicePDFObject').prop('data', invPDF);
            $('#invoicePDFAnchor').prop('href', invPDF);

            $('#invoiceNo').prop('value', invNo);
            //(START)PDF NOT LOAD FIXES
            var invoicePDFHTML = "<object id='payslipPDFObject' data='" + invPDF + "' frameborder='0' width='100%' height='400px' style='height: 85vh;'><p>Your web browser doesn't have a PDF plugin.Instead you can<a id='payslipPDFAnchor' target='_blank' href='" + invPDF + "'>click here to download the PDF file.</a></p></object>";
            document.getElementById("invoicePDFModalContent").innerHTML = invoicePDFHTML;
            //(END)PDF NOT LOAD FIXES

            $.ajax({
                type: 'GET',
                url: '<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/phpfunctions/invoice.php'; ?>',
                data: {getInvoiceByInvNo: invNo},
                success: function (data) {
                    invoiceDetails = JSON.parse(data);
                    console.log(invoiceDetails);
                }
            });
            var whatstext='';
            $.ajax({
                type: 'GET',
                url: '<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $config['appRoot'] . '/phpfunctions/invoice.php'; ?>',
                data: {clientId: invNo},
                success: function (data) {
                    email = data;
                    whatstext = 'https://wa.me/' + data + '?text=' + invPDF + '';
                    if (email.length > 0) {
                        $('.whats').attr('href', whatstext);
                    }
                }
            });

            $('#invoicePDFModal').modal('toggle');


        });
    });

   function active(tag,id){
        $.ajax({
            type:'post',
            url:'<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot']; ?>/phpfunctions/store.php',
            data:{
                makeActive:true,
                id:id,
                tag:tag
            },
            success:function (res) {
                if(res){ alert("select "+tag+" set default");}
                else{alert("select "+tag+" not set default");}
            }
        });
    }
</script>
</body>

</html>