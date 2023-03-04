<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Jadwal Wisuda</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Button trigger modal -->

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal Wisuda</th>
                        <th>Periode Daftar</th>
                        <th>Status</th>
                        <th>Nomor Kursi Mhs</th>
                        <th>Nomor Kursi Ortu</th>
                        <th>QRCode Mhs</th>
                        <th>QRCode Ortu</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $cur_date = date('Y-m-d');
                    $id_user = $_SESSION['id'];
                    $query = "SELECT j.* , rj.nomor_kursi_ortu, rj.qrcode_ortu, rj.nomor_kursi, qrcode,rp.nama_predikat, rj.id_reg_jadwal, rj.ipk, rj.masa_studi, rj.waktu_reg,rj.min_score, rj.retake FROM jadwal as j 
                    LEFT JOIN reg_jadwal as rj on (j.id_jadwal = rj.id_jadwal AND rj.id_user  = $id_user ) 
                    LEFT JOIN ref_predikat as rp on rj.predikat = rp.id_ref_predikat 
                    WHERE ( '$cur_date' BETWEEN w_reg_start AND w_reg_end ) OR  rj.id_user = $id_user
                    -- GROUP BY id_jadwal
                    ";

                    // echo $query;
                    // die();
                    $result = mysqli_query($linkDB, $query);
                    // $row = mysqli_fetch_array($result);
                    // $row = $result->fetch_array(MYSQLI_NUM);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // echo json_encode($row);
                            // die();
                    ?>
                            <tr>
                                <td><?= $row['tanggal_wisuda'] ?></td>
                                <td><?= $row['w_reg_start'] . ' s.d ' . $row['w_reg_start'] ?></td>
                                <td><?= $row['status'] == 1 ? 'Menunggu' : 'Sudah Dijadwalkan' ?></td>
                                <td><?= !empty($row['nomor_kursi']) ? $row['nomor_kursi'] : '' ?></td>
                                <td><?= !empty($row['nomor_kursi_ortu']) ? $row['nomor_kursi_ortu'] : '' ?></td>
                                <td><?= !empty($row['qrcode']) ? "   <a width='100%' href='./qrcode/{$row['id_reg_jadwal']}.png' target='_blank'>
                     <img width='100%' src='./qrcode/{$row['id_reg_jadwal']}.png'></a>
             " : '' ?></td>
                                <td><?= !empty($row['qrcode_ortu']) ? "   <a width='100%' href='./qrcode/{$row['id_reg_jadwal']}_ortu.png' target='_blank'>
                     <img width='100%' src='./qrcode/{$row['id_reg_jadwal']}_ortu.png'></a>
             " : '' ?></td>
                                <td>
                                    <?php
                                    if (!empty($row['id_reg_jadwal']))
                                        echo 'Waktu Daftar : ' . $row['waktu_reg'] . '<br>' .
                                            'Predikat : ' . $row['nama_predikat'] . '<br>' .
                                            'IPK : ' . $row['ipk'] . '<br>' .
                                            'Masa Studi : ' . $row['masa_studi'] . '<br>' .
                                            'Nilai Minimum : ' . $row['min_score'] . '<br>' .
                                            'Pernah Mengulang Mata Kuliah : ' . ($row['retake'] == 'Y' ? 'Pernah' : 'Tidak Pernah') . '<br>'
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if (empty($row['id_reg_jadwal'])) {
                                        echo '<a class="daftar btn btn-primary" data-id="' . $row['id_jadwal'] . '"> <i class="fa fa-note"></i>  Daftar </a>';
                                    } else {
                                        if ($row['status'] == 1) {
                                            echo '<a class="delete btn btn-danger" data-id="' . $row['id_reg_jadwal'] . '"><i class="fa fa-trash"></i> Hapus </a>';
                                        }
                                    }
                                    ?>
                            </tr>
                    <?php
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-form-label">IPK</div>
                            <input type="hidden" id="id_jadwal" name="id_jadwal" class="form-control" required />
                            <input type="number" step="0.01" min=0 max=4 id="ipk" name="ipk" class="form-control" required />
                        </div>
                        <div class="col-lg-12">
                            <div class="col-form-label">Masa Studi (tahun)</div>
                            <input type="number" step="0.01" min=0 max=8 name="masa_studi" id="masa_studi" class="form-control" required />
                        </div>
                        <div class="col-lg-12">
                            <div class="col-form-label">Nilai Terendah</div>
                            <select name="min_score" id="min_score" class="form-control" required>
                                <option value="E">E</option>
                                <option value="D">D</option>
                                <option value="C">C</option>
                                <option value="B">B</option>
                                <option value="A">A</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-form-label">Fakultas / Jurusan / Strata</div>
                            <select name="fakultas_jurusan" id="fakultas_jurusan" class="form-control" required>
                                <option value="">-</option>
                                <?php
                                $query_select = "SELECT * from fakultas_jurusan ORDER by no_urut";

                                // echo $query;
                                // die();
                                $result_select = mysqli_query($linkDB, $query_select);
                                // $row = mysqli_fetch_array($result);
                                // $row = $result->fetch_array(MYSQLI_NUM);

                                if ($result_select->num_rows > 0) {
                                    while ($row_select = $result_select->fetch_assoc()) {
                                        echo "<option value='{$row_select['id_fakultas_jurusan']}'>{$row_select['nama_fakultas']} - {$row_select['nama_jurusan']} - {$row_select['strata']}<option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-form-label">Pernahkan mengambil ulang matakuliah ?</div>
                            <select name="retake" id="retake" class="form-control" required>
                                <option value="Y">Pernah</option>
                                <option value="N">Tidak Pernah</option>
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

        var RefModal = {
            'self': $('#reg_modal'),
            'info': $('#reg_modal').find('.info'),
            'form': $('#reg_modal').find('#reg_form'),
            // 'addBtn': $('#reg_modal').find('#add_btn'),
            // 'saveEditBtn': $('#reg_modal').find('#save_edit_btn'),
            'id_jadwal': $('#reg_modal').find('#id_jadwal'),
        }
        $('.daftar').on('click', function(ev) {
            cur_id = $(this).data('id')

            RefModal.self.modal('show');
            RefModal.id_jadwal.val(cur_id);
        })

        $('.delete').on('click', function(ev) {
            cur_id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "apakah kamu yakin akan menghapus data pendaftaran ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/del_jadwal.php`,
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
                text: "apakah kamu yakin akan mendaftar pada jadwal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Saya Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoading();
                    return $.ajax({
                        url: `back-end/reg_wisuda.php`,
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