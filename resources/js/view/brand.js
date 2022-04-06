$(() => {
    //confirm delete
    $(".delete-supplier").submit(function () {
        if (
            confirm(
                "Bạn có chác chắn muốn xóa brand " +
                this.dataset.name +
                "có id " +
                this.dataset.id +
                '? Xóa brand này sẽ xóa toàn bộ sản phẩm từ brand này'
            )
        ) {
            console.log("saved to the database.");
            return true;
        }
        console.log("not saved to the database.");
        return false;
    });

    //disable blank input
    $('.form-filter').on('submit', function (e){
        $(this).find(':input').filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true;
    })
});
