@extends('partial.app')

@section('css')
    <style>
        .modal-dialog .modal-header {
            justify-content: flex-start !important;
        }

        .modal {
            overflow-y:auto;
        }

        .alamat-action a:hover{
            color: var(--base-color);
        }
    </style>
@endsection

@section('content')
<div class="row sticky-header-next-sec">
    <div class="content-container mt-4 col-12 col-md-6 offset-md-3" style="padding-bottom: 1%">
        <div class="section-title">
            <div class="back-button">
                <a href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                        <path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg>
                </a>
            </div>
            <h5 class="font-weight-bold">Alamat Pengiriman</h5>
            <p>Kelola Informasi Alamat Pengiriman</p>
            <hr style="background-color: black; ">
        </div>
        <div id="place_alamat_pengiriman"></div>
        <div class="section-body text-center pb-2">
            @if ($count_alamat_pengiriman == 0)
                <div id="alert_alamat_not_found">
                    <img src="{{ asset('front/assets/images/project/not-found.png') }}" draggable="false" alt="">
                </div>
            @endif
            <br><br>
            <button class="btn btn-primary rounded-pill btn-xs btn-add-alamat-pengiriman" onclick="add()" disabled>Tambah Alamat Pengiriman</button>
        </div>
    </div>
</div>

@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center">Tambah Alamat</h5>
            </div>
            <form id="form_submit_self" action="/profile/alamat-pengiriman/store-update" method="post">
                <div class="modal-body">
                    <div class="ec-vendor-upload-detail">
                        <div class="row px-2">
                            <input type="text" hidden name="provinsi" id="provinsi">
                            <input type="text" hidden name="kota" id="kota">
                            <input type="text" hidden name="kecamatan" id="kecamatan">
                            <input type="text" hidden id="provinsi_id">
                            <input type="text" hidden id="kota_id">
                            <input type="text" hidden id="kecamatan_id">
                            <input type="text" hidden name="type" id="type">
                            <input type="text" hidden name="id" id="id">
                            <div class="col-12 col-md-8  space-t-15 pt-2">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" class="form-control required-field" name="penerima" id="penerima">
                            </div>
                            <div class="col-12 col-md-4 space-t-15 pt-2">
                                <label class="form-label">No Telepon</label>
                                <input type="text" class="form-control required-field" name="no_telepon" maxlength="12" id="no_telepon" onkeypress="return onKeypressAngka(event,false);">
                            </div>
                            <div class="col-12 col-md-12 space-t-15 pt-2">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control required-field" id="alamat" cols="30" rows="5"></textarea>
                            </div>

                            <div class="col-12 col-md-6 pt-6">
                                <label class="form-label">Provinsi</label>
                                    <select name="provinsi_id" class="form-control required-field selectric provinsi_id" onchange="change_provinsi()">
                                    </select>
                               </div>

                            <div class="col-12 col-md-6 pt-6">
                                <label class="form-label">Kota</label>
                                <select name="kota_id" class="form-control required-field selectric kota_id" onchange="change_kota()">
                                </select>
                            </div>
                            <div class="col-12 col-md-6 space-t-15 pt-3">
                                <label class="form-label">Kecamatan</label>
                                <select name="kecamatan_id" class="form-control required-field selectric kecamatan_id" onchange="change_kecamatan()">
                                </select>
                            </div>
                            <div class="col-12 col-md-6 space-t-15 pt-3">
                                <label class="form-label">Kelurahan</label>
                                <input type="text" class="form-control required-field" name="kelurahan" id="kelurahan" onkeyup="return onkeyupUppercase(this.id);">
                            </div>
                            <div class="col-12 col-md-6 space-t-15 pt-2">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control required-field" maxlength="6" name="kode_pos" id="kode_pos" onkeypress="return onKeypressAngka(event,false);">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection

