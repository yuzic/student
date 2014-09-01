var autocomplete = function(idInput,address,varName){
    this.lastAjax = null;
    this.name = varName;
    this.id = 'div_'+varName;
    this.idInput = idInput;
    this.address = address;
    this.selIndex = 0;
    this.count = 0;
    this.lastStr = '';
    this.inputStr = '';
    this.buildOn = false; // создан список или ещё нет
    this.minLen = 2; // минимальная длинна строки для поиска
    this.visible = false; // видимый или нет
    this.mouseIn = false; // наведена мышь или нет
    this.timerStart = false;
    this.fields =  {'key':'key','value':'value','descript':'descript'};

    this.style = '<style> \n\
                    .div_aac {background: white; border: 1px solid gray; padding: 2px} \n\
                    .div_aac .line {padding: 2px; border: 1px solid white} \n\
                    .div_aac .sel {padding: 2px; border: 1px solid silver; background: silver} \n\
                    .div_aac .line:hover {padding: 2px; border: 1px solid silver; } \n\
                    .div_aac .line a {color: black;}\n\
                    .div_aac .line a span {color: gray;}\n\
                  </style>';

    this.onSelect = function(key,value){
        $('#'+this.idInput).val(value);
    }



    this.keyUp = function(){
        if(this.visible)
        if(this.selIndex-1 > 0){
            $('#line_'+this.id+'_'+this.selIndex).attr('class','line');
            this.selIndex--;
            $('#line_'+this.id+'_'+this.selIndex).attr('class','line sel');
            this.onSelect($('#line_'+this.id+'_'+this.selIndex).attr('acKey'),
                          $('#line_'+this.id+'_'+this.selIndex).attr('acValue'),
                          'descript');
        } else {
            $('#line_'+this.id+'_'+this.selIndex).attr('class','line');
            this.selIndex = 0;
            if(this.lastStr != ''){
                this.onSelect('0',this.lastStr,'');
            }

        }
    }
    this.keyDown = function(){
        if((this.lastStr == '')&&(this.selIndex == 0)){
            this.lastStr = $('#'+this.idInput).val();
        }
        if(this.selIndex+1 <= this.count){
            $('#line_'+this.id+'_'+this.selIndex).attr('class','line');
            this.selIndex++;
            $('#line_'+this.id+'_'+this.selIndex).attr('class','line sel');
            this.onSelect($('#line_'+this.id+'_'+this.selIndex).attr('acKey'),
                          $('#line_'+this.id+'_'+this.selIndex).attr('acValue'));
        }
    }
    this.resize = function(){
        var offset = $('#'+this.idInput).offset();
        var x = offset.left;
        //var y = offset.top + $('#'+this.idInput).height() + $(window).scrollTop();
        var y = offset.top + $('#'+this.idInput).height();

        $('#'+this.id).width($('#'+this.idInput).width()- 4);
        $('#'+this.id).offset({
            top: y, 
            left: x
        })
    }
    this.hide = function(){
        this.count = 0;
        this.selIndex = 0;
        this.lastStr = '';
        $('#'+this.id).hide();
        //$('#'+this.id).html();
        this.visible = false;
    }
    this.show = function(){
        if(!this.visible){
            $('#'+this.id).show();
            this.visible = true;
        }
        this.resize();
    }
    this.getData = function(){
        var Self = this;
        //if(Self.lastAjax != null) Self.lastAjax.abort();
            Self.lastAjax = $.ajax({
                type: "POST",
                url: Self.address,
                async: true,
                data: 'str=' + Self.searchStr,
                success: function(data){
                    if(data != 'null'){
                        Self.show();
                        Self.outData(data);
                        //останавливаем timer
                        clearTimeout( this.timerStart )
                    } else
                        Self.hide();
                },
                error: function(xhr, status){
                    //Self.hide();
                    //$('#'+Self.id).html("Ошибка!");
                }
            });

    }
    this.outData = function(data){
        var data = eval('('+data+')');
        //console.log(this.inputStr);
        var str = '';
        this.count = 0;
        this.selIndex = 0;
        this.lastStr = '';
        var tempLenStr = this.inputStr.length;
        for(var i in data){
            this.count++;
            // выделяем входжение
            var subChunk = data[i]['name'].substr(0,tempLenStr);
            var selectNameChunk = null;
            if (subChunk == this.inputStr){
                var selectNameChunk = '<b>'+ this.inputStr+'</b>'+data[i]['name'].substr(tempLenStr);
            }else{
                selectNameChunk = data[i]['name'];
            }
            str += '<div id="line_'+this.id+'_'+this.count+'" acKey="'+data[i][this.fields['key']]+'" acValue="'+data[i][this.fields['value']]+'" class="line"> \n\
            <a href="javascript: void(0)" onmousedown="'+this.name+'.onSelect('+data[i][this.fields['key']]+',\''+data[i][this.fields['value']]+'\'); '+this.name+'.hide()">'+selectNameChunk
            if(data[i][this.fields['descript']] != null) // если описание пустое, непоказываем
                str += '<span> ('+data[i][this.fields['descript']]+')</span>'
            str += '</a></div> \n';
        }
        $('#'+this.id).html(str);
    }
    this.update = function(){
        this.searchStr = $('#'+this.idInput).val();
        if((this.searchStr.length) >= this.minLen){
              this.timerStart = setTimeout(function() { acTest.getData() }, 250)

        }else{
            this.hide();
        }
    }
    this.init = function(){
        var Self = this;
        if(this.buildOn == false){
            // если слой небыл создан, создаём его
            $('body').append(this.style);
            $('body').append('<div id="'+this.id+'" class="div_aac" style="display: none; position: absolute; z-index: 9998"></div>');
        }
        
        $('#'+this.idInput).bind('blur', function(){
            if(!Self.mouseIn)
                Self.hide();
        });
        
        $('#'+this.id).bind('mouseover', function(){
            Self.mouseIn = true;
        });
        $('#'+this.id).bind('mouseout', function(){
            Self.mouseIn = false;
        });

        $('#'+this.idInput).keydown(function(e){
            switch(e.which){
                case 40:
                    Self.keyDown();
                    break;
                case 38:
                    Self.keyUp();
                    break;
                case 27:
                    Self.hide();
                    break;
                case 13:
                    Self.hide();
                    break;
                case 39:
                    // стрелка ->
                    break;
                default:
                    break;
            }

        });
        
        $('#'+this.idInput).keyup(function(e){
            if((e.which in {13:13,16:16,17:17,18:18,27:27,37:37,38:38,39:39,40:40}) == false) // если ненажаты эти клавиши
                if(Self.inputStr != $('#'+Self.idInput).val()){ // если есть изменения в строке
                    Self.inputStr = $('#'+Self.idInput).val();
                    Self.update();
                }
        });
    }
}