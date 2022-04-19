$(function () {
    /* SLUG FIELD */
    $("#name").on("input", function () {
        $("#slug").val(slugnify(this.value));
    });

    /* SELECTIZE */
    $(".selectize").selectize();

    $("#brandSelect").selectize({
        create: true,
        placeholder: "Chọn thương hiệu ...",
        create: function (input) {
            return {
                value: input,
                text: input,
            };
        },
        render: {
            option_create: function (data, escape) {
                var addString = "Thêm thương hiệu";
                return (
                    '<div class="create">' +
                    addString +
                    " <strong>" +
                    escape(data.input) +
                    "</strong>&hellip;</div>"
                );
            },
        },
    });

    $("#categorySelect").selectize({
        create: true,
        create: function (input) {
            return {
                value: input,
                text: input,
            };
        },
        render: {
            option_create: function (data, escape) {
                var addString = "Thêm danh mục";
                return (
                    '<div class="create">' +
                    addString +
                    " <strong>" +
                    escape(data.input) +
                    "</strong>&hellip;</div>"
                );
            },
        },
    });

    /* CONFIRM DELETE */
    $(".delete-product").on("submit", function () {
        if (
            confirm(
                "Bạn có chác chắn muốn xóa sản phẩm " +
                    this.dataset.name +
                    this.dataset.id
            )
        ) {
            return true;
        }
        return false;
    });

    /* PREVIEW IMAGES */
    $(".preview-input").on("change", function () {
        previewImage(this);
    });

    $(".preview-input[multiple]").on("change", function () {
        previewProductImages(this);
    });

    /* CAROUSEL */
    $("#productSlide").carousel({
        pause: true,
        interval: false,
    });

    /* VARIANT TABS */
    $(".nav-tabs>a").on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        const target = $(this).data("target");
        $("#" + target)
            .addClass("show active")
            .fadeIn()
            .siblings(".tab-pane")
            .fadeOut()
            .removeClass("show active");
    });

    $("#addVariant2").on("click", function () {
        $(this).hide();
        $("#variant1").after(/* html */ `
            <div class="mb-4" id="variant2">
                <div class="variant-group form-group mb-2">
                    <label class="form-label required" for="variant1">Nhóm phân loại 2</label>
                    <input type="text" class="form-control mb-2 variant-name" name="variant2_group_name" placeholder="Tên nhóm phân loại (VD: Màu sắc, kích cỡ)">
                    <input type="text" class="form-control mb-2 variant2-value infinite-input" name="variant2_group_values[]" placeholder="Tên phân loại (VD: Đỏ)">
                </div>
                <button class="btn btn-danger" type="button" id="removeVariant2">Xóa phân loại 2</button>
            </div>
            `);

        addUpdateTableListener();
        addInfiniteInputListener("#variant2 .infinite-input");
        addRemoveVariant2Listener("#removeVariant2");
    });

    $("#applyAllBtn").on("click", function () {
        const price = $("#priceAll").val();
        const quantity = $("#quantityAll").val();
        const sku = $("#skuAll").val();
        $(".v-price").val(price);
        $(".v-quantity").val(quantity);
        $(".v-sku").val(sku);
    });

    $("#productStoreForm").on("submit", function(e){
        e.preventDefault();
        if($("#multipleVariants.active").length !== 0){
            $("#singleVariant input").prop("disabled", true);
        }
        else {
            $("#multipleVariants input").prop("disabled", true);
        }

        const form = new FormData($("#productStoreForm").get(0));
        $.ajax({
            url: FORM_POST,
            type: "POST",
            date: form,
            processData: false,
            contentType: false,
        });
        // TODO: ajax
    });

    addUpdateTableListener();
    addInfiniteInputListener(".infinite-input");
});

/* FUNCTIONS */
function slugnify(title) {
    slug = title.toLowerCase();

    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
    slug = slug.replace(/đ/gi, "d");
    slug = slug.replace(
        /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
        ""
    );
    slug = slug.replace(/ /gi, "-");
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-/gi, "-");
    slug = slug.replace(/\-\-/gi, "-");
    slug = slug.replace(/^\-|\-$/gi, "");
    return slug;
}

function previewImage(input) {
    const file = input.files[0];
    const fileReader = new FileReader();
    fileReader.addEventListener(
        "load",
        function () {
            $(input)
                .next(".preview-img-wrapper")
                .removeClass("d-none")
                .addClass("img-thumbnail")
                .children("img")
                .attr("src", fileReader.result);
        },
        false
    );
    if (file) {
        fileReader.readAsDataURL(file);
    }
}

function previewProductImages(input) {
    const previewImgs = $(input).next(".preview-imgs");
    previewImgs.removeClass("d-none").empty();
    const files = Array.from(input.files);
    files.forEach((file) => {
        let fileReader = new FileReader();
        fileReader.addEventListener("load", function () {
            previewImgs.append(/*html*/ `
                        <div class="col-3">
                            <div class="preview-img-wrapper mb-3">
                                <img class="img-thumbnail" src="${fileReader.result}" alt="">
                            </div>
                        </div>
                `);
        });
        fileReader.readAsDataURL(file);
    });
}

function debounce(func, timeout = 200) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
}

