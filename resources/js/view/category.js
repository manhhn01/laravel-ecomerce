$(() => {
    //confirm delete
    $(".delete-category").submit(function () {
        if (
            confirm(
                "Bạn có chác chắn muốn xóa danh mục " +
                    this.dataset.name +
                    "có id " +
                    this.dataset.id +
                    '? Xóa danh mục này sẽ xóa toàn bộ sản phẩm trong danh mục'
            )
        ) {
            console.log("saved to the database.");
            return true;
        }
        console.log("not saved to the database.");
        return false;
    });

    //disable blank search input
    $('.form-filter').on('submit', function (e){
        $(this).find(':input').filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true;
    })
});
