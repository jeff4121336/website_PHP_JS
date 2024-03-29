<?php
    require '/var/www/html/IERG4210/lib/db.inc.php';
    require '/var/www/html/IERG4210/lib/auth.php';
    require '/var/www/html/IERG4210/lib/nonce.php';
    $res = ierg4210_cat_fetchall();
    $options = '';
    $poptions = '';
    $pres = ierg4210_prod_fetchall();
    foreach ($res as $value){
    $options .= '<option value="'.$value["cid"].'"> '.$value["name"].' </option>';
    }
    foreach ($pres as $value){
    $poptions .= '<option value="'.$value["pid"].'"> '.$value["name"].' </option>';
    }
if(isset($_POST['AdminPanel'])) {
        if (ierg4210_auth()) {
                header('Location: admin.php');
        }
}

if(isset($_POST['Login'])) {
    header('Location: login.php');
    exit();
}

if(isset($_POST['Logout'])){
        header('Location: login.php');
        ierg4210_log_out();
        exit();
}

if(!ierg4210_auth()) {	
	header('Loction: login.php');
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>GoodShop</title>

    <link rel="stylesheet" href=admin.css type="text/css">
    <link rel="stylesheet" href=web.css type="text/css">
</head>

<body>
        <form method="post">
            <input type="submit" name="AdminPanel" value="AdminPanel"/>
            <input type="submit" name="Login" value="Login"/>
            <input type="submit" name="Logout" value="Logout"/>
        </form>
        <?php
                $username = ierg4210_getuser();
                echo ' User: '.$username;
        ?>

    <div>
        <header> Welcome to GoodShop! </header>
    </div>


    <div class="links">
        <a href="main.php">Home Page</a>
   	<a href="admininfo.php"> Order Details </a>
    </div>
    <div class="adminheader">
        Admin Panel
    </div>

    <div class="container"> <!--  Flex box -->

        <div id="FlexCol1">
        <fieldset>
            <legend> New Product</legend>
            <form name="insertprod" id="prod_insert" method="POST" action="admin-process.php?action=<?php echo ($action = 'prod_insert'); ?>"
            enctype="multipart/form-data">

                <label for="prod_cid"> Category * </label>
                <div> <select id="prod_cid" name="cid"><?php echo $options; ?></select></div>
                <label for="prod_name"> Name *</label>
                <div> <input id="prod_name" type="text" name="name" required="required" pattern="^\w+( \w+)*$"/></div>
                <label for="prod_price"> Price * </label>
                <div> <input id="prod_price" type="text" name="price" required="required" pattern="^[0-9\.]+$"/></div>
                <label for="prod_inv"> Inventory * </label>
                <div> <input id="prod_inv" type="text" name="inventory" required="required" pattern="^[0-9]+$"/></div>
                <label for="prod_desc"> Description * </label>
                <div> <input id="prod_desc" type="text" name="description" required="required" pattern="^\w+( \w+)*$"/> </div>
                <label for="prod_image"> New Image </label>
                <div> <input type="file"  name="file" accept="image/jpeg, image/jpg, image/png, image/gif"/> </div>
                <div class="drop_area" draggable="true"> Drop Image Here...</div>
                <input type="submit" value="Submit"/>
                <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />

           </form>
        </fieldset>

        <fieldset>
                <legend>New Catagories</legend>
                <form method="POST" action="admin-process.php?action=<?php echo ($action = 'cat_insert') ?>" enctype="multipart/form-data">
                        <label for="prod_name"> Name *</label>
                        <div> <input id="prod_name" type="text" name="name" required="required" pattern="^\w+( \w+)*$"/></div>

                     <input type="submit" value="Submit" />
                    <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />

                </form>
        </fieldset>

        <fieldset>
                <legend>Delete Catagories</legend>
                <form method="POST" action="admin-process.php?action=<?php echo ($action = 'cat_delete'); ?>" enctype="multipart/form-data">

                    <label for="prod_cat">Delete Category *</label>
                    <div> <select id="prod_cat" name="cid"><?php echo $options; ?></select></div>

                    <input type="submit" value="Submit" />
                    <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />

                </form>
        </fieldset>

        <fieldset>
            <legend>Edit Catagories</legend>
                <form method="POST" action="admin-process.php?action=<?php echo ($action = 'cat_edit'); ?>" enctype="multipart/form-data">

                    <label for="prod_cat">Edit Category *</label>
                    <div> <select id="prod_cat" name="cid"><?php echo $options; ?></select></div>

                    <label for="catnewname">New Name *</label>
                    <div>
                        <input id="catnewname" name="name" type="text" required="required" pattern="^\w+( \w+)*$"></select>
                    </div>
                    <input type="submit" value="Submit" />
                    <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />
                    
                </form>
        </fieldset>

        </div>

        <div id="FlexCol2">
            <fieldset>
            <legend> Edit Product</legend>
            <form name="editprod" method="POST" action="admin-process.php?action=<?php echo ($action = 'prod_edit'); ?>" enctype="multipart/form-data">

                <label for="prod_pid"> Product *</label>
                <div> <select id="prod_pid" name="pid" required="required"><?php echo $poptions;?></select></div>
                <label for="prod_name"> New Name *</label>
                <div> <input id="prod_name" type="text" name="name" required="required" pattern="^\w+( \w+)*$"/></div>
                <label for="prod_price"> New Price *</label>
                <div> <input id="prod_price" type="text" name="price" required="required" pattern="^[0-9\.]+$"/></div>
                <label for="prod_inv"> New Inventory *</label>
                <div> <input id="prod_inv" type="text" name="inventory" required="required" pattern="^[0-9]+$"/></div>
                <label for="prod_desc"> New Description *</label>
                <div> <input id="prod_desc" type="text" name="description" required="required" pattern="^\w+( \w+)*$"/> </div>

                <label for="prod_image"> New Image </label>
                <div> <input type="file" name="file" accept="image/jpeg, image/jpg, image/png, image/gif"/> </div>
                <div class="drop_area" draggable="true"> 
                        Drop Image Here...
                </div>
                <input type="submit" value="Submit"/>
                <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />
                
            </form>
            </fieldset>

            <fieldset>
                <legend>Delete ALL Products by CID</legend>
                <form method="POST" action="admin-process.php?action=<?php echo ($action = 'prod_delete_by_cid'); ?>" enctype="multipart/form-data">

                    <label for="prod_cid">Delete Products by CID *</label>
                    <div> <select id="prod_cid" name="cid"><?php echo $options; ?></select></div>

                    <input type="submit" value="Submit" />
                    <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />

                </form>
            </fieldset>

            <fieldset>
                <legend>Delete Products </legend>
                <form method="POST" action="admin-process.php?action=<?php echo ($action = 'prod_delete'); ?>" enctype="multipart/form-data">

                    <label for="prod_id">Delete Products *</label>
                    <div> <select id="prod_id" name="pid"><?php echo $poptions; ?></select></div>

                    <input type="submit" value="Submit" />
                    <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />


                </form>
            </fieldset>
                
            <fieldset>
            <legend> Add User </legend>
            <form name="login" method="POST" action="admin-process.php?action=<?php echo ($action = 'account_set_up'); ?>" " enctype="multipart/form-data">

                <label for="email"> Email *</label>
                <div> <input id="email" type="email" name="email" required="required"/> </div>
                <label for="password"> Password (8-16 with Lower/Uppercase and numbers only)*</label>
                <div> <input id="password" type="password" name="password" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$"/></div>

                <label for="user"> Account Type *</label>
                <div>
                <input type="radio" name="user" value="admin" required="required"/> Admin
                <input type="radio" name="user" value="NormalUser"/> Normal User
                </div>

                <input type="submit" value="Submit"/>
                <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />

                
            </form>
            </fieldset>

        </div>
    </div>

    <div>
        <footer>
            <div>
                GoodShop Limited 2023
            </div>
            <div>
                Come And Buy! Enjoy Shopping!
            </div>
        </footer>
    </div>

<script src=dragdrop.js type="text/javascript"></script>
</body>

</html>