function addInfiniteInputListener(selector) {
    $(selector).on(
        "keyup",
        debounce(function () {
            if (!$(this).val()) {
                if (!$(this).is(":last-child")) {
                    $(this).next(".infinite-input").trigger("focus");
                    $(this).remove();
                }
            } else if ($(this).next(".infinite-input").length == 0) {
                $(this).after($(this).clone(true).val(""));
            }
        })
    );
}

function addRemoveVariant2Listener(selector) {
    $(selector).on("click", function () {
        $(this).remove();
        $("#variant2").remove();
        $("#addVariant2").show();
        updateVariantsTable();
    });
}

function updateVariantsTable() {
    console.log("update");
    const variantNames = $(".variant-name").toArray();
    const variant1Values = $(".variant1-value:not(:last-child)").toArray();
    const variant2Values = $(".variant2-value:not(:last-child)").toArray();

    if (!validateVariantInfo(variantNames, variant1Values, variant2Values)) {
        $("#variantsTable").html(
            `<tbody><tr><td class="text-center">Chưa có phân loại</td></tr></tbody>`
        );
        return;
    }

    $("#variantsTable").html(/*html*/ `
        <thead>
            <tr>
                ${variantNames
                    .map(
                        (name) =>
                            "<th style='text-align:center'>" +
                            name.value +
                            "</th>"
                    )
                    .join("")}
                <th style='width: 10%; text-align:center'>Giá</th>
                <th style='width: 10%; text-align:center'>Giá sale</th>
                <th style='width: 10%; text-align:center'>SL</th>
                <th style='width: 20%; text-align:center'>SKU</th>
                <th style='width: 6%; text-align:center'>Ảnh</th>
                <th style='width: 0%; text-align:center'></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    `);

    if (variant1Values.length > 0 && variantNames.length > 0)
        for (let i = 0; i < variant1Values.length; i++) {
            if (variant2Values.length > 0 && variantNames.length == 2) {
                for (let j = 0; j < variant2Values.length; j++) {
                    $("#variantsTable tbody").append(/*html*/ `
                        <tr>
                            <td style="font-weight: bold;">${variant1Values[i].value}</td>
                            <td style="font-weight: bold;">${variant2Values[j].value}</td>
                            <td><input type="text" class="form-control v-price" name="v_prices[${i}][${j}" id=""></td>
                            <td><input type="text" class="form-control v-sale-price" name="v_sale_prices[${i}][${j}]" id=""></td>
                            <td><input type="text" class="form-control v-quantity" name="v_quantities[${i}][${j}]" id=""></td>
                            <td><input type="text" class="form-control v-sku" name="v_skus[${i}][${j}]" id=""></td>
                            <td>
                                <div>
                                    <input type="file" class="form-control d-none v-image" id="vImage[${i}][${j}]" name="v_images[${i}][${j}]">
                                    <label class="d-block required preview-img-wrapper img-thumbnail" for="vImage[${i}][${j}]">
                                        <img src="/storage/images/logo.png" alt="" class="preview-variant img-fluid">
                                    </label>
                                </div>
                            </td>
                            <td class="text-center"><button type="button" class="btn btn-danger delete-row-btn">Xoá</button></td>
                        </tr>
                    `);
                }
            } else {
                if (variant1Values[i].value.length > 0){
                    $("#variantsTable tbody").append(/*html*/ `
                        <tr>
                            <td style="font-weight: bold;">${variant1Values[i].value}</td>
                            <td><input type="text" class="form-control v-price" name="v_price[${i}]" id=""></td>
                            <td><input type="text" class="form-control v-sale-price" name="v_sale_prices[${i}]" id=""></td>
                            <td><input type="text" class="form-control v-quantity" name="v_quantity[${i}]" id=""></td>
                            <td><input type="text" class="form-control v-sku" name="v_sku[${i}]" id=""></td>
                            <td>
                                <div>
                                    <input type="file" class="form-control d-none v-image" id="vImage[${i}]" name="v_images[${i}]">
                                    <label class="d-block required preview-img-wrapper img-thumbnail" for="vImage[${i}]">
                                        <img src="/storage/images/logo.png" alt="" class="preview-variant img-fluid">
                                    </label>
                                </div>
                            </td>
                            <td class="text-center"><button type="button" class="btn btn-danger delete-row-btn">Xoá</button></td>
                        </tr>
                    `);
                }
            }
        }

    addRemoveRowEventListener();
    addVariantImagePreviewListener();
}

function addUpdateTableListener() {
    $(".variant-group input.form-control").on(
        "keyup",
        debounce(updateVariantsTable, 500)
    );
}

function validateVariantInfo([n1, n2], v1, v2) {
    if (
        !n1.value ||
        v1.length == 0 ||
        (n2?.value && v2.length == 0) ||
        (v2.length > 0 && !n2?.value)
    ) {
        return false;
    } else return true;
}

function addVariantImagePreviewListener() {
    $(".v-image").on("change", function () {
        previewImage(this);
    });
}

function addRemoveRowEventListener() {
    $(".delete-row-btn").on("click", function () {
        $(this).parents("tr").remove();
        if ($("#variantsTable tbody tr").length === 0) {
            $("#variantsTable").html(
                `<tbody><tr><td class="text-center">Chưa có phân loại</td></tr></tbody>`
            );
        }
    });
}
