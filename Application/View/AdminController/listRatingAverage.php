<table width="50%" border="0" cellpadding="8" cellspacing="1" class="table">
    <tr class="tableheader">
        <th> Студент</th>
        <th> ср. Оценка</th>
    </tr>
<?php
$sumRating = 0;
Loader::loadHelper('Html');
foreach ($this->listRating as $data):?>
    <tr  class="table_rows">
        <td><?php echo Html::encode($data['firstName']);?> <?php echo Html::encode($data['surname']);?> </td>
        <td><?php echo Html::encode($data['ratingAvg']);?> </td>
    </tr>
<?php endforeach;?>
</table>
