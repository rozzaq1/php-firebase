<?php
include('includes/header.php');
?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                            Edit and Upload
                                <a href="index.php" class="btn btn-danger float-end"> Back </a>
                            </h4>           
                        </div>
                        <div class="card-body">
                            
                            <?php
                            include('dbcon.php');

                            if(isset($_GET['id']))
                            {
                                $key_child = $_GET['id'];

                                $ref_table = "contacts";
                                $getdata = $database->getReference($ref_table)->getChild($key_child)->getValue();

                                if($getdata > 0)
                                {
                                    ?>
                                
                                <form action="code.php" method="POST">

                                    <input type="text" name="key" value="<?=$key_child;?>">
                                    <div class="form-grub mb-3">
                                        <label for="">First name</label>
                                        <input type="text" name="first_name" value="<?=$getdata['fname']?>" class="form-control">
                                    </div>
                                    <div class="form-grub mb-3">
                                        <label for="">Last name</label>
                                        <input type="text" name="last_name" value="<?=$getdata['lname']?>" class="form-control">
                                    </div>
                                    <div class="form-grub mb-3">
                                        <label for="">Email Address</label>
                                        <input type="email" name="email" value="<?=$getdata['email']?>" class="form-control">
                                    </div>
                                    <div class="form-grub mb-3">
                                        <label for="">Phone</label>
                                        <input type="phone" name="phone" value="<?=$getdata['phone']?>" class="form-control">
                                    </div>
                                    <div class="form-grub mb-3">
                                        <button type="submit" name="update-contact" class="btn btn-primary">Update</button>
                                </form>
                            <?php
                                }
                                else
                                {
                                    $_SESSION['status'] = "Ga onok id";
                                    header('Location : index.php');
                                    exit();
                                }
                            }
                            else
                            {
                                $_SESSION['status'] = "Ga onok isi";
                                header('Location : index.php');
                                exit();
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
include('includes/footer.php');
?>