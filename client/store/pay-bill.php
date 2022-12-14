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
  <title>Jsuit Enterprise Solutions and Integrated Digital Signature (JES-IDS) - Pay Bill</title>
 <?php require("./assets/css.php"); ?>
  <link rel="stylesheet" href="./css/profile.css">
  <style></style>
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
      <h2>Payment</h2>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./store.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Payment</li>
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
              <h4>Payment</h4><!--<button data-toggle="modal" data-target="#profile-edit">request</button>-->
            </div>
            <div class="account-content">
                <div class="row">
                    <div class="col-12 text-center">
                        <?php if(isset($_GET['invoice'])){
                            echo "<h3>Invoice : ".str_pad($_GET['invoice'],10,"0",STR_PAD_LEFT)."</h3>";
                            echo "<h5>Total Amount : ".$_GET['amount']."</h5>";
                        } ?>
                        <button class="btn btn-default mt-5">Pay Now</button>
                    </div>
                </div>
        </div>
    </div>
  </section>

<!-- profile address -->
   <div class="modal fade" id="profile-edit">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"><button class="modal-close" data-dismiss="modal"><i class="icofont-close"></i></button>
        <form class="modal-form" method="post" <?php // method="post" action="../../phpfunctions/store.php" ?>>
          <div class="form-title">
            <h3>Technical Inquiry</h3>
          </div>
        <?php // <div class="form-group"><label class="form-label">profile image</label><input class="form-control" type="file"></div> ?>

          <div class="form-group"><label class="form-label">Name</label><input class="form-control" type="text" name="name" /></div>
          <div class="form-group"><label class="form-label">IC Number</label><input class="form-control" type="number" name="icno" /></div>
          <div class="form-group"><label class="form-label">Academic Qualification</label><input class="form-control" type="text" name="acaQualification" /></div>
          <?php /*<div class="form-group"><label class="form-label">State</label>
              <select name="state"  id="state" class="form-control" >
                  <option value="Johor" <?php if(strtolower($data['state']) == strtolower('Johor')) { echo 'selected';} ?>>Johor</option>
                  <option value="Kedah" <?php if(strtolower($data['state']) == strtolower('Kedah')) { echo 'selected';} ?>>Kedah</option>
                  <option value="Kelantan <?php if(strtolower($data['state']) == strtolower('Kelantan')) { echo 'selected';} ?>">Kelantan</option>
                  <option value="Kuala Lumpur" <?php if(strtolower($data['state']) == strtolower('Kuala Lumpur')) { echo 'selected';} ?>>Kuala Lumpur</option>
                  <option value="Labuan" <?php if(strtolower($data['state']) == strtolower('Labuan')) { echo 'selected';} ?>>Labuan</option>
                  <option value="Malacca" <?php if(strtolower($data['state']) == strtolower('Malacca')) { echo 'selected';} ?>>Malacca</option>
                  <option value="Negeri Sembilan" <?php if(strtolower($data['state']) == strtolower('Negeri Sembilan')) { echo 'selected';} ?>>Negeri Sembilan</option>
                  <option value="Pahang" <?php if(strtolower($data['state']) == strtolower('Pahang')) { echo 'selected';} ?>>Pahang</option>
                  <option value="Perak" <?php if(strtolower($data['state']) == strtolower('Perak')) { echo 'selected';} ?>>Perak</option>
                  <option value="Perlis" <?php if(strtolower($data['state']) == strtolower('Perlis')) { echo 'selected';} ?>>Perlis</option>
                  <option value="Penang" <?php if(strtolower($data['state']) == strtolower('Penang')) { echo 'selected';} ?>>Penang</option>
                  <option value="Sabah" <?php if(strtolower($data['state']) == strtolower('Sabah')) { echo 'selected';} ?>>Sabah</option>
                  <option value="Sarawak" <?php if(strtolower($data['state']) == strtolower('Sarawak')) { echo 'selected';} ?>>Sarawak</option>
                  <option value="Selangor" <?php if(strtolower($data['state']) == strtolower('Selangor')) { echo 'selected';} ?>>Selangor</option>
                  <option value="Terengganu" <?php if(strtolower($data['state']) == strtolower('Terengganu')) { echo 'selected';} ?>>Terengganu</option>
              </select>
              <div class="invalid-feedback">
                  Please enter state
              </div>

          </div>
 */?>
          <div class="form-group"><label class="form-label">University/Company</label><input class="form-control" name="university" type="text" /></div>
          <div class="form-group"><label class="form-label">Occupation</label><input class="form-control" name="occupation" type="text"  /></div>
          <div class="form-group"><label class="form-label">Correspondence Address</label><input class="form-control" name="corAddress" type="text"  /></div>
          <div class="form-group"><label class="form-label">Telephone(Office or Mobile)</label><input class="form-control" name="tel" type="number"  /></div>
          <div class="form-group"><label class="form-label">Email</label><input class="form-control" name="email" type="email"  /></div>
          <div class="form-group"><label class="form-label">Ttile of Research</label><input class="form-control" name="researchTitle" type="text"  /></div>
          <div class="form-group"><label class="form-label">No. of research team member(if any)</label><input class="form-control" name="teamNo" type="number"  /></div>
          <div class="form-group"><label class="form-label">Research Category</label><input class="form-control" name="researchCate" type="text"  /></div>
          <div class="form-group"><label class="form-label">MONETARY resource (Budget)</label><input class="form-control" name="monetaryResource" type="text"  /></div>
          <div class="form-group"><label class="form-label">Attachment (Supporting document)</label><input class="form-control" name="attachment" type="file"/></div>

            <button class="form-btn" name="researchGrant" type="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
