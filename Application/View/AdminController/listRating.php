<table width="50%" border="0" cellpadding="8" cellspacing="1" class="table">
    <tr class="tableheader">
        <th> Предмет</th>
        <th> Оценка</th>
    </tr>
<?php
$sumRating = 0;
foreach ($this->listRating as $data):?>
    <tr  class="table_rows">
        <td><?php echo $data['name'];?> </td>
        <td><?php
            $sumRating+= (int) $data['rating'];
            echo $data['rating'];?>
        </td>
    </tr>
<?php endforeach;?>
    <tr  class="table_rows">
        <td> Ср. бал </td>
        <td><?php echo number_format($sumRating / count($this->listRating), 2);?> </td>
    </tr>
</table>
