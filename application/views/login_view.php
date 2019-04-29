<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <style type="text/css">
    .divider-text {
        position: relative;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .divider-text span {
        padding: 7px;
        font-size: 12px;
        position: relative;
        z-index: 2;
    }

    .divider-text:after {
        content: "";
        position: absolute;
        width: 100%;
        border-bottom: 1px solid #ddd;
        top: 55%;
        left: 0;
        z-index: 1;
    }

    .btn-facebook {
        background-color: #405D9D;
        color: #fff;
    }

    .btn-twitter {
        background-color: #42AEEC;
        color: #fff;
    }
    </style>
</head>

<body>
    
    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <?php $this->authentication->notification();?>
                <h4 class="card-title mt-3 text-center">Login to your Account</h4>
                <p>
                    <a href="" class="btn btn-block btn-twitter"> <i class="fab fa-twitter"></i>   Login via Twitter</a>
                    <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via
                        facebook</a>
                </p>
                <p class="divider-text">
                    <span class="bg-light">OR</span>
                </p>
                <?php echo form_open('/authenticate')?>

                <?php echo form_error('email_address', '<small class="text-danger">', '</small>'); ?>
                <div class="form-group input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <input name="email_address" class="form-control" placeholder="Email address" type="email"
                        value="<?php echo set_value('email_address'); ?>" required>
                </div> <!-- form-group// -->


                <?php echo form_error('user_type', '<small class="text-danger">', '</small>'); ?>
                <div class="form-group input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                    </div>
                    <select name="user_type" class="form-control">
                        <option <?php echo  set_select('user_type', 'User', TRUE); ?>>User</option>
                        <option <?php echo  set_select('user_type', 'Manager'); ?>>Manager</option>
                        <option <?php echo  set_select('user_type', 'Accauntant'); ?>>Accauntant</option>
                    </select>
                </div> <!-- form-group end.// -->
                <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                <div class="form-group input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="password" class="form-control" placeholder="password" type="password"
                        value="<?php echo set_value('password'); ?>" required>
                </div> <!-- form-group// -->
                <?php echo form_error('password_repeat', '<small class="text-danger">', '</small>'); ?>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"> Login </button>
                </div> <!-- form-group// -->
                <p class="text-center">Dont have an account? <a href="<?php echo site_url('/register')?>">Create
                        account</a> </p>
                <?php echo form_close();?>
            </article>
        </div> <!-- card.// -->

    </div>
</body>

</html>