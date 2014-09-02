<div>
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="table">
  <tr class="tableheader">
   <th  width="5%"> № </th>
   <th width="10%"> email </th>
   <th width="15%"> Имя </th>
   <th  width="15%"> Фамилия </th>
   <th  width="10%"> Группа </th>
   <th  width="10%"> Дата рождения </th>
   <th> Действия </th>
  </tr>
<?php
Loader::loadHelper('Html');
foreach ($this->studentList as $data):?>
    <tr class="table_rows" id="preload_<?php echo $data['userId'];?>"   userId="<?php echo $data['userId'];?>">
        <td class="itcen"><?php echo Html::encode($data['userId']);?> </td>
        <td><?php echo Html::encode($data['email']);?> </td>
        <td><?php echo Html::encode($data['firstName']);?> </td>
        <td><?php echo Html::encode($data['surname']);?> </td>
        <td><?php echo Html::encode($data['groupName']);?> </td>
        <td><?php echo Html::encode($data['dob']);?>г. </td>
        <td>
            <a href="javascript:void(0)" class="user-delete">Удалить</a>
            <a href="javascript:void(0)" class="user-add-rating">Добавить оценки</a>
        </td>
     </tr>
<?php endforeach;?>
</table>
</div>

