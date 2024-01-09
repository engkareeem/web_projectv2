
<html>
<script src="../src/jquery-3.7.1.min.js"></script>
<body>









<img src="getImage.php?id=658b4c20974d911cdd03ad4f" alt="Image">
<button id="downloadButton">download</button>
<div id="productList"></div>

<form id="uploadImageForm">
    <label>
        Title: <input type="text" name="title">
    </label>
    <br>
    <label>
        File: <input type="file" id="file">
        <input type="submit" value="upload">
    </label>
</form>


<form id="addProductForm">
    <label>
        Title: <input type="text" name="title">
    </label>
    <br>
    <label>
        Description: <input type="text" name="description">
    </label>
    <br>
    <label>
        Category: <input type="text" name="category">
    </label>
    <br>
    <label>
        price: <input type="number" name="price">
    </label>
    <br>
    <label>
        Stock: <input type="number" name="stock">
    </label>
    <br>
    <label>
        imageURL: <input type="file" name="file">
    </label>
    <br>
    <input type="submit" value="Add product">
</form>

<br>
<label>
    Username: <input type="text" id="username"> <br>
</label>
<label>
    Email: <input type="email" id="email"> <br>
</label>
<label>
    Password:<input type="text" id="password"> <br>
</label>
<button id="registerButton">Register</button>
<button id="loginButton">Login</button>
<script>
    $(document).ready(function() {
        $("#downloadButton").click(function () {
            $.ajax({
                url: 'getImage.php', // Replace with your server endpoint
                method: 'GET',
                data: {
                    id: "658b470f974d911cdd03ad4b",
                },
                success: function(data) {
                    // Handle the response data and populate the product list
                    $('#productList').text(data);
                    console.log(data);
                },
                error: function(error) {
                    // Handle errors
                    console.log('Error:', error);
                }
            });
        });
        $("#uploadImageForm").submit(function () {
            let formData = new FormData();
            // $.each($(this).serializeArray(), function(_, field) {
            //     formData.append(field.name, field.value);
            // });
            formData.append('file', $("#file")[0].files[0]);

            $.ajax({
                url: 'upload.php', // Replace with your server endpoint
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // Handle the response data and populate the product list
                    $('#productList').text(data);
                    console.log(data);
                },
                error: function(error) {
                    // Handle errors
                    console.log('Error:', error);
                }
            });
            event.preventDefault();
        });
        $("#addProductForm").submit(function () {
            // let formData = new FormData();
            // $.each($(this).serializeArray(), function(_, field) {
            //     formData.append(field.name, field.value);
            // });
            // formData.append('file', $("#file")[0].files[0]);
            let formData = new FormData(this);
            $.ajax({
                url: 'addProduct.php', // Replace with your server endpoint
                method: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    // Handle the response data and populate the product list
                    $('#productList').text(data);
                    console.log(data + " " );
                },
                error: function(error) {
                    // Handle errors
                    console.log('Error:', error);
                }
            });
            event.preventDefault();
        });


        $("#registerButton").click(function() {
            $.ajax({
                url: 'register.php', // Replace with your server endpoint
                method: 'POST',
                data: {
                    username: $("#username").val(),
                    email: $("#email").val(),
                    password: $("#password").val()
                },
                success: function(data) {
                    // Handle the response data and populate the product list
                    $('#productList').text(data);
                    console.log(data);
                },
                error: function(error) {
                    // Handle errors
                    console.log('Error:', error);
                }
            });
        });
        $("#loginButton").click(function() {
            $.ajax({
                url: 'login.php', // Replace with your server endpoint
                method: 'POST',
                data: {
                    username: $("#username").val(),
                    password: $("#password").val()
                },
                success: function(data) {
                    // Handle the response data and populate the product list
                    $('#productList').text(data);
                    console.log(data);
                },
                error: function(error) {
                    // Handle errors
                    console.log('Error:', error);
                }
            });
        });
    });
</script>

</body>
</html>

