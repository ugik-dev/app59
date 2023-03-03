<?php
$id = $_GET['jadwal'];
$query2 = "SELECT u.name , rg.*, rp.nama_predikat FROM reg_jadwal rg 
JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat 
JOIN users u on rg.id_user = u.id 
WHERE id_jadwal = $id
ORDER BY nomor_kursi ASC";
$result2 = mysqli_query($linkDB, $query2);

$dataPeserta = [];
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $kursi = explode('-', $row2['nomor_kursi']);
        $dataPeserta[$kursi[0]][$kursi[1]] = $row2;
    }
}
?>

<style>
    div .chair {
        width: 50px !important;
        border: 1px solid green;
        padding: 0px;
        margin: 0px;
        text-align: center;
        color: black
    }

    div .check_in {
        background-color: #67f06d !important;
    }

    div .not_check_in {
        background-color: #E3db5d !important;
    }
</style>
<!-- <style>
    div .chair {
        width: 30px;
        border: 1px solid green;
        padding: 0px;
        margin: 0px;
        text-align: center;
    }
</style> -->
<script src="https://unpkg.com/html5-qrcode"></script>
<div class="row">
    <div class="col-lg-3">
        <div id="qr-reader" style="width:100%"></div>
        <div id="qr-reader-results"></div>
        <div id="qr-reader-value"></div>
    </div>
    <div class="col-lg-9">

        <div class="box-container">
            <table border=1 width=100%>
                <tr>
                    <td style="text-align: center; background-color: green;  color: white;">Podium</td>
                </tr>
            </table>
            <br>
            <table border=1 width=100% style="align-items: center; text-align: center">

                <?php
                foreach ($dataPeserta as $key => $r) {
                ?>
                    <tr>
                        <td style="align-items: center; text-align: center">
                            <div class="row" style="margin:0px ;align-items: center; text-align: center">
                                <?php
                                foreach ($r as $key2 => $p) {
                                    echo "<div class='chair " . ($p['status_reg'] == '3' ? 'check_in' : 'not_check_in') . "' data-id='" . $p['nomor_kursi'] . "'>" . $p['nomor_kursi'] . "</div>";
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
    </div>
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

                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('./lib/phpqrcode/qrlib.php');
                    foreach ($dataPeserta as $key => $r) {
                        foreach ($r as $key2 => $p) {
                            //     $status = $p['status_reg'] < '3' ? 'Sudah Check-In' : '<a class="btn btn-block btn-social btn-dropbox">
                            //     <i class="fa fa-dropbox"></i> Belum Checkin
                            //  </a>';
                            if ($p['status_reg'] == '3') {

                                $status = "<a class='btn btn-success btn-icon-split'> <span class='icon text-white-50'> 
                                <i class='fas fa-check'></i> </span>
                                <span class='text'>Sudah Check-In</span>
                                </a>";
                            } else {
                                $status = "<a class='btn btn-warning btn-icon-split'> <span class='icon text-white-50'> 
                                <i class='fas fa-times'></i> </span>
                                <span class='text'>Belum Check-In</span>
                            </a>";
                            }
                            echo "
                <tr>
                    <td style='text-align: center'> {$p['nomor_kursi']} </td>
                    <td style='text-align: center'> {$p['name']} </td>
                    <td style='text-align: center'> {$p['nama_predikat']} </td>
                    <td style='text-align: center'> {$p['ipk']} </td>
                    <td style='text-align: center'> {$status} 
                        
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

<script>
    $(document).ready(function() {
        $('#dataPeserta').DataTable();
        var resultContainer = document.getElementById('qr-reader-results');
        var valueContainer = $('#qr-reader-value');
        var lastResult, countResults = 0;

        // valueContainer.html

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                check_in(decodedText)
                valueContainer.html(decodedText)
                console.log(`Scan result ${decodedText}`, decodedResult);
            }
        }

        function check_in(decodedText) {
            console.log(decodedText)
            swalLoading();
            return $.ajax({
                url: `back-end/checkin.php`,
                'type': 'get',
                data: {
                    'qrcode': decodedText
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
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);

    });
</script>

<!-- <script>
    $(document).ready(function() {
        var table = $('#dataPeserta').DataTable();
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
</script> -->