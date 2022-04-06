$(() => {
    $('#printBtn').on('click', function (){
        printOrder();
    });

    $("#buyPlace")
        .on("change", function () {
            if (this.value === "0") {
                //online
                $(".order-info-container").html($("#onTemplate").html());
            } else if (this.value === "1") {
                //offline
                $(".order-info-container").html($("#offTemplate").html());
            }

            bindEvents(); //bind event to new element
        })
        .trigger("change");
});
/* end ready */

//bind event for template
const bindEvents = () => {
    // input coupon event
    $(".coupon-input.no-check")
        .on(
            "input",
            debounce(function () {
                getCoupon($(this).val(), false);
            }, 500)
        )
        .trigger("input");

    $(".coupon-input.check")
        .on(
            "input",
            debounce(function () {
                getCoupon($(this).val(), true);
            }, 500)
        )
        .trigger("input");

    //input product id event
    $(".product-search-input").on(
        "input",
        debounce(function () {
            getProduct($(this).val());
        }, 500)
    );

    //button add product event
    $(".add-order-product-btn").on("click", function () {
        const idSku = $(".product-search-input").val();
        addProduct(idSku);
    });

    updatePrice();
};

const getCoupon = (idName, check) => {
    if(idName) {
        $.ajax({
            method: "post",
            url: "/coupon/ajax",
            data: {
                id_name: idName,
                check: check
            },
            beforeSend: () => {
                $(".coupon-card-container").empty();
                $("#couponLoad")
                    .removeClass("d-none")
                    .addClass("d-flex justify-content-center");
            },
            complete: function () {
                $("#couponLoad")
                    .addClass("d-none")
                    .removeClass("d-flex justify-content-center");
                updatePrice();
            },
            success: (result) => {
                const {data, error} = result;
                if (data) {
                    const couponCard = `
                <div class="card" id="couponCard" data-discount="${data.discount}">
                <input type="hidden" name="coupon_id" value="${data.coupon_id}">
                <div class="card-header text-center">
                    ${data.coupon_name}
                </div>
                <div class="card-body">
                <h5 class="card-title">Giảm
                    ${data.discount} %
                </h5>
                <p class="card-text">
                    ${data.description}
                </p>
                <div class="card-footer text-muted text-center">
                    Hết hạn vào: ${data.expire_at}
                </div>
                </div>
                </div>
                `;
                    $(".coupon-card-container").html(couponCard);
                }

                if (error) {
                    console.log(error.code, error.message);
                }
            },
        });
    }
    else{
        $(".coupon-card-container").empty();
    }
};

const getProduct = (idSku) => {
    if(idSku){
        $.ajax({
            method: "post",
            url: "/product/ajax",
            data: {
                id_sku: idSku,
            },
            beforeSend: function () {
                $("#productPreview").empty();
                $("#productLoad")
                    .removeClass("d-none")
                    .addClass("d-flex justify-content-center");
            },
            complete: function () {
                $("#productLoad")
                    .addClass("d-none")
                    .removeClass("d-flex justify-content-center");
            },
            success: (result) => {
                const data = result.data;
                const error = result.error;
                if (data) {
                    $("#productPreview").html(`
                    <div class="card product-preview-card">
                    <div class="card-body">
                    <p class="card-text">Id: ${data.product_id}</p>
                    <p class="card-text">SKU: ${data.sku}</p>
                    <h5 class="card-title">${data.product_name}</h5>
                    <p class="card-text text-danger">${data.price.toLocaleString(
                        "vi-VN"
                    )} đ</p>
                    <p class="card-text">Số lượng: ${data.quantity}</p>
                    </div>
                    </div>
                `);
                } else if (error) {
                    console.log(error.code, error.message);
                }
            },
        });
    }
    else{
        $("#productPreview").empty();
    }
};

const addProduct = (idSku) => {
    $.ajax({
        method: "post",
        url: "/product/ajax",
        data: {
            id_sku: idSku,
        },
        success: (result) => {
            const { data, error } = result;
            if (data) {
                if (data.quantity <= 0) {
                    alertMsg("Sản phẩm đã hết hàng");
                } else if (
                    $("#productsTable>tbody").find(
                        `[data-id=${data.product_id}]`
                    ).length !== 0
                ) {
                    alertMsg("Sản phẩm đã có trong hóa đơn");
                } else {
                    const productRow = `
                        <tr data-id=${data.product_id} data-price="${
                        data.price
                    }">
                        <input type="hidden" name="products[${
                            data.product_id
                        }][product_id]" value="${data.product_id}">
                        <th scope="row">
                            ${data.product_name}
                        </th>
                        <td>
                            ${data.sku}
                        </td>
                        <td>
                            <input class="form-control" type="number" min="1" max="${data.quantity}" name="products[${data.product_id}][quantity]" value="1" oninput="updatePrice()">
                        </td>
                        <td>
                            ${data.price.toLocaleString("vi-VN")} đ
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete-order-product-btn" onclick="removeProduct(${
                                data.product_id
                            })">Xóa</button>
                        </td>
                        </tr>
                        `;
                    $("#productsTable>tbody>tr:last-child").before(productRow);
                    updatePrice();
                }
            }

            if (error) {
                console.log(error.code, error.message);
                if (error.code === 404) {
                    alertMsg("Không tìm thấy sản phẩm");
                }
            }
        },
    });
};
//add alert message
const alertMsg = (msg) => {
    const alert = $(
        `<div class="alert alert-danger" id="orderListAlerts" role="alert">${msg}</div>`
    );
    $("#orderListAlerts").append(alert);
    setTimeout(() => {
        alert.remove();
    }, 2000);
};

//remove product from list
const removeProduct = (id) => {
    $(`[data-id=${id}]`).remove();
    updatePrice();
};

//update price
const updatePrice = () => {
    const rows = $("#productsTable tr:not(:last-child)");
    let sum = 0;

    rows.each(function (index, row) {
        sum +=
            $(row).data("price") * $(row).find('input[name*="quantity"]').val();
    });

    const discount = $("#couponCard").data("discount");
    if (discount) {
        const discountAmount = Math.round((sum * parseInt(discount)) / 100);
        $("#discountAmount").text(
            discountAmount.toLocaleString("vi-VN") + " đ"
        );
        sum -= discountAmount;
    }

    $("#totalPrice").text(sum.toLocaleString("vi-VN") + " đ");
};

const printOrder = ()=>{
    window.print();
}
