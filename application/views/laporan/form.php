<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Susunan Kepengurusan</title>
    <style>
        .page_break { page-break-before: always; }
        table {
        border-collapse: collapse;
        /* border: 1px solid black; */
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;

        }
        .judul{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 16px;
        }
        @page { 
          margin-top: 1cm;
          margin-bottom: 1cm;
          margin-left: 1.5cm;
          margin-right: 1.5cm;
        }
    </style>
</head>
<body>
            <?php 
            $no = 1;
            foreach ($pengurus['list'] as $key => $value) { 
                if($key == 0){
                    echo '<div>';
                }else{
                    echo '<div class="page_break">';
                }

                echo '<table width="100%">';
                echo '<tr>';
                echo '<th class="judul" align="center" colspan="3">
                SUSUNAN DAN PERSONALIA<br>
                '.$value->level.' '.$value->nama_susunan.'<br>
                PARTAI PERSATUAN PEMBANGUNAN<br>
                KABUPATEN SITUBONDO<br>
                <HR></HR>
                </th>';
                echo '</tr>';

                foreach ($value->list_ketua as $ketua) :
                    echo '<tr>';
                    echo '<td valign="top" width="60%">'.$ketua->jabatan.'</td>';
                    echo '<td valign="top">:</td>';
                    echo '<td valign="top" width="35%">'.$ketua->nama_pengurus.'</td>';
                    echo '</tr>';
                endforeach;

               
                $no++;
                echo '</table>';
                echo '</div>';
            }
            ?>
           
</body>
</html>