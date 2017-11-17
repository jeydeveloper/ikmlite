<table width=100%>
    <tr><td>

    <tr><th><font size=12px>Data Laporan Transaksi</font><BR>
</table>
<p></p>
<table width=100%>
    <tr><td width=10%>Tanggal Cetak:<td> : <?php echo date('d-m-Y'); ?>
</table>
<table width=100% border=1 cellpadding=3 cellspacing=0 >
    <tr>
        <th width=5%  > NO
        <th width=20% > Tanggal Transaksi
        <th width=15% > Status

<?php
$no=1;
foreach($data_master as $data_master_result):
    print"<tr>
            <td align=center width=5% >$no
            <td align=center  >".$data_master_result['trans_tgl']."
            <td align=center  >".$data_master_result['butt_status']."
            ";
    $no++;
endforeach;
?>