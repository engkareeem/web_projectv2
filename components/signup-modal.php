<div class="modal fade" tabindex="-1" id="signup-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="icon close-button fa-sharp fa-regular fa-xmark" data-bs-dismiss="modal"></span>
            </div>
            <div class="modal-body">
                <div class="body-header">
                    <span  class="icon fa-solid fa-user person-icon"></span>
                    <span class="content-title">Sign-Up</span>
                </div>

                <form id="signup-form">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="icon-text-field">
                            <span class="icon fa-regular fa-circle-user text-field-icon"></span>
                            <input type="text" placeholder="Username" name="username" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="icon-text-field">
                            <span class="icon fa-solid fa-at text-field-icon"></span>
                            <input type="email" placeholder="Email" name="email" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="icon-text-field">
                            <span class="icon fa-duotone fa-lock text-field-icon"></span>
                            <input type="password" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <div class="icon-text-field">
                            <span class="icon fa-duotone fa-lock text-field-icon"></span>
                            <input type="password" placeholder="Confirm Password" name="confirm-password">
                        </div>
                        <span class="response" style="color: #ff1f1f;font-size: 0.9em"></span>
                    </div>
                    <button type="submit" class="primary-btn">Submit</button>
                </form>
                <div class="medal-footer">
                    Already have an account &nbsp <span class="switch-to-signin" data-bs-toggle="modal" data-bs-target="#login-modal"> Login</span>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="../js/jquery-3.7.1.min.js"></script>
<!--<script src="../js/main.js"></script>-->
<script>
    const signUpModal = document.getElementById('signup-modal')
    signUpModal.addEventListener('shown.bs.modal', () => {

    })
    $(() => {
        $(".response").text("");
        $('#signup-modal').on('hidden.bs.modal', function () {
            // Load up a new modal...
            $('#login-modal').modal('show');
        })
        $('#signup-form').submit(function () {
            event.preventDefault();
            try {

                $.ajax({
                    url: 'api/register.php', // Replace with your server endpoint
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data) {
                        $('#signup-modal').modal("hide");
                        $('#login-modal').modal('show');

                        $(".response").text("Register successful, You can login now!"); // TODO: Make it successful response (ex. green font)
                    },
                    error: function(error) {
                        $(".response").text("Something goes wrong.. Please try again!");
                        console.log('Error:', error);
                    }
                });
            } catch (e) {
                console.error("Error nigga: ", e);
            }
            event.preventDefault();
        });
    });
</script>