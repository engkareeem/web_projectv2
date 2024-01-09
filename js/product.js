
function changeFilter(element,filter) {
    if(element.classList.contains('active')) return;
    let activeElement = document.querySelector(".filter-bar .active");
    activeElement.classList.remove("active");
    element.classList.add("active");
    let content;
    $.ajax({
        url: 'api/generate/products.php',
        method: 'POST',
        data: {
            filter: filter,
        },
        async: false,
        success: function(data) {
            content = data;
        },
        error: function(error) {
            console.log('Error:', error);
            content = 'Bad Request';
        }
    });
    if(content !== 'Bad Request') {
        let container = document.getElementById('products-grid-view');
        if(content.length <= 0) {
            content = '<h1 style="color:white;">Empty</h1>';
        }
        container.innerHTML = content;
    }

}

function checkout(id) {
    if(id !== '') {
        shop_operation('purchase',id,1);

    } else {
        shop_operation('purchase-cart',id,1);
    }
    console.log("Test");

    const successModal = $("#success-purchase-modal");
    successModal.modal("show");
    successModal.on({
        'hidden.bs.modal': function (){
            window.location.href = 'profile-page.php';
        }
    })
}
function updateCartCount() {
    let cartCount = 0;
    for(let cookie of document.cookie.split(';')) {
        if(cookie.trim().startsWith("cart_")) {
            cartCount+=1;

        }
    }
    $('.cart-count-Badge').each(function () {
        $(this).html(cartCount > 9 ? '9+':cartCount);
    });
}
function updateCheckout() {
    setTimeout(function() {
        let response;
        $.ajax({
            url: 'api/UserShop.php',
            method: 'POST',
            data: {
                type: 'price-query',
                product_id: '',
            },
            async: false,
            success: function(data) {
                response = data;
                console.log(response);
            },
            error: function(error) {
                console.log('Error:', error);
                response = 'Bad Request';
            }
        });

        if(response !== 'Bad Request') {
            let totalItemsPriceElement = document.querySelector('.items-price .amount');
            let feesElement = document.querySelector('.fees .amount');
            let discountsElement = document.querySelector('.discounts .amount');
            let totalPriceElement = document.querySelector('.total-price .amount');
            let totalItemsPrice = response.split(';')[0];
            let totalPrice = response.split(';')[1];
            totalItemsPriceElement.innerText = totalItemsPrice;
            feesElement.innerText = 0.5;
            discountsElement.innerText = totalItemsPrice - totalPrice + 0.5;
            totalPriceElement.innerText = totalPrice;
        }
    }, 100);

}
$(()=> {
    $('#searchBar').on('input', function () {
       let text = $(this).val().toLowerCase();
       $('.card-item').each(function () {
          let title = $(this).find('.header .title').text();
          if(!title.toLowerCase().includes(text)) {
              $(this).hide();
          } else {
              $(this).show();
          }
       });
    });
    $(".horizontal-spinner .spinner-decrement").on('click',function () {
        let spinnerValue = $(this).next();
        let parent = $(this).closest('.cart-item');
        if(spinnerValue.val() > 1) {
            let newValue = spinnerValue.val() - 1;
            spinnerValue.val(parseInt(newValue.toString()));
            shop_operation('add-cart',parent.attr('id'),newValue);
            updateCheckout();
        }
    });
    $(".horizontal-spinner .spinner-increment").on('click',function () {
        let spinnerValue = $(this).prev();
        let newValue = parseInt(spinnerValue.val()) + 1;
        let parent = $(this).closest('.cart-item');
        spinnerValue.val(parseInt(newValue));
        shop_operation('add-cart',parent.attr('id'),newValue);
        updateCheckout();
    });
});
function shop_operation(type,id,count = 1) {
    var response;
    $.ajax({
        url: 'api/UserShop.php',
        method: 'POST',
        data: {
            type: type,
            product_id: id,
            count: count,
        },
        async: false,
        success: function(data) {
            response = data;
            console.log(data);
        },
        error: function(error) {
            console.log('Error:', error);
            response = 'Bad Request';
        }
    });
    return response !== 'Bad Request';
}
function fav_product(element,id) {
    event.stopPropagation();
    if(element.classList.contains("fa-regular")) {
        if(shop_operation('add-fav',id)) {
            element.classList.remove("fa-regular");
            element.classList.add("fa-solid");
            updateCartCount();
        }
    } else {
        if(shop_operation('remove-fav',id)) {
            element.classList.add("fa-regular");
            element.classList.remove("fa-solid");
            updateCartCount();
        }
    }
}
function cart_product(element,id,count= 1) {
    event.stopPropagation();
    if(element.classList.contains("fa-regular")) {
        if(shop_operation('add-cart',id,count)) {
            element.classList.remove("fa-regular");
            element.classList.add("fa-solid");
            updateCartCount();
        }
    } else {
        if(shop_operation('remove-cart',id,count)) {
            element.classList.add("fa-regular");
            element.classList.remove("fa-solid");
            updateCartCount();
        }
    }
}
