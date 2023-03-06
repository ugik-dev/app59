<!-- <div class="no-style" id="no-style"> -->
<style>
    .no-style {
        all: unset;
    }

    div .chair {
        width: 30px !important;
        padding: 0px;
        margin: 0px;
        text-align: center;
        color: black;
        font-size: 11px;
    }

    .border_blue {
        border: 4px solid blue;
        background-color: #67f06d !important;

    }

    .border_green {
        border: 4px solid green;
        background-color: #67f06d !important;
    }

    div .check_in {
        background-color: #67f06d !important;
    }

    div .not_check_in {
        background-color: #E3db5d !important;
    }

    .no-style {
        all: unset;
    }
</style>

<table border=1 width=100%>
    <tr>
        <td style="text-align: center; background-color: green;  color: white;"><b>P O D I U M</b></td>
    </tr>
</table>
<br>
<table border=1 width=100% class="" style="align-items: center; text-align: center">
    <?php
    foreach ($dataPeserta as $key => $r) {
    ?>
        <tr>
            <td style="align-items: center; text-align: center">
                <div class="row" style="margin:0px ;align-items: center; text-align: center">
                    <?php
                    foreach ($r as $key2 => $p) {
                        echo "<div class='chair border_green " . ($p['status_reg'] == '3' ? 'check_in' : 'not_check_in') . "' data-id='" . $p['nomor_kursi'] . "'>" . $p['fakultas'] . '|' . $p['id_fakultas_jurusan'] . '<br>' . $p['nomor_kursi'] . "</div>";
                    }
                    ?>
                </div>

            </td>

        </tr>
    <?php
    }
    ?>
</table>
<br>
<table border=1 width=100%>
    <tr>
        <td style="text-align: center; background-color: grey;  color: white;">P E M B A T A S</td>
    </tr>
</table>
<br>
<table border=1 width=100% class="" style="align-items: center; text-align: center">
    <?php
    foreach ($dataOrtu as $key => $r) {
    ?>
        <tr>
            <td style="align-items: center; text-align: center">
                <div class="row" style="margin:0px ;align-items: center; text-align: center">
                    <?php
                    foreach ($r as $key2 => $p) {
                        echo "<div class='chair border_blue " . ($p['status_ortu'] == '3' ? 'check_in' : 'not_check_in') . "' data-id='" . $p['nomor_kursi'] . "'>" . $p['nomor_kursi'] . "</div>";
                    }
                    ?>
                </div>

            </td>

        </tr>
    <?php
    }
    ?>
</table>
<table border=0 width=100%>
    <tr>
        <td>
            <div class="border_green"></div>
        </td>
        <td> :</td>
        <td> Tempat Duduk Mahasiswa</td>
    </tr>
    <tr>
        <td>
            <div class="border_blue"></div>
        </td>
        <td> :</td>
        <td> Tempat Duduk Orang Tua / Wali</td>
    </tr>

    <tr>
        <td>
            <div class="" style="border: 4px solid #67f06d   "></div>
        </td>
        <td> :</td>
        <td> Sudah Check In</td>
    </tr>

    <tr>
        <td>
            <div class="" style="border: 4px solid #E3db5d   "></div>
        </td>
        <td> :</td>
        <td> Belum Check In</td>
    </tr>
</table>
<!-- </div> -->