@section('js')
<script>

    $(document).ready(function(){
        get_data_province();
        get_data_alamat_pengiriman();
    });

    function get_data_alamat_pengiriman(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/AlamatPengiriman",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                console.log(response);
                if(response.status === 200){
                    var data = response.data;
                    $('#alert_alamat_not_found').hide();
                    $('#place_alamat_pengiriman').empty();
                    for(let i = 0; i < response.data.length; i++) {
                        let badge_alamat_utama = response.data[i].alamat_utama == 1 ? '<div class="d-flex"><span class="badge bg-danger" style="float:left; margin: 5px 0 5px 0">Alamat Utama</span></div>' : '';
                        let button_alamat_utama = response.data[i].alamat_utama == 0 ? `<p>|</p><button type="button" onclick="change_alamat_utama('${response.data[i].id}')"><a href="#">Atur Sebagai Alamat Utama</a></button>` : '';
                        let button_hapus_alamat_utama = response.data[i].alamat_utama == 0 ? `<p>|</p><button type="button" onclick="action_delete('${response.data[i].id}','${response.data[i].penerima}')"><a href="#" >Hapus</a></button>` : '';
                        $('#place_alamat_pengiriman').append(`
                            <div class="content-container alamat-container-card" style="padding: 18px 0 18px 18px;">
                                <div class="row alamat-card p-1" style="align-items: center; margin-right: 0!important;margin-left: 0!important;">
                                    <div class="col-md-8 col-12">
                                        <h5>${response.data[i].penerima}</h5>
                                        ${badge_alamat_utama}
                                        <p>${response.data[i].no_telepon}</p>
                                        <p class="two-line-only">${response.data[i].alamat_lengkap}</p>
                                    </div>
                                    <div class="col-md-4 py-2 text-center alamat-action">
                                        <button type="button" onclick="edit(${response.data[i].id})"><a href="#" >Ubah Alamat</a></button>
                                        ${button_hapus_alamat_utama}
                                        ${button_alamat_utama}
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                    $("#master_package_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#master_package_id").append(`<option value="${data[i].id}">${data[i].package}</option>`);
                    }
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function get_data_province(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/api-provinsi",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                console.log(response);
                if(response.status === 200){
                    var data = response.data;
                    $('.btn-add-alamat-pengiriman').removeAttr('disabled');
                    $(".provinsi_id").empty();
                    $('.provinsi_id').append('<option selected disabled>- Pilih -</option>');
                    for (var i = 0; i < data.length; i++) {
                        $(".provinsi_id").append(`<option value="${data[i].province_id}">${data[i].province}</option>`);
                    }

                    $('.provinsi_id').selectric();

                    $('#provinsi').val($('.provinsi_id option:selected').text());
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                 Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function change_provinsi(){
        $('#provinsi').val($('.provinsi_id option:selected').text());
        let data_kota = $('#kota_id').val();
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/api-city-by-provinsi/" + $('.provinsi_id').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                console.log(response);
                if(response.status === 200){
                    var data = response.data;
                    $(".kota_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].city_id == data_kota){
                            $(".kota_id").append(`<option value="${data[i].city_id}" data-kodepos="${data[i].postal_code}" selected>${data[i].city_name}</option>`);
                        }else{
                            $(".kota_id").append(`<option value="${data[i].city_id}" data-kodepos="${data[i].postal_code}">${data[i].city_name}</option>`);
                        }
                    }

                    change_kota();

                    $('#kota').val($('.kota_id option:selected').text());

                    $('.kota_id').addClass('selectric');
                    $('.kota_id').selectric();
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                 Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function change_kota(){
        $('#kota').val($('.kota_id option:selected').text());
        $('#kode_pos').val($('.kota_id option:selected').attr('data-kodepos'));

        let data_kecamatan = $('#kecamatan_id').val();
        $.ajax({
            url : "/master/api-kecamatan-by-city/" + $('.kota_id').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                console.log(response);
                if(response.status === 200){
                    var data = response.data;
                    $(".kecamatan_id").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].subdistrict_id == data_kecamatan){
                            $(".kecamatan_id").append(`<option value="${data[i].subdistrict_id}" selected>${data[i].subdistrict_name}</option>`);
                        }else{
                            $(".kecamatan_id").append(`<option value="${data[i].subdistrict_id}">${data[i].subdistrict_name}</option>`);
                        }
                    }

                    $('#kecamatan').val($('.kecamatan_id option:selected').text());

                    $('.kecamatan_id').addClass('selectric');
                    $('.kecamatan_id').selectric();
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                 Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function change_kecamatan(){
        $('#kecamatan').val($('.kecamatan_id option:selected').text());
    }

    function add(){
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Alamat Pengiriman');
        $("#form_submit_self")[0].reset();
    }

    function edit(id){
        let url = '/profile/alamat-pengiriman/detail/' + id;
        edit_action_custom(url, 'Edit Alamat Pengiriman');
        $("#type").val('update');
    }

    function edit_action_custom(url, modal_text){
      save_method = 'edit';
      $("#modal").modal('show');
      $(".modal-title").text(modal_text);
      $("#modal_loading").modal('show');
      $.ajax({
         url : url,
         type: "GET",
         dataType: "JSON",
         success: function(response){
            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
            Object.keys(response).forEach(function (key) {
               var elem_name = $('[name=' + key + ']');
               if (elem_name.hasClass('selectric')) {
                  elem_name.val(response[key]).change().selectric('refresh');
               }else if(elem_name.hasClass('select2')){
                  elem_name.select2("trigger", "select", { data: { id: response[key] } });
               }else if(elem_name.hasClass('selectgroup-input')){
                  $("input[name="+key+"][value=" + response[key] + "]").prop('checked', true);
               }else if(elem_name.hasClass('my-ckeditor')){
                  CKEDITOR.instances[key].setData(response[key]);
               }else if(elem_name.hasClass('custom-control-input')){
                  $("input[name="+key+"][value=" + response[key] + "]").prop('checked', true);
               }else if(elem_name.hasClass('time-format')){
                  elem_name.val(response[key].substr(0, 5));
               }else if(elem_name.hasClass('format-rp')){
                  var nominal = response[key].toString();
                  elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
               }else{
                  elem_name.val(response[key]);
               }
            });

            $('#provinsi_id').val(response['provinsi_id']);
            $('#kota_id').val(response['kota_id']);
            $('#kecamatan_id').val(response['kecamatan_id']);

            change_provinsi();

         },error: function (jqXHR, textStatus, errorThrown){
            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
             Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
         }
      });
   }

    function action_delete(id, name){
        let url = '/profile/alamat-pengiriman/delete/' + id;
        delete_action(url, name);
        get_data_alamat_pengiriman();
    }

    function change_alamat_utama(id){
        let url = '/profile/alamat-pengiriman/change-alamat-utama/' + id;
            Swal.fire({
                title: 'Yakin?',
                text: "Apakah anda yakin mengganti alamat utama?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save Changes'
            }).then((result) => {
                if (result.isConfirmed) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url : url,
                    type: "GET",
                    dataType: "JSON",
                    success: function(response){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        if(response.status === 200){
                            Swal.fire('Good job!',response.message,'success');
                            $("#modal").modal('hide');
                            get_data_alamat_pengiriman();
                        }else{
                            Swal.fire('Oops!',response.message,'error');
                        }

                    },error: function (jqXHR, textStatus, errorThrown){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                    }
                });
                }
        });
    }

    $('#form_submit_self').on('submit', function(e){
      e.preventDefault();

      var form_id = $(this).attr("id");
      if(check_required(form_id) === false){
        Swal.fire('','Mohon isi field kosong','warning');
        return;
      }

      Swal.fire({
            title: 'Yakin?',
            text: "Apakah anda yakin akan menyimpan data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Save Changes'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url:  $('#form_submit_self').attr('action'),
                    type: $('#form_submit_self').attr('method'),
                    data: $('#form_submit_self').serialize(),
                    success: function(response){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        if(response.status == 200){
                            Swal.fire('Good job!',response.message,'success');
                            $("#modal").modal('hide');
                            get_data_alamat_pengiriman();
                            $("#form_submit_self")[0].reset();
                            reset_all_select();
                        }
                        else if(response.status == 201){
                            Swal.fire('Good job!',response.message,'success');
                            $("#modal").modal('hide');
                            window.location.href = response.link;
                        }
                        else if(response.status == 203){
                            Swal.fire('Good job!',response.message,'success');
                            $("#modal").modal('hide');
                            tb.ajax.reload(null, false);
                        }
                        else if(response.status == 300){
                             Swal.fire('Oops!',response.message,'error');
                        }
                    },error: function (jqXHR, textStatus, errorThrown){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                    }
                });
            }
        })
   });

   function delete_action(url, nama){
    Swal.fire({
            title: 'Yakin?',
            text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya! Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url : url,
                  type: "DELETE",
                  dataType: "JSON",
                  success: function(response){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);

                     if(response.status === 200){
                        Swal.fire('Good job!',response.message,'success');
                        $("#modal").modal('hide');
                        get_data_alamat_pengiriman();
                     }else{
                        Swal.fire('Oops!',response.message,'error');
                     }

                  },error: function (jqXHR, textStatus, errorThrown){
                     setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                      Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                  }
               });
            }
      });
   }

</script>
@endsection
