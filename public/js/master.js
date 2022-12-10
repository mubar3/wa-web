$(document).ready(function () {

    $('.select2').select2();

    $('.data-list').on('click','.hapus_data_list', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var data = $(this).data('nama');
        var tipe = $(this).data('tipe');

        if(tipe == 'hapus'){
            var buttonText = 'Hapus';
            var confirmText = 'Apakah Anda yakin ingin menghapus permanen ';
        }

        if(tipe == 'nonaktifkan'){
            var buttonText = 'Ya';
            var confirmText = 'Apakah Anda yakin ingin menonaktifkan ';
        }

        if(tipe == 'aktifkan'){
            var buttonText = 'Aktifkan';
            var confirmText = 'Apakah Anda yakin ingin mengaktifkan kembali ';
        }

        Swal.fire({
            title : 'Perhatian',
            text  : confirmText+data,
            icon  : 'warning',
            width : '20rem',
            confirmButtonText : buttonText,
            cancelButtonText : 'Batal',
            showCancelButton : true,
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type : 'GET',
                    url  : url,
                    dataType : 'json',
                    success : function(msg) {
                        // console.log(msg);
                        if(msg.tipe === true){
                            Swal.fire({
                                title : 'Berhasil',
                                text  : msg.pesan,
                                icon  : 'success',
                                width : '20rem',
                                timer : 3000,
                                showConfirmButton : false,
                                showCancelButton : false,
                            });

                        }else{
                            Swal.fire({
                                title : 'Error',
                                text  : msg.pesan,
                                icon  : 'error',
                                width : '20rem',
                                // timer : 3000,
                                showConfirmButton : false,
                                showCancelButton : false,
                            });
                        }

                        // data_list.ajax.reload();
                        getList();

                        if(typeof getDashboard === "function"){
                            getDashboard();
                        }

                    }
                });
            }
        });

        return false;
    });

    // Filter list dan sampah
    list_display();

    $('body').on('click','.btn-display', function(e){
        e.preventDefault();
        var status = $(this).data('status');
        $('input[name="_status"]').val(status);
        getList();
        list_display();
    });

    function list_display(){
        var status_input = $('input[name="_status"]').val();
        if(status_input == '' || status_input == 'on'){
            $('#btn-on').addClass('active');
            $('#btn-off').removeClass('active');

        }else{
            $('#btn-off').addClass('active');
            $('#btn-on').removeClass('active');
        }
    }

    // pilih area dari region
   $('.box_filter').on('change','#region', function(){
    var url = '/dropArea';
    var token = $("input[name=_token]").val();

    $.ajax({
        type : 'POST',
        url  : url,
        data : {
            region : $(this).val(),
            _token  : token,
        },
        success : function(msg){
            if(msg.status == true){
                var areas = msg.data;
                $('#area').removeAttr('disabled');
                $('#area').html('');
                $('#area').html('<option value="">--Area--</option>');

                $.each(areas, function(index, row ){
                    $('#area').append('<option value="'+row.id+'">'+row.label+'</option>');
                });

            }else{
                $('#area').attr('disabled','disabled');
                $('#area').html('<option value="">--Area--</option>');
            }
        }
    });

    return false;
});


    // pilih subarea dari area
   $('#my-form').on('change','#area', function(){
        var url = '/dropSubarea';
        var token = $("input[name=_token]").val();

        $.ajax({
            type : 'POST',
            url  : url,
            data : {
                area_id : $(this).val(),
                _token  : token,
            },
            success : function(msg){
                if(msg.status == true){
                    var areas = msg.data;
                    $('#subarea').removeAttr('disabled');
                    $('#subarea').html('');
                    $('#subarea').html('<option value="">-- Semua Subarea --</option>');

                    $.each(areas, function(index, row ){
                        $('#subarea').append('<option value="'+row.id+'">'+row.label+'</option>');
                    });

                }else{
                    $('#subarea').attr('disabled','disabled');
                    $('#subarea').html('<option value="">-- Semua Subarea --</option>');
                }
            }
        });

        return false;
   });

   // pilih kategori dari divisi
   $('#my-form').on('change','#divisi', function(){
        var url = '/dropKategori';
        var token = $("input[name=_token]").val();

        $.ajax({
            type : 'POST',
            url  : url,
            data : {
                divisi_id : $(this).val(),
                _token  : token,
            },
            success : function(msg){
                if(msg.status == true){
                    var areas = msg.data;
                    $('#kategori').removeAttr('disabled');
                    $('#kategori').html('');
                    $('#kategori').html('<option value="">-- Semua Kategori --</option>');

                    $.each(areas, function(index, row ){
                        $('#kategori').append('<option value="'+row.id+'">'+row.label+'</option>');
                    });

                }else{
                    $('#kategori').attr('disabled','disabled');
                    $('#kategori').html('<option value="">-- Semua Kategori --</option>');
                }
            }
        });

        return false;
    });

    // pilih Account dari Channel
   $('#my-form').on('change','#channel', function(){
    var url = '/dropChannel';
    var token = $("input[name=_token]").val();

    $.ajax({
        type : 'POST',
        url  : url,
        data : {
            channel_id : $(this).val(),
            _token  : token,
        },
        success : function(msg){
            if(msg.status == true){
                var areas = msg.data;
                $('#account').removeAttr('disabled');
                $('#account').html('');
                $('#account').html('<option value="">-- Account --</option>');

                $.each(areas, function(index, row ){
                    $('#account').append('<option value="'+row.id+'">'+row.label+'</option>');
                });

            }else{
                $('#account').attr('disabled','disabled');
                $('#account').html('<option value="">-- Account --</option>');
            }
        }
    });

    return false;
    });

     // pilih Divisi dari Cluster
   $('body').on('change','#cluster', function(){
    var url = '/dropCluster';
    var token = $("input[name=_token]").val();

    $.ajax({
        type : 'POST',
        url  : url,
        data : {
            cluster_id : $(this).val(),
            _token  : token,
        },
        success : function(msg){
            if(msg.status == true){
                var record = msg.data;
                $('#divisi').removeAttr('disabled');
                $('#divisi').html('');

                $.each(record, function(index, row ){
                    $('#divisi').append('<option value="'+row.id+'">'+row.label+'</option>');
                });

            }else{
                $('#divisi').attr('disabled','disabled');
                $('#divisi').html('<option value="">-- Divisi --</option>');
            }
        }
    });

    return false;
    });

    // Logout
    $('#logout-btn').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var data = $(this).data('nama');

        Swal.fire({
            title : 'Perhatian',
            text  : 'Anda yakin ingin Logout?',
            icon  : 'warning',
            width : '20rem',
            confirmButtonText : 'Ya',
            cancelButtonText : 'Batal',
            showCancelButton : true,
        }).then((result) => {
            if(result.isConfirmed){
                window.location = url;
            }
        });

        return false;
    });


});
