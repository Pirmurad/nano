$(document).ready(function () {
    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    //datetimepicker
    $('.datetimepicker').datetimepicker({
        inline: true,
        sideBySide: true,
        format: 'DD.MM.YYYY HH:mm',
    });

    //datetimepicker
    $('.datepicker').datetimepicker({
        format: 'DD.MM.YYYY',
    });

    $('.timepicker').datetimepicker({
        format: 'HH:mm',
    });

    $("textarea.summernote").summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['link', ['link']],
            ['picture', ['picture']],
            ['video', ['video']],
            ['table', ['table']],
            ['hr', ['hr']],
            ['fontname', ['fontname']],
            ['fullscreen', ['fullscreen']],
            ['undo', ['undo']],
            ['redo', ['redo']]
        ],
        height: 172,
        codemirror: {
            mode: 'text/html',
            htmlMode: true,
            lineNumbers: true,
            theme: 'monokai'
        }
    });

    /* Ajax Delete Method */

    $.deleteAjax = function (object) {

        var

            id = object.data("id"),

            value = object.data("value");

        url = object.data("url"),

            url = url + "cms/inc/" + value + "/delete.php",

            data = {"id": id, "value": value};


        swal({

            title: 'Əminsiniz?',

            text: 'Təsdiqlənsə,silinəcək və geri almaq mümkün olmayacaq.',

            type: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#d33',

            showLoaderOnConfirm: true,


            preConfirm: function () {

                return new Promise(function (resolve) {

                    $.ajax({

                        url: url,

                        type: 'POST',

                        data: data,

                        dataType: 'json',

                    }).done(function (response) {

                        swal('Silindi!', response.message, response.status);

                        $(".Delete" + id).remove();

                    }).fail(function () {

                        swal('Ooops...', 'Bir şeylər səhv oldu', 'error');

                    });

                });

            },

            allowOutsideClick: false

        }).catch(swal.noop);
    };

    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
    }


    $("#type_id").on('change', function postinput() {
        var matchvalue = $(this).val(); // this.value

        $.ajax({
            url: 'matchedit-data.php',
            data: {matchvalue: matchvalue},
            type: 'post',
            dataType: 'json'
        }).done(function (responseData) {
            $(".tipler").html(responseData.form);
            $("#keyword").val(responseData.tags);
        }).fail(function () {
            console.log('Failed');
        });
    });


        $('#tip_product').on('click','.refresh',function () {
            var yenile_id = $(this).val();
            var matchvalue = $('#type_id').val(); // this.value

            $.ajax({
                url: 'matchedit-data.php',
                data: {yenile_id: yenile_id, matchvalue: matchvalue},
                type: 'post',
                dataType: 'json',
                success: function (result) {
                    var select_id = '.tipler #' + result.type_param.linkname;
                    $(select_id).html(result.value);
                }


            })
        });

    $('#tip_product').on('click','.addNewValue',function (e) {
            e.preventDefault();
            var id = $(this).data("id");

        $.ajax({
            url: 'ajaxGetValue.php',
            data: {
                id: id
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {

                $('#newParamVAlue .modal-content').html(data.modal);
                $('#newParamVAlue').modal('show');
            }

        });


        });

    $(document).on('click','.saveNewValue',function (e) {
        e.preventDefault();
        var id =$('#id').val(),
            name = $('#valueName').val();

        $.ajax({
            url: 'addNewValue.php',
            data:{
                id :id,
                name: name
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
                var select_id = '.tipler #' + data.param.linkname,
                    newValue=data.new_value.name;
                $(select_id).prepend($('<option>', {
                    value: newValue,
                    text : newValue
                }));
                $('#newParamVAlue').modal('hide');

            }

        });

    })


});
