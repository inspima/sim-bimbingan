<table class="table">
    <tbody>
        <tr>
            <td><label>NIM</label></td>
            <td><?php echo $tesis->nim ?></td>            
        </tr>
        <tr>
            <td><label>Nama</label></td>
            <td><?php echo $tesis->nama; ?></td>            
        </tr>
        <tr>
            <td><label>Judul</label></td>
            <td>
            <?php 
                $judul = $this->tesis->read_judul($tesis->id_tesis);
                echo $judul->judul; 
            ?>
            </td>            
        </tr>
        <tr>
            <td><label>Pembimbing Utama</label></td>
            <td>
                <b><?php echo $tesis->nip_pembimbing_dua ?></b><br>
                <?php echo $tesis->nama_pembimbing_dua ?>
            </td>            
        </tr>
        <tr>
            <td><label>Pembimbing Kedua</label></td>
            <td>
                <b><?php echo $tesis->nip_pembimbing_dua ?></b><br>
                <?php echo $tesis->nama_pembimbing_dua ?>
            </td>            
        </tr>
    </tbody>
</table>