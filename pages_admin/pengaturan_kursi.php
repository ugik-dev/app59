<style>
    div .chair {
        width: 30px;
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
    <table border=1 width=100%>


        <?php
        $id_user = $_SESSION['id'];
        $query = "SELECT * FROM ref_baris as j ORDER BY nama_baris asc
                       ";
        $result = mysqli_query($linkDB, $query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?= $row['nama_baris'] ?></td>
                    <td>
                        <div class="row" style="margin:0px">
                            <?php
                            for ($i = 1; $i <= $row['jml_kursi']; $i++) {
                                echo "<div class='chair'>$i</div>";
                            }
                            ?>
                        </div>

                    </td>
                    <td style="text-align: center;">
                        <?php
                        if (!empty($row['id_baris'])) {
                            echo '
                            <a title="Edit" class="edit btn btn-primary" data-id="' . $row['id_baris'] . '" data-nama="' . $row['nama_baris'] . '" data-jml="' . $row['jml_kursi'] . '"> <i class="fa fa-book fa-xs" ></i> </a>
                            <a title="Hapus" class="delete btn btn-danger" data-id="' . $row['id_baris'] . '"> <i class="fa fa-trash fa-xs"></i> </a>';
                        }
                        ?>
                    </td>
                </tr>
        <?php
            }
        }
        ?>

    </table>
    <button class="add_baris btn btn-success"><i class="fa fa-plus"></i> Baris</button>
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

        var RefModal = {
            'self': $('#reg_modal'),
            'info': $('#reg_modal').find('.info'),
            'form': $('#reg_modal').find('#reg_form'),
            // 'addBtn': $('#reg_modal').find('#add_btn'),
            // 'saveEditBtn': $('#reg_modal').find('#save_edit_btn'),
            'id_baris': $('#reg_modal').find('#id_baris'),
            'nama_baris': $('#reg_modal').find('#nama_baris'),
            'jml_kursi': $('#reg_modal').find('#jml_kursi'),
        }
        $('.add_baris').on('click', function(ev) {
            // cur_id = $(this).data('id')

            RefModal.self.modal('show');
            RefModal.form.trigger('reset');
            // RefModal.id_baris.val(cur_id);
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