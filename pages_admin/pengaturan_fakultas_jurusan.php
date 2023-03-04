<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Fakultas / Jurusan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Button trigger modal -->
            <button class="add_jadwal btn btn-primary"> <i class="fa fa-plus"></i> Tambah Data</button>
            <br>
            <br>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Urut</th>
                        <th>Fakultas</th>
                        <th>Jurusan</th>
                        <th>Strata</th>
                        <!-- <th></th> -->
                        <!-- <th>Waktu Daftar</th> -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id_user = $_SESSION['id'];
                    $query = "SELECT j.* FROM fakultas_jurusan as j 
                     -- GROUP BY id_fakultas_jurusan
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
                                <td><?= $row['no_urut'] ?></td>
                                <td><?= $row['nama_fakultas'] ?></td>
                                <td><?= $row['nama_jurusan'] ?></td>
                                <td><?= $row['strata'] ?></td>

                                <td>
                                    <?php
                                    echo '
                                        <a title="Edit" class="edit btn btn-primary" data-id="' . $i . '" > <i class="fa fa-book fa-xs" ></i> </a>
                                        <a title="Hapus" class="delete btn btn-danger" data-id="' . $row['id_fakultas_jurusan'] . '"> <i class="fa fa-trash fa-xs"></i> </a>';
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
<div class="modal  fade" id="reg_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form opd="form" id="reg_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Fakultas Jurusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_fakultas_jurusan" name="id_fakultas_jurusan" class="form-control" />
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="col-form-label">No Urut</div>
                            <input type="number" name="no_urut" id="no_urut" class="form-control" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="col-form-label">Fakultas </div>
                            <input type="text" name="nama_fakultas" id="nama_fakultas" class="form-control" required />
                        </div>
                        <div class="col-lg-5">
                            <div class="col-form-label">Jurusan</div>
                            <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control" required />
                        </div>
                        <div class="col-lg-2">
                            <div class="col-form-label">Strata</div>
                            <select name="strata" id="strata" class="form-control" required>
                                <option>S1</option>
                                <option>S2</option>
                                <option>S3</option>
                            </select>
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
            'id_fakultas_jurusan': $('#reg_modal').find('#id_fakultas_jurusan'),
            'no_urut': $('#reg_modal').find('#no_urut'),
            'nama_fakultas': $('#reg_modal').find('#nama_fakultas'),
            'nama_jurusan': $('#reg_modal').find('#nama_jurusan'),
            'strata': $('#reg_modal').find('#strata'),
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
            RefModal.id_fakultas_jurusan.val(curData['id_fakultas_jurusan']);
            RefModal.no_urut.val(curData['no_urut']);
            RefModal.nama_fakultas.val(curData['nama_fakultas']);
            RefModal.nama_jurusan.val(curData['nama_jurusan']);
            RefModal.strata.val(curData['strata']);
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
                        url: `back-end/del_fakultas.php`,
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
            // RefModal.id_fakultas_jurusan.val(cur_id);
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
                        url: `back-end/kelolah_fakultas.php`,
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
                            // RefModal.self.modal('hide');
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