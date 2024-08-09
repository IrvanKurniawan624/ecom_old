@extends('partial.app')
@section('title','Metode Pembayaran')

@section('css')
<style>
    input::file-selector-button {
        box-shadow: 0 2px 6px #acb5f6;
        background: #6777ef;
        border-color: #6777ef;
        font-size: 12px;
        font-family: "Nunito";
        color: white;
        font-weight: 600;
        line-height: 25px;
        letter-spacing: .5px;
        border-radius: .3rem;
        padding: .55rem 1.5rem;
    }

</style>
@endsection

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>QRIS</h4>
                </div>
                <div class="card-body" id="place_data">
                    @if(!empty($data[0]->qris))
                    <div class="row">
                        <div class="col-12 col-md-12 d-flex justify-content-center">
                            <img src="/{{ $data[0]->qris }}" alt="">
                        </div>
                        <div class="col-12 col-md-12 d-flex justify-content-center">
                            <form id="form_qris" enctype="multipart/form-data"
                                action="/admin/apps/pembayaran/qris" method="POST"
                                autocomplete="off" class="justify-content-center d-none"
                                style="flex-direction: column;">
                                <div class="form-group">
                                    <input type="file" id="qris" name="qris">
                                </div>
                                <div class="form-group">
                                    <button type="submit" style="width: 100%" class="btn btn-success">Submit</button>
                                    <button type="button" style="width: 100%" id="btn-cancel"
                                        class="btn btn-danger mt-2">Cancel</button>
                                </div>
                            </form>
                            <button type="submit" class="btn btn-warning btn-lg" id="btn-ubah">Ubah</button>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <form id="form_qris" style="width: 100%" enctype="multipart/form-data"
                            action="/admin/apps/pembayaran/qris" method="POST"
                            autocomplete="off">
                            <div class="col-12 col-md-12 d-flex justify-content-center">
                                <div class="form-group">
                                    <input type="file" id="qris" name="qris" style="width: 100%">
                                    <button type="submit" class="btn btn-success mt-5 float-right"
                                        style="width: 100%">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Rekening BCA</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 d-flex justify-content-center">
                            <div class="form-group pb-3" style="width: 80%; margin: auto">
                                <form id="form_no_rekening" enctype="multipart/form-data"
                                    action="/admin/apps/pembayaran/no-rekening"
                                    method="POST" autocomplete="off">
                                    <label for="no_rekening">Rekening BCA</label>
                                    @if(!empty($data[0]->no_rekening))
                                    <input type="text" id="no_rekening" name="no_rekening"
                                        data-initial-value="{{ $data[0]->no_rekening }}"
                                        value="{{ $data[0]->no_rekening }}" readonly class="form-control">
                                    @else
                                    <input type="text" id="no_rekening" name="no_rekening" readonly
                                        class="form-control">
                                    @endif
                                    <button type="button" id="btn-ubah-2"
                                        class="form-control btn btn-warning mt-4">Ubah</button>
                                    <button type="submit" id="btn-submit-2"
                                        class="form-control btn btn-success mt-4 d-none">Simpan</button>
                                    <button type="button" id="btn-cancel-2"
                                        class="form-control btn btn-danger mt-4 d-none">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>No Whatsapp</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 d-flex justify-content-center">
                            <div class="form-group pb-3" style="width: 80%; margin: auto">
                                <form id="form_no_telepon_pembayaran" enctype="multipart/form-data"
                                    action="/admin/apps/pembayaran/no-telepon"
                                    method="POST" autocomplete="off">
                                    <p class="d-block invalid-feedback" style="font-size: 13px; margin-bottom: 0">
                                        *No
                                        Whatsapp untuk mengirim <b>Bukti Transfer</b></p>
                                    @if(!empty($data[0]->no_telepon_pembayaran))
                                    <input type="text" id="no_telepon_pembayaran" name="no_telepon_pembayaran"
                                        data-initial-value="{{ $data[0]->no_telepon_pembayaran }}"
                                        value="{{ $data[0]->no_telepon_pembayaran }}" readonly class="form-control">
                                    @else
                                    <input type="text" id="no_telepon_pembayaran" name="no_telepon_pembayaran" readonly
                                        class="form-control">
                                    @endif
                                    <button type="button" id="btn-ubah-3"
                                        class="form-control btn btn-warning mt-4">Ubah</button>
                                    <button type="submit" id="btn-submit-3"
                                        class="form-control btn btn-success mt-4 d-none">Simpan</button>
                                    <button type="button" id="btn-cancel-3"
                                        class="form-control btn btn-danger mt-4 d-none">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#form_qris').submit(function (e) {
        e.preventDefault();

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_qris').attr('action'),
                        type: $('#form_qris').attr('method'),
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: new FormData($('#form_qris')[0]),
                        success: function (response) {
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                $("#form_qris")[0].reset();
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                window.location.href = response.link;
                            } else {
                                iziToast.error({
                                    title: 'Error!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                // swal(response.message, { icon: 'error', });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" +
                                errorThrown + ")", {
                                    icon: 'error',
                                });
                        }
                    });
                }
            });
    })

    $('#form_no_rekening').on('submit', function (e) {
        e.preventDefault();

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_no_rekening').attr('action'),
                        type: $('#form_no_rekening').attr('method'),
                        data: $('#form_no_rekening').serialize(),
                        success: function (response) {
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                $('#no_rekening').val(response.data);
                                $('#no_rekening').attr("readonly", "readonly");
                                $('#btn-ubah-2').removeClass('d-none');
                                $('#btn-ubah-2').addClass('d-block');
                                $('#btn-submit-2').removeClass('d-block');
                                $('#btn-submit-2').addClass('d-none');
                                $('#btn-cancel-2').removeClass('d-block');
                                $('#btn-cancel-2').addClass('d-none');
                            } else if (response.status == 300) {
                                swal(response.message, {
                                    icon: 'error',
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" +
                                errorThrown + ")", {
                                    icon: 'error',
                                });
                        }
                    });
                }
            });
    });

    $('#form_no_telepon_pembayaran').on('submit', function (e) {
        e.preventDefault();

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_no_telepon_pembayaran').attr('action'),
                        type: $('#form_no_telepon_pembayaran').attr('method'),
                        data: $('#form_no_telepon_pembayaran').serialize(),
                        success: function (response) {
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                $('#no_telepon_pembayaran').val(response.data);
                                $('#no_telepon_pembayaran').attr("readonly", "readonly");
                                $('#btn-ubah-3').removeClass('d-none');
                                $('#btn-ubah-3').addClass('d-block');
                                $('#btn-submit-3').removeClass('d-block');
                                $('#btn-submit-3').addClass('d-none');
                                $('#btn-cancel-3').removeClass('d-block');
                                $('#btn-cancel-3').addClass('d-none');
                            } else if (response.status == 300) {
                                swal(response.message, {
                                    icon: 'error',
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            setTimeout(function () {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" +
                                errorThrown + ")", {
                                    icon: 'error',
                                });
                        }
                    });
                }
            });
    });

    $('#btn-ubah').click(function () {
        $(this).addClass('d-none');
        $(this).removeClass('d-block');
        $('#form_qris').removeClass('d-none')
        $('#form_qris').addClass('d-flex')
    });

    $('#btn-cancel').click(function () {
        $('#btn-ubah').removeClass('d-none');
        $('#btn-ubah').addClass('d-block');
        $('#form_qris').addClass('d-none')
        $('#form_qris').removeClass('d-flex')
    });

    $('#btn-ubah-2').click(function () {
        $('#no_rekening').removeAttr("readonly");
        $(this).addClass('d-none');
        $(this).removeClass('d-block');
        $('#btn-submit-2').addClass('d-block');
        $('#btn-submit-2').removeClass('d-none');
        $('#btn-cancel-2').addClass('d-block');
        $('#btn-cancel-2').removeClass('d-none');
    });

    $('#btn-cancel-2').click(function () {
        $('#no_rekening').attr("readonly", "readonly");
        $('#btn-ubah-2').removeClass('d-none');
        $('#btn-ubah-2').addClass('d-block');
        $('#btn-submit-2').removeClass('d-block');
        $('#btn-submit-2').addClass('d-none');
        $('#btn-cancel-2').removeClass('d-block');
        $('#btn-cancel-2').addClass('d-none');
        $('#no_rekening').val($('#no_rekening').attr("data-initial-value"));
    });

    $('#btn-ubah-3').click(function () {
        $('#no_telepon_pembayaran').removeAttr("readonly");
        $(this).addClass('d-none');
        $(this).removeClass('d-block');
        $('#btn-submit-3').addClass('d-block');
        $('#btn-submit-3').removeClass('d-none');
        $('#btn-cancel-3').addClass('d-block');
        $('#btn-cancel-3').removeClass('d-none');
    });

    $('#btn-cancel-3').click(function () {
        $('#no_telepon_pembayaran').attr("readonly", "readonly");
        $('#btn-ubah-3').removeClass('d-none');
        $('#btn-ubah-3').addClass('d-block');
        $('#btn-submit-3').removeClass('d-block');
        $('#btn-submit-3').addClass('d-none');
        $('#btn-cancel-3').removeClass('d-block');
        $('#btn-cancel-3').addClass('d-none');
        $('#no_telepon_pembayaran').val($('#no_telepon_pembayaran').attr("data-initial-value"));
    });

</script>
@endsection
