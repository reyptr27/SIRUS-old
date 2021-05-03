<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Print Notulen {{ $event->nama_event }} - {{ $event->id }}</title> 
    </head>
    <body>
    	<table width="100%">
    		<tr>
    			<td align="center"><h3>NOTULEN MEETING</h3></td>
    			<td align="center">
    				<img src="../public/assets/images/logo.png" width="50">
        			<br><b>SINAR RODA GROUP</b><br><br>
        		</td>
    		</tr>
    		<tr>
    			<td colspan="2" align="center" style="font-size: 11px; border-style: solid;">FORM INI HARUS SELALU DIGUNAKAN UNTUK MENCATAT NOTULEN YANG DIADAKAN RUTIN PER DIVISI /PER CABANG</td>
    		</tr>
    	</table>
    	<br>
    	<table width="100%">
    		<tr>
    			<td width="18%" align="center">DIVISI</td>
    			<td width="2%">:</td>
    			<td width="50%" style="border-style: solid;">&nbsp;
                <?php 
                    use App\Models\Event\Event_Absen;
                    use App\Models\Departemen;
                ?>
                </td>
				<td width="10%" align="right">Date :</td>
				<td width="20%" align="center">{{ date('d-m-Y', strtotime($event->tanggal)) }}<br></td>
    		</tr>
    	</table>
    	<br>
        <table width="100%">
            <tr>
                <td width="18%" align="center">DEPT</td>
                <td width="2%">:</td>
                <td width="50%" style="border-style: solid;">&nbsp;
                <?php 
                    if($event->all_dept == 1){
                        echo "All Department";
                    }else{
                        $jml = count($event_dept);
                        if($jml > 1){
                            $i = 1;
                            foreach($event_dept as $ed){
                                $dept = Departemen::where(['id' => $ed->dept_id])->first();
                                echo $dept->kode_departemen;
                                if($i < $jml){
                                    if($i == $jml-1){
                                        echo " & ";
                                    }else{
                                        echo ", ";
                                    }
                                }
                                $i++;
                            }
                        }else{
                            $dept = Departemen::where(['id' => $event_dept[0]->dept_id])->first();
                            echo $dept->kode_departemen;
                        }
                    }                
                ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
    	<table width="100%">
    		<tr>
    			<td width="18%" align="center">PESERTA</td>
    			<td width="2%">:</td>
    			<td width="10%" style="border-style: solid;" align="center">
                <?php
                    $peserta = Event_Absen::where(['event_id' => $event->id])->get();
                    echo count($peserta);
                ?>
                </td>
    			<td width="10%">&nbsp;ORANG</td>
				<td width="60%" align="center">&nbsp;</td>
    		</tr>
    	</table>
    	<br>
    	<table width="100%">
    		<tr>
    			<td width="18%" align="center">KATEGORI</td>
    			<td width="2%">:</td>
    			<td width="40%">&nbsp;
                Rutin 
                <img src="../public/assets/images/uncheck.png" width="20px;" style="margin-top:4px;">
                &nbsp; &nbsp; &nbsp;
                Evaluasi
                <img src="../public/assets/images/uncheck.png" width="20px;" style="margin-top:4px;">
                &nbsp; &nbsp; &nbsp;
                Khusus
                <img src="../public/assets/images/uncheck.png" width="20px;" style="margin-top:4px;">
                </td>
				<td width="40%" align="center">&nbsp;</td>
    		</tr>
    	</table>
    	<br>
		<table width="100%">
    		<tr>
    			<td width="18%" align="center">AGENDA</td>
    			<td width="2%">:</td>
    			<td width="70%" style="border-style: solid;">&nbsp;{{ $event->nama_event }}</td>
				<td width="10%" align="center">&nbsp;</td>
    		</tr>
    	</table>
    	<br>
    	<table width="100%" border="1" style="border-collapse: collapse; font-size: 13px;">
    		<tr>
    			<th width="5%" align="center">NO.</th>
    			<th width="30%" align="center">DESCRIPTION</th>
    			<th width="10%" align="center">DEPT</th>
    			<th width="11%" align="center">TARGET</th>
    			<th width="22%" align="center">REALISASI</th>
    			<th width="22%" align="center">NOTES</th>
    		</tr>
    	</table>
    </body>
</html>
