
<?php
    include './components/signup-modal.php';
    include './components/login-modal.php';
    include_once 'api/DBApi.php';
$user = DBApi::ensureLogin();
    $isLogged = $user->username !== null;
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div id="nav">
    <a href="index.php"><img src="/src/logo-no-text.png" alt="" id="logo"></a>

    <div id="nav-links">
        <a href="index.php" class="nav-item-link">Home</a>
        <a href="all_products.php" class="nav-item-link">Catalog</a>
        <?php
        if($isLogged) {
            global $cartCount;
            $cardCount = count(DBApi::getCart());
            if($cardCount > 9) $cardCount = '9+';
            echo '<a href="profile-page.php" class="nav-item-link">Profile</a>';
            echo '<a href="shopping_cart.php" class="nav-item-link" id="cart-nav-btn">Cart
            <span class="position-absolute start-100 translate-middle badge rounded-pill cart-count-Badge">$cartCount</span>
                </a>';
        }
        ?>

    </div>
    <div id="nav-buttons">


        <?php
            if(!$isLogged) {
                echo '<button type="button" data-bs-toggle="modal" data-bs-target="#login-modal">Log In</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#signup-modal">Sign up</button>';
            } else {
                echo "
                <div class='cart-icon-wrapper'>
            <div class='icon fa-duotone fa-cart-shopping' id='shopping-cart-icon'>
                <span class='position-absolute start-100 translate-middle badge rounded-pill cart-count-Badge'>$cardCount</span>
            </div>
        </div>";
            }
        ?>

    </div>
</div>

<div id="notification-section">

</div>


<script>
    const navbar = document.getElementById('nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 8) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });


    /**
     * This function shows notification in any page.
     *
     * @param {string} msgTitle Title of the notification.
     * @param {string} msgBody Notification content.
     * @param {String} msgType Type of the Notification: \
     * -1 => Error. \
     * 0 => Warning. \
     * 1 => Success.
     * @param {number} msgTimeout Time (ms) till notification get removed.
     * @param {number} animationDuration Time (ms) for animation duration
     * @return {null}
     */
    function notify(msgTitle, msgBody, msgType = 1, msgTimeout = 1000, animationDuration = 1000){
        const notificationSection = $("#notification-section");
        let notificationIcon, className;
        switch (msgType){
            case -1:
                notificationIcon = 'fa-sharp fa-triangle-exclamation'
                className = 'error-notification';
                break;
            case 0:
                notificationIcon = 'fa-sharp fa-circle-exclamation'
                className = 'warning-notification';
                break;
            case 1:
                notificationIcon = 'fa-sharp fa-circle-check'
                className = 'success-notification';
        }
        const notificationInstance = `
            <div class="notification ${className}">
                <div class="notification-icon icon ${notificationIcon}">

                </div>
                <div class="notification-body">
                    <div class="notification-title">${msgTitle}</div>
                    <div class="notification-msg">${msgBody}</div>
                </div>
            </div>`;

        const notification = $(notificationInstance);
        notificationSection.append(notification);
        notification.fadeOut(0);

        notification.fadeIn(animationDuration, ()=> {
            setTimeout(function() {
                notification.fadeOut(animationDuration - animationDuration/4, () => {
                    notification.remove();
                });
            }, msgTimeout);
        });


    }

    $(document).ready(function() {
        let path = window.location.pathname
        path = path.substring(path.lastIndexOf("/")+1);
        $('#nav-links a[href*="'+path+'"]').addClass('active');
        if(path.indexOf("cart") > 0) {
            $("#shopping-cart-icon").css("color", "white");
        }
        $("#shopping-cart-icon").click(function (){
            window.location.href = 'shopping_cart.php';

        });
    });
</script>