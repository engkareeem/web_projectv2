<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div id="nav">
    <a href="dashboard.php"><img src="/src/logo-no-text.png" alt="" id="logo"></a>
    <div id="nav-links">
        <a href="dashboard.php" class="nav-item-link">Dashboard</a>
        <a href="products-management.php" class="nav-item-link">Products</a>
        <a href="users-management.php" class="nav-item-link">Users</a>

    </div>

    <div id="nav-buttons">
        <button type="button" id="logoutButton">Log out</button>
    </div>

</div>

<div id="notification-section">

</div>


<script>
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('nav');
        if (window.scrollY > 8) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    $(document).ready(function() {
        let path = window.location.pathname
        path = path.substring(path.lastIndexOf("/")+1);
        $('#nav-links a[href*="'+path+'"]').addClass('active');
    });
    $(() => {
        $("#logoutButton").click(function () {
            $.ajax({
                url: 'api/logout.php',
                method: 'POST',
                success: function(data) {
                    if(data === "success") {
                        location.href = "index.php";
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
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
                <div class="icon notification-icon ${notificationIcon}">
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

</script>