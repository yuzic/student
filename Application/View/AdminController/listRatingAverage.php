<table width="50%" border="0" cellpadding="8" cellspacing="1" class="table">
    <tr class="tableheader">
        <th> Студент</th>
        <th> ср. Оценка</th>
    </tr>
<?php
$sumRating = 0;
foreach ($this->listRating as $data):?>
    <tr  class="table_rows">
        <td><?php echo $data['firstName'];?> <?php echo $data['surname'];?> </td>
        <td><?php echo $data['ratingAvg'];?> </td>
    </tr>
<?php endforeach;?>
</table>
