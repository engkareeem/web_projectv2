<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Products</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">
</head>
<body>
<?php include './components/admin-navbar.php' ?>
<div class="users-mgm-title">Users</div>
<div class="users-mgm-body">
    <div id="user-form-wrapper">
        <div class="form-title">User Account Information</div>
        <form method="post" enctype="multipart/form-data" id="user-form">
            <div class="data-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Name of the user" disabled>
            </div>


            <div class="data-box">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="User email" disabled>
            </div>


            <div class="data-box">
                <label for="lastLogin">Last Login:</label>
                <input type="date" id="lastLogin" name="lastLogin" disabled>
            </div>


            <div class="data-box">
                <label for="purchasedListCount">Products Bought:</label>
                <input type="number" id="purchasedListCount" name="purchasedListCount"  value="0" disabled>
            </div>

            <br>
            <button type="submit" class="deactive-btn" disabled>Deactivate this Account</button>
        </form>
    </div>
    <div class="users-list-card">
        <?php
            include_once 'api/DBApi.php';
            $users = DBApi::getAllUsers();
            foreach($users as $user) {
                $purchasedCount = count($user->purchasedList);
                echo "
                <div class='user-item' username='$user->username' email='$user->email' lastLogin='$user->lastLogin' purchasedListCount='$purchasedCount'>
                    <div class='img-container'>
                        <img src='src/profile-img.jpg' alt='...'>
                    </div>
                    <div class='user-item-title'>$user->username</div>
                </div>";
            }
        ?>

    </div>
</div>

<?php include './components/admin-footer.php' ?>

<script>
    $(".user-item").click(function (){
        $(this).toggleClass("selected");
        $(this).siblings().removeClass("selected");
        const deactivateButton = $(".deactive-btn");
        if($(this).hasClass("selected")){
            deactivateButton.prop("disabled", false);
            let form = document.forms[0];
            Array.from(form.elements).forEach(e => {
                if(e.type !== 'date') {
                    e.value = $(this).attr(e.name);
                } else {
                    e.value = (new Date($(this).attr(e.name)* 1000)).toISOString().split('T')[0];
                }
            })

        }else{
            deactivateButton.prop("disabled", true);
            document.forms[0].reset();
        }
    })
    $('#user-form').submit(function () {
        event.preventDefault();
    })
</script>

</body>
</html>