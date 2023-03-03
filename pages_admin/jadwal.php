<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Button trigger modal -->
            <button class="add_jadwal btn btn-primary"> <i class="fa fa-plus"></i> Jadwal</button>
            <br>
            <br>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal Wisuda</th>
                        <th>Tanggal Mulai Daftar</th>
                        <th>Tanggal Akhir Daftar</th>
                        <th>Status</th>
                        <th>Jumlah Peserta</th>
                        <!-- <th>Waktu Daftar</th> -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id_user = $_SESSION['id'];
                    $query = "SELECT j.* FROM jadwal as j 
                     -- GROUP BY id_jadwal
                    ";

                    // echo $query;
                    // die();
                    $result = mysqli_query($linkDB, $query);
                    // $row = mysqli_fetch_array($result);
                    // $row = $result->fetch_array(MYSQLI_NUM);
                    $data_result = [];
                    $i = 0;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $data_result[] = $row;
                            // echo json_encode($row);
                            // die();
                    ?>
                            <tr>
                                <td><?= $row['tanggal_wisuda'] ?></td>
                                <td><?= $row['w_reg_start'] ?></td>
                                <td><?= $row['w_reg_end'] ?></td>
                                <td><?= $row['status'] == 1 ? 'Belum Generate Posisi' : 'Sudah Generate Posisi' ?></td>
                                <td>
                                    <?php
                                    $resultp = mysqli_query($linkDB, "SELECT count(*) jm FROM reg_jadwal WHERE id_jadwal = {$row['id_jadwal']}");
                                    $resultrow = mysqli_fetch_assoc($resultp);
                                    echo $resultrow['jm'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['status'] >= 2) {
                                        echo '
                                        <a title="Lihat Posisi" class="btn btn-primary" href="?page=lihat_posisi&id=' . $row['id_jadwal'] . '"> <i class="fas fa-eye fa-xs" ></i> Lihat</a>
                                        <a title="Scanner" class="btn btn-primary" href="?page=scanner&jadwal=' . $row['id_jadwal'] . '"> <i class="fas fa-eye fa-xs" ></i> Scan</a>
                                        ';
                                    } else {
                                        echo '
                                        <a title="Generate Posisi" class="generate btn btn-primary" data-id="' . $i . '" > <i class="fas fa-flag fa-xs" ></i> Generate</a>
                                        <a title="Edit" class="edit btn btn-primary" data-id="' . $i . '" > <i class="fa fa-book fa-xs" ></i> </a>
                                        <a title="Hapus" class="delete btn btn-danger" data-id="' . $row['id_jadwal'] . '"> <i class="fa fa-trash fa-xs"></i> </a>';
                                    }
                                    ?>

                            </tr>
                    <?php
                            $i++;
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
</button> -->

<!-- Modal -->
<div class="modal fade" id="reg_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form opd="form" id="reg_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_jadwal" name="id_jadwal" class="form-control" />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-form-label">Tanggal Wisuda</div>
                            <input type="date" name="tanggal_wisuda" id="tanggal_wisuda" class="form-control" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-form-label">Tanggal Mulai Pendaftaran</div>
                            <input type="date" name="w_reg_start" id="w_reg_start" class="form-control" required />
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Tanggal Akhir Pendaftaran</div>
                            <input type="date" name="w_reg_end" id="w_reg_end" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        var DataResult = <?= json_encode($data_result) ?>;
        console.log(DataResult);
        var RefModal = {
            'self': $('#reg_modal'),
            'info': $('#reg_modal').find('.info'),
            'form': $('#reg_modal').find('#reg_form'),
            // 'addBtn': $('#reg_modal').find('#add_btn'),
            // 'saveEditBtn': $('#reg_modal').find('#save_edit_btn'),
            'id_jadwal': $('#reg_modal').find('#id_jadwal'),
            'tanggal_wisuda': $('#reg_modal').find('#tanggal_wisuda'),
            'w_reg_start': $('#reg_modal').find('#w_reg_start'),
            'w_reg_end': $('#reg_modal').find('#w_reg_end'),
        }
        $('.add_jadwal').on('click', function(ev) {
            cur_id = $(this).data('id')

            RefModal.self.modal('show');
            RefModal.form.trigger('reset');
        })
        $('.edit').on('click', function(ev) {
            curData = DataResult[$(this).data('id')]
            console.log(curData);

            RefModal.self.modal('show');
            RefModal.form.trigger('reset');
            RefModal.id_jadwal.val(curData['id_jadwal']);
            RefModal.tanggal_wisuda.val(curData['tanggal_wisuda']);
            RefModal.w_reg_start.val(curData['w_reg_start']);
            RefModal.w_reg_end.val(curData['w_reg_end']);
        })
        $('.generate').on('click', function(ev) {
            cur_id = DataResult[$(this).data('id')]['id_jadwal']
            Swal.fire({
                title: 'Konfirmasi?',
                text: "apakah kamu yakin akan menggenerate posisi tempat duduk pada jadwal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/generate.php`,
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
                                // location.reload();
                            });
                        },
                        error: function(e) {}
                    });
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                }
            })
            // RefModal.self.modal('show');
            // RefModal.id_jadwal.val(cur_id);
        })

        $('.delete').on('click', function(ev) {
            cur_id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "apakah kamu yakin akan menghapus data jadwal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/del_jadwal_admin.php`,
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
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                }
            })
            // RefModal.self.modal('show');
            // RefModal.id_jadwal.val(cur_id);
        })

        RefModal.form.on('submit', function(ev) {
            event.preventDefault();
            // console.log('dagt');
            // RefModal.self.modal('show');
            // cur_id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "apakah kamu yakin akan menyimpan jadwal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/kelolah_jadwal.php`,
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
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                }
            })
        })
    })
</script>