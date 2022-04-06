$(() => {
    $('#printBtn').on('click', function (){
        printNote();
    });

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

    //table input event
    $('#productsTable input').on('input', function () {
        if ($(this).val() !== '') {
            updatePrice();
        }
    });

});
/* end ready */

//get product preview
const getProduct = (idSku) => {
    if (idSku) {
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
    } else {
        $("#productPreview").empty();
    }
};

//add product to table
const addProduct = (idSku) => {
    $.ajax({
        method: "post",
        url: "/product/ajax",
        data: {
            id_sku: idSku,
        },
        success: (result) => {
            const {data, error} = result;
            if (data) {
                if (
                    $("#productsTable>tbody").find(
                        `[data-id=${data.product_id}]`
                    ).length !== 0
                ) {
                    alertMsg("Sản phẩm đã có trong phiếu");
                } else {
                    const productRow = $(`
                        <tr data-id=${data.product_id}>
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
                            <input class="form-control" type="number" min="1" max="30000" name="products[${data.product_id}][quantity]" value="1" oninput="updatePrice()">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="products[${data.product_id}][price]" value="0" maxlength="15" oninput="updatePrice()">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete-order-product-btn" onclick="removeProduct(${data.product_id})">Xóa</button>
                        </td>
                        </tr>
                        `);
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
        sum += $(row).find('input[name*="price"]').val() * $(row).find('input[name*="quantity"]').val();
    });

    $("#totalPrice").text(sum.toLocaleString("vi-VN") + " đ");
};

const printNote = ()=>{
    window.print();
}

