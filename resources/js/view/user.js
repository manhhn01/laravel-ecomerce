$(() => {
    $('#addUser').on('click', function () {
        $('.itemlist-wrapper').append(`
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-4 col-name">
                        <div class="itemside">
                            <div class="info">
                                <input class="mb-0 form-control" name="new_emails[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="itemside">
                            <div class="info">
                                <input type="text" class="mb-0 form-control" name="new_last_names[]" >
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="itemside">
                            <div class="info">
                                <input type="text" class="mb-0 form-control" name="new_first_names[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="itemside">
                            <div class="info">
                                <input type="password" name="new_passwords[]" class="mb-0 form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="itemside">
                            <div class="info">
                                <button type="submit" class="btn btn-danger" onclick="removeUser(this)">Xoá</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- row .// -->
            </article>
        `)
    });
});

function removeUser(el) {
    $(el).parents('.itemlist').remove();
}

function removeUserAjax(id, el) {
    const result = confirm('Bạn có chắc muốn xoá user này');
    if (result) {
        $.ajax({
            method: "post",
            url: "/user/delete",
            data: {
                id
            },
            success: (result) => {
                if (result.status === 'success') {
                    removeUser(el);
                }
            }
        });
    }
}

function submitForm(){
    $('form.itemlist-wrapper').submit();
}
