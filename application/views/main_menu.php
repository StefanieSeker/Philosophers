<?php echo javascript("validator.js"); ?>

<?php
$attributes = array('name' => 'myform');
echo form_open('home/login', $attributes);
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Philosophers</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <?php echo anchor('home/index', 'Home'); ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Quotes</a>
            </li>
            <li class="nav-item">

                <a class="nav-link"><?php echo anchor('admin/index', 'Admin'); ?></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <?php
            if ($user == null) {
                echo form_input(array('name' => 'email', 'id' => 'email', 'pattern' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$','class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required'));

                $data = array('name' => 'password', 'id' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required');
                echo form_password($data);
                echo form_submit('mysubmit', 'Login', 'class="btn btn-outline-success my-2 my-sm-0"');
                echo form_close();
            } else {
            echo anchor('home/logout', 'Logout'); } ?>



        </div>

        <div>

        </div>
    </div>


</nav>