<?php /*
  <div class="modal fade" id="contact-edit" class="contact-edit">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"><button class="modal-close" data-dismiss="modal"><i class="icofont-close"></i></button>
        <form class="modal-form" action="../../phpfunctions/store.php" method="post">
          <div class="form-title">
            <h3>edit contact info</h3>
          </div>
          <div class="form-group"><label class="form-label">title</label>
              <select class="form-select" name="title" id="contact_title" >
              <option value="primary" selected >primary</option>
              <option value="secondary" >secondary</option>
            </select></div>
          <div class="form-group"><label class="form-label">number</label>
              <input class="form-control" type="text" name="value" id="contact_value" value="+8801838288389">
              <input class="form-control" type="hidden" value="" name="id" id="contact_id">
          </div>
            <button class="form-btn" name="updateDetails" type="submit">save contact info</button>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="address-edit" class="address-edit">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"><button class="modal-close" data-dismiss="modal"><i class="icofont-close"></i></button>
        <form class="modal-form" action="../../phpfunctions/store.php" method="post">
          <div class="form-title">
            <h3>edit address info</h3>
          </div>
          <div class="form-group"><label class="form-label">title</label>
              <select class="form-select" name="title" id="address_title">
              <option value="home" selected >home</option>
              <option value="office" >office</option>
              <option value="business" >business</option>
              <option value="academy" >academy</option>
              <option value="others" >others</option>
            </select></div>
          <div class="form-group"><label class="form-label">address</label>
              <textarea class="form-control" name="value" id="address_value" placeholder="jalkuri, fatullah, narayanganj-1420. word no-09, road no-17/A">dskfkdsa</textarea>
              <input class="form-control" type="hidden" value="" name="id" id="address_id">
          </div><button class="form-btn" name="updateDetails" type="submit">save address info</button>
        </form>
      </div>
    </div>
  </div>
 */ ?>
  <footer class="footer-part">
      <?php require("./assets/footer-content.php"); ?>
  </footer>
<?php require("./assets/js.php"); ?>
<script>
    function edit(tag,num){
        hag="#"+tag;
        let idtag=hag+num;
        let title=$(idtag+" #title"+num).val();
        let value=$(idtag+" #value"+num).val();
        let id=$(idtag+" #id"+num).val();
        title=String(title);
        let code=""
        if(title.toLowerCase()==="primary") {
            code = '<option value="primary" selected>primary</option>'+
                '<option value = "secondary"> secondary </option>';
        }else if(title.toLowerCase()==="secondary") {
            code = '<option value="primary">primary</option>'+
            '<option value = "secondary" selected > secondary </option>';
        }else if(title.toLowerCase()==="home") {
            code = '<option value="home" selected >home</option>'+
                '<option value = "office"> office </option>'+
                '<option value="business">business</option>'+
                '<option value="academy">academy</option>'+
                '<option value="others">others</option>';
        }else if(title.toLowerCase()==="office") {
            code = '<option value="home">home</option>'+
                '<option value = "office" selected > office </option>'+
                '<option value="business">business</option>'+
                '<option value="academy">academy</option>'+
                '<option value="others">others</option>';
        }else if(title.toLowerCase()==="business") {
            code = '<option value="home">home</option>'+
                '<option value = "office"> office </option>'+
                '<option value="business" selected >business</option>'+
                '<option value="academy">academy</option>'+
                '<option value="others">others</option>';
        }else if(title.toLowerCase()==="academy") {
            code = '<option value="home" >home</option>'+
                '<option value = "office"> office </option>'+
                '<option value="business">business</option>'+
                '<option value="academy" selected >academy</option>'+
                '<option value="others">others</option>';
        }else if(title.toLowerCase()==="others") {
            code = '<option value="home">home</option>'+
                '<option value = "office"> office </option>'+
                '<option value="business">business</option>'+
                '<option value="academy">academy</option>'+
                '<option value="others" selected >others</option>';
        }
        document.getElementById(tag+"_title").innerHTML=code;
        document.getElementById(tag+"_value").value=value;
        document.getElementById(tag+"_id").value=id;
    }
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