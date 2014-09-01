<!DOCTYPE html>
<head>
    <style>
        .registration-form fieldset {
            border: none;
            outline: none;
            margin: 20px 0 0 0;
            width: 300px;
            padding: 0;
        }
        /*--------------- Таблицы ----------------*/
        .table_rows td {border-bottom: #DEE4D6 solid 1px; background-color: #eff3eb;}
        td.table_rows {border-bottom: #DEE4D6 solid 1px; background-color: #eff3eb;}
        .table_rows_action td {background-color: #dae0d8}

        .line_bottom {border-bottom:1px solid #77aa00;}
        .line_bottom_b {border-bottom:1px solid #484848;}
        .table td {
            padding: 7px;
        }
        /*.tableborder {
            background-color:#fff
        }*/
        .tableheader {
            font-weight:bold;
            color:#fff;
            background-color: #484848;
        }

        .tableheader td {
            font-weight:bold;
            color:#fff;
            background-color: #484848;
        }
        .tableheader div {
            font-weight:bold;
            color:#fff;
            background-color: #484848;
        }
        .first {
            background-color:#eff3eb;
            color:#484848;
        }
        .second {
            background-color:#dae0d8;
        }
        .third {
            background-color:#cdd5ca;
        }
        #first {
            background-color:#eff3eb;
            color:#484848;
        }
        #second {
            background-color:#dae0d8;
        }
        #third {
            background-color:#cdd5ca;
        }

    </style>
    <script src="/js/jquery-2.1.1.min.js"> </script>
    <script src="/js/jquery.userManager.js"></script>
    <script>
       $(document).ready(function(){
           $('#user-container').userManager({
               selectorContainer:'#user-container',
               createUserRoute:'/admin/add',
               listUserRoute:'/admin/list',
               deleteUserRoute:'/admin/delete',
               createUserRatingRoute:'/admin/addUserRating',
               createUserTopRatingRoute:'/admin/userTopRating'
            });
       });

    </script>
</head>
<body>
<a href="javascript:void(0)" class="add-user-button">Добавить студента</a>
<a href="javascript:void(0)" class="user-list">Список студентов</a>
<a href="javascript:void(0)" class="user-top-rating">Рейтинг (топ 10)</a>
<div id="user-rating-container"> </div>
<div class="user-container" id="user-container"></div>
</body>
</html>

