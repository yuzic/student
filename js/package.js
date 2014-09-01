/**
 * пакетная отправка данных \ тестирования api функций
 * User: itcoder
 * Date: 06.10.13
 * Time: 21:58
 * To change this template use File | Settings | File Templates.
 */
var package = function(){
    this.lastAjax = null;
    this.adres = null;

    this.send = function(data){
        var Self = this;
        //if(Self.lastAjax != null) Self.lastAjax.abort();
        Self.lastAjax = $.ajax({
            type: "POST",
            url: this.adres,
            async: true,
            data: 'dataJson=' + data,
            success: function(data){
                if(data != 'null'){
                    console.log('success');
                }
            },
            error: function(xhr, status){

            }
        });
    }

    this.update = function(){
        var jsonData=[];
        for (i=0; i<20; i++){
            jsonData.push({id:i,name:'стул'+1, descr:'Просто описание'+1});
        }
        this.adres =  '/api/update';
        this.send(JSON.stringify(jsonData));
    }

    this.insert = function(){

        var jsonData=[];
        for (i=0; i<1000; i++){
            jsonData.push({name:'Тумбочка'+1, descr:'Просто описание'+1});
        }
        this.adres =  '/api/insert';
        this.send(JSON.stringify(jsonData));

    }
    this.delete = function(){
        var jsonData=[];
        for (i=0; i<10; i++){
            jsonData.push({id:i});
        }
        this.adres =  '/api/delete';
        this.send(JSON.stringify(jsonData));
    }

    this.init = function(){
        var Self = this;
    }



}