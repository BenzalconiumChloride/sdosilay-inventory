<?php

require_once '../global-library/database.php';

require_once 'include/functions.php';



$data = ["emailAddress" => null, "message" => null];



if (isset($_POST['txtEmailAddress'])) {

    $result = doLogin();

    if (!empty($result) && is_array($result)) {

        $data = $result;

    }

}

?>



<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo WEB_ROOT; ?>admin/assets/css/login.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/global-css.php'); ?>



    <title>Login - Department of Education</title>

    <style>

        .logo-row {

            display: flex;

            flex-wrap: wrap;

            justify-content: center;

            align-items: center;

        }



        .gov-logo {

            width: clamp(80px, 20vw, 150px);

            height: auto;

            object-fit: contain;

        }



        /* SUCCESS */

        #toast-container>div {

            border-radius: 10px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);

            font-weight: 500;

        }





        /* ERROR */

        #toast-container>.toast-error {

            background-color: #dc3545 !important;

            /* red */

        }



        /* WARNING */

        #toast-container>.toast-warning {

            background-color: #ffc107 !important;

            /* yellow */

            color: #000 !important;

        }



        /* INFO */

        #toast-container>.toast-info {

            background-color: #198754 !important;

            /* green */

        }

    </style>

</head>



<body>

    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center position-relative" style="z-index: 1;">

        <div class="container py-4">

            <div class="row justify-content-center">

                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">



                    <div class="text-center mb-4" style="animation: fadeInDown 0.8s ease-out;">

                        <div class="row justify-content-center logo-row mb-2">

                            <img src="<?php echo WEB_ROOT; ?>assets/images/upload/depedSilay.png" class="gov-logo">

                        </div>

                    </div>



                    <div class="card login-card">

                        <div class="card-body p-4 p-sm-5">

                            <div class="form-header mb-4 text-center">

                                <h2 class="mb-2">Welcome Back</h2>

                                <p class="mb-0">Please sign in to continue</p>

                            </div>



                            <form id="loginform" name="frmLogin" method="post">



                                <div class="mb-3">

                                    <label for="email" class="form-label">Email Address</label>

                                    <input type="email" class="form-control py-3 px-3 fs-6" name="txtEmailAddress" id="email"

                                        value="<?php echo htmlspecialchars($data["emailAddress"]); ?>"

                                        placeholder="Enter your email address" required>

                                </div>



                                <div class="mb-4">

                                    <label for="password" class="form-label">Password</label>

                                    <input type="password" class="form-control py-3 px-3 fs-6" name="txtPassword" id="password"

                                        placeholder="Enter your password" required>

                                </div>



                                <div class="d-grid mb-3">

                                    <button type="submit" class="btn btn-success py-3 fs-6">Sign In</button>

                                </div>



                                <div class="forgot-password text-center">

                                    <a href="#">Forgot your password?</a>

                                </div>

                            </form>

                        </div>

                    </div>



                    <div class="footer-info mt-4 text-center" style="animation: fadeIn 1s ease-out 0.5s both;">

                        © 2025 Department of Education. All rights reserved.

                    </div>



                </div>

            </div>

        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>

        $(function() {

            toastr.options = {

                closeButton: true,

                progressBar: true,

                positionClass: "toast-top-right",

                timeOut: 5000

            };



            <?php if (!empty($data["message"])): ?>

                <?php if (($data['status'] ?? '') === 'error'): ?>

                    toastr.error(

                        "The email or password you entered is incorrect. Please try again.",

                        "Login Failed"

                    );

                <?php else: ?>

                    toastr.success(

                        "<?php echo addslashes($data['message']); ?>",

                        "Success"

                    );

                <?php endif; ?>

            <?php endif; ?>

        });

    </script>



</body>



<?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/global-js.php'); ?>



</html>