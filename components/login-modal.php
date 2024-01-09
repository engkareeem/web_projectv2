
<div class="modal fade" tabindex="-1" id="login-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="icon fa-sharp fa-regular fa-xmark close-button" data-bs-dismiss="modal"></span>
            </div>
            <div class="modal-body">
                <div class="body-header">
                    <span class="icon fa-solid fa-user person-icon"></span>
                    <span class="content-title">Log-In</span>
                </div>

                <form id="signin-form">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="icon-text-field">
                            <span class="icon fa-regular fa-circle-user text-field-icon"></span>
                            <input type="text" placeholder="Username" name="username" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="icon-text-field">
                            <span class="icon fa-duotone fa-lock text-field-icon"></span>
                            <input type="password" placeholder="Password" name="password">
                        </div>
                        <span class="response" style="color: #ff1f1f;font-size: 0.9em"></span>
                    </div>
                    <button type="submit" class="primary-btn">Submit</button>
                </form>

                <div class="medal-footer">
                    Don't have an account? &nbsp <span class="switch-to-signup" data-bs-toggle="modal" data-bs-target="#signup-modal"> Sign Up</span>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="../js/jquery-3.7.1.min.js"></script>
<!--<script src="../js/main.js"></script>-->
<script>
    const loginModal = document.getElementById('login-modal')
    loginModal.addEventListener('shown.bs.modal', () => {
    })
    $(() => {
        $(".response").text("");
        $("#signin-form").submit(function () {
            try {
                $.ajax({
                    url: 'api/login.php',
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data) {
                        if(data === "success") {
                            location.href = "index.php";
                        } else {
                            //TODO: Make the inputs error design. sorry for my england
                            $(".response").text(data);
                        }

                    },
                    error: function(error) {
                        $(".response").text("Something goes wrong, please try again.");
                        console.log('Error:', error);
                    }
                });
            } catch (e) {
                console.error("error nigga ", e);
            }

            event.preventDefault();
        })
    })

</script>