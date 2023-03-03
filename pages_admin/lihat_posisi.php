<?php
$id = $_GET['id'];
// include('../linkDB.php');

$query2 = "SELECT u.name , rg.*, rp.nama_predikat FROM reg_jadwal rg 
JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat 
JOIN users u on rg.id_user = u.id 
WHERE id_jadwal = $id
ORDER BY nomor_kursi ASC";
$result2 = mysqli_query($linkDB, $query2);

$dataPeserta = [];
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        // $dataPeserta[] = $row2;
        $kursi = explode('-', $row2['nomor_kursi']);
        $dataPeserta[$kursi[0]][$kursi[1]] = $row2;
    }
}

// echo json_encode($dataPeserta);

?>
<style>
    div .chair {
        width: 50px !important;
        border: 1px solid green;
        padding: 0px;
        margin: 0px;
        text-align: center;
    }
</style>

<div class="box-container">
    <table border=1 width=100%>
        <tr>
            <td style="text-align: center; background-color: green;  color: white;">Podium</td>
        </tr>
    </table>
    <br>
    <table border=1 width=100% style="align-items: center; text-align: center">
        <style>
            div .chair {
                width: 30px;
                border: 1px solid green;
                padding: 0px;
                margin: 0px;
                text-align: center;
            }
        </style>
        <?php
        foreach ($dataPeserta as $key => $r) {
        ?>
            <tr>
                <td style="align-items: center; text-align: center">
                    <div class="row" style="margin:0px ;align-items: center; text-align: center">
                        <?php
                        foreach ($r as $key2 => $p) {
                            echo "<div class='chair' data-id='" . $p['nomor_kursi'] . "'>" . $p['nomor_kursi'] . "</div>";
                        }
                        ?>
                    </div>

                </td>

            </tr>
        <?php
        }
        ?>
    </table>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Kursi</th>
                        <th>Nama</th>
                        <th>Predikat</th>
                        <th>IPK</th>
                        <th>Status</th>
                        <th>QRCODE</th>
                        <!-- <th>Waktu Daftar</th> -->
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('./lib/phpqrcode/qrlib.php');
                    foreach ($dataPeserta as $key => $r) {
                        foreach ($r as $key2 => $p) {
                            $status = $p['status_reg'] == '3' ? 'Sudah Check-In' : 'Belum Check-In';
                            echo "
                <tr>
                    <td style='text-align: center'> {$p['nomor_kursi']} </td>
                    <td style='text-align: center'> {$p['name']} </td>
                    <td style='text-align: center'> {$p['nama_predikat']} </td>
                    <td style='text-align: center'> {$p['ipk']} </td>
                    <td style='text-align: center'> {$status} </td>
                    <td>
                        <a width='100%' href='./qrcode/{$p['id_reg_jadwal']}.png' target='_blank'>
                     <img width='100%' src='./qrcode/{$p['id_reg_jadwal']}.png'></a>
                    </td>
                    </td>
                </tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="reg_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form opd="form" id="reg_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-form-label">Nama Baris</div>
                            <input type="hidden" id="id_baris" name="id_baris" class="form-control" />
                            <input type="text" placeholder="contoh : G" onkeydown="return /[A-Z]/i.test(event.key)" id="nama_baris" name="nama_baris" class="form-control" required />
                        </div>
                        <div class="col-lg-12">
                            <div class="col-form-label">Jumlah Kursi</div>
                            <input type="number" step="1" min=0 max=100 name="jml_kursi" id="jml_kursi" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // var TablePeserta = $('#dataPeserta').DataTable();
        var table = $('#dataPeserta').DataTable();
        // var SearchFilter = $('#dataTable_filter').find('input');
        // SearchFilter.val('12');
        $('#dataTable_filter').find("input").attr('id');

        var RefModal = {
            'self': $('#reg_modal'),
            'info': $('#reg_modal').find('.info'),
            'form': $('#reg_modal').find('#reg_form'),
            'id_baris': $('#reg_modal').find('#id_baris'),
            'nama_baris': $('#reg_modal').find('#nama_baris'),
            'jml_kursi': $('#reg_modal').find('#jml_kursi'),
        }
        $('.add_baris').on('click', function(ev) {
            RefModal.self.modal('show');
            RefModal.form.trigger('reset');
        })
        $('.chair').on('click', function(ev) {
            cur_id = $(this).data('id')
            console.log(cur_id);
            table.search('fas');
            // SearchFilter.val('12');
        })

        $('.edit').on('click', function(ev) {
            cur_id = $(this).data('id')
            nama = $(this).data('nama')
            jml = $(this).data('jml')
            RefModal.self.modal('show');
            RefModal.form.trigger('reset');
            RefModal.id_baris.val(cur_id);
            RefModal.nama_baris.val(nama);
            RefModal.jml_kursi.val(jml);
        })



        $('.delete').on('click', function(ev) {
            cur_id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "apakah kamu yakin akan menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/del_baris.php`,
                        'type': 'get',
                        data: {
                            'id': cur_id
                        },
                        success: function(data) {
                            Swal.close();
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire(
                                    'Gagal!',
                                    json['message'],
                                    'error'
                                );
                                return;
                            }
                            RefModal.self.modal('hide');
                            Swal.fire(
                                'Berhasil!',
                                json['message'],
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(e) {}
                    });
                }
            })
        })

        RefModal.form.on('submit', function(ev) {
            event.preventDefault();
            // console.log('dagt');
            // RefModal.self.modal('show');
            // cur_id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "apakah kamu yakin akan menyimpan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/kelolah_baris.php`,
                        'type': 'post',
                        data: RefModal.form.serialize(),
                        //  {
                        //     'id': cur_id
                        // },
                        success: function(data) {
                            Swal.close();
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire(
                                    'Gagal!',
                                    json['message'],
                                    'error'
                                );
                                return;
                            }
                            RefModal.self.modal('hide');
                            Swal.fire(
                                'Berhasil!',
                                json['message'],
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(e) {}
                    });
                }
            })
        })
    })
</script>