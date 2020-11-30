<?php

if ($jadwal) {

    ?>              

    <div class="form-group">

        <table class="table table-condensed ">

            <tr class="bg-gray-light">

                <th>Nama</th>

                <th>Tim</th>

                <th>Status</th>

            </tr>

            <tr>

                <td><?php echo $tesis->nama_pembimbing_satu ?><br/><b><?php echo $tesis->nip_pembimbing_satu ?></b></td>

                <td><button class="btn btn-xs bg-blue-gradient" style="color:white">Pembimbing I</button>

                </td>

                <td>
                    <?php
                    if ($tesis->status_pembimbing_satu == NULL) {
                        ?>
                        <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                        <?php
                    } else
                    if ($tesis->status_pembimbing_satu == '1') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                        <?php
                    } else
                    if ($tesis->status_pembimbing_satu == '2') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                        <?php
                    }
                    ?>
                </td>

            </tr>

            <tr>

                <td><?php echo $tesis->nama_pembimbing_dua ?><br/><b><?php echo $tesis->nip_pembimbing_dua ?></b></td>

                <td><button class="btn btn-xs bg-blue-gradient" style="color:white">Pembimbing II</button>

                </td>

                <td>
                    <?php
                    if ($tesis->status_pembimbing_dua == NULL) {
                        ?>
                        <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                        <?php
                    } else
                    if ($tesis->status_pembimbing_dua == '1') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                        <?php
                    } else
                    if ($tesis->status_pembimbing_dua == '2') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                        <?php
                    }
                    ?>
                </td>

            </tr>

            <?php

            $penguji = $this->tesis->read_penguji($jadwal->id_ujian);

            $str_status_tim = '';

            foreach ($penguji as $listpenguji) {

                if ($listpenguji['status_tim'] == '1') {

                    $str_status_tim = 'Ketua';

                } else if ($listpenguji['status_tim'] == '2') {

                    $str_status_tim = 'Anggota';

                }

                ?>

                <tr>

                    <td><?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>

                    <td><button class="btn btn-xs bg-blue-gradient" style="color:white"><?php echo $str_status_tim ?></button>

                    </td>

                    <td>

                        <?php

                        if ($listpenguji['status'] == '1') {

                            ?>

                            <a class="btn btn-xs btn-warning"> Belum disetujui</a>

                            <?php

                        } else

                        if ($listpenguji['status'] == '2') {

                            ?>

                            <a class="btn btn-xs btn-success"> Disetujui</a>

                            <?php

                        } else

                        if ($listpenguji['status'] == '3') {

                            ?>

                            <a class="btn btn-xs btn-danger"> Ditolak</a>

                            <?php

                        }

                        ?>

                    </td>

                </tr>

                <?php

            }

            ?>

        </table>

    </div>



    <?php

} else {

    ?>

    <div class="form-group">

        <p>Jadwal ujian belum ada</p>

    </div>

    <?php

}

?>