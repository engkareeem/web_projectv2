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
<div class="products-mgm-title">Products</div>
<div class="products-mgm-body">
    <div id="product-form-wrapper">
        <div class="form-title">Product Information</div>
        <form method="post" enctype="multipart/form-data" id="product-form">
            <div class="data-box">
                <label for="title">Product Title:</label>
                <input type="text" id="title" name="title" placeholder="Name of the product" required>
            </div>


            <div class="data-box">
                <label for="price">Price <span style="font-size: 14px; font-weight: bold">( $ ) </span>:</label>
                <input type="number" id="price" name="price" min="0" value="0" required>
            </div>


            <div class="data-box">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" min="0" value="0" required>
            </div>


            <div class="data-box">
                <label for="discount">Discount <span style="font-size: 14px; font-weight: bold">( % ) </span>:</label>
                <input type="number" id="discount" name="discount" min="0" max="100" step="5" value="0" required>
            </div>
            <div class="data-box">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter descriptive information about the product" required></textarea>
            </div>

            <div class="data-box">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="components">Components</option>
                    <option value="laptops">Laptops</option>
                    <option value="computers">Computers</option>
                    <option value="accessors">Accessors</option>
                </select>
            </div>

            <div class="data-box">
                <label for="image">Image <span style="font-size: 14px; font-weight: bold">(PNG, JPG, JPEG) </span>:</label>
                <input type="file" id="productImage" name="file" accept=".png, .jpg, .jpeg, .webp" required>
            </div>
            <span class="response" style="color: #ff1f1f;font-size: 0.9em"></span>

            <br>
            <button type="submit" class="add-btn" id="add-btn">Add Product</button>
            <button type="submit" class="update-btn" id="update-btn" disabled>Update</button>
            <button type="button" class="delete-btn" id="delete-btn" disabled>Delete</button>
        </form>
    </div>
    <div class="products-list-card">
        <?php
        include_once 'api/DBApi.php';
        $products = DBApi::getAllProducts();
        foreach($products as $product) {
            echo "
                <div class='product-item' _id='$product->_id' title='$product->title' description='$product->description' 
                price='$product->price' category='$product->category' imageID='$product->imageID' creationDate='$product->creationDate' 
                discount='$product->discount' stock='$product->stock' numSold='$product->numSold'>
                    <div class='img-container'>
                         <img src='api/getImage.php?id=$product->imageID' alt='image'>
                    </div>
                    <div class='product-item-title'>$product->title</div>
                    </div>";
        }
        ?>
    </div>
    </div>
</div>

<?php include './components/admin-footer.php' ?>

<script>
    let currentProductView=null;
    $(".product-item").click(function (){
        $(this).toggleClass("selected");
        $(this).siblings().removeClass("selected");
        const addBtn = $(".add-btn");
        const updateBtn = $(".update-btn");
        const deleteBtn = $(".delete-btn");
        if($(this).hasClass("selected")){
            addBtn.prop("disabled", true);
            updateBtn.prop("disabled", false);
            deleteBtn.prop("disabled", false);
            let form = document.forms[0];
            Array.from(form.elements).forEach(e => {
                if(e.type !== 'file') {
                    e.value = $(this).attr(e.name);
                }
            })
            currentProductView = $(this).attr('_id');

        }else{
            $('#product-form')[0].reset();
            addBtn.prop("disabled", false);
            updateBtn.prop("disabled", true);
            deleteBtn.prop("disabled", true);
        }
    })
    $("#add-btn").click(function () {
        let form = $('#product-form')[0];
        $('#productImage').attr('required',true);
        if(form.checkValidity()) {
            let formData = new FormData(form);
            let response = sendRequest('api/productOperation.php',"add",formData);
            if(response === 'success') {
                notify("Success","Product added Successfully!",1,3000);
                $("#product-form")[0].reset();
            } else {
                notify("Error", response, -1,5000);
            }
        }
    });
    $("#update-btn").click(function () {
        let form = $('#product-form')[0];
        $('#productImage').attr('required',false);
        if(form.checkValidity() && currentProductView !== null) {
            let formData = new FormData(form);
            formData.delete('file');
            formData.append('product_id',currentProductView);
            let response = sendRequest('api/productOperation.php',"edit",formData);
            if(response === 'success') {
                $('#product-form')[0].reset();
                $(".add-btn").prop("disabled", true);
                $(".update-btn").prop("disabled", true);
                $(".delete-btn").prop("disabled", true);
                currentProductView = null;
                setTimeout(function() {
                    location.reload();
                }, 3000);
                notify("Success","Product Edited Successfully!",1,3000);
            } else {
                notify("Error", response, -1,5000);
            }
        }

    });
    $("#delete-btn").click(function () {
        if(currentProductView !== null) {
            let formData = new FormData();
            formData.append("product_id",currentProductView);
            let response = sendRequest("api/productOperation.php","delete",formData);
            if(response === 'success') {
                $('#product-form')[0].reset();
                $(".add-btn").prop("disabled", true);
                $(".update-btn").prop("disabled", true);
                $(".delete-btn").prop("disabled", true);
                currentProductView = null;
                setTimeout(function() {
                    location.reload();
                }, 3000);
                notify("Success","Product Deleted Successfully!",1,3000);
            } else {
                notify("Error", response, -1,5000);
            }
        }
    });
    $("#product-form").submit(function () {
        event.preventDefault();
    });

    function sendRequest(endPoint,type,data) {
        let response;
        data.append("type",type);
        $.ajax({
            url: endPoint, // Replace with your server endpoint
            method: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            async: false,
            success: function(data) {
                // Handle the response data and populate the product list
                response = data;
                console.log(data + " " );
            },
            error: function(error) {
                // Handle errors
                console.log('Error:', error);
            }
        });
        return response;
    }
</script>

</body>
</html>