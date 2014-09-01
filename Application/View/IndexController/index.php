<html>
<head>
    <script src='/js/jquery_and_json.js'></script>
    <script src='/js/autocomplete.js'></script>
    <script src='/js/package.js'></script>

    <script>

        //                             id_tag    address        var_name
        var acTest = new autocomplete('test','/index/search','acTest');
        acTest.fields =  {'key':'id','value':'name','descript':'descript'};
        acTest.init();

        var packageData = new package();
        packageData.init();



    </script>
</head>
<body>



<a href="javascript:void(0)" onClick="packageData.insert()"> Записать </a> <br>
<a href="javascript:void(0)" onClick="packageData.update()"> Обновить </a> <br>
<a href="javascript:void(0)" onClick="packageData.delete()">Удалить </a> <br>
<br>
<br>
<br>
<input type='text' id='test'>
</body>

</html>
