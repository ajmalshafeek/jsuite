<?php
// Registration from
$config=parse_ini_file(__DIR__."/../jsheetconfig.ini");
$count=1;
/*
if (!isset($_SESSION)) {
    session_name($config['sessionName']);
    session_start();
}
*/
?>
<html>
<head>
    <link rel="stylesheet" href="./../css/bootstrap.min.css" />
    <script src="./../js/jquery-3.3.1.min.js"></script>
    <script src="./../js/popper.min.js"></script>
    <script src="./../js/bootstrap.min.js"></script>
    <title>
        Jsuit Enterprise Solutions and Integrated Digital Signature (JES-IDS) - Forget Password
    </title>
    <link rel="shortcut icon" type="image/x-icon" href='<?php echo 'https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/app/favIcon.ico'; ?>' />
    <?php
    //require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/importScripts.php");
    ?>
    <style>
    body{ height: 100%;
        background: rgb(0,100,234);
        background: -moz-linear-gradient(45deg, rgba(0,100,234,1) 0%, rgba(1,230,173,1) 100%);
        background: -webkit-linear-gradient(45deg, rgba(0,100,234,1) 0%, rgba(1,230,173,1) 100%);
        background: linear-gradient(45deg, rgba(0,100,234,1) 0%, rgba(1,230,173,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#0064ea",endColorstr="#01e6ad",GradientType=1);
    }
    .btn{
        background: rgb(1,141,220);
        background: -moz-linear-gradient(45deg, rgba(1,141,220,1) 0%, rgba(0,210,188,1) 100%);
        background: -webkit-linear-gradient(45deg, rgba(1,141,220,1) 0%, rgba(0,210,188,1) 100%);
        background: linear-gradient(45deg, rgba(1,141,220,1) 0%, rgba(0,210,188,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#018ddc",endColorstr="#00d2bc",GradientType=1);
        padding: 7px 40px;
        border-radius: 0;
        text-transform: uppercase;
        margin-top: 20px;
        color: #fff;
        font-weight: bold;
    }
    .reg-model {
                    max-width: 450px;
                    min-width: 200px;
                    border-radius: 10px;
                    padding: 20px 20px 20px 20px;
                    margin-top: 10vh;
                    margin-left: auto;
                    margin-right: auto;
                    background-color: #f8f9fa;


                }
    .container {
        background-color: transparent;
        display: flex;
        justify-content: center;
        position: relative;
    }
    input.form-control{
        border-left: 0;
        border-top: 0;
        border-right: 0;
        border-bottom: 2px solid #01e3be;
        border-radius: 0px;
    }
    h3{margin-bottom: 20px;}
    .linkButton{
        color:#008cd8;padding: 5px;
        border: 0;
        background-color: transparent
    }
    form{
        margin-bottom: 0px;
    }
    .custom-text, .custom-text button{
        font-size: 14px;
    }
    .btn-primary:hover {
        color: #fff;
        background-color: #d90000;
        border-color: #cc0000;
    }
    .btn-primary {
        color: #fff;
        background-color: #ea2b2b;
        border-color: #ea2b2b;
    }


    /* Media Query for Mobile Devices */
    @media (max-width: 480px) {

    }

    /* Media Query for low resolution  Tablets, Ipads */
    @media (min-width: 481px) and (max-width: 767px) {

    }
    </style>
    <script>
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
    </script>
</head>
<body>
<div class="container">

    <div class="reg-model text-center">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); } ?></div>
            </div></div>
            <div class="row">
                <div class="col-12">
                    <h3>Forget Password</h3>
                </div>
            </div>
            <form action="../phpfunctions/registrationRequest.php" method="post">
              <?php if(!isset($_GET['verify'])||empty($_GET['verify'])) { ?>
                <div class="row">
                    <div class="col-12 form-group">
                        <input type="email" name="email" class="form-control email" placeholder="* Email" required />
                        <div class="invalid-feedback">
                            Please enter email
                        </div>
                    </div>
                </div>
<?php } if(isset($_GET['verify'])) { ?>
                  <input type="hidden" name="email" class="form-control email" value="<?php echo $_GET['verify'] ?>" />
                <div class="row">
                    <div class="col-12 form-group">
                        <input type="password" name="password" class="form-control pass" placeholder="********" required />
                        <div class="invalid-feedback">
                            Please enter password
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-12 form-group">
                        <input type="text" name="vcode" class="form-control vcode" placeholder="Verification Code" required autocomplete="false" />
                        <div class="invalid-feedback">
                            Please enter verification code
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" name="updateClientByForm" class="btn btn-default" value="1">Update Password</button>
                    </div>
                </div>
                <?php } else { ?>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" name="forgetClientByForm" class="btn btn-default" value="1">Reset Password</button>
                    </div>
                </div>
                <?php } ?>
            </form>
            <div class="custom-text">
                Already have account? <a href="./" class="linkButton">Login</a>
            </div>
            <div class="custom-text">
                Don't have an account?<a href="registration.php" class="linkButton">Registration</a>
            </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 text-center mt-2 text-light">
            Copyright @ Jsoft Solution Sdn Bhd.
        </div>
    </div>
</div>
</body>
</html>
<?php unset($_GET['verify']); ?>