/* 
 *  Document   : 地图展示组件
 *  Created on : 2014-06-15,
 *  Author     : leeduan
 *  Description: 简单的地图展示，可以用于有对地图区域和城市展示有需求的产品
 *  Version: 1.0
*/
//;(function($,window,document,undefine){
var scripts= document.getElementsByTagName('script'),
    src=scripts[scripts.length-1].src,
    path=src.replace(src.split('/').pop(),'');
$.fn.Rmap = function(options) {
        //定义地图初始化值
        var opts,
            defaults = {                                                               //渲染的ID
                width    : 950,                                                                     //默认面板高宽度
                height   : 630,                                                                     //默认面板高度
                datas    : null,                                                                    //基础数据集合
                ifcity   : true,                                                                    //控制地图城市点是否显示
                loc_click: true,                                                                    //控制地图区域是否是点击或hover
                cityshow : true,                                                                    //是否右侧菜单显示
                colorpanel:true,                                                                    //控制色阶面板是否显示
                map_pro  : [path+'img/A.png','images/B.png','images/C.png'],                          //在地图上展示城市点的图片
                map_hover: [path+'img/A1.png','images/B1.png','images/C1.png'],                       //在地图上展示城市点mouseover后的图片
                sHexColor: null,                                                                    //整个地图的色阶
                sHexText : null,                                                                    //色阶的初始化范围值，与SHexColor,总数对应
                set_per  : null,                                                                    //mouseover或click 区域后的浮动窗内显示的字段值
                set_val  : null,                                                                    //mouseover 城市点后的浮动窗内显示的字段值
                city_type: null,                                                                    //城市类型，如：核心，重点等
                zoom     : 1,                                                                       //地图缩放比例
                x        : 0,                                                                       //地图初始化开始点的x坐标偏移值
                y        : 0,                                                                       //地图初始化开始点的Y坐标偏移值
                w_position_x:null,                                                                  //区域mouseover 后窗口的x轴偏移值
                w_position_y:null,                                                                  //区域mouseover 后窗口的y轴偏移值
                s_position_x:null,                                                                  //点(城市) mouseover 后窗口的x轴偏移值
                s_position_y:null,                                                                  //点(城市) mouseover 后窗口的y轴偏移值
                float_arr   :null,                                                                  //浮动窗口属性
                citystyle : 1,                                                                      //城市图标显示的样式 值：1，2
                cityavg  : null,                                                                    //当开启样式2的时候城市的均值，这里作用是设定当前城市点的颜色变化
                animate  : false,                                                                   //是否开启播放功能，如果开启，animate_data不能为空，默认为false
                animate_data : null,                                                                //播放的数据集合
                animate_bar  : 635                                                                  //播放bar的宽度
            },
            R={},
            set={},
            city_imgs,
            map_path={},
            current = null, 
            max_per = 0,
            min_per = 100,
            avg_per =0,
            color_list = {},
            movepositionX=0,
            movepositionY=0,
            setval=[],
            attr = {
                "fill" : "#FFF",
                "stroke" : "#ddd",
                "stroke-width" : 1.5,
                "stroke-linejoin" : "round"
            },
            textAttr = {
                "fill": "#000",
                "font-size": "12px",
                "cursor": "pointer"
            },
            setcolor=0,
            animatedate;
        
        opts= $.extend(defaults, options);
        
        //地图初始化
        this.init=function(){       
            Raphael.getColor.reset();
            this.refresh();        
            //播放功能开启，动画数据接入
            if(opts.animate==true && opts.animate_data){

                this.click_animate();
            }
            
        }
        this.init_html=function(){
            var me=this,
                drag_bar='',
                cityMap='<div style="display:none;height:150px;width:300px,overflow:scroll" class="citymap-label"></div>',
                topFrame='<div id="RmapTool"style="position:absolute;width:16px;z-index:10;right:20px;">'+
                         '<div  class="mapadd" id="add" title="放大"></div>'+
                         '<div  class="mapminus" id="minus" title="缩小"> </div>'+
                         '<div  class="mapcolor" id="mapcolor" title="透视"></div>'+
                         '</div><div id="RmapTip" class="Rmap-tip" style="position:absolute;top:'+(opts.height-140)+'px;right:30px">'+
                         '<div id="areaInfo"></div>'+
                         '<div id="cityInfo"></div>',
                html;
                
            if(opts.animate==true && opts.animate_data){
                //初始化滚动条
                var data_slider_values=[],i=0;
                $.each(opts.animate_data.data,function(){
                    data_slider_values.push(i);
                    i++;
                });
                drag_bar='<div style="float:left;width:60px;padding:10px">'+
                        '<div id="playbutton" style="cursor:pointer"><img src="images/pause.png" id="play"></div></div>'+
                        '<div style="float:left;"><input type="text" class="timeline"  data-slider="true"'+
                        'data-slider-values="'+data_slider_values.join(',')+'" data-slider-highlight="true" bar-type="date"stye="display:block">'+
                        '</div><div style="clear:both"></div>';
                
            }
            html=drag_bar+cityMap+topFrame;
            me.before(html);
        },
        //地图数据获取
        this.getData=function(){
            return this.config.data;
        }

        //地图及文字渲染
        this.refresh=function(){
            var me=this;

            me.html(''); 
            me.draw();
            me.event();
            
            //颜色标尺展开
            if(opts.colorpanel==true){
                me.tooltips();
            }
            set=R.set();
            //填充色块
            me.fill();
            //添加城市
            if(opts.ifcity==true){
                me.addCity();
            }
            
            me.drag();
            //滑轮滚动事件处理
            me.wheel();

        }
        this.drag=function(){
            var me=this,
                lastX=0,lastY=0;
            var dragging = false;
            var start = function (x,y) {

                this.attr({
                    opacity: 1
                });
                this.lastX = x;
                this.lastY = y;
                 dragging = true;
            },
            move = function (dx, dy, x, y) {
                if (dragging) {
                me.get(0).style.cursor="move";

                var deltaX = x - this.lastX;
                var deltaY = y - this.lastY;
                //位移坐标
                movepositionX=dx;
                movepositionY=dy;
                set.translate(deltaX, deltaY);
                this.lastX = x;
                this.lastY = y
                R.safari();
                }
            },
            up = function () {
                dragging = false;
                me.get(0).style.cursor="";
                set.attr({
                    opacity: 1
                });
            };
            
            set.drag(move, start, up);
        }
        //滑轮滚动事件处理
        this.wheel=function(){
            var me=this;
            
             if (true) {
            
                me.mousewheel(function(event,positon) {

                    //解决与外部滚动条产生联动的问题
                    event = event || window.event;
                    if (event.stopPropagation) event.stopPropagation();
                    else event.cancelBubble = true;
                    if (event.preventDefault) event.preventDefault();
                    else event.returnValue = false;

                    if(positon>0){
                        me._mapevennt("zoomout");
                    }else{
                        me._mapevennt("zoomin");
                    }
                });
                
                
                
            }else{
                //firefox单独处理
                me.bind("DOMMouseScroll",function(event) {
                    
                    var positon=event.originalEvent.detail;
                    console.log(event.originalEvent);
                    if(positon>0){
                        me._mapevennt("zoomin");
                    }else{
                        me._mapevennt("zoomout");
                    }
                    
                    event.preventDefault()
                });
            }
            
        }
        
        //地图绘制
        this.draw = function () {
        
            var me=this,
                perKey=opts.set_per.value,
                datas = opts.datas;
   
            R = Raphael(this.attr('id'), opts.width, opts.height); 
            map_path=me.Rmap.makepath(R,attr);
            
            //添加省份总数            
            $.each(datas,function(key,value){
                if(key!=='city' && value[perKey]){                  
                    map_path[key].stateCount = map_path[key].name + '('+ value[perKey] +')';
                }
            });
        }
        this.set=function(k,v){
            opts[k]=v;
            return this;
        }
        this.fill=function(){
            var me=this;
            $.map(map_path,function(data,state){
                //添加文字
                me.showTitle(data);     
                data.path["state"]={"name":state};
                set.push(data.path);    
                
                
                //为地图添加颜色
                if(opts.datas[state]!=undefined){
                
                    if(state===opts.datas[state].AreaName){
                        var colors=me.color_set(opts.datas[state][opts.set_per.value]);
                        var anim = Raphael.animation({ fill: colors, stroke: "#eee" }, 100);
                        data['path'].stop().animate(anim.delay(0));
                    }
                }else{

                    var anim = Raphael.animation({ fill: "#A6CBF9", stroke: "#eee" }, 100);
                    data['path'].stop().animate(anim.delay(0));
                }

                

                //图形的点击事件
                if(opts.loc_click==true){
                    $(data['path'][0]).click(function (e) {
                    
                        var el = e;
                        me.clickMap(state,el);

                    });
                    $(data['path'][0]).css('cursor', 'pointer');
                }else{
                    //图形的hover事件
                    $(data['path'][0]).mouseover(function (e) {
                        var el = e;
                        me.hoverMap(state,el);
                        
                    }).mouseout(function (e) {
                        $(".citymap-label").css({"display":"none"});
                    });
                    $(data['path'][0]).css('cursor', 'pointer');
                }
        
            });
        }
        //地图文字显示
        this.showTitle=function(data){
            if(data['xy']){
                data['path'].color = Raphael.getColor(0.9);
                var xy_y=data['xy'][1];     
                if(data['stateCount']){
                    var tt=R.text(data['xy'][0], xy_y, data['stateCount']).attr(textAttr);              
                }else{
                    var tt=R.text(data['xy'][0], xy_y, data['name']).attr(textAttr);                
                }
                set.push(tt);
            }
        }
        //地图缩放事件处理
        var i=0;
        this._mapevennt=function(val){

            //重新获取当前BOX的长宽以及鼠标位置
                var x=25,y=25,w=50,h=50,
                    sx=R._viewBox[0],sy=R._viewBox[1],sw=R._viewBox[2],sh=R._viewBox[3],
                dx = x - sx,
                dy = y - sy,
                dw = w - sw,
                dh = h - sh;

                var current_step = 1;
                var interval=25;
                var duration=2500;
                var steps = duration / interval;

                if(val=="zoomout"){
                    
                    var intervalID = setInterval( function()
                    {

                            var ratio = current_step / steps;
                            var eased_step = ratio ;                                    
                            R.setViewBox( sx + dx * eased_step,
                            sy + dy * eased_step,
                            sw + dw * eased_step,
                            sh + dh * eased_step, false );

                        if(current_step++ >= 10){

                            clearInterval( intervalID );
                        }
                    }, interval );
                    
                    i++;

                }else{
                
                    var intervalID = setInterval( function()
                    {

                            var ratio = current_step / steps;
                            var eased_step = ratio ;
                            
                            R.setViewBox( sx - dx * eased_step,
                            sy - dy * eased_step,
                            sw - dw * eased_step,
                            sh - dh * eased_step, false );
                        
                        if(current_step++ >= 10){
                            clearInterval( intervalID );
                        }
                    }, interval );
                    
                    i--;
                    
                }
                        
                
        }       
        /*
        *   实现地图的放大、缩小及复原
        */
        this.event=function(){
            
            //获取当前地图ID
            var me=this,
                box=document.getElementById(opts.renderid);
            //初始化地图
            R.setViewBox(parseInt(opts.x),parseInt(opts.y),opts.width*opts.zoom,opts.height*opts.zoom);
            
            $("#minus").unbind('click');
            $("#minus").bind('click',function(){
                
                me._mapevennt("zoomin");
                
            });
            
            $("#add").unbind('click');
            $("#add").bind('click',function(){

                me._mapevennt("zoomout")
                
            });
            $("#all").unbind('click');
            $("#all").click(function(){
                    R.setViewBox(movepositionX,movepositionY,opts.width*opts.zoom,opts.height*opts.zoom);
                    movepositionX=0;
                    movepositionY=0;
                    
                });
            $("#mapcolor").unbind('click');
            $("#mapcolor").click(function(){
                if(setcolor==0){

                    $.map(set,function(data,state){
                        if(data.type=="path"){
                                data.attr({'fill':"#FFF"});
                        }

                    });
                    setcolor=1;
                }else{

                    $.map(set,function(data,state){

                        if( data.type=="path" &&data['state']!=undefined&&opts.datas[data["state"].name]!=undefined &&data['state'].name===opts.datas[data['state'].name].AreaName){
                            var colors=me.color_set(opts.datas[data['state'].name][opts.set_per.value]);
                            data.attr({'fill':colors});
                        }else if(data.type=="path"){
                            data.attr({'fill':"#ACD6FF"});
                        }
                    });
                    setcolor=0;
                }
                    
            });
            $(window).resize(function(){
                R.setSize(me.width(),me.height());
            })
        }
        /*
        * 右侧城市栏设置及事件
        */
        this.city_func=function(event,state,mouse_el){
            
            var citylist=[{}],
                citylistData=this.Rmap.citylistData,
                city_list_container=$("#city_list");
            
            city_list_container.html('');
            for(var city_k in opts.datas.city){
                if(citylistData[city_k])citylist[0][city_k]=citylistData[city_k];
            }
            $.each(citylist,function(i,record){

                var chk=($.inArray(parseInt(i),ifchecked)>-1)?"checked":"";

                city_list_container.append("<div class=hack></div><div class=province>"+opts.city_type[i]+"<div class='city_right'><input id=check"+i+" type=checkbox value="+i+" "+chk+"></div></div>");

                

                if(event=='default'){
                    var hh=$("<div class='dd'></div>");
                    $.each(record,function(key,e){
                        hh.append('<li _r='+key+' _type='+i+'>'+e.name+'</li>');
                    });
                    city_list_container.append(hh);
                }else{
                    $.each(record,function(key,e){
                        if(mapvetor[current].name==e.province){
                            city_list_container.append('<li style="color:#FF0000" _r='+key+' _type='+i+'>'+e.name+'</li>');
                        }else{
                            city_list_container.append('<li _r='+key+' _type='+i+'>'+e.name+'</li>');
                        }
                    });
                }
            });
            
            //触发check事件
            for(i=0;i<=3;i++){
                
                $("#check"+i).click(function(e){
                    var el=$(this);

                    if(el.attr('checked')=='checked'){
                        
                        ifchecked.push(el.attr('value'));
                        $.unique(ifchecked);
                        $.map(set,function(val,j){
                        
                            if(val.type=='image' || val.type=='circle'){
                                
                                if(el.attr('value')==val.data('kind')){
                                    val.show();
                                }
                            }
                        });
                    }else{
                        ifchecked.splice($.inArray(el.attr('value'),ifchecked),1);
                        $.map(set,function(val,j){
                        
                            if(val.type=='image' || val.type=='circle'){
                                //console.log(val.data('kind'));
                                if(el.attr('value')==val.data('kind')){
                                    val.hide();
                                }
                            }
                        });
                    }
                });
                
            }

            if(map_path[current] && opts.datas[current]!=undefined){
                var _width=90/100*opts.datas[current][opts.set_per.value];
                var htmls='<div style="width:'+opts.float_arr.width+'px;height:'+opts.float_arr.height+'px">'+mapvetor[current].name;
                htmls+='<div class="hack"></div><div class="map_float_top">'+opts.set_per.text+'</div>';
                htmls+='<div style="width:'+_width+'px;" class="map_float_left"></div>';
                htmls+='<span class="map_float_right">'+opts.datas[current][opts.set_per.value]+'%</span>';
                htmls+='</div>';
                
                //如果city图标不显示，采用hover
                if(opts.ifcity==false && typeof(mouse_el)!='undefined'){
                    $(".citymap-label").css({"display":"block",'left':(mouse_el.clientX+15)+'px','top':(mouse_el.clientY+30)+'px','z-index':'9999'}).html(htmls);
                }else{
                    $(".citymap-label").css({"display":"block",'left':opts.w_position_x+'px','top':opts.w_position_y+'px','z-index':'9999'}).html(htmls);
                }
            }
        
        }
        //处理地图区域点击
        this.clickMap=function(state){
    
            current && map_path[current]['path'].animate({ stroke: "#ddd" ,"stroke-width":1}, 2000, "bounce");
                        
            current = state;   
            map_path[state]['path'].animate({ stroke: "#000" ,"stroke-width":1}, 1200, "bounce");

            
            R.safari();

        }
        //处理地图区域hover
        this.hoverMap=function(state,el){
            
            
            current && mapvetor[current]['path'].animate({ stroke: "#ddd" ,"stroke-width":1}, 2000, "bounce");
                        
            current = state;   
            mapvetor[state]['path'].animate({ stroke: "#000" ,"stroke-width":1}, 1200, "bounce");
            
            if(opts.animate==true){
                this.animate_func(state,el);
            }else{
                //this.city_func('maphover',state,el);
            }
            
            R.safari();

        }
        //目前动画只针对区域显示
        this.animate_func=function(state,el){
            
            var _width=90/100*opts.animate_data.data[animatedate][state][opts.set_per.value];
                var htmls='<div style="width:'+opts.float_arr.width+'px;height:'+opts.float_arr.height+'px">'+mapvetor[current].name+' ('+animatedate+')';
                htmls+='<div class="hack"></div><div class="map_float_top">'+opts.set_per.text+'</div>';
                htmls+='<div style="width:'+_width+'px;" class="map_float_left"></div>';
                htmls+='<span class="map_float_right">'+opts.animate_data.data[animatedate][state][opts.set_per.value]+'%</span>';
                htmls+='</div>';
            
            
            $(".citymap-label").css({"display":"block",'left':(el.clientX+15)+'px','top':(el.clientY+30)+'px','z-index':'9999'}).html(htmls);
            
        }
        //右侧列表增加城市
        this.addCity=function(data){
            var me=this,
                cData,
                cityicon,
                citylistData=me.Rmap.citylistData,
                citys=opts.datas.city,
                kind,
                src_img,
                color="#CCCCCC";
            if(!citys)return;
            city_imgs={};
            $.map(citys,function(city,city_k){
                cData=citylistData[city_k];
                if(!cData)return;//没有地图数据
                kind=me.getKind(city[opts.cityavg]);
                if(opts.citystyle==1){
                    src_img=opts.map_pro[kind];
                    cityicon=R.image(src_img, cData.circleLng[0]-5, cData.circleLng[1]-15,15,25).data({"title":city_k,'name':cData.name,'kind':kind,'data':city});
                    cityicon.mouseover(function(e){
                        var img=this,
                            currtkind=img.data('kind'),
                            src=opts.map_hover[currtkind];
                        if(e.target.href.baseVal==src){
                                return false;
                        }else{
                                var ob=this.attr({'src':src});
                                me.city_float(img.data('name'),img.data('title'));
                        }

                    }).mouseout(function(e){
                        var img=this,
                            currtkind=img.data('kind'),
                            src=opts.map_pro[currtkind];
                        if(e.target.href.baseVal==src){
                            return false;
                        }else{
                            //$(".citymap-label").hide();
                            this.attr({'src':src});
                        }
                    });
                }else{
                    color=me.color_set(city[opts.cityavg]);
                    cityicon=R.circle(cData.circleLng[0],cData.circleLng[1], 5).data({"title":city_k,'name':cData.name,'kind':kind}).attr({fill: color,"stroke":'#eee',"stroke-width":1});
                    cityicon.mouseover(function(e){
                        var img=this,
                            ob=img.attr({fill: color,"stroke":'#eee','opacity': 1,"stroke-width":3,"r":7});
                        if($.browser.msie!=true){
                            ob.toFront();
                        }
                        me.city_float(img.data('name'),img.data('title'));
                    }).mouseout(function(){
                        this.attr({fill: color,"stroke":'#eee',"stroke-width":1,'opacity': 1,"r":5});
                        $(".citymap-label").hide();
                    });
                                
                }
                city_imgs[city_k]=cityicon;
                set.push(cityicon);
            })          
        }
        this.hoverImg=function(_code){
            var me=this,
                img;//找出该城市的坐标
            $.map(set,function(val,i){
                if(val.type=='image'){
                    if(val.data('title')==_code){
                        
                        img=opts.map_hover[val.data('kind')];

                        var ob=val.attr({'src':img});
                        ob.toFront();                           
                        me.city_float(val.data('name'),_code);
                        
                    }else{
                        var ob=val.attr({'src':opts.map_pro[val.data('kind')]});
                    }
                }else if(val.type=='circle'){
                    
                    if(val.data('title')==_code){
                            
                            var ob=val.attr({"stroke":'#eee','opacity': 1,"stroke-width":3,"r":7});
                                    
                            ob.toFront();
                            
                            me.city_float(val.data('name'),_code);
                    }
                }
            });
        }
        this.city_float=function(name,key){
            var htmls='<div style="width:'+opts.float_arr.width+'px;height:'+opts.float_arr.height+'px">'+name,
                count=0;
            if(opts.datas.city[key]){
                $.map(opts.datas.city[key],function(val,i){
                    if($.inArray(i,setval)>-1){
                        var _width=90/1000*val;
                        if(!count)htmls+='</div>';
                        count++;
                        htmls+='<div><div class="hack"></div><div class="map_float_top">'+opts.set_val[i]+'</div>';
                        htmls+='<div style="width:'+_width+'px;" class="map_float_left"></div>';
                        htmls+='<span class="map_float_right">'+val+'</span></div>';
                    }
                
                });
            }
            $(".citymap-label").empty();
            $(".citymap-label").css({"display":"block",'left':opts.s_position_x+'px','top':opts.s_position_y+'px','z-index':'9999'}).html(htmls);

        }
        //色阶菜单
        this.tooltips=function(){

            var title="色阶区间表",text;
            var ht='<div style="font-weight:bold" class="color_title">'+title+'</div>'+
                        '<div class="tooltip_explode_flag" style="width: 50px; height: 10px; margin: 0px auto; line-height: 6px;"><img src="'+path+'img/drag_up.gif" id="drag_button" _value="1" style="cursor: pointer; width: 48px;"></div>'+
                        '<div class="tooltiplist"><table>';
                
            for(i=0;i<opts.sHexColor.length;i++){
            
                text=opts.sHexText[i].text;

                ht+="<tr><td><div style='padding:2px;width:10xp;height:10px;background:"+opts.sHexColor[i]+"'></div><td><td>"+text+"<td><tr>";
                
            }

            ht+="</table></div>";
        
            $("#RmapTip").html(ht);

            $(".tooltip_explode_flag").click(function(){
                
                var flag = $('.tooltip_explode_flag').find("img").attr('src');

                if(flag.indexOf('drag_up')!=-1){
                
                    $(".tooltiplist").hide("normal");
                    $('.tooltip_explode_flag').find("img").attr('src', path+'img/drag_down.gif');
                }else{
                    $(".tooltiplist").show("normal");
                    $('.tooltip_explode_flag').find("img").attr('src', path+'img/drag_up.gif');                           
                }
            });
        }
        
        //地图根据数据值设置
        this.color_set=function(n,val){
            var color="FFFFFF";
            for(i=0;i<opts.sHexText.length;i++){
                var val=opts.sHexText[i].value.split("-");
                
                if(n>=parseInt(val[0]) && n<parseInt(val[1])){
                    color=opts.sHexColor[i];
                }
            }

            return color;
        }
        //地图根据数据值设置
        this.getKind=function(n){
            var kind=0;
            for(i=0;i<opts.sHexText.length;i++){
                var val=opts.sHexText[i].value.split("-");
                
                if(n>=parseInt(val[0]) && n<parseInt(val[1])){
                    kind=i;
                }
            }
            return kind;
        }
        
        //浮动窗的时间部分
        this.float_date=function(){
        
            var el=$(".dragger"),html="";
            html='<div style="top: 25px; left: 5px; position: absolute; border-color: rgb(159, 209, 237); display: block;" class="float_div" id="float_pop"><dialogl style=" border-color:  transparent   transparent #9FD1ED transparent;top:-13px;left:5px"></dialogl><dialogt style="border-bottom-color:#fff;top:-11px;left:5px"></dialogt><div class=""><span></span></div><div style="auto;text-align:left" id="win_mid" class="win_mid"><div style="padding:2px;background:#FEFEE2;color:#7F7F7F">2013-07-16</div></div></div>';
            
            el.html(html);
        }
        /*
        * t:日期 ；data以日期作为key；arrs数组 每个值为data对应的key
        */
        this.province_select=function(t, data, arrs){
            var me=this;
            
            var el=$('.dragger');
            if(arrs[el.attr('_value')]==t){
                me.float_date();                
            }

            $.each(data[t], function (i, item) {
            
                var n=item.per,
                    color=me.color_set(n);
                var anim = Raphael.animation({ fill: color, stroke: "#eee" }, 100);
                mapvetor[item.AreaName]['path'].stop().animate(anim.delay(0));

            });
        },
        
        //地图播放动画部分
        this.click_animate=function(){
            var me=this;
            var data=opts.animate_data.data;
            
            var arrs = [],arr_number = [],j=0;
            $.map(data,function(val,i){
                arrs.push(i);
                arr_number.push(j);
                j++;
            });

            var ifplay = 0,arr = arr_number;

            //点击播放按钮
            $("#play").click(function(e){

                var arr=arr_number,i=0;                  
                $.each(arr,function(key,val){
                    //起始距离
                    if(i>$('.dragger').attr('_value') || !$('.dragger').attr('_value')){
                        var left=(val)*(opts.animate_bar/(arr.length-1));
                        var ladd=opts.animate_bar/arr.length;
                        
                        
                        
                        if(ifplay%2==1){    
                            $("#play").attr("src",'images/pause.png');
                            $('.dragger').animate({'left':(left-5)+"px"},1000,'linear',function(e){
                                $(this).attr('_value',val);
                                $(".output").html(arrs[val]);
                                me.province_select(arrs[key], data, arrs);
                                $("#win_mid").text(arrs[key]);
                            });
                            $(".highlight-track").animate({'width':(left-5)+"px"},1000,'linear');
                        }else{              
                            animatedate=$("#win_mid").text();
                            $("#play").attr("src",'images/play.png');
                            $('.dragger').stop();
                            $('.highlight-track').stop();
                            $(".float_div").stop();
                        }
                    }
                    
                    i++;
                })
                    
                ifplay++;
                    
            });
            
            //初始化及拖拽轴线    
            $("[data-slider]").bind("slider:ready slider:changed", function (event, datas) {
                    
                    $(".slider").css({'width':opts.animate_bar+'px'});
                    animatedate=arrs[datas.value];
                      
                    me.float_date();        
                
                    $(this)
                    $('.dragger').attr('_value',datas.value);
                    var left=$('.dragger').css('left').split('px');
                    $("#win_mid").text(arrs[datas.value]);
                    var obj=arrs[datas.value];                      
                    $.each(data[arrs[datas.value]], function (i, item) {
                        var n=item.per,
                        color=me.color_set(n);
                        var anim = Raphael.animation({ fill: color, stroke: "#eee" }, 100);
                        mapvetor[item.AreaName]['path'].stop().animate(anim.delay(0));
                    });
                    ifplay=1;
                    $("#play").attr("src",'images/play.png')
            });
        }
       
        if(!$('#RmapTool').length)this.init_html();
        this.init();
        return this;
    }
//})(jQuery,window,document);  
/**
 * 地图省份数据
 * @param {} R
 * @param {} attr
 * @return {}
 */
$.fn.Rmap.makepath =function (R,attr) {
    return {
        "1,002," : {
            "path" : R.path("M70.73,377.98l3.34,-0.37l1.23,-0.9l-0.15,1.09l0.54,1.5l2.17,1.89l0.91,0.18l2.08,-0.52l0.72,-1.76l2.47,-0.23l2.74,-2.56l0.39,-1.91l-1.33,-2.43l-1.11,-1.09l0.7,-2.71l-0.27,-0.93l-4.22,-1.03l-0.44,-0.81l-1.2,-0.5l-2.45,-2.91l-0.17,-5.06l-0.96,-3.09l0.11,-1.12l3.51,-2.22l0.31,-1.01l-0.29,-1.11l0.78,-0.58l2.38,-0.88l1.94,0.15l2.08,-0.67l3.56,1.0l1.28,-0.45l2.56,-4.65l-0.03,-1.0l-1.12,-2.57l2.26,-1.18l0.14,-0.89l-0.45,-0.8l2.34,-2.68l1.25,-2.81l0.02,-1.44l2.8,1.91l2.73,0.39l1.36,0.63l1.66,0.0l1.59,0.85l1.13,-0.27l0.26,-1.33l2.01,1.2l3.01,-0.16l2.88,1.5l6.04,-1.44l1.03,-1.98l3.26,-1.84l0.52,-1.59l1.2,-0.69l4.18,0.63l1.72,-0.7l1.62,0.44l0.16,2.69l2.42,1.65l1.67,-0.29l5.72,1.08l3.8,-0.26l2.19,-0.73l2.28,0.69l5.86,-3.09l3.17,-0.7l2.15,-1.48l3.2,-0.97l1.71,0.33l2.43,-0.38l2.06,1.61l2.42,-1.87l3.26,0.04l2.16,-1.99l1.84,-4.03l2.77,-0.88l0.85,-0.8l2.69,0.07l1.94,-0.69l5.76,-0.68l2.46,-1.23l3.26,0.68l4.68,-0.6l1.6,-0.99l6.66,-0.35l3.68,1.35l1.86,-0.06l2.15,1.61l3.51,0.21l5.38,2.46l-1.46,0.48l-0.99,0.93l0.5,2.13l1.83,1.11l2.84,0.09l-1.11,2.67l0.08,1.39l-0.47,0.82l0.75,0.96l-3.59,1.64l-0.63,2.29l1.74,2.7l0.02,2.19l0.91,0.4l2.34,0.04l0.42,1.01l-1.59,2.08l1.11,2.86l0.07,2.42l0.72,0.67l-0.82,2.56l-1.78,0.99l-0.46,1.33l1.63,2.88l2.11,1.56l0.03,0.83l0.91,0.74l0.43,1.53l2.65,1.07l0.55,0.88l0.09,1.69l1.69,1.97l1.77,0.13l3.43,2.15l1.86,0.31l1.17,-0.3l1.45,-1.34l2.79,-0.32l0.63,-1.27l2.45,-0.02l0.02,0.91l2.57,3.26l2.67,1.64l1.28,0.19l2.51,2.01l2.0,-0.62l0.99,0.18l0.09,1.59l0.46,0.52l2.44,-0.37l4.0,0.49l1.2,-0.31l1.79,0.5l1.97,-0.22l0.62,1.36l2.43,-0.13l2.33,1.56l1.1,0.05l0.94,0.89l1.75,-0.83l1.84,-0.11l0.77,0.2l0.93,0.98l3.87,0.36l1.18,-0.75l2.06,-0.32l0.66,-1.02l0.66,0.22l2.72,-1.33l1.97,2.19l2.45,1.26l0.68,2.26l1.8,1.15l2.7,0.19l0.65,0.88l1.12,0.34l0.12,1.9l-0.69,0.42l-0.17,0.84l0.81,2.46l1.25,1.14l3.63,0.1l0.9,0.84l4.27,-0.25l1.12,2.42l0.65,0.44l1.07,-0.76l-0.01,-2.07l-0.34,-1.02l-0.97,-0.99l0.61,-0.86l1.02,-0.37l2.54,2.38l2.8,0.6l1.29,0.74l0.94,-0.26l0.4,-1.17l-0.68,-1.31l0.58,-1.27l-0.53,-0.73l3.31,-0.82l2.11,0.14l0.83,-0.87l0.98,-0.23l0.47,-0.85l-0.46,-0.69l0.4,-1.42l1.28,-0.09l0.44,-0.63l0.06,-1.76l-0.91,-0.57l0.39,-0.89l2.67,0.34l1.07,0.62l1.38,-1.51l3.94,1.16l1.06,1.0l1.63,0.68l0.22,1.67l3.36,4.29l-0.47,1.7l0.26,1.28l1.83,2.12l0.51,1.28l4.04,3.79l-1.07,1.36l-1.07,-1.11l-0.99,-0.03l-0.56,0.67l-0.18,1.79l0.11,0.6l1.18,0.63l1.56,2.12l-0.19,1.78l2.48,2.28l-0.79,1.04l0.41,2.86l0.41,0.52l0.38,5.04l0.7,1.47l0.28,2.16l-0.68,1.44l-0.3,2.83l0.81,1.57l0.3,3.95l0.52,1.06l-1.35,0.28l-0.43,0.54l0.45,2.28l-1.06,0.81l-0.42,1.19l0.62,1.06l-0.74,0.33l-1.17,-3.01l-2.53,0.83l-0.13,1.51l0.58,2.0l-1.3,1.25l0.8,3.66l-0.92,1.8l-1.58,1.2l-2.01,-1.91l-0.53,0.22l-0.71,2.05l-1.59,0.96l-1.49,-0.97l-0.09,-0.83l-1.52,-1.45l-1.86,0.07l-1.37,-2.49l-1.11,0.3l-0.76,-0.77l-0.87,0.34l-1.13,2.16l-0.03,1.46l-0.69,0.04l-0.92,0.93l-2.82,-2.24l-0.8,-0.12l-1.5,0.67l-2.6,-0.48l-2.33,-1.6l-3.01,0.76l-0.75,0.88l-1.15,-0.41l0.95,-0.89l-0.19,-0.99l1.55,-1.05l0.37,-1.13l1.59,-0.77l0.47,-0.84l-2.0,-3.52l0.45,-1.2l-0.38,-0.48l-2.72,0.72l-2.12,1.79l0.35,-0.83l-0.48,-1.23l1.04,-0.97l1.83,-0.63l0.71,-1.55l-0.66,-0.71l-1.3,0.57l-0.55,-0.16l-0.88,-1.72l-1.46,-1.61l-3.4,1.22l-4.33,2.38l-0.73,0.7l0.09,0.91l-0.65,0.17l-0.83,1.45l-2.27,-0.39l-0.46,-0.56l-3.54,-1.17l-0.52,0.32l-2.08,-0.33l-0.01,-0.57l-1.05,-1.26l-1.8,-0.58l-1.41,1.58l-1.72,0.22l-0.93,0.93l-1.37,0.38l-1.95,2.49l-1.24,-0.09l-0.45,0.69l0.32,1.22l-1.48,0.41l-2.84,2.14l-6.0,0.55l-1.6,0.58l-1.44,3.88l-3.83,3.08l-0.97,-0.11l-1.57,1.06l-0.75,1.33l0.28,0.56l0.64,0.15l-0.16,0.75l-3.33,2.01l-0.55,-0.46l-1.48,0.85l-0.75,-0.99l-0.46,0.18l-0.19,0.73l-1.6,-0.02l-1.86,1.31l-4.57,-0.54l0.32,-2.02l-0.38,-0.76l-3.31,-0.92l-1.69,-1.35l-2.0,0.19l-1.89,1.63l-1.98,-1.1l-3.56,-0.92l-4.08,0.35l-0.58,-0.19l0.65,-1.68l-0.65,-1.01l-5.44,-1.14l-1.06,0.5l-0.93,-0.07l-1.68,1.82l-2.52,0.61l-1.83,1.58l-1.82,2.85l-2.04,1.44l-1.65,3.73l-1.94,1.11l-0.83,2.17l-1.19,-1.06l-0.41,-1.87l0.94,-1.73l0.71,-3.0l-0.63,-1.55l0.11,-0.99l-1.39,-1.26l-2.04,-0.87l-3.57,1.98l-3.85,0.56l-0.55,1.03l-3.51,-0.43l-1.65,1.6l-1.16,-0.25l-0.83,0.29l-0.82,-0.5l-1.76,0.41l-0.56,-0.69l-1.25,0.58l-1.82,-0.12l-2.11,-1.95l-1.44,0.05l-0.95,-1.03l-1.42,-0.11l-0.16,-0.86l-1.0,-0.56l-0.99,0.38l-1.21,-0.21l-0.68,2.47l-0.83,0.47l-3.03,-1.36l-0.19,-1.96l-0.73,-0.59l-1.76,1.72l0.57,2.22l-1.42,0.37l-0.06,-1.25l-0.83,-0.92l-0.5,-1.65l-1.98,-1.4l-0.51,-1.62l-0.67,-0.27l-1.06,1.19l-2.53,-0.63l-1.07,0.59l-3.67,-0.58l-0.04,-1.7l1.04,-1.33l0.26,-1.06l-0.38,-0.65l-1.76,-0.71l-1.97,1.62l-1.42,-0.08l-1.65,-0.86l-0.11,-0.8l-1.03,-0.72l-2.37,-0.63l-1.25,-1.93l-1.9,-0.68l-0.02,-1.96l-1.35,-1.59l0.29,-1.2l-1.33,-1.05l-2.64,-0.52l-1.84,0.88l-1.45,0.15l-0.77,1.12l-1.37,-0.38l-0.23,-1.12l-1.61,-1.55l-0.63,-1.74l-0.76,-0.5l-0.64,0.13l-0.05,-1.07l-1.27,-1.18l-1.02,-0.1l-0.8,0.45l-1.07,-1.02l-1.22,-0.45l-0.94,0.34l-1.97,-1.73l-0.13,-0.83l-0.98,-0.15l-1.2,-1.39l-3.38,-1.79l-2.3,-0.41l-0.2,-0.6l0.4,-0.92l-1.04,-1.01l0.12,-1.33l-0.5,-0.62l-1.55,0.09l-2.05,-0.68l-0.89,0.2l-2.5,-0.94l-1.29,0.68l-0.34,0.72l-0.93,-0.66l-0.83,-0.03l-0.79,3.68l-1.1,0.39l-0.08,0.93l-0.69,0.93l-1.34,-0.23l-1.77,-3.75l-2.84,-1.05l-0.82,-1.12l-1.92,-1.13l-1.33,-0.06l-2.73,-1.37l-1.57,-0.34l-0.28,-1.08l0.69,-1.31l-1.19,-1.21l-1.37,0.13l-3.53,-2.92l-1.58,-0.29l-2.24,0.63l-1.34,-1.17l-1.01,-0.17l-0.37,-0.98l-1.32,-0.72l-1.28,-3.14l-1.9,-1.7l-1.47,0.23l-0.39,1.28l-0.5,-0.33l-1.1,0.99l-1.28,-0.12l0.32,-1.96l-0.91,-0.9l1.71,-1.63l-0.44,-0.85l-1.04,-0.64l-0.64,-1.42l1.01,-3.2l-4.17,-4.45l-0.11,-2.89l-1.01,-1.76Z").attr(attr),
            "name" : "西藏",
            "xy":[222.6,387.3]
        },
        "1,026," : {
            "path" : R.path("M441.71,465.83l1.34,-0.99l3.19,-3.75l0.6,-0.06l2.97,2.04l1.31,-0.59l0.16,-0.97l1.18,-1.14l1.05,1.41l1.09,0.51l4.21,-0.18l1.19,0.38l3.04,-1.64l2.07,0.11l1.51,-5.04l0.87,-0.67l1.92,-0.23l2.04,1.6l3.88,-1.21l1.96,-0.04l0.87,-0.49l1.89,0.3l1.0,-0.48l1.07,-0.98l-0.77,-2.86l-1.27,-0.94l-0.14,-0.92l-0.72,-0.69l-1.03,-0.37l-1.5,0.55l-1.46,-0.19l-0.31,-1.61l-3.0,-1.01l0.04,-1.63l-0.46,-0.74l0.74,-1.21l2.96,-0.35l1.13,-2.18l2.72,2.45l1.52,0.67l0.15,0.95l0.72,0.35l1.18,-1.45l0.9,0.39l0.7,-0.38l-0.07,-1.02l0.57,-1.36l-0.76,-1.61l1.51,2.25l-1.05,2.19l3.03,0.79l0.59,-0.53l0.06,-1.18l0.75,-0.11l0.48,-0.66l0.12,-2.28l0.65,-0.45l0.94,0.17l0.79,-1.38l1.29,-0.23l2.22,1.52l2.89,-1.43l0.88,-2.04l-1.21,-1.72l0.7,-1.84l1.13,1.02l1.63,0.59l1.15,-0.11l0.08,1.5l1.11,1.15l3.23,-1.28l3.04,-0.15l1.21,4.02l-0.76,0.75l0.13,1.13l3.7,1.4l-0.08,3.18l0.66,1.28l0.97,0.22l0.63,-0.39l-0.48,-2.06l0.55,-0.11l0.69,0.63l-0.81,2.87l0.44,0.78l0.85,-0.25l4.58,0.54l1.2,-4.05l0.6,-0.59l0.24,2.39l1.37,1.07l-0.94,2.72l0.59,0.87l-0.36,0.85l0.28,2.66l1.25,1.27l0.43,1.94l-1.65,1.23l-0.63,0.98l-0.9,-0.15l-1.24,0.65l-1.73,2.31l-1.71,1.19l-0.17,0.94l-1.3,0.35l-0.29,0.63l1.97,1.62l0.99,-0.32l0.67,-0.93l1.1,-0.59l0.35,0.6l0.68,0.15l1.21,-1.05l2.41,-0.05l1.17,1.21l-0.01,1.17l-0.9,1.18l0.32,0.61l0.8,0.18l-3.5,2.08l0.32,0.76l1.02,0.44l0.52,0.8l-0.25,1.03l-1.08,1.37l-0.38,1.57l0.46,1.04l1.0,0.34l0.86,3.2l-0.85,0.8l0.13,1.11l-1.43,2.65l-0.43,-0.03l-0.85,-1.13l-0.64,0.07l-0.13,0.74l-0.26,-0.65l-0.59,-0.17l-2.05,0.51l-1.32,1.17l-0.2,0.98l0.5,0.54l2.05,-0.95l0.09,2.1l-0.29,0.22l-0.86,-0.57l-2.06,0.4l-0.24,-1.16l-0.95,-0.19l-1.16,0.71l-0.29,1.15l-0.83,0.49l-0.33,0.81l-1.54,-1.51l-2.03,-0.52l-2.7,2.46l-0.32,2.4l-2.22,0.41l-1.12,0.87l-0.99,-0.02l-0.67,-1.22l-0.73,0.16l-0.69,-1.48l-2.36,1.48l0.15,-0.73l-0.88,-0.53l-0.35,-1.27l-1.17,-0.49l0.2,-0.65l-0.37,-0.65l-1.54,-1.09l-0.95,0.53l-1.45,0.06l-1.56,1.42l-0.07,0.87l0.56,0.89l-0.22,1.14l-1.12,0.03l-0.37,0.8l-3.09,0.34l-3.22,2.19l-4.38,1.17l-0.2,0.58l0.58,1.75l-2.31,2.56l-1.35,-1.28l-1.66,0.31l-1.76,-1.21l-2.52,-0.48l-1.06,-1.76l-1.07,-0.44l-1.32,0.34l-1.31,-1.14l-1.74,1.0l-0.82,1.02l-0.39,1.35l-1.83,0.53l-0.69,1.07l-1.42,0.78l-2.35,-1.58l0.05,-0.65l2.25,-2.82l-0.16,-1.54l0.43,-1.67l0.79,-0.23l0.23,-0.84l-1.77,-0.77l-1.51,-1.37l-0.43,-1.95l-1.49,0.05l-0.14,-1.08l-1.68,-1.11l-0.08,-1.15l0.72,0.07l0.47,-0.47l0.54,-1.54l-0.32,-1.24l1.4,-1.3l0.71,-3.82l1.97,-1.87l-0.73,-1.97l-1.14,-1.62l-1.2,-0.2l-0.51,-1.57l-0.61,-0.43l-0.62,0.15l-0.8,1.24l-3.14,-0.15l-1.33,1.97l-2.58,-0.45l-0.86,-0.98l0.24,-1.71l-0.67,-0.4l-0.2,-0.82l0.88,-0.79l0.03,-1.52l-1.21,-1.71l-1.15,0.34l-0.29,-0.36Z").attr(attr),
            "name" : "贵州",
            "xy":[484.8,467.6]
        },
        "1,019," : {
            "path" : R.path("M621.87,495.6l1.92,-2.2l0.4,-2.63l0.65,-1.23l-0.25,-0.95l1.19,-1.75l0.75,-0.44l-0.39,-1.33l2.8,-1.43l1.38,-2.82l-0.28,-2.4l1.37,-1.69l0.86,0.48l0.7,-0.63l0.34,-1.79l-1.14,-1.04l-0.53,-1.91l0.58,-2.66l1.56,-1.55l3.79,-0.62l1.8,-1.45l1.85,-3.0l-0.84,-1.41l0.38,-0.98l-0.23,-1.99l2.6,-3.34l0.01,-1.14l0.76,-0.13l2.31,-1.64l1.12,1.76l2.3,0.77l0.78,-0.72l0.31,-1.23l3.62,-0.7l1.05,-1.0l3.43,-0.85l0.42,-1.67l-0.43,-0.6l0.65,-0.53l1.37,0.18l1.15,-0.58l0.59,0.23l1.3,-0.45l0.74,0.96l-0.5,0.6l0.29,0.77l-0.5,0.78l-0.04,1.91l1.11,1.2l0.98,2.9l0.46,2.6l-0.56,0.69l0.54,0.74l5.42,1.05l1.82,-1.41l1.46,-0.34l1.14,-2.3l0.49,0.09l-0.09,0.84l1.06,1.41l0.05,1.48l1.33,1.81l2.72,-0.09l0.72,-0.53l1.11,0.27l2.22,-1.13l1.75,0.52l0.61,0.88l0.16,0.63l-0.8,-0.2l0.1,-0.64l-0.87,-0.51l-1.61,0.63l-0.17,1.62l0.61,0.2l0.71,-0.56l1.16,0.44l0.34,1.16l-1.58,-0.51l-0.37,0.52l0.29,0.55l-0.71,0.74l0.4,0.51l-1.39,0.37l0.36,0.53l-0.85,0.64l-0.84,-0.18l-0.39,0.31l0.06,1.42l-1.34,-0.01l-0.73,1.72l-0.66,-0.46l0.67,-1.63l-0.4,-0.59l-0.92,0.26l-0.57,0.79l-0.99,-0.41l-0.38,0.78l-0.62,-0.55l-0.71,0.22l-0.52,1.06l0.08,2.13l1.05,0.96l1.12,-0.69l0.66,0.06l1.01,1.99l-0.24,0.21l-1.56,-1.17l-1.78,0.7l0.31,0.99l0.88,-0.03l0.07,1.14l0.58,0.58l-0.82,0.51l0.14,0.62l-2.6,3.54l-4.9,-2.47l-0.72,0.32l0.82,1.02l0.77,0.19l1.13,2.06l2.45,0.2l1.38,-0.83l0.25,-0.65l2.15,0.52l-0.41,0.84l-1.52,0.77l0.64,1.98l-0.29,0.64l-0.64,-0.21l-1.47,0.8l0.53,1.79l0.74,0.53l0.49,-0.15l0.09,0.89l-0.37,0.21l-0.98,-0.92l-1.08,-0.2l0.25,-1.02l-1.29,-0.41l-0.88,0.86l-0.52,1.28l-1.86,0.87l-0.19,0.54l1.26,1.57l0.29,1.08l0.48,0.02l0.85,-0.85l0.31,0.42l-0.65,0.28l0.05,0.73l-1.19,-0.03l-0.42,-1.06l-0.87,0.58l-0.28,-1.05l-1.35,-0.1l-1.7,0.67l-0.09,0.94l1.16,0.59l-0.17,0.61l-0.97,-0.04l-0.5,0.89l1.68,1.44l-0.7,0.22l-0.13,0.83l-1.45,-0.0l-0.36,0.35l-0.65,-1.07l-1.03,-0.06l-0.27,1.09l-1.11,-0.07l1.02,2.25l1.08,-0.18l0.53,0.35l-0.64,0.65l-0.95,0.12l-0.21,1.03l0.38,0.52l-0.56,0.55l-0.13,-0.48l-1.83,-0.92l-0.06,-0.9l-0.64,-0.18l-0.44,0.42l0.04,1.04l-1.35,0.07l-0.94,0.56l0.17,-0.48l-0.91,-1.48l-0.69,0.24l-0.5,1.14l-0.65,-0.29l-1.49,1.11l-0.02,0.56l0.83,0.34l-0.45,0.48l-1.53,-0.52l-1.29,0.34l-0.18,0.81l1.23,1.0l2.25,0.02l-0.07,1.12l0.92,-0.3l0.37,0.63l-1.28,0.86l-1.08,-0.14l-0.63,0.47l0.26,0.74l-0.59,1.54l-0.79,0.37l-0.76,-0.93l-0.53,0.55l-1.11,-0.37l0.15,1.77l-0.87,0.99l-0.83,-0.58l-2.24,-0.27l-0.16,0.79l1.1,0.5l-0.52,1.1l-2.31,0.03l-0.42,1.4l-0.85,0.89l-1.72,-1.39l-1.62,-5.17l0.56,-2.06l-1.19,-2.98l-1.0,-1.52l-0.97,-0.69l0.23,-2.14l-2.03,-0.2l-1.88,0.83l-2.06,-3.48l-1.47,0.43l-0.4,-0.48l-2.15,-0.09l-1.03,-0.72l-2.08,-0.36l0.2,-1.05l-0.66,-2.7ZM656.51,505.04l-0.03,0.12l-0.1,-0.07l0.06,-0.01l0.07,-0.04ZM676.96,491.97l0.08,0.14l0.0,0.09l-0.06,-0.17l-0.03,-0.06ZM679.3,477.67l0.05,-0.35l0.62,-0.75l0.31,0.62l-0.98,0.49ZM683.74,471.1l0.07,1.15l-1.2,0.46l0.36,-0.85l0.77,-0.76ZM681.39,473.34l-0.07,0.36l-0.54,0.39l0.11,-0.59l0.5,-0.17ZM678.82,490.95l0.22,0.01l0.41,-0.12l-0.74,0.75l0.11,-0.63ZM679.47,489.86l-0.5,-0.11l-0.09,-1.06l0.85,0.62l-0.26,0.55ZM676.67,481.19l0.06,-0.02l0.05,0.06l-0.11,-0.04ZM654.76,506.12l0.81,0.04l-0.41,0.81l0.02,-0.53l-0.42,-0.32ZM644.18,518.52l0.17,-0.48l0.78,0.26l-0.12,0.58l-0.83,-0.36ZM644.13,519.99l0.03,0.14l-0.2,0.02l0.17,-0.16Z").attr(attr),
            "name" : "福建",
            "xy":[655,483]
        },
        "1,031," : {
            "path" : R.path("M466.93,427.37l-0.32,-1.45l1.39,-1.6l2.25,-0.64l0.34,-1.36l2.31,-1.15l0.39,-2.67l-2.8,-2.06l1.36,-0.63l-0.11,-0.85l1.29,-0.16l0.03,-0.89l0.96,-1.49l4.31,1.49l1.82,2.01l1.11,-0.69l1.47,-0.11l0.55,-0.86l1.28,-0.09l0.84,0.73l1.34,3.19l0.91,0.72l4.12,-0.23l0.63,-0.35l2.74,-2.85l2.08,-4.16l1.54,-1.76l0.22,-0.95l-0.54,-1.26l0.3,-0.7l0.64,-0.6l1.69,-0.05l0.95,-0.67l0.74,1.15l0.9,0.19l1.68,-1.28l0.47,-0.95l-0.27,-0.64l1.06,-1.31l0.46,-2.99l1.95,-1.19l0.8,-2.8l1.76,-0.6l2.51,-3.25l-0.01,-1.19l-0.59,-0.89l-3.14,-2.04l1.12,-1.67l1.17,-0.49l-0.67,-1.24l1.71,-0.19l3.89,2.44l3.89,1.7l1.64,1.3l2.01,2.47l5.17,-0.18l0.82,1.13l0.28,1.43l3.18,0.82l2.25,1.74l0.51,0.97l-0.08,1.31l0.48,0.76l-0.98,1.1l0.43,2.03l-0.14,1.48l-0.56,0.91l-0.94,0.05l-1.11,-1.03l-0.96,0.08l-2.13,1.1l-2.49,2.66l-0.78,0.0l-1.74,1.19l-1.6,-0.35l-1.64,0.64l-1.06,-0.6l-1.78,-0.12l-1.38,0.88l-1.97,0.52l-0.64,-0.76l-0.63,-0.09l-1.0,1.15l-2.38,0.31l-0.9,1.59l0.2,0.8l2.02,0.9l0.14,0.41l-0.09,6.37l-1.91,0.52l0.56,1.96l0.72,0.48l0.89,-0.04l1.35,-2.06l0.81,2.37l2.79,1.15l-0.3,2.09l0.76,1.31l0.02,1.01l1.46,0.77l0.91,1.48l2.86,2.61l-0.59,2.43l0.54,2.46l-0.94,1.65l1.02,0.76l-0.31,0.82l-1.52,1.24l-1.02,2.81l0.1,0.79l-4.52,-0.53l0.73,-2.72l-1.31,-1.33l-1.5,0.48l0.39,2.05l-0.35,-0.12l-0.34,-4.24l-0.65,-0.69l-3.03,-0.74l0.78,-1.39l-1.44,-4.81l-3.82,0.19l-2.78,1.29l-0.61,-0.7l-0.39,-1.89l-1.57,-0.01l-1.73,-0.69l-0.68,-0.85l-0.64,-0.02l-0.79,0.75l-0.43,1.22l0.22,1.43l0.98,0.88l-0.66,1.54l-2.27,1.16l-1.99,-1.48l-1.99,0.33l-0.74,1.28l-0.76,-0.19l-1.11,0.79l-0.18,2.41l-1.08,0.47l-0.52,1.55l-1.5,-0.6l0.76,-1.79l-0.9,-1.85l-1.16,-1.19l-0.73,-0.17l-0.41,0.45l0.86,2.35l-0.5,1.85l-0.93,-0.45l-1.11,-1.44l-0.87,-3.53l-3.8,-1.5l-2.05,0.91l-0.77,-0.21l-0.69,-0.97l-0.55,-4.7l-0.61,-0.3l-0.64,0.5l-1.9,-0.3l-1.11,-0.61l-0.23,-1.53l-1.25,-0.58Z").attr(attr),
            "name" : "重庆",
            "xy":[502,415]
        },
        "1,004," : {
            "path" : R.path("M349.99,371.94l2.0,-1.66l-0.11,-2.86l1.73,-2.25l1.16,-0.39l0.73,-0.92l-0.46,-0.62l-2.89,-0.88l-0.56,-1.56l-1.24,-0.76l-0.2,-3.72l3.33,-1.03l0.52,-1.14l0.67,0.53l0.16,1.49l0.42,0.39l2.02,-0.39l2.13,-1.26l2.59,0.32l0.88,1.42l2.25,-0.07l3.04,2.85l-0.29,0.95l1.59,2.09l0.55,3.24l1.58,2.33l4.81,2.33l1.41,2.18l3.44,0.92l2.66,1.44l0.73,-0.21l0.67,-2.81l0.9,-0.43l0.39,-0.78l1.03,0.98l1.09,-0.03l1.49,1.62l0.12,1.1l-0.56,1.27l0.49,0.82l1.49,0.25l0.68,-1.55l1.81,-0.36l1.05,1.01l0.93,1.72l-1.12,0.93l-0.2,0.91l1.07,1.09l0.55,-0.07l1.12,-0.9l1.15,-3.5l3.12,0.9l4.03,-1.18l1.05,-2.34l-0.25,-1.12l-1.37,-1.21l0.7,-2.88l1.88,-0.73l0.82,0.36l0.83,-0.91l2.23,1.87l0.98,-0.17l1.38,-2.55l-0.95,-1.15l0.08,-0.7l1.36,-1.33l0.43,-1.87l0.65,0.61l0.54,1.68l-1.45,2.88l0.62,2.56l0.57,-0.05l1.77,-1.46l1.66,-0.15l0.74,-1.37l1.29,-0.36l0.78,-0.97l2.62,-1.25l0.23,-1.97l-2.13,-1.62l0.19,-1.33l-2.25,-3.28l1.08,-0.36l1.25,0.16l1.45,-1.61l2.56,-0.31l0.31,-0.82l-0.78,-0.49l2.45,-1.7l1.94,-0.47l1.24,1.47l1.79,0.83l0.07,3.5l0.67,0.78l-0.06,1.22l0.76,0.69l2.61,0.48l1.93,-0.85l-0.41,1.02l0.44,0.67l1.71,-0.11l1.76,0.68l2.28,-0.17l3.06,0.57l0.43,2.44l2.32,2.44l-0.78,0.61l0.09,1.37l1.84,2.76l-0.3,0.94l-1.45,0.74l-0.18,1.45l0.69,0.69l1.35,0.34l2.62,2.17l3.66,0.56l1.1,0.53l2.13,-0.43l0.54,0.59l0.87,0.04l1.02,-1.05l1.13,0.31l2.46,-1.67l0.19,-0.93l-0.88,-1.14l1.04,-0.81l1.15,3.14l0.87,0.45l1.8,-0.95l1.36,-0.03l0.92,-1.39l2.75,-0.43l-0.66,1.38l0.12,1.24l0.91,1.0l1.88,0.99l2.27,-0.84l3.67,-0.62l1.45,-1.01l1.6,0.41l2.87,-0.02l0.53,0.54l-0.42,2.15l0.36,0.61l2.82,1.19l2.38,-1.49l0.46,2.05l2.85,0.29l2.8,2.73l2.02,1.24l0.72,-0.1l0.26,-0.95l0.49,-0.3l1.87,-0.09l0.76,-0.44l3.13,0.16l-1.75,0.71l-0.09,0.58l0.66,0.76l-0.91,0.31l-1.3,2.25l0.33,0.59l3.04,1.94l0.48,1.09l-2.35,3.08l-1.85,0.69l-0.76,2.76l-2.12,1.35l-0.47,3.15l-1.06,1.27l0.0,1.28l-1.41,1.08l-0.91,-1.3l-0.61,-0.14l-0.99,0.77l-1.77,0.08l-0.98,0.84l-0.48,1.16l0.42,1.87l-1.53,1.75l-2.08,4.15l-2.74,2.81l-4.05,0.17l-1.54,-3.42l-1.33,-1.32l-0.81,0.41l-0.95,-0.12l-0.6,0.88l-1.43,0.1l-0.63,0.58l-1.63,-1.83l-4.74,-1.6l-0.72,0.42l-0.96,2.2l-1.31,0.1l0.05,1.07l-1.31,0.74l0.32,1.05l2.5,1.66l-0.51,0.86l0.08,1.15l-1.93,0.74l-0.53,1.41l-2.0,0.54l-1.24,1.22l-0.65,1.1l0.19,1.4l0.42,0.69l1.19,0.51l0.39,1.65l1.39,0.73l2.55,0.22l0.59,4.15l0.93,1.25l1.36,0.37l1.87,-0.9l3.37,1.33l0.4,2.74l1.46,2.12l-0.41,0.85l-0.46,-0.99l-1.46,-0.62l-2.85,-2.58l-0.58,-0.1l-1.33,2.37l-2.23,0.0l-0.96,0.58l-0.95,1.69l0.54,0.82l-0.05,1.74l0.77,0.67l2.53,0.75l-0.02,1.1l0.53,0.63l1.85,0.23l1.43,-0.54l0.71,0.34l0.49,1.32l1.25,0.91l0.62,2.29l-1.36,0.8l-2.0,-0.29l-6.52,1.72l-0.5,-0.71l-1.87,-0.96l-1.89,0.36l-0.67,0.6l-0.81,-1.76l0.65,-1.05l0.03,-1.49l-1.28,-0.1l-0.4,-0.91l-1.97,-0.49l-1.49,0.63l-0.32,1.88l-0.79,0.58l-2.62,0.18l-1.52,0.56l-1.45,-0.63l-2.05,-1.82l1.58,-0.78l-0.47,-1.86l0.27,-0.55l-0.82,-1.17l-1.54,-0.81l-0.2,-2.73l2.55,-0.95l0.19,-0.94l-1.15,-0.48l-1.26,0.23l-0.68,-0.48l-2.42,0.77l-0.67,-0.32l-1.23,0.3l-1.54,-0.93l-1.26,2.77l1.13,3.06l-1.91,1.36l-0.94,-0.75l-1.33,0.44l-1.74,1.77l-0.43,1.89l0.78,0.37l0.41,0.89l-0.99,2.88l-2.39,1.87l0.1,0.86l-1.13,0.36l-1.3,2.33l-1.68,0.38l-0.9,-0.39l-1.02,2.15l0.36,2.64l-0.55,1.59l0.35,1.8l1.11,1.57l1.19,4.29l-0.89,0.87l-0.05,1.79l-1.62,0.0l-2.54,2.1l-0.67,-0.45l0.03,-1.49l-1.21,-0.49l-4.66,2.37l-2.16,2.26l-2.62,-0.24l-0.86,0.89l-0.77,-0.58l-0.42,-1.5l-1.61,-0.94l-0.91,0.38l-0.04,-0.89l0.91,-0.66l0.07,-0.72l-1.58,-2.15l-1.79,-0.97l1.19,-1.92l0.04,-1.43l-0.97,-0.34l-0.65,0.85l-0.64,-1.97l-2.87,-2.55l0.19,-2.71l-1.34,-0.28l-0.97,0.43l-0.43,-2.89l-1.58,-1.79l0.01,-1.21l-3.11,-4.97l-1.01,-0.51l-1.15,1.25l-1.64,-0.45l-1.42,1.66l-0.27,-1.78l-1.33,-0.63l-1.86,-2.25l-0.58,-1.64l1.93,-1.02l-0.17,-1.81l-2.26,-2.14l-0.85,-1.68l-1.4,-0.64l-0.29,-1.14l-1.35,-1.07l-0.34,-1.71l-1.98,0.62l-1.21,1.9l-0.41,1.66l-1.97,0.98l0.4,5.1l-2.81,-3.57l0.13,-2.47l-0.61,-1.15l-0.49,-2.64l0.35,-2.02l-0.18,-4.19l-0.68,-1.42l-0.3,-4.01l-0.81,-1.47l0.27,-2.58l0.73,-1.77l-0.32,-2.22l-0.69,-1.43l-0.38,-5.01l-0.43,-0.66l-0.38,-2.68l0.8,-1.06l-2.6,-2.61l0.2,-1.81l-1.67,-2.22l-0.96,-0.65l0.18,-1.75l1.85,1.33l1.82,-2.1l-0.09,-0.57l-4.25,-3.93l-0.43,-1.19l-1.78,-2.18l0.27,-2.69l-3.46,-4.5l-0.35,-1.84l-2.93,-1.83l-5.08,-1.54l-0.97,-1.04l-1.87,-0.84l-0.99,-1.27l-0.37,-2.07Z").attr(attr),
            "name" : "四川",
            "xy":[431,415]
        },
        "1,015," : {
            "path" : R.path("M695.81,401.07l2.67,-0.28l0.32,-0.69l-0.17,-1.24l0.96,-0.26l0.18,-1.73l0.57,-1.03l1.91,-0.51l5.19,3.27l2.42,4.39l0.24,1.15l-0.37,0.7l-1.85,-0.2l-3.78,0.81l-2.39,1.97l-0.76,-1.17l-1.33,-0.32l-0.73,-0.82l-1.28,0.38l-0.15,-2.75l-1.11,-0.45l-0.53,-1.25ZM709.59,397.24l0.33,0.11l-0.12,0.39l-0.09,-0.17l-0.12,-0.32ZM700.86,390.08l1.36,-0.1l1.61,0.83l0.44,1.2l2.48,1.45l2.89,0.91l0.01,0.5l-0.62,0.22l-3.62,-1.26l-3.14,-1.88l-1.42,-1.89Z").attr(attr),
            "name" : "上海",
            "xy":[722,398]
        },
        "1,006," : {
            "path" : R.path("M629.83,342.14l1.13,-2.91l4.96,-0.86l1.76,1.5l3.36,6.85l1.13,-0.18l0.25,-1.34l1.03,-0.71l1.71,1.75l1.93,0.25l1.3,-1.1l1.67,0.06l0.43,-2.23l1.63,-0.26l1.94,0.5l0.19,1.07l0.79,0.48l-0.28,0.77l0.8,1.8l2.74,-0.31l1.32,-1.14l0.71,-3.33l1.42,-0.35l1.59,0.41l1.17,-0.9l1.49,-3.55l0.21,-1.47l3.01,-0.19l1.47,-0.93l0.42,-0.06l-0.48,0.48l-0.13,2.1l-0.55,1.12l0.6,2.79l0.68,0.03l0.31,-0.67l1.55,-0.19l1.17,0.39l0.11,0.94l2.86,2.55l1.28,0.21l1.43,0.89l1.7,0.22l4.45,2.28l1.12,2.49l0.99,4.83l1.48,2.05l-0.2,1.62l2.14,2.91l0.47,2.3l1.03,0.91l0.02,1.24l0.92,0.84l0.35,1.82l0.99,0.29l0.18,2.94l-0.8,0.68l-0.29,2.25l1.8,1.37l2.07,0.8l0.47,0.7l2.37,0.47l1.65,1.13l0.22,1.76l-0.74,0.36l0.52,1.43l0.91,1.1l1.39,-0.07l2.52,1.45l1.5,1.54l0.96,3.15l-0.52,0.22l-2.64,-0.6l-2.2,-1.44l-2.51,-0.95l-2.46,0.48l-1.21,-0.44l-1.36,0.43l-2.44,-3.01l-4.43,-1.45l-1.05,0.26l-2.91,2.37l-2.27,-0.12l-1.28,-0.88l-1.01,-1.46l0.07,-1.55l-1.29,-1.63l-1.42,-0.56l-0.98,0.09l-0.91,-0.61l-0.74,0.39l0.99,1.04l-0.92,1.27l0.07,0.71l0.6,0.13l0.82,-0.63l0.77,0.37l0.03,1.07l1.37,0.83l0.55,1.59l4.46,1.45l3.85,-1.19l0.3,-0.78l3.21,0.43l1.17,1.64l-0.08,0.26l-0.74,-0.43l-0.23,0.41l0.36,1.04l1.88,0.96l1.94,0.13l3.67,2.33l0.86,1.2l-1.95,0.89l-0.6,1.2l-0.04,1.26l-1.05,0.47l0.1,1.67l-2.79,0.23l-0.26,0.62l0.66,1.62l-2.97,0.35l-0.36,0.53l0.4,1.02l-1.46,0.37l-1.15,1.14l-0.7,-1.81l-0.88,0.11l-0.52,-0.82l-2.13,0.29l-1.1,-0.32l-2.35,-1.95l-0.34,-1.17l-0.77,-0.55l-2.47,-0.15l-2.29,0.71l-2.89,-0.85l-0.05,-1.19l-0.63,-0.46l-1.22,0.4l-1.4,-0.41l-1.35,0.79l-3.67,0.2l-0.81,-1.29l1.25,-0.86l0.84,-2.12l-0.26,-1.95l-0.99,-0.32l-0.51,-0.72l-1.38,0.46l0.05,-0.98l-2.87,-1.21l-0.26,-1.63l-1.4,-0.73l0.55,-0.65l-0.23,-0.93l1.63,-1.24l0.09,-0.88l1.38,-0.28l1.05,-0.83l-0.14,-0.83l0.42,-0.76l-0.27,-2.05l-1.07,-0.57l-0.6,-1.09l2.55,-0.29l1.81,0.29l1.22,1.18l0.77,0.17l0.84,1.06l0.44,-0.1l1.9,-2.7l-0.71,-3.98l-2.14,-1.5l-0.42,-0.96l-2.13,-0.2l-0.64,0.35l-0.59,1.53l-0.72,0.42l-0.23,1.64l-4.73,0.03l-1.07,-0.7l-0.76,-1.85l0.91,-0.94l-0.78,-0.93l-0.62,-3.03l-1.02,-0.47l-1.34,0.99l-0.84,-0.19l-0.78,-0.92l0.65,-0.68l1.01,-2.87l0.98,-0.24l0.12,-2.17l0.82,-1.42l-0.3,-1.01l-1.15,-0.64l-4.9,0.67l0.03,-2.21l-0.94,-0.29l-0.88,-1.96l-0.48,-0.18l-0.42,0.35l-1.14,-1.04l-1.45,0.41l-1.02,-0.83l-2.31,-0.14l-2.01,-1.12l-0.14,-1.28l-0.7,-0.6l0.18,-1.16l-0.58,-0.83l-2.08,-0.11l-0.6,-0.95l-2.52,-0.71l-2.92,-2.52l-0.06,-0.61ZM678.93,382.4l0.44,-0.1l0.53,0.6l-0.72,-0.3l-0.26,-0.2ZM680.23,383.74l0.2,0.51l0.05,0.28l-0.48,-0.16l0.24,-0.63Z").attr(attr),
            "name" : "江苏",
            "xy":[674,360]
        },
        "1,016," : {
            "path" : R.path("M712.08,417.1l1.37,0.04l2.68,1.27l0.27,0.35l-0.27,0.65l-2.51,-0.97l-0.93,0.12l-0.57,-0.56l-0.02,-0.92ZM713.83,414.37l1.02,-0.31l0.01,0.67l-0.63,-0.14l-0.41,-0.23ZM713.2,423.11l0.11,-0.14l0.15,-0.05l0.01,0.19l-0.27,-0.0ZM653.63,432.97l0.78,-2.02l1.1,-0.36l0.79,-1.7l1.91,-0.94l1.0,0.19l2.47,-2.71l1.36,-0.56l1.16,-1.22l0.13,-1.41l1.34,-1.04l1.07,-1.68l-0.34,-3.16l0.57,-0.99l-0.47,-1.26l0.73,-0.34l1.37,0.67l2.74,0.23l1.47,-1.16l1.27,-0.21l-1.0,-2.73l-1.16,-0.27l1.5,-1.84l0.62,0.71l0.87,-0.32l0.67,-1.88l1.24,-1.55l1.1,-4.78l3.22,-0.02l0.38,1.18l2.79,2.37l1.53,0.44l1.83,-0.24l0.36,0.68l0.88,-0.02l0.59,1.86l0.65,0.16l1.42,-1.43l1.8,-0.55l-0.11,-1.38l3.47,-0.54l0.18,2.92l1.07,0.36l0.62,-0.53l0.59,0.74l1.1,0.18l0.61,0.69l-1.92,1.64l-1.59,0.17l-0.75,0.56l-0.62,2.3l-0.62,0.71l-1.19,0.42l-1.76,-0.98l-4.09,0.34l-0.96,1.32l-1.54,0.19l-1.36,1.96l1.06,0.02l0.82,-0.98l1.01,0.78l0.75,-0.05l0.9,-1.2l1.01,-0.25l1.44,3.01l1.12,0.64l1.95,0.24l-0.0,-0.85l1.9,-0.75l2.72,-1.87l2.24,-0.27l2.4,1.39l2.86,3.56l1.19,0.53l0.99,-0.06l2.31,1.33l1.37,-0.08l-2.67,1.22l-2.53,3.25l-2.2,0.55l-0.53,-0.35l-1.1,0.78l-0.09,1.64l1.2,0.73l1.25,-1.32l2.02,-0.66l0.52,0.86l0.99,-0.34l0.85,-0.99l-0.4,-0.58l-0.92,-0.05l0.31,-0.26l1.54,-0.46l0.51,0.49l-0.89,1.0l0.71,1.09l-0.64,0.24l-0.3,0.7l0.46,1.07l-0.36,0.6l0.73,0.76l-0.15,0.38l-1.13,0.26l0.39,-2.06l-1.22,-1.08l-0.63,0.36l-0.14,2.36l-0.91,0.21l0.0,-1.7l-1.56,-0.11l-0.91,0.82l-0.28,1.04l-1.33,0.55l0.17,1.56l1.4,0.03l0.54,-0.17l0.94,0.02l-1.23,0.23l0.11,1.22l1.8,-0.36l-0.01,1.06l-0.93,-0.53l-0.23,0.29l-0.66,-0.2l-0.78,0.75l0.86,0.86l1.06,0.24l0.34,0.78l-0.41,1.13l-1.33,0.34l-2.12,-0.17l-2.87,-2.07l-0.68,0.32l0.45,0.86l1.85,1.24l-0.54,0.84l2.68,-0.13l0.73,0.33l0.62,2.04l-0.29,0.28l0.78,0.72l0.29,1.49l0.73,0.69l-0.11,0.22l-1.15,-0.8l-1.33,0.03l-0.93,0.86l0.06,0.61l-0.71,1.11l0.22,0.35l-0.69,-0.57l-0.63,-1.87l0.5,-0.86l-2.04,-0.35l-0.92,1.26l-1.05,-0.09l0.03,0.91l1.01,0.54l-0.5,0.8l-1.29,0.74l-0.59,2.08l-1.67,-0.13l-1.42,-0.77l-1.41,-0.0l-0.22,-0.93l-0.7,-0.21l-0.2,0.69l0.4,1.34l3.8,1.27l-1.78,2.87l-0.82,-0.55l-0.61,0.37l0.51,1.83l-1.17,0.49l-0.21,0.56l0.42,1.23l1.08,0.44l-0.6,1.01l-0.91,-0.27l-1.04,1.32l0.6,0.54l-0.51,1.33l-0.63,-0.31l-1.02,-2.29l-1.94,-0.73l-1.54,0.24l-1.25,0.9l-0.99,-0.3l-0.9,0.56l-1.98,0.18l-1.09,-1.44l-0.05,-1.48l-1.05,-1.49l0.04,-0.95l-0.47,-0.27l-1.24,0.07l-1.19,2.34l-1.27,0.21l-1.66,1.34l-1.43,-0.18l-0.61,-0.57l-2.77,-0.22l0.44,-0.65l-0.49,-2.87l-1.06,-3.09l-1.01,-0.91l0.67,-4.34l-0.88,-1.34l-0.63,-0.16l-0.69,0.46l-2.71,0.31l-0.03,-3.64l-0.61,-1.33l0.16,-1.39l-0.82,-1.75l-1.06,-0.73l-1.22,-2.04l-2.33,-1.46l-0.84,-1.06ZM710.57,432.92l0.46,-0.01l-0.07,0.7l-0.01,-0.19l-0.38,-0.5ZM710.08,418.29l0.28,0.25l-0.22,0.5l-0.14,-0.05l0.08,-0.7ZM699.58,449.15l0.66,-0.43l0.36,-0.53l0.13,1.22l-0.87,0.48l-0.28,-0.74Z").attr(attr),
            "name" : "浙江",
            "xy":[685,431]
        },
        "1,011," : {
            "path" : R.path("M540.48,343.2l-0.86,-0.53l-0.2,-2.13l1.42,-6.52l3.04,-3.88l1.15,-2.99l-0.87,-4.19l-0.79,-0.98l-0.87,-3.96l0.76,-6.4l-0.26,-1.28l-1.06,-1.25l0.44,-1.16l-0.58,-0.54l0.24,-0.81l-0.51,-1.04l0.46,-0.8l-0.09,-0.94l3.83,-4.91l0.3,-1.33l-0.78,-0.83l1.42,-0.78l0.85,-1.9l-0.32,-1.07l0.34,-0.76l-0.86,-0.71l0.13,-1.05l-1.36,-0.9l-0.96,-1.82l-1.01,-0.68l-0.19,-3.3l0.9,-0.77l0.22,-1.09l1.04,-0.25l1.78,-2.07l1.05,-0.45l0.78,-1.49l0.1,-0.98l-0.41,-0.62l1.92,-4.87l-0.39,-1.21l2.04,-1.47l1.61,-4.0l-0.18,-0.68l-1.34,-1.04l3.07,-0.62l1.31,-1.57l0.07,-1.37l0.45,-0.56l2.69,0.25l1.23,0.67l1.73,-0.65l1.23,-1.23l0.4,-1.52l2.13,-3.84l0.98,-0.95l1.67,-2.92l1.58,-0.88l2.61,0.87l1.92,1.18l1.73,-0.66l1.93,-2.53l3.25,-1.23l1.87,1.8l2.68,-0.22l2.81,-1.67l1.64,-0.02l4.22,-1.25l0.33,-1.1l-0.8,-1.56l1.02,-1.17l0.21,0.95l1.31,1.49l0.67,3.59l2.97,0.44l-5.68,1.93l-0.65,1.55l-0.43,-0.44l-0.57,0.1l-1.16,2.1l2.19,2.13l4.77,1.11l0.09,3.27l0.49,0.92l1.53,1.17l-1.8,4.02l-0.13,1.77l-1.92,1.62l-2.01,0.19l-1.4,-0.91l-2.79,1.01l-1.51,2.58l1.03,2.02l-0.94,1.15l-0.98,0.43l-0.15,0.74l-1.03,0.42l-1.16,2.02l-0.25,2.96l0.35,2.1l3.77,1.92l1.43,3.31l3.11,4.59l-0.75,2.7l-2.28,3.16l-0.56,1.71l-1.55,1.64l0.26,4.05l-1.1,-0.14l-1.08,1.71l-2.28,0.58l-0.48,0.55l0.4,0.71l-0.14,0.89l1.27,1.49l-0.03,1.26l2.65,2.01l-0.71,2.07l0.18,2.97l-0.85,1.52l-0.06,2.1l-0.5,0.72l-0.08,1.87l0.36,0.63l-1.9,1.92l-2.37,0.65l-0.38,0.75l-3.78,1.54l-1.73,1.46l-1.16,-0.03l-2.09,-1.17l-2.21,1.53l-6.87,-0.23l-0.34,0.4l-0.1,2.52l-1.03,-0.58l-1.96,0.21l-2.32,1.34l-1.71,2.32l-2.36,0.65l-0.71,-0.32l-1.35,0.26l-0.45,0.39l-1.22,-0.27l-0.54,0.87l-1.79,0.79l-1.01,-0.22l-0.46,1.1l-1.76,0.1l-1.68,0.96l-1.58,0.26l-0.64,-0.46l-1.18,0.31l-1.1,-0.33Z").attr(attr),
            "name" : "山西",
            "xy":[570,291]
        },
        "1,010," : {
            "path" : R.path("M347.72,203.74l32.89,3.89l8.0,-1.99l17.65,2.6l4.5,-0.14l1.56,0.37l1.31,0.88l2.23,3.24l2.37,1.76l15.25,3.18l9.15,4.34l11.56,-1.88l0.13,3.51l5.97,0.39l1.38,1.02l0.77,-0.27l2.67,-2.53l9.77,-4.39l13.18,-5.16l20.65,-2.96l9.13,0.99l2.5,-0.88l4.23,0.39l3.54,-0.45l2.69,-1.77l3.52,-1.38l2.23,-0.19l5.09,-2.31l0.82,-1.36l2.28,-1.86l1.09,-2.05l4.22,-4.52l6.26,-2.84l2.42,-0.47l2.81,-2.91l1.27,-0.04l1.52,-0.77l0.16,-1.87l-1.59,-2.83l-3.05,-2.35l-1.62,-2.11l-0.49,-1.79l-1.29,-1.0l0.36,-1.54l1.72,-2.55l0.17,-1.93l2.72,-4.9l1.4,-1.2l1.77,-0.82l6.28,0.36l2.47,2.54l2.46,1.1l5.36,1.31l5.37,0.43l2.12,0.55l4.3,-3.1l1.82,-0.33l1.15,-0.68l0.94,-1.29l3.99,-3.15l1.26,-1.91l0.29,-1.33l2.33,-0.72l3.39,0.97l5.92,-0.38l5.09,-1.16l4.9,-4.01l1.25,0.01l1.32,-0.73l1.25,-1.79l-0.54,-1.97l2.05,-3.51l2.47,-2.24l0.63,-1.15l2.1,-0.6l1.31,-1.04l7.7,0.53l1.38,-3.33l-0.09,-0.72l1.89,-0.42l0.66,1.06l0.82,0.44l2.05,-0.04l1.66,-1.66l5.31,-2.1l2.85,0.69l2.08,-0.35l1.54,0.51l1.93,-1.61l0.55,0.92l1.13,-0.42l1.0,1.24l4.28,1.08l2.67,-0.3l2.75,0.66l1.62,-1.2l0.75,0.06l0.71,-0.55l0.56,-0.96l-0.33,-0.78l0.16,-2.8l-1.88,-1.81l-0.2,-1.78l-0.86,-1.35l-1.14,-1.15l-1.53,-0.67l-0.66,-1.01l-2.54,-1.95l0.29,-0.47l-0.29,-0.77l-2.53,-0.93l-0.79,-2.53l-4.65,-1.78l-3.37,-3.96l-5.46,-1.2l-6.23,0.68l-6.02,6.38l-3.93,-2.92l-3.85,-1.29l-4.77,0.75l-3.83,-0.48l-2.44,1.09l-2.32,2.21l-4.63,-4.0l-0.84,-3.79l4.19,-2.15l-0.03,-5.32l3.36,-4.51l0.33,-0.79l-0.17,-1.2l9.26,-17.7l5.23,2.66l2.98,0.99l3.16,0.15l4.14,1.91l1.39,0.1l5.31,-3.35l0.71,-0.9l2.01,-1.11l0.27,-0.61l1.21,-0.32l0.73,-1.16l1.76,-1.12l0.89,0.14l3.08,-0.78l2.53,0.06l1.8,-0.58l1.69,-1.58l0.51,-1.19l0.17,-3.95l-2.92,-0.9l1.24,-0.87l0.65,-2.81l3.06,-2.81l0.44,-3.34l3.15,-3.15l0.47,-2.54l0.65,-0.45l-0.01,-0.87l1.49,-1.41l-0.17,-0.68l0.68,-0.41l0.38,-1.76l1.07,-1.21l0.65,-2.04l0.84,-0.08l4.82,-4.04l2.41,-0.83l0.98,-1.59l-0.17,-1.25l1.09,-1.18l0.19,-1.15l-0.46,-1.73l-1.84,-1.95l0.89,-1.65l0.34,-2.53l-4.26,-1.98l-4.09,1.09l-1.21,-0.1l-0.47,-0.62l0.33,-1.08l-0.23,-1.2l3.42,-1.89l2.53,-2.86l5.4,-4.46l0.33,-0.76l2.86,-0.29l2.24,0.26l2.08,-0.94l0.78,0.13l3.06,1.65l0.73,1.81l1.18,0.67l0.51,1.27l-1.47,2.09l-2.74,2.62l-4.89,3.62l0.01,0.94l2.37,0.93l2.43,1.73l3.06,1.17l2.02,2.32l1.35,0.22l1.76,-0.58l2.45,-3.99l1.83,0.7l2.37,3.29l3.81,1.01l-0.19,0.61l-1.51,0.64l-0.38,0.68l1.89,5.83l-0.76,2.26l1.9,2.93l0.09,1.29l0.65,1.09l3.17,2.79l1.32,-0.07l1.46,0.99l2.81,-0.09l1.35,1.21l1.04,0.24l2.5,-0.56l0.95,-1.68l2.29,0.19l2.25,-0.5l1.7,0.86l1.41,0.05l1.13,-0.54l0.34,-0.95l2.74,0.43l2.72,-0.72l0.55,-0.89l1.14,-0.67l0.24,-0.89l1.34,-0.51l0.36,-1.59l0.49,-0.2l2.92,0.62l2.13,1.39l3.16,4.68l2.03,1.2l0.37,1.08l1.58,0.86l0.8,1.13l0.28,1.31l-0.47,0.83l-1.74,0.93l-0.03,0.64l-0.98,1.04l-1.11,0.4l0.66,1.29l-0.08,2.95l-3.25,1.98l-0.63,0.81l-0.33,1.47l-0.97,1.11l-0.07,1.05l-2.58,2.0l-0.24,1.42l0.5,0.46l-1.42,1.26l0.74,1.3l-0.83,1.36l0.63,0.54l-0.06,2.1l-0.75,-0.22l-0.63,0.6l1.54,2.02l0.53,2.11l-0.62,3.97l-1.27,1.37l-1.16,-0.55l-2.48,-0.24l-0.95,1.36l-0.06,1.14l-2.91,5.99l-0.21,1.94l-1.12,1.52l-0.18,3.65l0.56,1.16l0.04,1.37l-0.54,1.68l-0.81,-0.76l-0.41,-1.58l-1.07,-1.57l-0.23,-2.64l-0.84,-0.97l-0.68,-0.02l-2.43,1.64l-7.36,7.42l-4.26,2.11l-1.2,2.41l-9.46,5.32l-1.09,2.33l-1.31,1.46l2.53,4.17l3.2,1.74l3.01,3.66l1.22,0.91l2.06,0.66l1.04,-0.97l1.06,-0.3l0.76,-1.25l0.73,0.18l0.02,0.83l0.46,0.44l1.4,-0.18l0.27,0.36l-1.06,1.53l-2.15,1.76l-4.47,-0.64l-1.12,0.52l-0.41,3.98l2.4,3.34l-0.77,1.62l-4.37,0.57l-0.45,5.8l-0.77,0.98l-2.42,-1.72l-0.58,-1.58l-0.91,-0.97l-0.77,0.07l-1.88,2.33l-3.3,-2.91l-3.33,-0.78l-0.79,0.6l0.65,1.25l-0.22,0.97l-2.21,2.62l0.37,0.72l1.32,0.8l2.72,-0.25l0.55,0.73l-0.32,1.12l0.31,0.96l0.74,0.9l1.49,0.49l1.08,1.63l0.4,1.37l-0.2,0.72l-2.69,1.43l-0.51,1.25l0.54,7.07l0.76,1.72l2.73,3.16l-0.37,3.27l0.42,0.79l0.64,0.31l1.22,-0.18l5.26,-2.18l5.13,-3.41l0.13,2.19l0.8,0.68l1.18,2.78l1.5,0.92l-0.55,1.96l2.99,6.35l-0.22,1.18l-0.75,-0.38l-0.62,0.29l-0.02,0.64l-1.0,1.0l0.04,1.03l0.61,0.69l4.47,1.79l-1.07,4.14l-5.16,1.49l-1.26,1.05l-0.65,1.98l-0.97,0.68l-1.22,-0.01l-1.29,0.79l-1.71,0.19l-3.36,-1.78l-2.23,-0.35l-0.73,0.99l1.03,2.04l-0.22,0.45l-1.49,0.36l-3.61,-1.49l-1.89,0.95l-0.8,2.35l-2.12,1.38l-1.09,0.05l-1.25,-1.43l-2.78,0.55l-5.33,4.49l-1.56,-0.78l-4.12,2.38l-2.04,0.33l-0.66,2.2l-1.8,1.08l-2.85,3.05l-0.48,1.43l-0.5,-0.05l0.09,-2.28l-0.79,-1.08l-0.11,-0.87l-1.29,-0.89l-0.13,-1.07l-1.08,-1.02l0.62,-0.6l-0.17,-0.75l-2.99,-0.79l-0.77,-1.98l-1.38,-0.88l-0.91,1.3l-1.96,0.69l-1.43,1.92l1.91,2.38l-0.78,1.59l0.11,1.8l-0.47,1.64l1.32,6.01l-1.46,1.89l-0.52,-0.32l-5.17,-0.2l-0.92,-0.82l-1.57,0.7l-3.42,-0.21l-1.36,0.71l-0.24,-1.85l-0.6,-0.58l0.22,-1.83l-1.29,-0.66l-1.05,-2.34l0.25,-0.45l1.22,0.79l0.73,-0.86l0.3,-1.51l-0.67,-0.95l0.3,-1.0l-0.31,-1.62l-1.18,-0.68l-1.01,1.11l-0.48,-2.54l-1.57,-0.8l0.78,-0.86l-0.31,-2.02l-3.23,-3.17l0.11,-0.64l-0.5,-0.41l-2.93,0.93l-0.72,-1.06l-0.44,-0.05l-1.43,1.46l-0.4,1.45l-2.24,-0.46l-2.25,0.13l-3.31,1.51l-1.03,1.84l0.86,1.96l-0.46,1.46l0.51,0.91l-1.14,1.01l-2.69,1.07l-0.96,-0.76l-1.02,0.32l-0.41,-0.83l-1.09,-0.2l-2.56,2.23l-1.26,0.27l-0.74,1.18l-1.52,-2.2l-1.19,-0.15l-4.51,2.54l-3.54,1.26l-0.56,0.66l0.29,1.02l-0.68,0.05l-0.42,0.57l-1.9,-0.53l-2.85,0.09l-0.17,-2.83l0.92,-0.95l-1.4,-5.61l-0.59,-0.53l-1.1,0.58l-3.08,0.21l-1.15,1.08l-0.88,2.07l-1.39,0.75l-1.43,1.62l-0.58,4.23l-2.5,0.98l-1.39,1.98l-0.32,2.59l1.11,0.9l0.04,0.94l-1.03,-0.03l-0.55,1.18l-0.86,0.31l3.01,3.31l0.48,1.77l1.23,0.96l-1.1,0.76l-0.59,1.04l0.78,2.24l-3.9,1.12l-1.76,0.05l-3.47,1.8l-1.71,-0.0l-0.69,-1.19l-0.81,-0.52l-1.99,0.34l-2.15,1.01l-1.99,2.57l-1.11,0.45l-1.7,-1.12l-3.28,-0.85l-1.85,1.12l-1.69,2.96l-1.0,0.98l-2.16,3.9l-0.36,1.45l-1.08,1.04l-1.14,0.45l-1.1,-0.66l-3.45,-0.14l-0.66,0.68l-0.02,1.59l-1.1,1.29l-2.38,0.25l-0.9,0.61l-0.4,-0.24l1.11,-1.63l0.19,-1.13l-0.48,-0.33l-1.75,0.24l-2.67,1.85l-2.66,3.7l-1.85,-2.18l-1.64,0.33l-0.86,0.62l-1.83,-1.93l-1.81,-0.08l-0.34,0.8l0.99,1.99l-2.97,1.63l-2.1,2.18l-2.13,0.73l-0.71,1.98l-1.23,1.82l-0.72,-0.11l-1.35,0.75l-0.48,1.04l-0.88,0.53l-0.08,0.82l-1.91,1.04l-1.98,2.33l-0.94,1.65l-0.51,2.21l1.23,2.21l-1.13,2.39l-1.09,-1.23l-1.32,0.99l-0.39,4.4l-3.65,0.08l-2.42,0.6l-4.4,-0.02l-0.1,-1.11l-1.21,-1.41l-7.49,-2.11l-0.21,-1.09l-1.14,-1.54l-2.44,-1.28l-1.73,0.36l-3.24,-0.59l-4.74,-2.11l2.24,-2.56l0.96,-3.22l3.26,-4.71l0.8,-1.77l-0.1,-0.63l-1.4,-0.93l-1.07,-1.82l0.02,-1.87l-0.39,-1.05l-0.62,-0.32l-2.34,0.25l-1.72,1.25l-2.9,-0.05l-0.7,0.78l0.09,1.82l-2.44,0.56l-0.74,2.37l-2.42,4.19l-0.84,2.89l-0.29,3.95l0.37,1.33l-1.01,0.98l-0.35,1.09l1.04,2.56l-0.35,2.93l-2.01,1.15l-1.92,0.17l-2.09,-0.5l-1.86,0.5l-2.78,1.35l-1.62,1.69l-4.12,0.65l-1.26,-0.4l-1.59,0.18l-0.89,0.49l-0.89,1.47l-1.26,0.2l-2.01,-1.12l-6.35,-5.34l-3.58,-1.18l-0.5,-2.34l-0.02,-1.52l1.69,-0.44l0.41,-0.5l-0.62,-3.23l-0.69,-1.2l6.26,-3.8l2.75,-4.34l1.46,-0.87l0.94,-1.67l0.01,-1.47l-2.43,-3.75l-0.02,-2.0l-0.8,-0.31l-4.04,0.28l-4.28,1.18l-4.92,2.33l-2.33,1.76l-5.36,-0.99l-2.0,-1.02l-1.13,-0.0l-8.49,2.79l-0.08,0.83l2.89,2.95l-2.66,2.84l-3.44,0.03l-2.38,-1.02l-1.26,-0.09l0.36,-0.72l-1.16,-0.86l-0.78,-1.23l-0.06,-1.5l-0.96,-0.29l-1.48,0.39l-2.39,-1.92l-0.44,-3.73l-0.63,-1.27l-4.49,-0.28l-0.49,-1.15l-2.23,-0.79l-0.39,-1.52l-1.12,-1.08l-4.38,-1.5l-2.47,-1.65l-4.32,-0.33l2.48,-2.58l4.31,-2.64l1.36,-3.08l2.75,-3.34l0.01,-2.56l-2.24,-3.18l-4.41,-0.57l-1.63,0.19l-2.36,0.98l-5.08,0.14l-4.98,1.97l-3.2,3.05l-4.81,0.37l1.21,-6.12l-5.6,-4.21l-4.14,-4.97l-0.02,-0.87l2.77,-2.76l-9.36,-20.03ZM735.33,129.65l0.0,-0.0l0.01,-0.03l0.0,0.01l-0.01,0.02Z").attr(attr),
            "name" : "内蒙古",
            "xy":[544,215]
        },
        "1,020," : {
            "path" : R.path("M636.92,258.06l3.33,1.19l1.08,-0.32l0.57,-2.54l-0.23,-0.73l1.12,-0.78l-0.34,-0.61l-1.0,-0.23l-0.35,-0.95l1.22,-2.1l1.18,-0.54l0.87,-2.02l2.8,1.69l0.82,1.06l1.15,0.23l-0.04,0.57l0.51,0.47l-1.84,0.05l-1.48,-0.7l-0.66,0.32l-0.09,2.38l0.44,2.13l0.77,1.33l0.66,0.37l0.14,1.58l1.49,0.83l0.83,-0.82l1.66,0.3l-0.49,2.1l0.39,0.62l1.53,0.79l-0.01,1.64l-1.59,0.36l-2.68,1.93l0.17,1.74l-2.1,3.27l-0.6,3.1l-3.77,0.9l-0.57,-0.61l-1.91,-0.36l-0.64,-1.49l-2.22,0.18l-2.42,-1.96l-0.4,-1.46l0.2,-1.19l3.15,-2.31l-0.19,-0.89l-0.97,-0.62l0.35,-2.5l-0.91,-2.47l-0.0,-1.57l1.09,-1.34Z").attr(attr),
            "name" : "天津",
            "xy":[663,272]
        },
        "1,013," : {
            "path" : R.path("M586.69,308.4l2.06,-0.5l0.89,-0.81l0.29,-0.94l0.87,0.21l0.59,-0.41l-0.25,-4.13l1.49,-1.54l0.56,-1.72l2.29,-3.19l0.85,-3.05l-3.24,-5.06l-1.43,-3.36l-1.88,-1.24l-1.86,-0.59l-0.02,-4.49l0.98,-1.64l1.03,-0.39l0.2,-0.78l0.86,-0.34l1.15,-1.42l-0.01,-0.73l-0.95,-1.59l1.36,-2.14l2.13,-0.68l1.21,0.88l2.02,-0.05l2.58,-1.82l0.46,-2.35l1.81,-4.11l-2.08,-2.45l0.09,-2.78l-0.35,-0.74l-5.01,-1.27l-1.72,-1.57l0.74,-1.01l0.59,0.53l0.62,-0.17l0.47,-1.8l5.1,-1.66l1.12,-0.9l-0.56,-0.8l-2.73,-0.24l-0.47,-3.14l-1.49,-1.9l-0.06,-1.42l-1.5,-1.38l-0.5,-1.8l-2.28,-2.31l0.46,-1.23l0.92,0.1l0.53,-0.64l-0.17,-1.55l-1.0,-0.58l0.23,-2.04l1.18,-1.74l2.7,-1.2l0.35,-3.31l0.55,-1.46l2.4,-1.68l1.58,-2.86l3.1,-0.25l0.73,-0.47l1.4,5.26l-0.9,0.82l0.12,3.39l0.47,0.36l3.13,-0.1l2.13,0.53l0.66,-0.65l1.17,-0.06l-0.18,-1.7l3.49,-1.24l4.38,-2.49l0.46,0.01l1.41,2.14l0.71,0.23l0.68,-0.39l0.39,-0.91l1.19,-0.22l2.47,-2.19l0.87,1.04l1.28,-0.28l1.05,0.77l3.01,-1.14l1.21,-0.8l0.4,-0.84l-0.51,-1.04l0.44,-1.59l-0.85,-1.84l0.71,-1.16l3.0,-1.36l4.51,0.33l0.53,-0.41l0.37,-1.41l0.87,-0.81l0.97,0.95l2.58,-0.88l0.2,0.64l3.1,2.98l0.23,1.64l-0.64,0.43l-0.11,0.69l1.65,1.04l0.47,2.62l1.29,0.17l0.85,-0.88l0.27,1.43l-0.34,1.07l0.71,0.95l-0.26,1.14l-0.13,0.28l-0.65,-0.65l-0.78,-0.04l-0.68,1.21l1.24,2.84l1.15,0.39l-0.28,1.79l0.67,0.64l0.32,2.01l1.04,0.43l0.59,-0.7l3.84,0.12l1.43,-0.67l0.89,0.77l5.1,0.26l-0.96,1.85l-1.87,1.54l-1.54,0.59l-0.04,1.05l1.07,0.53l-1.41,0.11l-0.94,2.71l3.24,3.28l1.16,-0.15l0.64,-0.53l0.01,1.13l1.78,1.73l3.76,-0.24l0.42,0.8l-0.26,2.03l0.82,1.57l-0.02,1.19l1.63,0.2l-0.06,1.85l1.46,1.45l-3.99,1.47l-0.66,0.62l-0.17,0.91l-2.28,1.32l-0.89,2.23l-0.9,0.27l-0.43,0.62l0.73,0.9l-0.31,0.76l0.25,1.05l-2.93,2.37l-0.44,1.15l-1.39,0.1l-0.63,-0.55l-1.02,0.83l-0.94,0.18l-0.45,-0.63l-1.39,-0.06l-3.97,2.57l-1.0,-0.43l-1.19,-1.96l-2.2,-0.8l-0.13,-1.91l-1.8,-1.11l0.52,-1.78l-0.22,-0.71l-2.42,-0.61l-0.65,0.69l-0.98,-0.53l0.04,-1.28l-1.38,-1.6l-0.33,-3.69l1.19,0.6l2.24,-0.02l0.55,-0.32l0.08,-0.67l-0.57,-0.61l-0.05,-0.79l-1.53,-0.43l-1.38,-1.48l-3.91,-2.19l-0.54,-0.77l-0.07,-1.69l-0.79,-0.81l0.89,-0.95l2.18,-0.31l1.37,-1.59l-4.97,-0.87l-1.47,0.34l-1.5,-0.72l-4.16,-3.9l-0.6,-1.86l-0.81,0.14l-0.38,0.91l-1.3,0.64l-0.58,0.83l-1.46,-0.42l-0.25,0.8l1.52,2.01l-1.15,-0.01l-0.72,0.45l-1.22,-0.44l-2.82,2.87l-2.15,-0.22l-2.63,1.24l0.06,0.66l3.09,4.31l-1.27,1.71l-4.37,1.34l-1.96,1.88l0.04,0.75l1.09,0.79l0.03,1.11l0.64,0.64l-0.97,-0.02l-0.6,0.48l0.34,2.5l1.57,1.0l1.47,0.01l0.37,0.76l1.14,0.78l2.82,-1.13l1.03,0.33l2.59,-0.38l1.68,1.95l1.58,0.44l1.16,-0.56l-0.4,-1.09l1.34,-0.5l0.38,-0.61l2.72,-0.04l0.08,1.73l0.87,2.31l-0.39,2.32l1.22,1.36l-3.1,2.19l-0.27,1.56l0.5,1.82l2.74,2.27l2.23,-0.16l0.48,1.38l1.98,0.43l0.71,0.67l4.19,-0.85l2.12,3.89l1.55,1.57l-0.48,0.79l0.12,0.98l-1.02,1.21l-1.95,0.54l-2.12,3.39l-9.18,0.11l-3.06,3.77l-2.27,2.06l-0.69,-2.02l-0.9,0.19l-1.69,2.58l0.5,1.23l-0.29,0.31l-2.46,0.01l-1.25,0.7l-0.21,1.21l-1.0,1.02l-0.62,2.24l-1.1,1.15l-0.13,0.86l-1.55,2.12l-2.8,1.15l-1.97,2.54l-0.95,2.0l1.06,3.34l0.88,0.31l0.61,0.84l0.06,0.95l-1.45,1.16l-1.27,-1.49l-1.98,-0.32l-2.37,2.1l-1.52,-1.47l-4.11,0.24l-3.34,-1.87l-3.56,-0.32l-1.46,-1.57l-3.85,0.07l-1.34,-1.35l-1.29,-0.64l0.16,-1.11l-1.31,-1.51l-0.05,-1.13Z").attr(attr),
            "name" : "河北",
            "xy":[623,283]
        },
        "1,021," : {
            "path" : R.path("M615.9,256.48l1.62,-0.31l0.26,-0.62l-0.9,-0.84l-0.15,-1.37l-0.99,-0.65l1.99,-1.74l4.06,-1.19l1.52,-2.03l-0.18,-1.32l-2.9,-3.64l1.98,-0.79l2.31,0.17l1.43,-1.02l1.37,-1.84l0.89,0.49l0.89,-0.47l1.76,-0.04l0.22,-0.71l-1.24,-1.66l0.92,-0.1l0.57,-0.83l1.35,-0.66l0.33,-0.88l0.31,1.55l4.41,4.12l1.74,0.81l1.57,-0.33l1.81,0.53l1.71,-0.09l-0.24,0.48l-2.44,0.48l-1.05,1.3l0.84,1.38l0.18,1.93l1.56,1.47l0.15,0.71l-0.8,1.28l-4.49,1.19l-2.87,0.06l-0.77,0.48l-0.29,1.32l0.6,1.27l2.11,1.4l-1.59,2.91l-3.52,0.15l-0.52,0.69l-1.61,0.7l-0.13,0.67l0.54,0.51l-0.68,0.09l-1.79,-0.98l-0.49,-0.99l-0.69,-0.39l-2.57,0.39l-1.2,-0.32l-2.03,0.58l-0.53,0.55l-1.27,-1.44l-2.6,-0.44l-0.47,-1.96Z").attr(attr),
            "name" : "北京",
            "xy":[630,247]
        },
        "1,009," : {
            "path" : R.path("M607.66,370.2l0.18,-1.07l0.61,-0.41l2.74,0.6l2.14,-0.87l1.25,-2.29l-0.39,-2.03l0.37,-1.68l0.52,0.01l0.95,-0.91l2.68,-0.6l-0.62,-2.75l0.53,-0.42l0.11,-1.43l-1.0,-0.83l0.32,-1.18l0.95,-1.06l0.96,-0.16l1.34,0.95l1.66,0.06l0.02,1.43l2.28,2.87l0.77,0.44l4.13,-1.25l0.57,-1.1l2.7,-0.92l0.17,-1.15l-1.43,-2.74l0.47,-0.91l-0.12,-1.87l-2.92,-0.08l-3.16,-2.67l0.06,-1.57l1.02,0.15l1.97,-1.16l1.16,0.59l1.75,1.78l2.54,0.73l0.64,0.98l1.9,-0.01l0.32,0.43l-0.16,1.22l0.74,0.73l-0.03,0.97l0.47,0.59l2.22,1.21l2.22,0.11l1.19,0.88l1.47,-0.4l0.86,0.96l0.93,-0.07l0.59,1.63l0.79,0.31l-0.29,2.11l0.28,0.36l2.27,0.04l3.62,-0.65l0.46,0.75l-0.79,1.28l-0.16,1.81l-0.82,0.34l-1.83,4.2l1.52,1.57l0.98,0.2l1.66,-0.86l0.15,1.78l0.88,1.65l-0.61,0.51l-0.06,0.79l0.93,2.07l1.45,0.96l5.09,-0.02l0.69,-0.54l0.12,-1.5l0.69,-0.36l0.59,-1.52l1.5,0.07l0.45,0.89l1.95,1.35l0.51,1.47l0.17,1.79l-1.31,2.04l-2.6,-2.22l-2.3,-0.31l-3.16,0.58l-0.14,0.77l0.68,1.28l1.0,0.42l-0.03,3.09l-2.29,0.84l-0.14,0.99l-1.68,1.35l0.07,0.92l-0.59,1.03l1.75,1.24l0.34,1.69l1.18,0.8l1.45,0.33l0.17,1.07l1.08,0.28l0.58,-0.33l0.41,0.53l0.65,-0.09l0.19,1.28l-0.75,1.93l-1.07,0.56l-0.29,0.62l1.12,2.07l4.26,-0.09l1.41,-0.8l1.15,0.41l1.2,-0.13l0.35,1.28l3.59,0.99l-0.7,3.97l-1.16,1.36l-0.64,1.82l-0.45,-0.66l-0.77,0.07l-1.92,2.26l0.27,0.89l1.03,0.22l0.47,1.55l-1.54,1.07l-2.56,-0.1l-1.52,-0.69l-1.33,0.58l-0.22,0.74l0.45,1.19l-0.76,0.86l0.57,2.94l-0.89,1.37l-1.38,1.08l-0.16,1.45l-1.01,1.05l-1.44,0.63l-2.32,2.53l-0.93,-0.51l-0.51,0.87l-1.5,0.43l-0.48,-0.32l-0.32,-1.47l-1.65,-0.74l-4.41,0.2l-0.95,-0.88l-1.47,-0.05l-1.75,-2.26l-0.14,-1.22l-2.38,-0.06l-0.09,-0.92l-0.86,-0.59l-1.24,0.33l-0.98,1.25l-0.06,0.53l0.59,0.62l-0.21,0.8l-1.75,0.82l-1.22,1.76l-1.23,-0.39l-0.58,0.31l-0.93,-0.92l0.33,-0.97l1.76,-0.72l1.41,-2.9l-1.52,-1.93l-1.46,-0.65l-1.1,0.12l-0.85,0.66l-1.2,1.88l-1.79,0.28l-1.79,1.38l-1.28,0.01l-0.28,-1.8l-0.73,-1.01l-0.47,-3.91l-2.4,-2.49l1.01,-0.9l-0.09,-1.21l-2.53,-2.97l0.13,-0.82l1.21,-0.37l0.0,-1.3l2.35,-1.68l0.26,-1.27l-0.71,-0.5l-0.82,0.04l-0.94,-1.4l-1.33,-0.04l-2.03,-1.52l-0.75,0.03l-0.53,0.87l-1.79,-2.47l-0.84,-0.48l0.23,-2.27l1.89,-3.27l2.15,-0.87l2.8,0.05l0.68,-0.43l0.41,-3.87l-0.2,-3.68l-0.79,-3.08l0.08,-1.29l0.78,-1.01l-1.16,-0.18l-1.25,1.29l-1.17,-0.05l-0.97,1.28l-1.13,0.1l-2.48,-2.38l-2.36,-0.59l-0.37,-4.3l-4.45,-2.16Z").attr(attr),
            "name" : "安徽",
            "xy":[642,385]
        },
        "1,023," : {
            "path" : R.path("M352.21,506.89l0.3,-4.22l1.66,-1.18l1.28,0.03l0.55,-0.66l-0.94,-1.39l-0.09,-1.87l0.74,-0.75l0.69,-1.92l1.28,0.67l2.23,-1.75l1.07,-1.43l-0.14,-1.67l0.57,-1.4l1.56,0.84l1.07,-0.26l2.53,-4.2l1.53,0.54l1.4,-1.24l-0.06,-0.81l-1.58,-1.57l-0.45,-1.51l1.3,0.4l1.01,-1.34l-0.84,-1.69l0.99,-1.76l0.13,-2.43l0.49,-1.27l-0.32,-1.59l0.26,-1.16l-0.51,-1.09l0.31,-3.1l-0.76,-0.87l-0.18,-1.05l0.52,-2.5l-0.5,-0.96l0.08,-2.93l-0.66,-0.84l-1.07,0.25l-0.74,-0.95l-1.76,-0.5l-0.66,0.47l-0.21,1.77l-0.65,0.18l-1.23,-2.86l-0.13,-1.53l-0.71,-0.58l0.39,-0.92l-0.89,-0.81l0.17,-2.51l1.71,-1.07l0.69,-1.87l1.83,1.79l0.95,-0.29l1.39,-1.23l1.08,-2.24l-0.83,-3.47l1.33,-1.35l-0.54,-3.26l1.42,-0.37l1.17,2.87l1.7,-0.45l0.23,-0.76l-0.6,-1.01l1.47,-1.78l-0.49,-2.12l1.16,-0.29l0.19,3.68l-0.35,2.11l0.35,2.22l0.75,1.64l-0.14,2.43l1.79,2.86l1.49,1.4l0.12,0.76l0.63,0.31l0.25,-0.39l0.25,-1.95l-0.64,-4.16l1.83,-0.83l1.65,-3.59l0.9,-0.36l0.19,1.27l1.42,1.17l0.3,1.15l1.46,0.7l0.79,1.62l2.12,1.92l0.23,1.1l-2.04,1.29l0.74,2.27l1.99,2.39l1.19,0.5l0.45,2.04l0.93,-0.09l1.2,-1.56l1.51,0.48l1.39,-1.06l3.02,4.84l0.01,1.25l1.57,1.77l0.51,3.03l0.62,0.33l1.73,-0.4l-0.49,1.7l0.25,0.91l2.91,2.59l0.74,2.07l0.92,0.11l0.51,-0.81l-1.33,3.07l0.71,0.88l1.36,0.55l1.28,1.87l-0.96,0.86l0.16,1.53l0.81,0.42l0.71,-0.41l1.25,0.8l0.16,1.23l1.25,1.06l1.22,-0.99l2.77,0.22l2.29,-2.36l4.42,-2.26l0.41,0.23l0.01,1.59l1.26,0.64l2.94,-2.12l1.11,0.16l0.78,-0.5l0.23,-1.96l0.5,-0.25l0.34,-1.02l-1.23,-4.42l-1.1,-1.54l-0.31,-1.57l0.54,-1.65l-0.4,-2.33l0.64,-1.36l0.79,0.15l2.03,-0.65l1.26,-2.32l1.1,-0.3l0.13,-1.0l2.31,-1.93l0.76,-1.43l0.18,-1.41l0.74,-0.74l-1.88,-1.38l0.26,-0.87l1.06,-0.72l0.52,-0.92l0.82,-0.34l1.12,0.84l2.59,-1.85l-0.19,-1.66l-0.88,-1.92l0.55,-1.32l3.37,0.42l2.4,-0.56l2.11,0.08l-2.46,1.08l0.09,3.29l0.35,0.66l1.95,1.22l-0.21,0.64l0.56,1.39l-1.55,0.61l-0.09,0.81l0.74,1.04l1.81,1.28l1.91,0.69l1.52,-0.6l2.7,-0.2l1.23,-0.96l0.19,-1.69l0.51,-0.36l1.96,0.35l0.41,0.91l0.98,0.02l-0.77,1.98l0.98,2.21l-1.42,4.72l-1.64,-0.24l-3.01,1.63l-0.95,-0.4l-4.0,0.22l-0.83,-0.35l-1.57,-1.69l-1.66,1.34l-0.31,1.13l-0.6,0.3l-2.7,-1.95l-0.96,-0.06l-0.73,0.34l-1.24,1.78l-3.12,2.86l-0.24,0.79l0.68,0.91l1.18,-0.37l0.82,1.24l-0.92,2.37l0.73,1.36l-0.04,1.64l1.11,1.26l1.33,0.53l1.89,0.05l1.54,-2.07l2.95,0.23l1.13,-1.32l0.58,1.67l1.37,0.36l1.22,2.2l-0.07,0.9l-1.56,1.37l-0.6,1.82l-0.08,1.91l-1.56,1.31l0.4,1.29l-0.45,1.46l-0.99,-0.12l-0.37,0.51l0.19,1.85l1.76,1.28l0.22,1.25l1.58,0.0l0.4,1.89l2.61,1.78l-0.57,0.46l-0.45,1.69l0.21,1.49l-2.22,2.68l-0.19,1.35l-0.83,1.27l0.27,1.6l1.49,2.86l1.9,1.33l0.73,-0.55l-0.51,-1.24l0.33,-0.37l3.01,0.77l1.97,-0.18l0.99,1.47l-0.01,2.64l1.36,1.2l0.79,0.18l0.41,-0.49l1.91,1.09l1.01,-0.42l0.35,-0.98l0.81,-0.21l0.56,1.05l2.23,0.83l1.42,-0.1l0.42,-0.84l1.0,-0.14l2.07,1.51l-0.06,0.62l0.76,1.12l-0.92,0.58l0.27,1.25l-0.37,2.98l-0.83,0.62l-1.01,0.17l-1.28,-0.74l-0.88,0.06l-1.52,1.66l-0.71,0.23l-0.13,0.66l-0.84,0.08l-0.21,1.05l-1.4,1.46l-0.84,-1.29l-1.03,-0.34l-0.6,-1.05l-0.81,-0.14l-1.3,1.7l-0.68,-0.18l-3.18,1.7l-1.12,-0.04l-0.23,0.77l-0.97,0.84l0.43,2.16l-1.64,1.54l-1.5,0.04l-0.41,-0.34l-3.17,2.3l-1.22,-0.65l-0.28,-1.47l-2.51,0.58l-1.08,1.32l-0.57,2.85l-4.12,-4.13l-0.67,-0.18l-0.99,0.63l-1.03,2.67l-1.21,-2.35l-1.63,-0.82l-1.16,1.96l-1.6,1.09l-0.04,1.01l-1.25,0.66l-0.12,0.8l-1.48,-0.65l-1.11,-1.93l-3.54,-1.76l-0.74,0.13l-0.31,-0.59l-1.0,-0.44l-1.89,1.66l0.24,0.92l-1.74,1.77l-0.38,1.14l-1.3,0.07l-1.87,-0.58l-1.61,0.3l-0.43,0.69l-1.19,-1.64l-1.42,0.22l-0.69,0.7l-0.7,2.44l-0.8,0.06l-0.58,0.81l0.69,1.17l-0.11,1.18l0.82,2.11l1.05,0.68l0.98,1.6l-0.31,1.37l0.42,1.17l0.68,0.47l-0.99,0.58l-0.31,3.87l0.45,0.75l1.14,0.66l-0.6,0.05l-0.2,0.93l-0.42,0.08l-0.6,-0.74l-0.85,-0.0l-0.27,-0.6l-1.09,-0.31l-3.79,0.89l-0.38,-0.66l0.3,-1.91l-0.93,-0.64l0.27,-1.36l-0.47,-1.04l0.17,-1.11l-1.03,-2.14l-0.95,-0.02l-3.48,1.63l-3.1,2.89l-2.18,0.18l-0.74,-0.91l-1.08,-0.23l-2.29,1.54l-1.05,-1.5l0.84,-1.23l-0.06,-0.54l-2.8,-0.96l-0.45,-1.55l0.68,-1.94l-0.66,-1.77l-1.24,-0.19l-0.66,0.41l-5.43,-1.41l-1.75,0.41l-2.08,-0.45l1.2,-3.49l1.67,-1.7l-0.02,-1.93l-0.69,-1.91l1.5,-1.68l0.05,-0.92l1.08,0.3l0.75,-0.73l-0.86,-2.32l-1.4,-0.22l-0.92,-0.89l-0.58,-0.01l-1.22,0.99l-0.24,-0.44l-2.04,-0.22l-0.62,-0.85l-2.1,-0.26l0.7,-1.28l-0.39,-0.89l0.13,-1.05l-0.5,-1.17l-0.92,-0.29l-0.16,-0.46l0.89,-0.6l0.19,-0.67l-1.08,-2.54l-1.65,-0.49l-0.09,-1.26l0.06,-0.98l2.71,-1.84l0.15,-1.32l-2.59,0.15l-1.93,0.66l-1.57,-0.76l-2.21,0.44l-2.22,-0.29l-4.34,1.51l-3.59,2.41l-1.2,-0.79l2.79,-3.0l0.02,-2.28l-0.92,-0.55l0.48,-0.82l-0.83,-1.38l-1.73,-0.03Z").attr(attr),
            "name" : "云南",
            "xy":[415,495]
        },
        "1,014," : {
            "path" : R.path("M588.88,461.02l-0.6,-3.22l2.16,-3.91l0.13,-1.99l2.71,-0.76l1.17,-0.86l0.59,-1.78l0.94,-1.16l1.39,-0.63l0.78,-1.33l-0.12,-1.02l-0.74,-0.48l0.04,-1.04l-1.45,-0.79l0.65,-1.14l0.13,-3.14l-3.4,-2.48l0.07,-1.04l1.26,-1.42l3.59,-1.22l0.52,-1.8l0.63,0.47l1.85,0.19l3.56,-1.13l0.49,0.42l0.7,-0.12l0.79,-0.54l0.91,-1.62l0.79,-0.11l0.33,-0.79l1.24,0.06l0.63,0.76l0.5,-0.17l0.43,-1.58l-0.31,-0.55l1.93,0.6l1.38,-0.6l1.05,-1.18l0.84,-2.15l2.94,-0.03l0.45,0.77l2.27,1.3l3.43,-0.87l1.88,0.07l2.29,-1.53l1.85,-0.31l1.32,-1.96l1.25,-0.59l1.08,0.44l1.26,1.36l-1.16,2.27l-1.71,0.64l-0.62,1.5l0.11,0.6l1.4,1.35l0.84,-0.29l1.55,0.22l1.39,-1.87l1.8,-0.86l0.45,-1.43l-0.43,-0.85l1.16,-1.02l0.71,1.41l2.12,0.13l0.57,1.64l1.58,1.76l1.57,0.1l1.15,0.93l4.23,-0.24l1.37,0.58l0.14,1.23l0.84,0.68l-0.6,1.18l-1.11,0.32l-0.97,2.58l1.19,1.73l2.82,2.04l2.3,3.47l-0.18,1.31l0.54,1.28l0.34,2.95l-1.8,1.64l0.39,0.99l-0.15,0.92l-3.13,0.73l-1.07,1.0l-3.73,0.77l-0.91,1.87l-1.65,-0.64l-0.91,-1.58l-0.63,-0.32l-2.77,1.76l-0.92,0.09l-0.16,1.52l-2.68,3.55l0.24,2.09l-0.34,1.41l0.81,0.89l-1.65,2.59l-1.49,1.24l-3.73,0.54l-1.93,1.84l-0.79,3.28l0.6,2.19l1.02,1.09l-0.24,1.1l-1.22,-0.3l-1.65,2.0l-0.08,3.62l-0.97,1.53l-1.84,0.61l-0.97,0.84l0.05,1.48l-1.68,2.17l0.17,1.2l-0.63,1.17l-0.36,2.52l-1.95,2.22l0.65,3.16l-0.48,0.63l0.54,0.89l-1.33,0.26l-0.68,0.94l-0.08,1.3l0.65,2.41l-0.93,0.23l-4.08,-3.72l-2.51,0.41l-1.59,1.14l-1.54,-0.33l-1.81,0.7l-0.82,1.14l-0.51,-0.51l-1.22,-0.14l-0.56,0.41l-0.19,0.83l-0.89,-0.53l-1.05,0.52l-1.19,-0.02l-0.9,0.82l-0.64,-0.95l-2.44,-1.42l1.81,-1.29l1.37,-3.12l4.66,-2.2l0.17,-0.53l-0.67,-0.55l0.44,-1.71l-0.47,-0.71l-1.49,-0.71l-0.28,-0.9l-0.61,-0.28l-0.95,0.52l-0.93,-0.04l-2.01,1.46l-2.32,-0.29l-1.34,0.66l0.11,-2.31l-1.24,-0.39l0.75,-1.92l-1.0,-1.37l-0.16,-0.93l1.62,-2.72l0.14,-2.02l2.44,-1.55l0.4,-0.81l-0.26,-0.56l-1.01,-0.41l-1.65,0.8l-1.16,-0.02l0.81,-1.05l0.34,-1.87l0.83,-1.11l0.22,-1.91l-3.3,-1.46l-0.45,-2.43l0.89,-2.29l-1.53,-2.13l-0.52,-0.16l1.37,-2.45l0.07,-1.35l-1.35,-0.72l-1.57,0.66l-0.77,-0.34Z").attr(attr),
            "name" : "江西",
            "xy":[624,462]
        },
        "1,008," : {
            "path" : R.path("M607.21,336.73l0.1,-2.32l1.25,-0.61l1.78,-2.6l2.57,-0.7l1.35,-1.01l0.11,-1.13l0.71,-0.25l0.26,-1.17l1.54,-1.35l2.12,-0.55l1.43,-1.63l1.81,-0.39l0.28,-0.55l-0.33,-0.53l0.85,-0.68l1.62,-0.02l0.86,-1.73l-0.24,-0.96l-0.56,-0.12l-2.06,1.29l-1.44,-0.15l-2.41,1.48l-3.02,0.54l-1.62,2.19l0.23,-2.08l1.25,-0.9l0.65,-2.22l-0.23,-2.43l-0.79,-0.97l-0.69,-0.16l-0.98,-2.57l0.94,-1.99l1.87,-2.37l2.67,-1.02l1.7,-2.3l0.12,-0.84l1.17,-1.29l0.61,-2.19l1.0,-1.01l0.12,-1.01l0.79,-0.47l2.83,-0.21l0.55,-0.79l-0.54,-1.08l1.45,-2.22l0.27,1.44l0.48,0.67l0.6,0.07l4.51,-4.65l0.86,-1.41l9.27,-0.16l2.26,-3.49l1.7,-0.38l1.06,-1.01l0.5,-0.87l-0.15,-0.99l0.64,-0.41l2.84,2.01l5.94,0.51l1.66,0.87l1.2,-1.16l2.6,-0.28l0.35,1.43l1.49,0.42l0.98,2.01l0.14,1.9l0.79,1.13l-1.74,2.13l-0.39,3.76l0.25,1.53l2.84,2.19l2.29,0.79l2.27,0.28l4.98,-0.54l2.05,-1.75l-0.53,-1.88l4.8,-2.57l1.69,-1.55l0.37,-0.59l-0.15,-0.78l5.99,-2.45l2.4,0.16l0.25,0.74l1.4,1.12l1.43,0.13l-0.1,1.21l0.42,0.78l3.22,-0.05l1.46,1.93l1.62,0.84l1.69,-0.17l0.17,-0.48l3.34,0.06l0.37,0.64l0.7,0.01l0.77,-1.81l1.15,-0.4l-0.24,0.96l0.91,1.28l1.07,-0.61l0.71,0.67l4.32,0.29l-0.87,1.13l0.75,1.74l-0.46,0.5l-1.6,0.18l-0.18,1.69l-0.62,0.63l0.38,0.83l1.52,-0.24l-0.1,0.65l-1.56,0.26l-0.1,0.99l-0.67,0.58l-1.96,-0.25l1.22,-0.42l-1.41,-1.12l0.16,-0.81l-0.37,-0.49l-0.68,0.14l-0.21,0.88l-0.78,0.28l-0.22,-0.81l-1.86,-0.2l-0.54,0.68l0.29,0.53l-2.02,0.57l-0.76,0.89l-3.85,0.11l-0.45,0.44l0.09,0.84l-0.81,0.14l-0.4,0.59l-2.98,0.72l-1.13,0.95l-0.73,-0.19l-0.27,0.57l-2.13,-1.03l-1.98,0.82l0.01,1.58l1.02,0.15l0.77,-0.94l0.99,1.07l-0.03,0.6l-0.59,0.45l-0.01,0.57l-0.44,-0.99l-0.52,-0.17l-0.91,0.09l-0.79,0.7l-0.34,1.37l-0.72,0.46l0.78,2.89l-4.65,1.53l-0.23,-0.48l0.67,-1.76l-0.82,-1.4l-0.84,0.03l-0.37,1.17l-0.46,-0.53l-2.02,0.02l-0.24,2.29l1.18,0.95l0.44,1.44l-2.12,1.52l-0.62,2.02l-0.87,-0.49l-0.72,0.53l0.28,0.78l-0.28,1.08l-0.72,-0.66l-0.95,0.84l-0.73,-0.23l-1.36,0.82l-1.38,3.34l-0.58,0.71l-1.34,0.47l-0.9,3.49l-2.17,-0.3l-1.78,1.0l-3.32,0.38l-1.78,5.11l-0.7,0.61l-1.75,-0.42l-1.63,0.55l-0.7,1.72l-0.15,1.77l-0.76,0.78l-2.08,0.3l-0.52,-1.08l0.22,-1.1l-0.87,-0.49l-0.25,-1.15l-2.52,-0.79l-2.07,0.34l-0.59,2.19l-1.41,-0.04l-1.26,1.08l-1.26,-0.17l-1.99,-1.89l-1.37,0.54l-0.83,1.79l-0.46,-1.72l-1.21,-2.47l-1.1,-1.26l-0.26,-1.09l-2.36,-1.99l-5.47,1.06l-0.9,1.21l-0.61,3.19l-1.76,1.05l-0.56,-0.27l-0.73,0.26l-0.78,-0.77l-0.69,0.23l-0.76,-0.35l-0.63,0.49l-2.1,0.34l-1.71,-0.49l-0.78,0.54l-1.39,-0.14l-1.18,-1.16l-0.26,-2.08l-1.89,-1.2l-1.09,-0.01l-0.01,-0.68l-0.72,-0.84l-2.84,-1.19l-1.93,0.04ZM685.46,321.14l0.32,-0.07l0.03,0.03l-0.17,0.15l-0.18,-0.11ZM706.14,306.99l-0.0,0.29l-0.29,-0.07l0.16,-0.18l0.13,-0.05ZM713.08,304.39l-0.08,0.29l0.02,-0.25l0.06,-0.04Z").attr(attr),
            "name" : "山东",
            "xy":[663,314]
        },
        "1,032," : {
            "path" : R.path("M540.9,343.98l0.74,0.46l0.93,-0.44l0.79,0.53l1.82,-0.33l1.69,-0.96l1.85,-0.13l0.73,-0.94l0.52,0.13l2.11,-0.92l0.49,-0.78l1.03,0.35l1.6,-0.7l0.74,0.32l2.69,-0.74l1.96,-2.42l2.05,-1.22l1.61,-0.14l1.03,0.72l0.6,-0.16l0.34,-2.92l6.48,0.24l2.15,-1.53l1.82,1.13l1.61,0.05l1.88,-1.52l1.42,-0.3l0.73,-0.69l1.71,-0.6l0.44,-0.62l2.31,-0.78l2.26,-2.44l-0.27,-2.62l0.61,-0.57l-0.1,-2.02l0.87,-1.66l0.14,-2.57l-0.3,-0.49l0.67,-1.73l3.51,-0.15l1.13,1.42l1.85,0.54l2.09,-0.03l3.32,1.82l4.09,-0.25l1.33,1.55l1.33,-0.32l1.49,-1.82l1.52,0.18l1.33,1.59l0.81,-0.13l1.03,-0.91l-0.51,1.85l-1.36,1.15l-0.25,2.52l0.47,0.61l1.48,-0.75l0.79,-1.58l2.98,-0.53l2.38,-1.47l1.26,0.19l-1.28,1.04l0.09,0.9l-1.47,0.23l-1.57,1.72l-2.38,0.62l-0.1,0.58l-1.36,0.9l-0.19,1.01l-0.88,0.61l0.11,0.69l-0.97,0.82l-2.93,0.96l-1.86,2.68l-1.32,0.68l-0.28,2.73l0.15,0.64l0.72,0.28l1.68,-0.14l2.56,1.04l0.49,0.58l0.08,1.2l1.46,-0.13l1.53,0.92l0.2,1.96l1.48,1.53l1.91,0.23l0.82,-0.52l1.56,0.49l2.83,-0.77l1.22,0.1l0.76,0.93l-0.08,1.51l0.82,0.94l2.76,2.13l2.49,-0.11l0.07,1.24l-0.47,1.12l1.41,3.13l-2.48,0.88l-0.5,1.06l-3.42,1.17l-2.72,-2.96l0.19,-0.93l-0.43,-0.73l-1.88,-0.18l-1.46,-0.95l-1.51,0.28l-1.2,1.32l-0.43,1.51l0.2,0.93l0.8,0.19l-0.05,0.67l-0.77,0.73l0.86,2.49l-2.12,0.3l-1.06,0.82l-0.91,0.02l-0.57,2.62l0.5,1.72l-0.95,1.84l-2.22,0.75l-2.11,-0.65l-1.52,1.1l-0.15,1.38l0.48,0.67l4.16,1.88l-0.16,2.3l0.61,2.18l2.5,0.56l2.78,2.51l1.7,-0.17l0.63,-1.13l1.49,-0.0l0.37,-0.65l0.9,7.75l-0.34,3.49l-2.88,-0.03l-2.35,0.87l-2.25,3.67l-0.56,1.74l-0.7,0.1l-0.73,-0.79l0.07,-1.38l-1.15,-1.21l-0.74,0.24l-1.23,1.7l-3.41,0.01l-2.11,-1.31l-1.22,-0.05l-0.13,-0.83l0.48,-1.2l-0.71,-0.9l-0.87,-0.2l-1.71,0.41l-1.4,-1.24l-1.82,-0.65l-1.58,1.43l-0.93,0.23l-0.08,-1.4l-0.54,-0.35l-0.74,0.17l-1.04,-1.91l-0.55,-2.37l0.42,-0.84l0.04,-2.83l-0.95,-1.33l-1.68,0.2l-1.6,1.71l-1.29,0.13l-1.21,-0.35l-1.82,-1.6l-0.75,-0.08l-0.86,0.51l-1.08,-0.71l-4.26,1.23l-3.27,-0.43l-3.39,0.52l-1.04,-0.7l-1.13,-0.07l-1.34,-1.0l-0.76,0.23l-0.67,-0.57l-2.54,-0.69l-0.75,-1.12l-1.12,-0.59l-0.81,-0.07l-0.82,0.49l-0.59,-1.48l-2.3,-2.53l-1.87,-1.31l0.02,-0.99l-1.62,-2.71l-1.58,-1.03l0.29,-4.39l-0.67,-1.86l-2.54,-1.7l-0.75,-1.76l-2.17,-1.12l0.74,-1.36l-0.75,-1.42l0.36,-1.85l-2.7,-1.65l0.69,-1.33l-0.42,-0.79l-1.71,-0.91l0.03,-2.39ZM622.93,320.46l0.54,-0.24l0.96,-0.65l-0.36,0.96l-1.14,-0.07Z").attr(attr),
            "name" : "河南",
            "xy":[586,355]
        },
        "1,034," : {
            "path" : R.path("M518.53,465.67l0.95,-0.51l0.19,-0.95l1.65,-1.13l1.74,-2.3l0.79,-0.44l1.2,0.05l2.69,-2.82l-0.07,-1.44l-0.64,-1.25l-0.95,-0.69l-0.3,-1.38l0.43,-0.77l-0.42,-0.51l0.82,-1.22l-0.37,-0.54l-0.67,0.02l0.91,-2.7l-1.42,-1.3l-0.19,-2.18l0.54,-1.79l-0.84,-0.76l0.78,-1.45l-0.6,-2.59l0.62,-2.56l-0.82,-0.92l0.41,-1.88l1.22,-1.09l-0.15,-0.98l0.7,-0.54l0.0,-0.73l1.21,-1.88l1.72,-0.83l0.71,0.38l0.76,-0.17l1.34,-2.09l4.69,-0.77l3.77,2.15l0.88,-0.45l0.3,-0.68l0.88,0.09l1.08,-0.59l0.46,-1.13l-1.68,-1.89l0.46,-0.9l-0.29,-0.82l2.89,0.35l0.59,-0.36l0.26,-0.81l6.94,1.05l2.36,1.74l1.14,-0.24l3.05,0.65l1.0,-0.41l2.37,1.06l3.53,3.26l0.73,0.03l1.18,1.87l2.62,-1.73l3.19,0.18l2.99,-2.46l0.58,1.34l-0.54,1.2l0.32,1.93l0.64,0.51l1.08,-0.66l0.04,0.81l0.6,0.41l1.53,-0.64l3.9,-4.62l1.63,-1.31l-0.49,2.39l1.74,0.28l0.3,2.22l0.78,1.24l-1.88,1.92l-0.25,1.35l0.91,0.54l0.16,1.47l0.8,0.99l0.43,0.09l0.9,-0.83l1.46,0.82l0.23,1.81l3.22,2.01l-0.22,2.56l-0.8,1.06l0.06,0.65l1.59,0.92l-0.1,0.74l0.86,0.66l0.01,0.44l-0.55,0.92l-1.38,0.59l-1.0,1.26l-0.48,1.68l-1.0,0.75l-3.02,1.01l-0.23,2.18l-1.39,2.07l-0.84,2.21l0.84,3.72l1.24,0.57l1.49,-0.65l0.75,0.27l-0.36,1.36l-1.04,1.38l-0.07,0.9l2.03,2.38l-0.86,1.92l0.5,2.79l0.67,0.64l2.58,0.87l-1.28,4.16l-1.08,1.81l0.77,0.62l1.61,-0.2l1.21,-0.74l0.66,0.24l-2.18,1.23l-0.65,0.82l-0.1,1.97l-1.66,2.88l0.26,1.44l0.9,1.13l-0.75,1.72l-0.65,0.29l-0.7,1.14l-1.79,-0.17l-1.52,0.51l-0.86,-0.87l-1.44,0.05l-2.11,-2.11l-1.45,0.31l-4.13,2.68l-1.02,-0.05l-0.18,0.71l0.56,1.27l1.8,0.05l-0.68,0.8l-0.12,2.01l0.34,0.96l-2.16,0.22l-1.11,-0.76l-0.42,-1.38l-1.05,-0.82l-6.42,-1.04l-0.51,0.45l-0.96,3.66l0.66,1.01l-0.26,1.03l-1.01,0.22l-0.63,0.72l-1.07,-0.42l-4.12,-0.06l-2.14,2.05l-0.77,-0.4l0.61,-1.67l-0.67,-2.27l0.46,-1.2l-0.64,-0.66l-0.14,-1.13l-0.79,-0.3l-0.82,0.33l-1.05,-0.44l-2.2,1.68l-1.02,1.81l-0.78,-1.31l0.53,-1.75l1.51,-0.92l0.99,-2.4l1.75,-1.04l0.6,-1.53l-0.04,-2.98l0.62,-0.27l0.82,-1.84l0.81,-0.66l-0.39,-1.03l-2.44,0.23l-0.47,0.69l-0.71,-0.84l1.13,-4.72l-0.46,-0.87l-2.04,-0.51l-2.62,-1.33l-0.64,0.31l-0.56,1.48l-2.18,0.01l-0.44,-0.9l-2.06,-0.22l-0.43,0.47l-0.17,1.6l-0.62,0.7l-1.07,0.12l-0.95,0.66l-1.38,2.21l-1.06,-1.05l-1.72,0.17l0.45,-1.65l-2.27,-0.89l-0.62,0.49l-0.85,1.87l-1.13,0.71l0.1,1.51l-1.13,0.26l0.06,-1.55l-0.98,-0.95l-2.21,0.02l-0.84,-2.42l0.25,-0.83l-1.35,-0.42l-0.27,-0.54l1.73,-3.78l-0.57,-1.32l-1.25,-0.68l1.44,-0.41l1.92,-1.44l-0.01,-0.82l-0.75,-0.51l0.66,-1.04l-0.16,-1.6l-1.33,-1.41l-1.41,-0.24l-1.0,0.31l-0.79,-0.27l-1.03,1.16l-0.07,-0.8l-0.77,-0.08l-2.8,1.96l-0.76,-0.75Z").attr(attr),
            "name" : "湖南",
            "xy":[557,460]
        },
        "1,012," : {
            "path" : R.path("M512.09,412.72l0.53,-1.11l2.29,-0.28l0.88,-1.0l0.38,0.57l0.77,0.19l2.27,-0.61l1.1,-0.8l1.51,0.11l1.17,0.62l1.84,-0.65l1.87,0.29l1.7,-1.21l0.82,0.0l2.59,-2.75l1.95,-0.99l2.11,1.09l1.07,-0.29l0.72,-0.98l0.28,-2.14l-0.48,-1.61l1.04,-1.44l-0.51,-0.94l0.04,-1.42l-0.65,-1.2l-1.98,-1.26l-0.19,-0.53l-3.26,-0.83l-0.5,-1.83l-1.71,-1.14l0.51,-0.89l-0.06,-1.92l0.92,-2.31l-0.93,-2.3l-1.14,-0.66l-0.69,-1.49l1.09,-0.86l0.2,-1.99l0.8,-0.88l1.56,0.01l0.78,0.46l0.88,-0.35l2.22,0.67l0.98,-1.06l0.94,0.13l0.47,-0.37l-0.1,-2.16l-1.26,-2.17l-2.83,-1.13l-1.33,0.34l-0.54,-0.26l0.47,-1.81l-0.62,-1.01l-4.17,-1.11l0.8,-0.78l1.01,0.15l0.77,-0.45l6.57,0.84l1.94,0.91l3.06,-0.31l1.38,-1.17l0.77,1.49l2.28,0.98l1.35,-1.75l1.26,-0.14l0.53,-0.75l0.43,0.75l1.41,0.83l1.5,2.53l0.08,1.18l1.97,1.38l2.3,2.53l0.77,1.59l1.68,-0.41l0.9,0.46l0.86,1.21l2.69,0.76l0.93,0.67l0.58,-0.3l1.21,0.94l1.2,0.1l1.23,0.74l3.47,-0.52l3.37,0.42l4.03,-1.22l1.05,0.72l1.46,-0.49l1.64,1.52l1.73,0.49l1.63,-0.23l1.42,-1.6l1.11,-0.17l0.52,0.62l-0.04,2.59l-0.43,0.87l0.58,2.66l1.28,2.33l1.19,0.06l0.16,1.6l1.64,-0.12l1.49,-1.43l1.34,0.53l1.51,1.29l2.57,-0.22l-0.29,1.5l0.25,1.12l1.55,0.32l2.37,1.39l3.78,-0.05l1.57,-1.89l0.54,0.73l0.02,1.54l1.03,1.03l1.27,-0.06l0.12,0.61l0.91,0.54l1.96,2.65l0.91,0.07l0.53,-0.92l1.91,1.47l1.24,-0.02l0.93,1.53l1.26,0.02l-0.18,0.5l-2.29,1.61l-0.09,1.42l-1.1,0.22l-0.33,1.44l1.06,1.86l0.73,0.28l0.8,1.07l0.09,0.61l-0.87,0.63l-0.18,0.75l0.57,1.14l1.86,1.45l0.44,3.79l0.77,1.13l0.17,1.51l-3.22,0.87l-1.89,-1.13l-0.64,-0.89l-3.28,-0.08l-0.48,0.17l-1.02,2.45l-0.95,1.01l-0.81,0.35l-2.94,-0.64l-0.25,0.67l0.52,0.39l0.13,0.78l-1.88,-0.31l-0.84,0.8l-0.68,-0.17l-1.1,2.21l-0.63,0.36l-0.69,-0.46l-3.6,1.16l-2.83,-0.57l-0.72,0.84l-0.04,1.04l-2.48,0.59l-2.28,2.07l-1.73,-0.88l-1.0,0.58l-0.45,-0.43l-0.16,-1.46l-0.84,-0.51l2.18,-2.9l-0.83,-1.49l0.11,-1.1l-0.52,-1.33l-1.65,-0.28l0.85,-2.41l-0.14,-0.68l-1.51,0.57l-1.62,1.32l-3.91,4.61l-1.44,-0.8l-1.16,0.59l-0.2,-1.88l1.49,-1.42l0.08,-0.97l-0.37,-0.38l-1.15,0.89l-0.16,-0.64l-0.84,-0.54l-3.3,2.59l-3.02,-0.24l-2.06,1.52l-1.06,-1.86l-0.78,0.12l-3.53,-3.11l-2.59,-1.17l-1.22,0.38l-2.89,-0.64l-1.16,0.23l-2.29,-1.72l-7.52,-1.04l-0.61,1.13l-2.27,-0.47l-1.49,0.81l0.36,0.72l-0.24,1.47l1.64,1.84l-1.01,0.65l-1.15,-0.08l-0.7,1.08l-2.18,-1.54l-1.76,-0.6l-4.86,0.86l-1.33,1.37l-0.16,0.8l-1.11,-0.35l-2.18,0.99l-2.06,3.46l0.06,1.09l-1.17,1.03l-0.26,1.59l-1.68,-1.55l-0.93,-1.49l-1.37,-0.68l0.12,-0.72l-0.75,-1.24l0.19,-2.38l-2.91,-1.3l-0.83,-2.39l-0.88,-0.18l-1.07,1.11l-0.32,1.02l-0.54,-0.17l-0.42,-1.08l1.33,-0.17l0.54,-0.62l0.11,-6.62l-0.42,-0.96l-1.98,-0.86Z").attr(attr),
            "name" : "湖北",
            "xy":[568,400]
        },
        "1,005," : {
            "path" : R.path("M455.35,502.86l1.1,0.98l1.8,0.67l1.66,-1.01l0.59,-0.99l1.92,-0.6l0.59,-1.6l1.82,-1.54l0.96,1.04l1.72,-0.27l0.57,0.29l1.12,1.8l2.64,0.57l1.78,1.18l1.64,-0.33l1.29,1.26l0.69,0.03l2.39,-2.33l0.38,-0.92l-0.34,-1.66l0.38,-0.3l1.28,-0.03l2.2,-0.85l3.14,-2.15l3.12,-0.35l0.59,-0.91l1.11,0.06l0.54,-1.92l-0.63,-1.25l1.3,-1.18l2.37,-0.3l0.71,0.81l-0.06,0.99l1.25,0.58l1.25,2.73l0.85,0.07l1.48,-0.87l0.67,1.02l0.99,-0.26l0.48,1.1l1.66,0.1l1.19,-0.9l2.47,-0.56l0.42,-0.73l0.03,-1.79l2.27,-2.04l1.35,0.29l2.63,3.11l0.63,-0.27l0.08,-0.55l-0.54,-1.53l1.17,-0.72l-0.09,-0.87l0.57,-0.59l0.54,-0.11l0.27,1.37l2.46,-0.4l1.3,0.51l0.74,-0.74l-0.04,-3.04l-0.7,-0.17l-1.85,0.83l1.08,-0.97l1.7,-0.4l0.65,0.84l0.89,-0.45l0.76,0.73l1.0,-0.1l1.77,-3.06l-0.18,-0.99l1.03,-0.83l1.71,-0.02l0.7,0.74l-0.28,0.99l0.37,0.68l1.69,-0.11l0.68,-0.73l-0.2,-1.23l1.05,-0.59l1.23,-2.05l1.18,0.5l-0.54,1.19l0.23,0.68l2.1,-0.05l1.36,1.1l0.92,-0.61l0.9,-1.85l1.91,-0.68l0.81,-0.89l0.33,-1.83l1.36,0.23l0.54,0.93l2.51,0.02l0.71,-0.42l0.38,-1.29l4.32,1.74l-1.17,4.4l0.81,1.7l0.97,0.4l0.58,-0.7l1.29,-0.06l-1.0,1.97l-0.8,0.41l-0.01,3.33l-0.48,1.18l-1.61,0.88l-1.07,2.5l-1.55,0.96l-0.65,1.74l0.08,0.9l0.87,1.42l0.81,0.24l0.81,-0.59l0.59,-1.43l1.9,-1.47l0.71,0.49l1.17,-0.24l-0.18,0.72l0.68,0.64l-0.46,0.88l0.18,1.74l0.48,0.7l-0.68,1.6l0.13,0.6l1.53,0.7l1.78,-1.13l0.51,-0.99l4.1,0.14l-0.6,0.53l-0.14,1.54l1.12,1.16l-0.2,1.12l0.93,1.59l-2.68,1.94l0.46,3.71l-1.2,1.02l-0.38,1.23l-1.92,-0.01l-0.73,1.46l0.18,1.15l-2.28,1.09l-0.02,0.87l-1.52,3.28l0.05,3.49l0.63,1.04l-0.86,2.18l-2.16,2.26l-2.13,0.31l0.26,0.84l-0.55,0.58l-0.99,-0.24l-0.54,0.66l-2.57,0.58l-0.49,1.48l-0.72,0.14l0.24,2.05l1.09,1.09l-1.24,-0.04l-0.9,1.67l-0.9,-0.3l-0.78,0.54l-1.16,-0.89l-1.42,0.41l0.11,3.23l0.47,1.18l-1.93,0.24l-1.66,-0.36l-2.29,0.59l-0.88,2.97l-1.04,0.49l-0.96,-0.35l-0.46,0.35l0.15,2.45l-0.66,-0.37l0.24,-1.52l-0.98,-0.1l-0.08,-0.59l-0.61,-0.19l0.46,-0.97l-1.05,-0.51l-1.66,1.78l1.49,1.27l-0.37,1.06l-0.86,-0.1l-0.5,0.64l-1.14,-0.24l-0.95,0.45l-0.45,-0.7l-0.63,0.32l-0.22,0.7l-1.03,0.03l-0.63,-0.25l1.28,-0.59l-0.04,-1.7l-1.56,-0.95l-1.67,0.47l-0.74,-1.35l0.83,-0.5l-1.37,-1.29l-1.53,0.33l0.59,0.58l-0.58,0.94l0.38,0.44l-0.51,-0.23l0.12,-0.61l-0.95,-0.41l0.24,-0.57l-0.96,-0.53l0.36,-0.72l-1.31,-1.35l-1.07,0.77l-0.1,-0.59l-0.85,0.42l-0.19,1.27l0.79,1.04l-0.6,0.77l0.35,0.38l-0.13,0.17l-0.36,-0.32l-0.52,0.38l-0.52,-0.74l-0.47,0.04l-0.73,2.03l-0.2,-0.7l-0.86,-0.14l-0.56,1.06l-2.57,0.35l-0.2,0.62l-1.8,-1.83l-1.07,-0.41l-4.15,1.12l-0.97,-1.05l-1.19,0.7l-0.89,-1.61l-1.57,-0.03l-2.46,-1.46l0.45,-0.93l-0.4,-0.89l-1.42,0.11l-0.79,-0.76l-1.96,-0.61l-0.85,0.49l0.29,-1.43l-0.45,-1.4l0.3,-0.72l-0.55,-1.52l-1.26,-0.46l-0.17,-1.17l0.67,-2.23l0.69,0.55l0.76,-0.27l1.05,-2.62l0.78,-0.66l-0.14,-0.61l-0.95,-0.19l-1.09,-1.07l-0.75,0.23l-0.62,-0.74l-1.26,-0.38l-0.7,0.57l-2.71,0.52l-0.69,-1.39l-1.2,-0.49l-2.03,-0.01l-0.7,0.7l-1.46,0.25l-2.14,-1.95l-2.06,-0.32l-0.15,-1.62l1.27,-1.23l0.19,-0.84l0.84,-0.07l0.23,-0.71l1.94,-1.88l2.17,0.8l2.04,-1.08l0.53,-3.41l-0.29,-1.07l0.97,-0.64l-0.81,-1.57l0.11,-0.7l-2.08,-1.35l0.15,-0.48l-0.52,-0.51l-1.83,0.59l-0.47,0.77l-0.98,0.08l-1.78,-0.69l-0.91,-1.19l-1.43,0.36l-0.51,1.13l-0.42,0.11l-2.09,-1.4l-0.59,0.2l-0.07,0.46l-0.91,-0.74l-0.0,-2.66l-1.47,-1.9l-2.12,0.15l-3.31,-0.75l-0.91,0.74l0.32,1.35l-1.4,-1.52l-0.99,-2.09l-0.25,-1.15l0.6,-0.88ZM517.56,549.84l0.44,0.3l-0.04,0.06l-0.4,0.04l0.0,-0.4ZM515.06,548.1l-0.01,-0.01l0.02,-0.01l-0.02,0.02ZM513.41,550.45l-0.18,0.19l-0.13,0.01l0.21,-0.26l0.09,0.06ZM513.0,550.67l-0.09,0.13l-0.05,-0.06l0.06,-0.04l0.09,-0.03ZM512.78,549.79l-0.01,0.0l-0.0,-0.02l0.02,0.02Z").attr(attr),
            "name" : "广西",
            "xy":[510,515]
        },
        "1,030," : {
            "path" : R.path("M531.14,558.51l1.4,-1.15l0.06,-1.58l2.21,-0.88l-0.2,-0.49l0.56,-0.81l-0.06,-0.71l-0.46,-0.4l-1.67,-0.08l-0.81,-1.45l0.88,0.1l1.44,-0.72l0.76,-2.85l1.88,-0.45l1.64,0.37l2.47,-0.36l0.27,-1.11l-0.52,-0.82l-0.09,-2.55l0.55,-0.16l1.18,0.84l0.94,-0.54l0.76,0.31l0.7,-0.27l0.71,-1.57l0.96,0.18l0.6,-0.5l-0.2,-0.81l-0.93,-0.84l0.02,-1.09l0.7,-1.41l2.47,-0.76l0.37,-0.56l1.15,0.14l0.95,-1.52l1.48,-0.21l2.41,-2.49l1.0,-2.64l-0.63,-1.13l-0.05,-3.29l1.42,-2.94l0.08,-0.97l2.16,-0.94l-0.03,-1.47l0.48,-1.02l1.98,-0.04l0.44,-1.32l1.33,-1.32l-0.54,-3.51l1.42,-0.58l1.31,-1.44l-0.91,-2.09l0.18,-1.4l-1.1,-0.85l0.11,-1.04l2.02,-1.46l0.55,0.37l0.51,-0.34l0.36,-2.01l-0.66,-0.72l0.91,-3.41l6.1,1.03l1.01,1.96l1.37,0.94l0.99,0.14l2.35,-0.62l-0.41,-1.5l0.12,-1.88l0.9,-0.9l-0.42,-0.66l-1.86,0.04l-0.26,-0.55l2.85,-1.16l2.17,-1.67l0.61,-0.11l2.07,1.96l1.54,0.02l0.78,0.98l1.95,-0.61l1.82,0.2l1.61,-1.53l0.84,0.4l-0.1,1.97l0.64,0.45l1.59,-0.67l2.5,0.25l2.12,-1.48l0.83,0.06l0.67,-0.48l0.39,0.97l1.69,0.91l-0.45,1.58l0.22,0.6l-4.07,2.08l-1.51,3.27l-2.2,1.75l0.24,0.53l2.69,1.49l0.76,1.08l3.57,-1.22l1.13,0.47l0.76,-1.26l1.67,0.68l1.05,-1.27l1.55,-0.55l1.66,0.26l1.55,-1.13l1.01,0.19l1.14,-0.56l3.76,3.61l1.75,-0.13l0.48,-0.54l-0.74,-2.75l0.1,-1.11l0.52,-0.47l1.32,0.02l0.36,-0.69l2.44,1.06l1.93,0.04l0.54,0.6l1.31,-0.5l2.21,3.48l3.54,-0.83l-0.35,1.83l2.06,2.38l1.09,2.78l-0.54,1.37l0.09,1.27l2.0,5.35l-0.67,0.3l-1.48,-0.23l-0.72,0.97l-0.19,2.14l-1.22,1.48l-1.78,-0.15l-1.06,-0.75l-0.71,0.01l-0.22,1.01l0.56,0.84l0.61,0.45l1.35,-0.18l-0.63,1.38l-0.76,-0.86l-1.34,0.59l0.32,0.66l0.51,0.02l-0.55,0.88l0.12,1.61l-0.57,0.88l-1.67,0.14l-0.83,-0.76l-1.22,0.07l-0.48,0.23l0.23,0.74l-1.12,1.17l-0.22,-0.92l-1.11,-0.4l-0.48,0.14l0.52,1.09l-2.9,1.08l-1.79,-1.11l0.58,-0.61l-0.15,-0.57l-2.62,0.83l-1.83,-0.86l-0.88,0.25l-0.01,0.47l0.52,0.53l0.62,-0.06l-0.31,0.47l0.33,0.39l0.8,0.12l-0.39,0.69l0.67,1.21l-2.33,-0.43l1.02,-0.71l-0.55,-0.58l-1.46,-0.09l0.57,-0.58l-0.52,-1.27l-1.25,1.14l-2.82,0.81l-0.9,1.41l-0.32,-0.99l-1.64,-0.01l-0.19,-0.62l-0.8,-0.38l-0.54,0.58l-0.81,-0.12l-2.04,0.93l-0.98,1.35l0.62,0.65l-0.65,0.63l-1.55,-0.92l-2.22,0.86l-2.18,0.25l-0.5,0.45l-1.84,-0.0l-0.99,-0.94l-1.08,-2.71l-1.26,-0.11l-0.82,-1.98l0.48,-1.79l-0.38,-0.54l-1.21,0.48l0.54,-0.69l1.59,-0.52l2.25,0.05l-0.1,-0.51l-2.05,-0.71l-2.96,1.48l-1.54,-0.45l-0.3,0.83l1.16,0.5l-0.07,1.23l-2.15,0.51l-1.32,-0.26l-0.48,0.51l1.43,0.8l0.92,-0.16l1.34,1.34l-1.19,-0.09l0.02,0.49l1.3,0.79l1.06,1.36l0.28,1.85l-0.45,1.48l0.95,0.75l-0.28,1.29l-0.72,0.82l-0.79,0.11l-1.04,-1.77l-1.18,-1.07l-1.43,-2.94l-0.92,-0.01l-0.02,1.6l3.12,4.22l-1.01,0.05l-0.82,1.74l-1.23,-0.28l-0.05,-1.78l-0.57,-0.37l-0.46,0.24l-1.36,1.55l0.1,2.56l-0.56,0.85l-0.63,0.2l-0.57,-1.3l-0.69,-0.2l-1.22,0.53l-1.47,1.28l-0.31,0.93l-0.75,0.23l-1.64,-0.97l-0.14,-0.52l1.15,-0.92l-0.35,-0.59l-1.16,0.34l0.12,-1.39l-0.57,-0.49l-0.64,0.69l-0.17,1.02l0.69,2.63l-0.41,0.84l-0.99,0.33l-0.95,-0.44l0.02,-1.41l-2.64,0.5l0.45,-0.89l-0.39,-0.47l-0.86,0.75l-1.16,-1.33l-0.6,0.33l0.08,1.44l0.99,1.1l-0.68,0.44l-0.61,-0.86l-0.64,0.26l-2.17,-0.39l0.0,0.52l1.39,1.37l-1.17,0.81l-0.61,0.99l-0.49,-0.69l-0.63,0.3l0.01,0.53l-0.84,0.05l-0.59,-0.98l-0.73,-0.1l-0.36,0.75l-0.82,0.37l-0.15,0.65l-1.68,-0.87l-1.06,0.54l-1.93,-0.39l-0.35,0.16l0.02,0.92l-1.64,1.03l-1.15,-0.26l-0.43,-0.64l-1.99,1.01l-0.52,0.91l0.24,1.29l-2.09,0.36l0.61,-0.45l0.12,-1.02l-0.81,-0.51l-0.31,-0.84l-0.49,-0.02l0.18,-0.42l-0.59,-0.35l-0.46,0.25l-0.18,0.5l0.48,1.07l-0.47,-0.16l-0.48,0.5l1.18,1.69l-0.12,0.66l-2.11,1.53l-0.23,-0.35l-0.59,0.3l-0.86,1.46l0.24,2.04l0.27,0.55l0.7,0.2l1.73,-0.3l-0.61,2.54l0.4,0.78l2.44,1.1l0.54,0.98l-1.65,2.29l-1.63,0.67l-1.1,-0.22l-1.12,0.38l-1.3,-0.81l-1.25,0.34l-0.18,-0.72l0.39,0.38l0.55,-0.31l0.47,-1.21l-1.25,-1.36l-1.45,-0.16l0.25,-0.98l-1.2,-0.95l1.07,-0.32l0.34,-0.62l-0.25,-0.42l-1.15,0.17l-0.17,-2.16l-0.66,-0.34l-0.46,0.45l-0.19,-0.39l0.69,-2.27l-0.54,-1.42ZM543.13,557.94l0.08,-0.04l0.34,0.53l-0.17,-0.05l-0.25,-0.44ZM583.01,543.82l0.02,0.05l-0.01,0.05l-0.01,-0.09ZM601.78,536.97l0.56,-0.18l0.55,0.24l-1.09,0.4l-0.03,-0.47ZM606.46,533.46l0.4,0.79l0.97,0.48l-0.49,0.96l-1.8,-0.13l-0.1,-1.57l1.02,-0.54ZM634.51,525.06l0.02,-0.0l0.01,0.02l-0.03,-0.02ZM639.65,519.39l0.88,0.5l-0.69,0.54l-0.03,-0.66l-0.16,-0.39ZM541.05,563.77l0.1,0.5l-0.03,0.09l-0.06,-0.1l-0.0,-0.49ZM534.6,570.21l-0.04,-0.04l0.03,0.03l0.01,0.02ZM534.46,570.05l-0.32,-0.15l0.01,-0.09l0.3,0.24ZM639.21,522.84l0.24,-0.36l0.55,0.17l-0.06,0.27l-0.74,-0.08ZM586.1,531.41l0.39,0.11l0.1,0.08l-0.16,0.15l-0.33,-0.34ZM587.4,532.44l0.1,0.06l0.03,0.01l-0.04,-0.0l-0.09,-0.07ZM584.85,544.52l0.14,-0.19l0.18,-0.06l-0.09,0.26l-0.23,-0.01ZM583.99,543.54l0.07,-0.02l0.03,-0.01l-0.08,0.06l-0.02,-0.03ZM583.38,546.39l-0.01,0.03l0.0,-0.03l0.0,0.01ZM576.33,549.57l-0.05,-0.04l0.08,-0.06l-0.04,0.1ZM576.65,549.13l0.02,-0.08l0.05,-0.0l-0.0,0.0l-0.07,0.08ZM573.59,550.6l0.05,-0.29l0.33,-0.17l0.03,0.22l-0.41,0.24ZM563.04,551.12l0.02,-0.24l0.7,-0.19l0.15,0.11l-0.87,0.31ZM544.13,561.72l0.15,-0.17l0.08,0.02l-0.18,0.21l-0.05,-0.07ZM539.8,560.39l0.95,-0.69l0.48,0.29l-0.49,0.02l-0.94,0.38ZM542.05,559.99l1.02,-0.38l0.09,0.08l-0.22,0.74l-0.89,-0.44Z").attr(attr),
            "name" : "广东",
            "xy":[585,521]
        },
        "1,029," : {
            "path" : R.path("M515.62,589.7l0.94,-0.9l-0.79,-1.88l0.73,-1.18l3.51,-1.76l1.21,-1.69l2.16,-0.81l0.87,-1.07l1.09,0.23l0.35,-0.59l-0.35,-1.36l-1.72,0.38l1.53,-1.42l2.08,0.62l0.42,0.5l1.68,-0.33l0.44,-0.49l-0.61,-0.47l0.04,-0.83l1.71,-0.53l0.47,0.77l0.54,-0.27l1.39,0.63l1.09,-0.84l0.2,0.91l0.89,0.35l0.64,-0.92l1.44,-0.19l0.46,-1.23l1.34,0.41l1.09,-0.4l1.11,2.08l0.5,-0.71l-0.33,-1.25l2.02,1.0l0.82,0.95l0.51,-0.72l-0.79,-1.9l1.14,-0.5l1.45,1.73l2.05,0.17l1.05,4.75l-1.82,1.62l0.33,-1.0l-0.51,-0.32l-0.88,0.27l-0.21,2.03l-1.73,1.44l-0.09,0.94l-0.5,0.35l-0.77,2.05l-1.14,-0.15l-0.5,0.39l1.3,1.49l-0.72,1.09l-0.15,1.24l-1.07,1.22l0.44,0.84l-0.46,0.83l-2.21,0.58l-2.75,2.45l-0.92,0.27l0.68,0.7l-3.15,0.78l-1.51,-0.09l-0.51,1.58l-1.66,1.33l-0.06,-0.63l-0.8,0.12l-1.28,-0.79l-4.01,-0.06l-0.6,-1.04l-1.92,-0.11l-2.82,-1.76l-1.44,-0.27l0.15,-2.97l-1.01,-1.93l0.46,-1.49l-0.53,-2.2Z").attr(attr),
            "name" : "海南",
            "xy":[532,588]
        },
        "1,018," : {
            "path" : R.path("M0.41,265.46l0.6,-1.95l-0.16,-1.38l2.81,-0.47l1.49,-2.23l-0.47,-2.28l-1.09,-1.19l2.1,-4.08l2.73,-1.11l2.5,0.2l5.54,-4.16l2.18,0.13l0.18,-1.04l-0.95,-1.01l0.5,-1.18l2.16,1.13l2.03,-0.27l0.95,0.37l5.14,-3.33l0.63,2.15l0.71,0.79l-0.41,1.32l0.73,1.57l3.6,-0.02l1.06,-1.08l1.38,-0.52l1.34,0.36l1.29,-1.17l0.41,1.32l0.62,0.32l2.54,-1.7l1.2,-2.27l0.83,-0.61l0.59,-2.96l1.61,-1.34l0.12,-1.75l1.26,-1.09l1.95,-0.48l1.6,0.56l3.15,-0.15l2.52,0.69l2.3,-0.3l2.6,-1.14l3.65,0.39l1.64,-1.25l1.47,-2.17l1.15,-0.82l0.06,-1.75l2.11,-1.28l1.59,-0.42l0.64,-0.99l7.84,-3.43l1.28,-0.95l1.58,0.19l3.26,-1.68l2.11,-0.28l1.33,-2.1l4.79,-0.29l1.06,-0.4l0.44,-1.14l-0.6,-1.63l0.76,-1.16l-1.06,-3.46l0.21,-0.97l-0.99,-2.58l1.43,-2.86l1.12,0.05l3.41,-1.38l-0.29,-1.13l-1.97,-0.67l-0.46,-0.69l3.43,-1.76l2.1,0.49l0.79,-1.25l-0.74,-2.4l-1.36,-0.73l0.85,-1.56l0.04,-0.9l-4.27,-9.24l-0.3,-1.4l-0.89,-1.13l0.5,-1.96l-0.63,-3.99l0.77,-2.62l-0.4,-0.85l1.82,-0.7l0.18,-0.94l-3.99,-1.87l-3.64,0.41l-1.67,-0.93l-0.09,-0.41l3.37,-2.2l4.18,-0.25l0.91,-1.07l1.32,0.05l2.3,-0.76l2.37,0.29l10.1,-3.03l1.73,-0.96l1.08,0.49l0.57,2.2l2.36,0.96l4.52,-1.56l1.15,0.4l2.03,1.66l1.46,-0.27l1.16,-2.44l0.2,-3.34l-1.94,-1.06l-2.25,-0.3l-0.72,-0.65l1.13,-3.42l1.73,-3.11l1.16,-5.4l1.57,-2.5l2.42,-7.4l2.17,-3.93l0.43,-4.7l1.42,-0.06l5.58,2.71l5.6,1.73l2.6,0.19l2.83,-0.66l3.69,0.56l2.05,-0.26l1.0,0.92l-0.52,1.54l0.81,0.68l2.75,-0.72l4.47,-3.5l4.25,-0.41l0.81,-2.25l1.47,-0.49l0.41,-1.47l-0.01,-1.88l-1.38,-2.39l0.16,-2.43l-1.17,-5.49l1.03,-4.0l1.91,-4.01l0.75,-0.74l3.14,-0.4l2.89,0.18l1.73,-1.24l1.75,-0.03l2.08,-0.83l2.88,-3.71l-0.14,-1.37l0.67,-1.36l-1.11,-1.95l1.94,-2.5l1.7,0.23l1.97,-0.67l4.2,1.1l1.22,-0.35l0.47,-0.58l4.06,-0.85l0.02,2.26l0.74,0.88l-1.63,0.87l-0.35,1.23l0.91,0.74l0.52,1.11l2.31,0.63l1.01,0.72l-1.72,1.98l0.7,1.07l4.81,1.63l1.65,1.41l1.23,0.02l0.8,0.81l-0.11,1.23l0.61,1.55l1.77,0.69l1.4,1.12l1.68,0.03l1.93,2.12l2.75,0.32l2.0,-1.15l2.61,0.14l0.42,1.19l1.17,1.24l0.83,0.28l0.65,1.15l2.23,-0.01l0.66,-0.27l0.35,-0.89l0.99,0.14l-0.12,0.99l0.57,1.23l1.3,0.94l2.38,0.77l-0.18,0.64l1.65,2.43l0.1,1.58l0.59,0.56l-0.23,1.35l3.64,5.54l2.47,1.21l0.69,1.29l-0.14,1.03l1.19,1.43l-0.16,2.51l0.74,0.68l-2.21,4.8l1.48,3.56l0.08,1.45l-4.25,4.86l-0.92,4.86l1.52,1.53l0.64,2.34l0.99,0.66l0.14,1.29l0.84,0.24l1.15,-0.54l1.61,0.07l2.22,1.48l1.82,0.29l0.94,-0.58l1.56,1.36l7.39,-0.07l2.19,1.09l4.21,0.32l5.51,-0.75l1.4,0.6l3.17,-0.04l5.29,1.03l2.59,1.28l3.15,3.66l2.16,0.5l1.69,-0.21l2.17,2.59l1.57,0.28l2.18,1.17l1.69,1.71l5.09,1.63l4.74,-0.54l-0.88,1.84l0.01,2.81l3.18,1.08l2.29,5.83l2.04,3.92l0.62,2.92l6.26,5.73l0.52,0.97l0.24,2.38l-3.67,2.19l-0.71,1.0l-0.56,7.26l0.39,2.19l-2.49,2.52l-1.12,0.37l-4.19,-0.45l-6.38,1.19l-7.13,3.62l-8.52,8.56l-6.34,8.97l-4.04,1.95l-3.66,-0.35l-1.77,0.6l-0.39,6.58l-2.23,4.09l2.76,7.4l-0.24,4.52l-8.1,1.55l-3.59,2.1l-7.19,1.96l-2.43,0.24l-2.5,1.14l-4.1,0.79l-5.22,0.38l-0.62,1.06l-3.6,2.24l-2.46,0.26l-0.97,0.6l-0.14,0.86l0.63,1.56l3.61,5.63l0.11,1.12l-0.64,1.56l0.33,0.92l6.17,3.18l1.58,1.38l2.03,0.7l1.1,3.0l2.27,3.17l-0.21,1.09l-4.19,1.39l-2.64,0.15l-2.15,2.41l-0.13,1.78l0.44,1.31l1.51,1.39l2.79,0.78l1.85,5.96l-0.13,0.68l-3.13,1.11l-3.77,-1.75l-6.84,-0.34l-0.93,-1.41l-1.09,-0.75l-0.6,0.4l-0.82,2.66l-3.63,-0.08l-6.62,-3.03l-3.59,-0.23l-2.09,-1.6l-1.97,0.02l-4.68,-1.45l-5.91,0.45l-1.7,1.01l-4.57,0.58l-3.33,-0.68l-2.47,1.23l-5.78,0.69l-1.83,0.67l-2.82,-0.05l-1.01,0.86l-2.99,1.03l-1.91,4.12l-1.77,1.7l-3.28,-0.03l-2.18,1.82l-0.45,-0.89l-1.39,-0.7l-2.63,0.36l-1.88,-0.31l-3.33,1.01l-2.17,1.49l-3.15,0.69l-5.67,3.03l-2.34,-0.7l-2.14,0.74l-3.67,0.25l-5.66,-1.07l-1.53,0.31l-1.94,-1.28l0.14,-1.98l-0.42,-0.86l-2.18,-0.68l-1.78,0.69l-4.41,-0.57l-1.46,0.83l-0.51,1.59l-3.17,1.75l-0.98,1.97l-5.67,1.33l-2.62,-1.47l-3.07,0.14l-2.15,-1.22l-0.73,0.4l-0.19,1.18l-0.33,0.04l-1.53,-0.84l-1.75,-0.02l-1.28,-0.62l-2.63,-0.35l-3.12,-2.06l-0.78,0.54l0.0,1.57l-1.33,2.91l-2.17,2.34l0.29,1.76l-1.5,0.46l-0.81,0.84l1.12,3.72l-2.36,4.25l-0.71,0.17l-1.65,-0.75l-2.0,-0.23l-2.04,0.66l-2.1,-0.11l-3.36,1.54l-2.17,-1.07l-2.13,-1.91l-4.24,-0.88l-1.02,-0.64l-1.19,-3.62l-0.9,-1.5l-0.32,-1.99l-1.83,-3.42l0.78,-2.9l-0.53,-1.16l-1.05,-0.0l-1.36,1.0l-1.53,-1.11l-1.73,0.67l-3.65,-0.19l-1.89,-0.97l-2.01,0.05l-1.48,-0.99l-1.83,0.03l-1.02,-0.96l-1.21,-0.12l-1.16,-1.05l-1.49,-0.6l0.01,-1.72l-0.69,-0.9l-2.28,1.21l-3.14,0.4l-0.93,-2.7l-2.14,-0.63l-0.62,-0.74l-0.02,-0.47l1.04,-0.73l0.04,-0.85l0.64,-0.67l-0.67,-1.24l0.1,-2.71l-2.0,-3.29l-3.13,-1.93l-1.37,-0.2l-1.7,0.73l-0.64,-2.68l-1.16,-0.78l-3.22,-1.13l-2.49,0.29l-0.82,0.58l-1.04,-1.16l-1.18,-0.1l-0.67,-0.59l-2.15,0.43l-0.59,-0.84l-1.39,-0.75l0.98,-0.22l0.56,-0.88l1.84,-0.0l1.36,-1.04l0.82,1.29l1.75,-0.24l0.91,-0.86l1.72,-0.53l0.49,-1.19l0.9,-0.31l0.1,-0.72l-3.85,-3.21l-0.08,-0.6l1.18,-2.16l-1.14,-1.11l0.38,-0.65l-0.51,-2.64l-1.31,-1.01l-0.27,-3.42l0.98,-1.43l-0.08,-1.66l-1.23,-1.18l-6.44,-2.59l-1.68,0.29l-1.67,-0.28l-1.31,1.24l0.08,1.14l-1.27,-0.04l-1.58,-0.9l-1.05,-2.15l-0.05,-1.42l-0.73,-0.98l0.35,-0.49l1.42,-0.3l0.36,-1.1l-1.83,-1.75l-1.45,-2.63Z").attr(attr),
            "name" : "新疆",
            "xy":[167,217]
        },
        "1,022," : {
            "path" : R.path("M453.32,296.26l0.57,-0.91l1.08,-0.31l2.03,0.39l4.62,-0.77l1.54,-1.72l2.56,-1.24l1.66,-0.46l2.0,0.5l2.11,-0.19l2.47,-1.4l0.54,-3.5l-1.04,-2.51l1.34,-1.95l-0.36,-2.31l0.27,-2.94l0.79,-2.76l2.4,-4.15l0.71,-2.31l1.68,-0.0l0.85,-0.66l-0.03,-2.05l2.98,-0.04l1.86,-1.28l1.99,-0.14l0.25,2.73l1.21,2.03l1.31,0.86l-3.98,6.27l-0.95,3.19l-2.49,2.78l0.09,0.63l5.39,2.44l3.47,0.61l1.41,-0.41l2.2,1.13l1.44,2.72l3.39,0.95l-0.26,0.72l-2.01,0.24l-0.46,1.22l-2.36,2.01l0.13,0.95l-1.24,3.84l1.3,2.55l-0.34,0.81l-2.16,-0.68l-2.98,0.27l-2.53,-1.64l-1.35,0.05l-0.64,0.57l-0.39,2.06l0.26,0.98l-0.93,1.43l1.12,2.04l-0.42,0.98l-0.8,-0.06l-0.98,0.65l-0.13,2.75l-0.9,0.7l0.94,1.3l0.12,1.26l-0.42,1.05l0.84,0.96l1.4,-0.26l1.96,1.16l1.16,-0.03l1.54,1.94l-0.13,1.47l-0.17,0.94l-1.15,0.59l0.9,1.72l-0.58,0.57l-1.55,0.91l-2.6,-0.92l-2.14,0.55l-0.14,0.71l0.63,1.71l-0.73,0.17l-0.15,0.51l0.41,0.86l0.81,0.35l-0.11,0.98l-0.39,1.15l-1.18,0.99l-2.08,-2.41l-1.88,-0.4l0.26,-0.5l-0.47,-0.55l-2.05,-0.64l-1.29,0.59l-1.89,-2.41l0.56,-0.79l-0.27,-0.46l-2.43,0.14l-1.84,-0.93l-1.54,-3.26l0.34,-1.08l1.4,-0.96l0.18,-2.79l-0.6,-1.95l-2.03,-3.11l-0.7,-2.42l1.3,-0.96l0.13,-0.82l-2.55,-3.46l-3.35,-1.69l-1.01,-2.08l-1.57,-0.65l-0.96,0.61l-0.72,-0.27l1.38,-1.1l-0.35,-1.89l-3.56,-0.63l-1.0,0.55Z").attr(attr),
            "name" : "宁夏",
            "xy":[476,298]
        },
        "1,003," : {
            "path" : R.path("M233.37,320.68l1.99,-1.02l5.27,-0.15l0.61,-0.67l0.53,-2.17l1.64,1.97l6.95,0.38l3.43,1.79l3.92,-1.17l0.65,-0.79l-1.91,-6.96l-3.73,-1.63l-0.82,-0.94l-0.1,-1.83l1.82,-2.22l2.46,-0.09l4.52,-1.53l0.54,-0.83l-0.14,-1.32l-2.28,-3.14l-1.28,-3.22l-2.16,-0.8l-1.59,-1.39l-5.92,-2.98l0.52,-2.21l-0.19,-1.18l-3.65,-5.7l-0.43,-1.72l3.04,-0.49l3.69,-2.3l0.37,-0.9l6.68,-0.68l2.63,-0.51l2.51,-1.14l6.07,-1.08l3.64,-1.14l3.55,-2.08l7.87,-1.51l1.71,0.06l1.58,-0.87l2.18,0.15l2.11,-0.56l1.7,-1.01l2.93,-0.49l2.36,0.41l3.65,-0.68l7.01,0.49l1.35,1.0l2.84,0.69l1.37,0.8l4.41,-0.52l2.1,2.25l1.67,0.62l1.85,2.15l1.3,0.39l1.53,1.35l1.84,0.63l0.58,1.18l3.7,0.83l2.83,1.39l-0.11,0.92l0.65,0.68l3.24,1.36l2.47,0.5l0.83,-0.26l0.29,-0.73l0.18,-3.28l-0.45,-1.28l0.6,-1.57l0.15,-4.4l-0.43,-1.89l0.54,-1.06l1.58,-0.15l3.23,0.89l10.68,5.98l2.97,-2.31l0.73,-1.46l1.51,1.1l2.11,0.23l1.36,-0.49l1.3,-1.63l1.97,0.56l1.0,1.0l1.57,0.12l0.16,1.25l5.92,5.04l0.91,1.48l3.63,2.6l4.05,1.46l1.22,1.25l0.61,-0.21l0.13,-0.64l-0.28,-1.36l-1.0,-1.4l0.19,-1.18l2.84,2.84l2.88,0.76l0.92,2.29l0.65,0.6l6.12,2.44l3.58,2.81l5.89,3.43l1.04,1.22l1.12,-0.15l0.29,-1.4l1.5,-1.82l0.33,1.62l1.02,1.0l-0.47,0.9l0.19,0.82l5.74,3.23l1.72,1.81l-0.86,1.03l-0.52,2.34l3.23,2.8l-0.01,0.42l-1.2,0.69l0.04,0.97l1.51,1.17l1.02,1.83l0.85,3.02l2.88,1.52l-1.43,2.43l1.03,1.37l-0.44,0.9l0.19,1.24l-2.47,-0.36l-1.65,0.61l-0.32,1.58l0.61,2.29l-0.21,1.29l-2.28,-0.31l-1.65,1.69l-2.03,0.41l-0.57,2.54l0.92,0.41l0.78,1.11l-1.49,1.88l-1.05,0.32l-1.57,1.3l-1.08,0.24l-1.22,1.1l-0.43,0.78l0.04,1.27l-0.79,-0.14l-1.58,1.22l0.06,0.82l0.71,0.84l0.86,0.16l0.85,-0.6l0.67,1.63l2.71,0.95l0.89,1.9l-0.75,1.01l-1.02,0.21l-1.89,2.27l-1.23,-0.17l-1.22,1.21l-2.83,-2.25l-3.61,-0.85l-1.04,-0.69l-2.88,-0.49l-1.85,-0.94l-0.95,0.41l-1.43,1.59l-0.41,1.33l0.18,1.03l2.39,3.87l1.05,0.89l1.6,0.41l0.61,3.24l1.05,-0.2l2.31,0.57l1.81,-1.07l1.44,3.13l2.09,-0.04l-1.48,1.72l-0.04,1.24l0.88,0.76l-1.18,2.05l-1.15,-1.21l-1.4,-0.73l-0.82,0.18l-0.29,0.61l-0.82,-0.21l-2.46,1.21l-0.69,3.29l0.39,0.86l1.11,0.69l0.11,0.64l-1.05,2.01l-1.22,-0.13l-2.01,0.87l-1.15,-0.59l-2.59,-0.31l-1.28,3.99l-0.75,0.43l-0.44,-0.62l1.33,-1.54l-1.2,-2.2l-1.69,-1.3l-2.06,0.48l-0.66,1.52l-0.76,-0.17l0.47,-1.57l-0.3,-1.46l-1.54,-1.68l-1.42,-0.15l-1.12,-1.33l-0.77,0.13l-0.27,1.12l-1.07,0.62l-0.59,2.67l-2.51,-1.37l-3.4,-0.91l-1.27,-2.09l-4.84,-2.34l-1.28,-1.97l-0.38,-2.86l-1.72,-2.46l0.26,-0.96l-3.19,-3.13l-0.92,-0.32l-1.48,0.29l-0.87,-1.42l-3.0,-0.45l-3.9,1.66l-0.07,-1.19l-0.63,-0.99l-1.25,-0.15l-0.56,1.19l-3.26,0.98l-0.51,0.83l0.42,4.08l1.23,0.75l0.75,1.76l2.87,0.93l-1.48,0.65l-1.86,2.4l-0.35,1.34l0.38,1.67l-1.38,0.71l-0.67,1.15l0.34,2.21l0.69,1.3l4.02,2.78l-0.71,0.83l-0.91,-0.61l-3.17,-0.25l-0.79,1.81l1.02,0.66l-0.15,1.42l-1.0,-0.06l-0.54,0.42l-0.52,1.62l0.26,1.16l-0.85,0.07l-0.64,0.86l-2.0,-0.17l-4.19,1.08l0.01,0.71l0.7,0.64l-0.58,1.09l0.69,1.56l-0.25,0.51l-1.38,-0.74l-2.67,-0.55l-2.26,-2.34l-2.11,0.42l-0.96,1.63l1.3,1.69l-0.16,2.22l-0.88,-2.27l-0.9,-0.6l-4.15,0.27l-0.72,-0.76l-1.32,-0.28l-2.16,0.29l-1.09,-0.94l-0.72,-2.25l1.01,-0.74l0.05,-1.46l-0.49,-1.28l-1.29,-0.49l-0.78,-0.95l-2.82,-0.23l-1.52,-1.02l-0.55,-2.14l-2.6,-1.4l-0.36,-0.81l-1.82,-1.48l-3.08,1.29l-0.94,-0.32l-0.48,1.13l-2.12,0.36l-0.97,0.7l-3.55,-0.33l-0.74,-0.9l-1.16,-0.32l-2.1,0.14l-1.4,0.81l-0.61,-0.75l-1.23,-0.12l-2.45,-1.6l-2.24,0.16l-0.73,-1.4l-2.19,0.2l-1.76,-0.51l-1.27,0.31l-3.98,-0.49l-2.16,0.45l-0.35,-2.01l-1.62,-0.35l-1.69,0.64l-2.31,-1.92l-1.35,-0.23l-2.56,-1.57l-2.32,-2.98l0.32,-0.77l-0.65,-0.51l-3.13,0.03l-0.74,1.32l-2.72,0.28l-1.55,1.4l-0.78,0.19l-2.62,-0.77l-2.33,-1.63l-1.95,-0.25l-1.11,-1.45l-0.04,-1.63l-0.68,-1.06l-2.71,-1.15l-0.32,-1.38l-0.86,-0.64l-0.16,-1.05l-2.12,-1.57l-1.42,-2.34l0.19,-0.79l0.99,-0.23l0.93,-0.93l0.92,-2.84l-0.16,-0.72l-0.58,-0.34l-0.05,-2.32l-0.43,-1.8l-0.66,-0.9l1.31,-1.24l0.28,-0.92l-0.77,-1.6l-3.11,-0.3l0.11,-1.98l-1.68,-2.32l0.43,-1.82l1.8,-0.57l1.91,-1.22l0.07,-0.71l-0.7,-0.56l1.49,-5.1l-0.61,-0.66l-2.09,0.04l-1.64,-0.48l-0.9,-1.74Z").attr(attr),
            "name" : "青海",
            "xy":[332,329]
        },
        "1,033," : {
            "path" : R.path("M284.85,266.53l0.23,-4.69l-2.74,-7.21l2.21,-3.95l0.32,-6.35l4.85,0.14l4.41,-2.13l6.44,-9.08l8.32,-8.38l6.91,-3.53l6.27,-1.17l4.14,0.46l1.58,-0.54l2.78,-2.99l-0.38,-2.32l0.38,-6.35l0.54,-1.27l3.88,-2.32l11.81,-1.14l9.41,20.14l-2.56,2.22l-0.04,1.73l4.34,5.21l5.37,3.89l-1.29,5.84l0.24,0.71l5.68,-0.35l3.36,-3.13l4.76,-1.87l4.99,-0.12l2.5,-1.02l1.4,-0.14l3.92,0.44l1.93,2.79l0.02,1.94l-2.7,3.25l-1.26,2.95l-4.23,2.57l-1.44,1.24l-1.55,2.21l0.36,0.56l4.69,0.29l2.4,1.61l4.33,1.47l0.91,0.94l0.42,1.52l2.31,0.87l0.62,1.23l4.44,0.25l0.82,4.75l2.78,2.23l0.87,0.15l1.27,-0.44l-0.12,1.19l0.95,1.51l0.84,0.46l-0.29,0.59l0.38,0.66l3.98,1.24l3.98,-0.12l3.05,-3.4l-0.22,-0.68l-2.7,-2.72l7.98,-2.54l2.72,1.02l5.67,1.02l2.62,-1.86l4.76,-2.26l4.14,-1.15l4.18,-0.19l-0.17,1.67l2.47,3.85l-0.03,0.84l-0.75,1.39l-1.52,0.94l-2.68,4.26l-6.43,3.97l1.23,4.59l-2.07,0.91l0.52,4.38l0.5,0.51l3.42,1.09l6.31,5.31l2.18,1.21l2.48,-0.09l1.03,-0.71l2.66,0.49l0.48,0.98l-1.25,0.79l-0.2,0.6l0.34,0.54l1.08,0.48l1.16,-0.6l1.04,0.46l0.86,1.92l0.73,0.67l3.1,1.5l1.96,2.78l-1.24,0.75l-0.19,1.06l0.75,2.5l2.04,3.11l0.54,1.94l-0.15,2.08l-1.17,0.67l-0.47,0.77l-0.06,1.94l1.75,2.94l2.12,1.03l1.55,-0.25l0.23,1.22l2.03,2.45l0.81,0.08l0.88,-0.56l0.94,0.31l-1.81,0.39l-0.22,0.59l0.31,0.55l4.27,0.0l1.88,2.27l1.31,0.27l1.48,-1.34l0.44,-1.37l0.05,-1.44l-1.08,-0.75l1.12,-0.06l0.21,-0.56l-0.87,-0.89l-0.29,-1.25l1.91,-0.12l2.15,0.85l2.02,-1.03l0.97,-1.0l-0.79,-1.72l1.17,-0.59l0.14,-2.75l-0.4,-0.75l-1.61,-1.86l-1.2,0.04l-1.94,-1.16l-1.34,0.25l-0.45,-0.43l0.44,-0.73l-0.12,-1.47l-0.78,-1.02l0.73,-0.69l0.0,-2.49l1.58,-0.39l0.73,-1.41l-0.04,-0.86l-0.93,-1.36l0.78,-1.23l-0.22,-1.16l0.32,-1.8l0.33,-0.16l0.99,0.08l2.28,1.56l3.08,-0.25l1.59,0.41l0.34,0.28l0.24,2.85l3.31,0.42l0.62,0.83l2.25,0.3l2.68,1.11l0.82,1.25l1.06,0.3l0.4,1.1l1.95,0.53l0.7,-0.45l1.88,0.74l1.2,1.4l2.66,0.6l1.14,0.99l-0.87,1.7l0.81,1.94l-0.32,2.08l-2.74,2.21l0.47,1.45l-0.14,2.01l1.33,2.22l0.18,2.44l-1.38,1.6l-3.3,0.19l-1.19,-0.52l-3.13,1.16l-0.42,-0.58l-3.08,-0.98l-0.46,0.41l0.03,0.84l-0.72,0.22l-0.25,0.52l1.35,2.58l1.17,1.18l-1.4,0.35l-2.31,-0.2l-0.95,0.64l-2.84,-0.28l-1.34,0.8l-2.17,-2.33l-2.18,-0.91l-4.99,0.07l-1.47,0.95l-0.14,1.95l0.71,1.74l-3.34,4.2l0.84,1.25l2.0,0.05l1.42,0.77l0.93,1.29l0.23,1.6l-1.59,-0.43l-1.0,0.28l-0.03,0.69l0.7,0.29l0.47,1.35l-0.87,0.21l-1.55,3.44l0.22,0.93l0.59,0.35l-0.34,0.54l0.19,1.66l1.28,1.37l-0.1,0.85l-0.56,0.17l-1.1,-1.16l-1.86,0.11l-1.72,0.79l-1.1,-0.87l-1.27,0.0l-0.83,0.99l-1.86,0.94l-0.62,1.46l-1.15,0.39l-0.19,0.96l0.66,1.29l2.36,0.97l-0.38,3.57l-3.02,1.41l-2.68,-0.57l-1.2,0.39l-0.74,1.32l0.92,1.4l-2.18,1.49l-1.12,-0.31l-1.14,1.08l-0.9,-0.7l-1.97,0.44l-1.24,-0.54l-2.64,-0.22l-1.16,-0.45l-2.23,-1.97l-1.54,-0.45l-0.02,-0.9l1.31,-0.57l0.54,-1.2l-0.17,-0.91l-1.58,-2.09l-0.21,-1.14l1.3,-0.29l0.22,-0.65l-1.48,-0.88l-1.64,-1.97l-0.0,-1.5l-0.5,-1.04l-1.01,-0.6l-4.8,-0.06l-1.83,-0.68l-1.38,0.18l0.51,-1.26l-0.41,-0.6l-2.52,0.95l-2.13,-0.38l-0.44,-0.34l0.04,-1.26l-0.64,-0.76l-0.11,-3.51l-2.02,-1.09l-1.58,-1.62l-2.51,0.59l-2.76,1.94l-0.14,0.71l0.36,0.37l-1.93,0.25l-1.25,1.53l-1.3,-0.14l-1.78,0.81l1.16,2.09l-0.12,0.68l0.97,0.54l-0.27,0.3l0.52,0.68l-0.02,1.0l1.87,1.56l0.17,1.11l-2.49,1.18l-0.69,0.91l-1.37,0.41l-0.76,1.38l-1.51,0.07l-1.35,1.13l-0.49,-1.28l1.47,-2.86l-0.73,-2.39l-1.59,-1.08l-0.53,1.25l-1.79,0.4l-0.7,-2.19l-1.08,-1.08l-2.1,1.07l-2.75,-0.4l0.06,-1.53l-0.54,-1.37l-1.93,-0.67l-0.76,-0.68l-2.27,-3.68l0.24,-1.71l1.56,-1.5l1.71,0.9l2.89,0.5l0.96,0.66l3.6,0.84l1.0,1.11l2.12,1.23l1.58,-1.29l1.4,0.04l1.85,-2.24l1.06,-0.24l1.02,-1.53l-1.06,-2.46l-1.29,-0.79l-1.56,-0.3l-0.81,-1.79l-1.48,0.61l-0.61,-0.75l2.18,-0.79l0.36,-2.03l1.1,-0.99l3.86,-2.0l1.64,-2.07l-0.06,-0.89l-1.46,-1.41l0.48,-0.97l-0.17,-0.68l1.7,-0.16l1.6,-1.67l2.1,0.36l0.63,-0.41l0.32,-1.23l-0.62,-2.8l0.17,-0.9l1.16,-0.44l2.97,0.23l-0.07,-1.83l0.44,-1.08l-1.03,-1.18l1.48,-2.19l0.03,-0.63l-2.25,-1.63l-0.98,-0.26l-0.61,-2.63l-1.08,-1.96l-1.47,-1.09l0.01,-0.36l1.07,-0.49l0.09,-1.21l-3.11,-2.62l0.45,-1.9l0.91,-0.86l-0.17,-0.93l-1.97,-2.05l-3.1,-2.03l-2.42,-1.01l0.37,-1.59l-1.01,-0.97l-0.58,-2.14l-0.88,0.09l-1.56,1.83l-0.55,1.62l-0.99,-1.19l-5.91,-3.44l-3.63,-2.84l-6.07,-2.41l-1.46,-2.81l-2.99,-0.84l-2.88,-2.88l-0.92,0.05l-0.45,1.47l1.05,2.51l-1.76,-1.1l-2.87,-0.84l-3.51,-2.52l-0.87,-1.44l-5.84,-4.95l-0.27,-1.37l-1.74,-0.23l-0.99,-0.99l-1.92,-0.6l-0.86,0.06l-0.71,1.2l-1.21,0.81l-2.12,-0.16l-1.04,-0.97l-1.03,-0.12l-1.04,1.68l-2.46,2.01l-10.29,-5.89l-3.47,-0.94l-1.97,0.22l-1.02,1.68l0.43,2.03l-0.15,4.31l-0.6,1.55l0.46,1.54l-0.46,3.31l-2.26,-0.46l-3.14,-1.32l-0.29,-1.45l-3.15,-1.57l-3.53,-0.74l-0.51,-1.12l-1.97,-0.73l-1.74,-1.47l-0.99,-0.2l-1.84,-2.15l-1.69,-0.64l-2.34,-2.4l-4.53,0.52l-1.22,-0.76l-2.83,-0.69l-1.4,-1.02l-7.25,-0.52l-3.66,0.68l-2.29,-0.41l-3.07,0.5l-2.02,1.11l-2.03,0.49l-2.0,-0.17l-1.55,0.86l-0.8,-0.05Z").attr(attr),
            "name" : "甘肃",
            "xy":[359,260]
        },
        "1,025," : {
            "path" : R.path("M472.9,364.07l1.1,-0.33l0.56,-1.41l1.85,-0.94l0.49,-0.82l0.86,-0.03l1.19,0.89l3.51,-0.92l1.06,1.14l1.51,-0.48l0.21,-1.49l-1.31,-1.41l-0.17,-1.3l0.48,-0.96l-0.95,-0.9l1.35,-2.98l1.0,-0.38l-0.45,-2.04l1.51,0.21l0.51,-1.02l-0.38,-1.77l-1.13,-1.46l-1.74,-0.93l-1.77,0.04l-0.43,-0.61l2.35,-2.27l0.92,-1.58l0.12,-0.85l-0.78,-1.23l-0.1,-1.28l0.92,-0.75l4.79,-0.1l1.89,0.78l2.58,2.52l1.51,-0.85l2.77,0.28l1.04,-0.65l2.32,0.19l1.61,-0.4l0.47,-0.7l-2.39,-3.68l0.68,-0.37l0.15,-0.86l2.33,0.82l0.7,0.71l2.8,-1.14l1.63,0.47l3.3,-0.17l0.79,-0.41l1.37,-1.76l-0.15,-2.84l-1.31,-2.09l0.11,-2.07l-0.46,-1.25l2.68,-2.02l0.37,-2.47l-0.8,-1.81l0.73,-0.98l0.05,-1.17l-1.39,-1.25l-2.71,-0.62l-1.06,-1.33l-2.15,-0.95l-1.0,0.47l-1.49,-0.4l-0.08,-0.9l-1.28,-0.42l-1.02,-1.39l-2.81,-1.18l-2.13,-0.25l-0.77,-0.87l-2.84,-0.26l-0.15,-1.94l0.7,-1.98l-0.62,-1.86l-0.67,-0.69l1.19,-3.52l-0.11,-0.97l2.16,-1.69l0.35,-1.12l1.9,-0.18l0.72,-1.05l3.3,0.79l0.91,1.08l0.05,1.23l0.81,0.36l4.43,-0.01l2.46,-0.6l3.96,-0.19l0.57,-1.87l0.09,-2.81l0.51,-0.6l0.75,1.11l0.85,0.04l1.51,-2.87l-0.05,-0.79l-1.15,-1.65l0.48,-1.99l0.85,-1.45l1.8,-2.13l2.03,-1.14l0.16,-0.96l0.76,-0.37l0.45,-1.0l2.13,-0.7l1.33,-1.98l0.56,-1.76l2.02,-0.65l2.13,-2.2l3.13,-1.72l0.1,-0.85l-0.94,-1.81l0.98,0.12l0.78,1.19l1.27,0.82l2.39,-0.98l1.19,1.72l0.99,0.5l0.78,-0.47l3.12,-4.14l1.65,-0.99l1.08,-0.01l-1.25,2.33l2.66,1.97l-1.52,3.73l-2.14,1.62l0.39,1.36l-1.9,4.74l0.35,1.51l-0.58,1.2l-1.11,0.5l-1.53,1.87l-1.36,0.53l-0.26,1.16l-0.73,0.28l-0.28,0.8l0.22,3.8l1.15,0.74l1.0,1.87l1.27,0.79l-0.43,0.26l-0.03,0.68l0.99,0.56l-0.26,0.63l0.31,0.93l-0.63,1.46l-1.57,1.02l-0.06,0.83l0.75,0.57l-0.22,0.7l-2.97,3.92l-1.39,0.85l0.64,0.96l-0.65,1.37l0.64,1.15l-0.54,0.48l0.63,1.05l-0.43,0.74l1.38,1.65l0.18,0.98l-0.76,6.42l0.95,4.35l0.73,0.65l0.85,4.08l-0.84,1.27l-0.15,1.21l-3.13,4.04l-1.48,6.8l0.28,2.49l1.2,0.93l0.07,2.8l1.99,1.29l-0.62,0.83l0.01,0.81l0.77,0.81l1.91,0.87l-0.38,1.77l0.74,1.16l-0.68,1.73l2.37,1.37l0.7,1.71l2.53,1.74l0.53,3.3l-0.51,1.49l-0.83,0.9l-1.32,0.19l-1.36,1.29l-1.3,-0.49l-0.51,-1.28l-0.72,-0.38l-1.65,1.2l-2.87,0.28l-1.73,-0.89l-6.77,-0.88l-0.86,0.47l-1.19,-0.1l-1.11,0.99l-0.34,0.65l0.46,0.7l4.2,0.97l0.23,0.7l-0.53,1.3l0.41,0.79l1.01,0.42l1.14,-0.36l2.78,1.14l0.92,3.1l-1.21,-0.07l-0.68,1.03l-1.93,-0.69l-0.94,0.34l-0.58,-0.46l-1.96,0.0l-1.34,1.21l-0.24,2.11l-1.15,1.23l0.87,1.96l1.07,0.56l0.23,1.29l0.59,0.71l-0.9,2.01l0.05,1.95l-0.51,1.16l-3.2,0.37l-0.91,-0.48l-2.09,-2.72l-6.68,-3.37l-3.0,-2.38l-3.36,-0.16l-0.92,0.46l-1.82,0.09l-0.85,0.47l-0.34,0.82l-1.62,-1.01l-1.01,-1.35l-1.91,-1.46l-2.71,-0.27l-0.58,-2.12l-1.18,0.15l-1.55,1.25l-0.7,-0.06l-1.74,-0.96l0.39,-2.28l-0.92,-1.07l-5.02,-0.46l-1.53,1.03l-3.66,0.62l-1.95,0.81l-2.16,-1.56l0.63,-2.44l-0.71,-0.62l-3.15,0.49l-1.11,1.47l-1.06,-0.09l-1.74,0.89l-0.89,-2.41l1.48,0.24l1.51,-0.39l1.01,-0.83l1.19,-0.24l0.64,-1.25l0.13,-3.5l-2.68,-1.22l-0.3,-1.08Z").attr(attr),
            "name" : "陕西",
            "xy":[516,345]
        },
        "1,028," : {
            "path" : R.path("M700.34,19.64l4.7,-3.47l2.81,-2.7l1.65,-2.32l-0.53,-1.85l-1.3,-0.86l-0.63,-1.7l-2.72,-1.38l2.62,-1.28l3.54,-0.89l2.95,-0.01l3.28,-1.29l1.3,0.89l6.72,-0.46l2.16,-0.67l2.3,-0.14l1.43,-1.08l4.0,1.06l1.14,-0.92l1.23,1.01l2.21,0.31l1.62,0.74l2.23,2.05l1.97,-0.43l1.91,2.58l1.85,0.7l2.16,0.09l0.87,1.12l1.39,-0.01l0.94,0.9l0.91,-0.65l-0.13,-0.95l2.33,-0.46l5.65,2.47l0.77,0.87l1.48,-0.33l1.37,1.37l-1.16,1.22l0.19,0.88l2.89,-0.39l0.09,0.82l1.74,1.85l1.45,-0.23l-0.59,0.42l0.26,0.99l-1.13,0.64l-0.07,1.12l0.78,1.08l1.14,-0.4l1.48,0.95l-0.16,1.05l0.33,0.4l0.97,0.06l0.87,1.25l-0.27,1.61l0.98,0.44l-1.03,0.63l-0.1,1.04l3.46,1.33l-1.67,2.63l3.11,5.13l1.04,0.53l0.01,1.2l-0.69,1.33l2.17,1.29l-0.47,0.92l0.15,1.0l1.56,0.47l-1.14,0.69l-0.3,1.37l0.65,0.87l0.9,-0.05l-0.17,1.46l0.46,2.17l3.12,3.11l1.1,2.19l0.99,0.78l0.01,1.42l1.1,1.73l-1.04,1.86l-0.01,0.52l0.94,0.85l-0.35,1.76l1.23,1.14l2.54,1.09l-1.52,3.43l0.68,2.01l-0.37,1.86l0.52,0.84l1.67,0.56l0.82,1.99l2.44,1.54l1.05,0.07l0.62,-0.42l1.4,1.07l2.02,0.16l1.05,-0.35l1.18,0.17l0.6,-0.6l3.7,0.03l0.49,-0.52l1.48,0.55l-0.77,1.28l0.44,0.71l1.76,-0.16l1.67,0.71l0.88,1.4l0.95,0.38l1.54,-0.79l2.03,0.9l0.65,-0.74l0.02,-0.88l1.03,0.11l0.47,0.45l0.42,1.92l2.41,0.44l0.42,1.4l1.41,0.54l-0.05,0.81l1.09,0.72l0.23,1.12l4.15,2.81l0.99,0.41l2.69,-0.6l1.5,0.81l1.56,-0.42l-2.05,4.69l1.3,1.0l0.31,1.71l1.73,-0.25l-0.23,1.31l1.18,2.07l-1.01,1.82l-1.15,1.06l-0.03,1.57l3.47,3.54l0.46,1.06l0.0,1.87l0.51,0.55l2.02,0.62l5.14,-1.24l2.48,1.49l1.41,-0.64l3.12,0.53l1.68,-0.56l1.99,0.14l2.53,-0.87l2.81,0.54l1.16,-0.96l-0.04,-0.9l1.37,-1.7l-0.03,-1.09l1.86,0.31l4.15,-3.18l1.77,-0.34l1.15,0.46l3.45,0.08l3.08,-2.9l3.36,-0.53l1.35,-0.92l4.66,-0.97l1.21,0.73l1.0,-0.15l0.91,1.09l1.13,0.48l-0.21,1.93l-1.63,1.67l-0.18,0.91l0.46,1.68l1.03,0.75l0.27,1.14l1.3,1.88l-1.09,1.1l-0.15,1.08l-1.8,2.03l-0.89,0.7l-2.52,0.2l-2.13,1.96l-0.44,1.55l1.03,2.51l-1.3,0.52l-0.94,1.79l-0.82,3.12l0.39,1.02l-0.42,1.82l-1.57,1.54l-0.91,2.05l0.14,0.75l1.11,0.87l-0.89,0.64l0.46,1.56l-3.01,2.04l0.33,1.66l-0.79,2.05l-0.6,0.11l-0.42,0.84l-1.03,0.15l-0.65,1.19l0.15,0.95l-0.67,1.53l0.54,0.41l-0.28,0.61l-0.7,0.86l-3.45,1.66l-0.71,1.42l-0.48,2.47l0.36,2.5l-0.29,0.56l-2.22,1.35l-14.01,-3.75l-1.89,-1.9l-1.22,0.72l-0.92,1.62l-1.42,0.35l-0.41,0.85l0.15,1.11l-2.5,2.24l-1.42,-0.13l-2.22,1.16l-1.86,-0.1l-0.53,0.9l-1.5,0.64l0.01,0.6l1.95,2.52l2.86,11.11l-0.69,0.79l0.04,1.84l-0.69,2.33l0.31,3.46l-0.42,1.2l0.85,0.83l-0.94,0.4l-1.0,-1.07l-0.94,-0.28l-2.0,1.28l-0.69,-1.25l-2.71,-1.93l-3.05,-0.97l0.27,-1.04l-0.63,-0.93l-0.58,-2.37l0.15,-2.01l-0.55,-0.48l-0.56,0.32l-0.65,1.54l-1.44,0.71l-0.89,1.12l-0.63,-0.19l-0.49,-2.26l-1.64,-0.72l-1.77,1.08l-0.33,1.49l-4.24,0.31l-3.54,1.41l-0.63,1.03l0.27,2.19l-3.08,1.17l-1.5,-0.3l-1.59,-2.59l-0.25,-1.66l-4.42,-6.31l-0.08,-4.36l-1.22,-2.05l-1.04,0.1l-1.75,0.96l-1.0,1.75l-0.99,-0.42l-0.46,0.22l-0.07,4.39l-2.55,0.92l-0.88,-0.2l-0.84,-1.62l-1.42,-0.93l0.05,-1.06l-1.72,-2.22l0.2,-1.67l1.07,-0.45l-0.53,-1.18l-2.73,-1.34l-1.91,0.65l-1.21,-0.85l-0.73,0.21l-0.82,1.07l-0.14,-2.25l-0.79,-1.63l1.25,-1.13l0.19,-0.91l-2.1,-4.0l-2.28,-0.2l-3.6,-1.86l-2.38,0.4l-2.52,1.3l-1.2,0.18l-3.34,-1.12l-2.46,-1.85l-0.42,-3.4l-0.39,-0.35l-1.29,0.09l-1.35,0.65l-1.18,-0.2l-1.03,1.52l-0.87,-0.32l-2.98,0.38l-0.79,-1.73l-1.3,-0.06l-0.74,-0.7l-0.63,0.39l-0.27,1.24l-1.38,-0.48l-0.61,0.36l-2.17,-0.01l-0.31,0.67l-1.22,-0.86l-1.0,0.17l-0.32,-1.43l-1.22,-0.29l-0.9,-1.62l-0.69,0.14l-0.11,-0.62l-1.77,-1.67l0.38,-0.47l0.03,-1.52l-1.26,-1.31l0.97,-1.46l-1.19,-3.03l-0.19,-2.06l-9.03,0.95l-1.85,-0.56l-1.06,0.59l-2.15,-2.93l0.29,-3.3l3.73,0.52l1.8,-0.26l2.11,-1.79l1.16,-1.65l0.3,-0.75l-0.52,-1.41l-0.83,-0.23l-0.79,1.07l-0.54,-1.27l-1.43,-0.28l-1.01,1.4l-0.93,0.21l-0.89,0.89l-0.7,-0.2l-1.76,-1.12l-3.09,-3.73l-3.13,-1.67l-2.3,-3.49l1.17,-1.19l0.97,-2.18l9.4,-5.27l1.22,-2.43l4.25,-2.1l7.37,-7.42l2.2,-1.49l0.52,0.64l0.18,2.53l1.11,1.65l0.43,1.62l0.87,1.18l1.2,-0.12l0.76,-2.35l-0.05,-1.57l-0.51,-1.08l0.13,-3.38l1.07,-1.41l0.25,-2.03l2.89,-5.94l0.05,-1.1l0.45,-0.89l1.99,0.26l0.68,0.52l1.18,-0.05l1.61,-1.89l0.63,-4.12l-0.65,-1.73l0.18,-0.67l-0.91,-1.25l0.69,-0.82l0.05,-2.29l-0.42,-0.62l0.69,-1.28l-0.51,-1.04l1.65,-2.02l-0.08,-0.68l-0.72,-0.35l1.06,-0.32l0.23,-0.85l1.15,-0.57l0.44,-1.75l0.64,-0.47l0.99,-2.26l0.89,-0.24l2.35,-1.78l0.23,-3.43l-0.56,-0.84l0.76,-0.2l1.66,-1.93l0.65,-0.02l1.13,-2.5l-1.23,-2.63l-1.59,-0.76l-0.54,-1.26l-1.89,-1.05l-3.21,-4.72l-2.37,-1.56l-3.13,-0.68l-1.11,0.35l-0.46,1.72l-1.28,0.45l-0.33,0.99l-1.03,0.54l-0.5,0.82l-2.2,0.58l-3.02,-0.38l-0.69,1.17l-0.7,0.3l-1.02,-0.04l-1.89,-0.9l-2.4,0.51l-2.32,-0.18l-0.86,0.56l-0.38,1.23l-2.05,0.44l-2.2,-1.42l-2.91,0.07l-1.31,-0.96l-1.23,0.12l-2.89,-2.55l-0.59,-1.07l-0.07,-1.18l-1.84,-2.77l0.78,-2.18l-1.88,-5.65l1.86,-1.08l0.26,-0.96l-0.5,-0.73l-3.7,-0.9l-2.31,-3.24l-2.27,-0.88l-0.85,0.42l-2.17,3.75l-1.36,0.41l-1.03,-0.2l-1.81,-2.22l-3.13,-1.21l-2.43,-1.72l-2.01,-0.71ZM784.36,45.67l0.01,-0.74l0.56,-0.19l-0.11,0.32l-0.46,0.61Z").attr(attr),
            "name" : "黑龙江",
            "xy":[799,95]
        },
        "1,007," : {
            "path" : R.path("M707.39,150.06l1.2,-0.92l1.06,-1.91l0.07,-1.04l-0.56,-0.87l2.86,0.68l3.56,3.02l1.1,-0.51l1.39,-1.93l1.2,2.35l2.06,1.63l1.09,0.33l1.38,-1.55l0.4,-5.47l4.0,-0.39l2.01,-2.77l1.83,0.56l5.97,-0.46l1.5,-0.54l0.95,0.28l0.99,3.97l-0.72,1.83l1.26,1.26l-0.56,2.12l1.43,1.22l0.5,1.39l1.09,0.08l0.87,1.35l1.04,0.13l-0.07,0.65l0.6,0.95l1.26,-0.07l0.58,0.69l0.82,0.19l0.83,-0.63l2.27,-0.25l1.57,0.34l0.53,-0.35l0.24,-0.97l0.47,0.39l0.96,-0.03l0.61,1.71l0.62,0.24l2.01,-0.43l2.0,0.28l0.73,-0.36l0.51,-1.19l1.08,0.22l2.16,-0.64l0.05,2.44l0.43,0.85l2.85,2.17l3.53,1.19l1.46,-0.2l2.59,-1.33l2.12,-0.36l3.38,1.83l2.17,0.17l1.65,3.36l-1.45,1.91l0.81,1.84l0.27,2.54l1.01,0.29l1.19,-1.24l0.93,0.81l1.97,-0.64l2.44,1.18l-0.77,0.76l-0.24,2.1l1.8,2.42l-0.05,1.1l1.53,1.12l0.41,1.23l0.68,0.5l1.37,0.28l2.97,-1.14l0.35,-0.71l-0.14,-3.43l1.15,0.07l0.96,-1.71l2.05,-1.08l0.61,0.78l0.38,1.67l-0.01,3.6l4.44,6.35l0.22,1.6l1.98,2.97l1.99,0.36l3.36,-1.28l0.39,-0.56l-0.31,-2.16l0.31,-0.53l3.28,-1.29l4.39,-0.37l0.6,-1.71l1.31,-0.8l0.93,0.54l0.43,2.21l0.99,0.42l0.65,-0.1l0.98,-1.18l1.76,-1.15l0.59,3.01l0.62,0.92l-0.28,0.91l0.27,0.6l3.18,1.04l2.57,1.83l0.97,1.41l1.12,-0.19l1.26,-1.07l1.54,1.32l2.03,-0.51l-0.54,2.97l-1.03,1.28l0.26,1.27l-1.58,1.7l0.33,2.03l-0.97,0.15l-0.49,0.77l-3.07,-0.3l-0.61,0.7l-2.19,0.2l-2.69,1.49l-0.46,1.31l0.6,0.45l1.59,0.12l0.7,0.96l-0.11,0.43l-0.44,-1.02l-1.69,0.01l-1.77,-1.69l-0.31,-3.36l-1.76,-0.34l0.23,-0.69l-0.3,-0.53l-2.02,0.26l-0.77,-0.76l-0.81,-0.03l-1.02,1.05l-1.33,3.85l0.25,1.34l-0.5,0.66l-0.46,3.14l-1.37,-0.13l-0.86,1.13l-1.25,-0.93l-1.72,-0.15l-0.79,1.06l-0.88,0.27l-0.19,0.91l-0.59,0.4l0.32,0.48l-0.47,0.58l0.21,0.68l-3.39,2.13l-0.32,0.82l-2.89,-0.29l-3.28,0.9l-3.46,-0.64l-3.69,0.85l-0.29,0.73l0.46,2.01l0.65,0.51l1.08,2.28l1.37,0.94l0.56,1.09l-2.0,3.15l-0.3,-0.35l-0.59,0.15l-0.8,-1.3l-1.8,-0.06l-0.83,0.59l-3.08,-0.05l-1.52,-0.95l-3.17,-0.09l-0.23,-0.55l-1.21,-0.33l-0.92,0.27l0.5,-0.21l0.12,-0.68l-1.77,-1.02l0.34,-0.55l-0.47,-0.83l-2.15,-1.49l-2.11,1.64l-0.85,-0.58l-0.76,0.09l-0.22,0.56l0.35,0.43l-1.25,0.42l-0.8,1.09l0.17,0.79l-1.11,2.23l0.18,0.95l-1.72,1.23l-1.72,2.64l-2.18,1.32l-1.18,2.3l-1.29,1.0l-0.6,-0.31l-2.57,0.63l-0.35,-0.48l-1.01,-0.13l1.25,-1.24l0.52,-1.96l0.64,-0.54l-0.31,-1.89l-1.43,-0.98l-0.24,-0.94l-1.06,-1.23l-1.43,-3.02l-0.3,-1.77l-1.91,0.01l0.21,-1.04l-0.61,-1.36l0.15,-2.0l0.8,-0.5l1.47,-2.08l0.38,-1.31l-1.6,-0.66l-0.8,0.2l-0.55,-2.24l-1.51,-0.56l0.51,-1.12l-1.59,-1.66l-0.15,-1.54l-1.84,-1.57l0.25,-0.99l-0.4,-1.24l-1.27,-0.44l0.11,-5.14l-0.49,-0.38l-1.81,0.31l-1.15,1.04l-0.86,1.63l-1.86,1.67l-1.06,-0.44l0.74,-0.71l-0.97,-1.12l0.67,-1.66l-1.76,-1.18l-0.57,-1.58l-1.64,-0.44l-1.03,-0.8l-1.11,-0.06l-3.52,-2.9l-0.92,0.08l-0.93,1.88l-4.06,-1.75l-0.1,-0.84l1.0,-0.97l1.02,0.01l0.37,-0.47l0.16,-1.59l-3.0,-6.39l0.57,-0.81l-0.06,-1.24l-1.67,-1.2l-1.06,-2.59l-0.8,-0.7l0.08,-1.72l-0.65,-0.89l-5.72,3.52l-5.11,2.12l-1.07,0.09l0.1,-3.82l-2.82,-3.33l-0.62,-1.42l-0.52,-6.91l0.28,-0.66l1.63,-0.59l1.3,-1.22l0.17,-1.0l-0.42,-1.51l-1.3,-1.99l-1.6,-0.58l-0.53,-0.69l0.15,-1.79l-0.82,-1.17l-1.17,-0.34l-1.68,0.48l-1.19,-0.69Z").attr(attr),
            "name" : "吉林",
            "xy":[777,188]
        },
        "1,024," : {
            "path" : R.path("M666.84,235.88l1.46,-0.21l0.13,-0.99l-1.13,-0.64l1.29,-0.38l2.04,-1.67l3.29,-4.2l0.01,-2.16l-0.98,-2.54l-0.22,-1.96l0.47,-1.57l-0.14,-1.64l0.67,-1.02l0.1,-1.12l-1.88,-1.99l1.24,-1.43l1.82,-0.58l0.63,-1.06l1.41,2.58l2.87,0.66l-0.6,1.1l1.2,1.2l0.23,1.24l1.12,0.6l0.13,0.9l0.72,0.85l0.03,2.62l1.43,0.38l0.52,-0.41l0.35,-1.28l2.74,-2.95l1.92,-1.21l0.49,-2.02l1.84,-0.24l4.11,-2.37l1.0,0.78l0.62,-0.03l5.36,-4.51l2.31,-0.49l1.01,1.35l1.71,-0.0l2.41,-1.55l0.83,-2.38l1.42,-0.71l3.37,1.48l1.93,-0.4l0.74,-1.17l-0.97,-2.27l1.79,0.31l3.55,1.84l4.72,-1.06l1.21,-0.89l0.68,-2.03l1.03,-0.83l5.31,-1.59l1.29,-4.41l0.01,-1.52l0.53,-0.82l3.52,2.88l1.23,0.11l0.92,0.76l1.66,0.46l0.32,1.38l1.59,0.94l-0.7,1.17l0.71,1.28l-0.49,0.44l0.04,0.76l1.56,0.8l1.02,-0.37l1.68,-1.56l0.95,-1.74l0.98,-0.86l1.18,-0.07l-0.38,4.27l0.39,0.98l1.2,0.42l0.19,0.78l-0.44,1.37l1.03,0.29l1.09,1.17l0.21,1.63l1.46,1.44l-0.47,0.49l0.02,0.74l1.6,0.7l-0.03,1.1l0.65,1.32l2.13,0.16l-1.63,2.46l-1.07,0.81l-0.08,2.33l0.61,1.39l-0.31,1.18l0.95,0.57l1.22,-0.19l0.17,1.36l1.48,3.14l1.07,1.26l0.29,1.04l1.34,0.79l0.17,1.33l-0.47,0.41l-0.46,1.88l-1.68,1.59l0.25,0.81l1.43,0.13l-0.68,0.84l0.17,0.72l-1.17,-0.34l-0.44,1.04l-0.94,0.13l-1.07,1.32l-1.55,-0.15l-3.94,1.99l-0.41,0.59l0.3,0.74l-1.99,-0.31l-2.17,1.87l-0.49,1.07l-2.05,1.01l-3.14,2.86l-0.13,1.6l-0.83,1.07l-2.27,1.58l-0.73,-0.15l-1.22,0.56l-0.8,-0.44l-2.41,0.33l-1.21,-0.55l-0.57,-1.15l-0.63,0.54l-0.49,1.89l-1.04,-0.3l-0.95,0.92l0.16,-0.93l-0.34,-0.47l-1.52,0.76l-1.18,-0.6l-0.44,0.5l0.18,0.53l-0.65,0.64l0.66,0.61l-1.18,0.31l-0.72,-0.37l-1.18,0.11l-0.92,0.64l0.11,0.46l-1.88,0.08l-2.19,1.58l-0.8,-0.05l-0.57,0.81l-0.61,-0.1l-0.95,1.01l-1.33,0.23l-1.82,1.2l-0.78,1.16l-1.7,1.33l-0.12,1.26l-1.12,1.06l-2.72,0.43l-0.4,0.55l-0.92,-0.5l-1.68,0.68l0.01,0.67l-0.86,0.33l0.02,0.61l1.54,0.55l-1.86,0.17l-1.01,0.81l-3.5,0.21l-0.93,1.3l-0.57,-1.68l0.58,-0.83l-0.65,-0.55l1.27,0.12l1.73,-0.49l0.57,-1.29l1.42,0.48l3.12,-1.28l0.42,-1.03l-1.26,-1.23l0.4,-0.77l1.44,-0.9l0.39,-0.89l1.44,-0.07l1.0,-0.45l0.28,-0.59l-0.62,-0.5l-1.21,0.51l-2.01,-0.15l-0.29,0.45l-2.18,0.11l-1.3,-2.46l-2.44,-0.14l0.54,-0.69l2.42,-0.63l0.96,0.18l0.39,-1.45l-1.2,-0.89l0.11,-1.19l2.87,-1.62l1.42,-0.05l1.52,-1.29l-0.03,-0.92l3.31,-3.41l0.28,-1.08l1.01,-0.8l0.43,-1.19l1.28,-1.44l-0.36,-1.23l-1.6,-1.09l-0.09,-1.64l-0.74,0.04l-0.98,-0.93l-2.61,-1.1l-0.45,-1.9l0.56,-1.2l-0.61,-0.18l-0.95,0.67l-0.34,1.48l-0.53,0.5l-2.11,0.02l-0.82,-0.91l-1.02,0.07l-1.31,-0.86l-1.22,0.67l-0.89,-0.48l-0.94,0.11l-1.5,1.09l-0.16,0.59l-1.47,0.22l-0.63,1.46l0.43,0.72l-1.81,0.41l-0.59,1.29l-1.88,2.05l-0.86,0.19l-0.27,0.85l-0.76,0.47l0.11,0.94l-0.68,0.55l-0.39,1.58l-1.87,0.39l-1.4,0.91l-4.55,1.71l-0.85,0.73l-1.47,-1.45l-0.02,-2.05l-1.55,-0.29l0.04,-0.85l-0.79,-1.44l0.24,-2.16l-0.55,-1.07l-0.55,-0.29l-3.58,0.26l-1.34,-1.33l0.12,-1.13l-0.54,-0.57l-1.76,0.9l-2.81,-2.8l0.73,-1.82ZM709.57,269.63l0.5,0.25l0.03,0.04l-0.11,0.09l-0.42,-0.38ZM726.69,260.46l0.18,0.04l-0.17,0.03l-0.01,-0.06ZM703.25,261.72l0.04,-0.0l-0.03,0.03l-0.01,-0.02ZM703.3,262.36l0.06,0.35l-0.37,-0.0l0.26,-0.25l0.05,-0.1Z").attr(attr),
            "name" : "辽宁",
            "xy":[716,232]
        },
        "1,001," : {
            "path" : R.path("M706.85,553.92l1.93,-1.7941 -1.0587,-1.5352 -1.5351,-2.2763 -1.3176,-1.1058 -1.6353,-1.2117 -1.9529,-1.2646 -1.2647,-1.0058 -1.9528,-2.1175 -1.3234,-2.2763 -1.0529,-1.3705 -1.0529,-1.7411 -1.0529,-1.1116 1.1588,-1.1117 1.4235,-1.9057 1.4235,-2.8056 -1.6352,-2.0116 1.2647,-2.4351 1.1646,-3.7055 1.1058,-1.5823 1.2117,-1.1646 1.3176,-1.7469 1.7411,-1.7469 1.1116,-2.8056 2.3292,-4.0231 3.5293,-2.4764 1.0587,-1.8999 1.588,-2.3234 1.5823,-0.0529 1.1646,-0.0529 1.7469,-0.0529 0,0.2117 0.4764,1.5351 0.3176,2.1703 -1.1116,1.4822 -0.4764,4.129 -0.5293,6.5641 -0.4235,1.4292 -1.3764,3.3349 -2.1704,4.87 -0.1588,0.3177 -0.2647,0.6353 -0.3705,0.9529 -0.2118,1.5351 -0.3706,3.0703 -0.5294,4.6583 -0.1588,0.1059 -0.3176,0.2118 -1.4235,0.3706z").attr(attr),
            "name" : "台湾",
            "xy":[706,527]
        }
        /*
        ,
        '香港' : {
            name : "香港",
            path : R.path("M595.032,536.183l-0.96,1.752c0,0,0.889,0.883,1.98,1.086s1.995-0.493,1.995-0.493L595.032,536.183z").attr(attr)
        },
        '澳门' : {
            name : "澳门",
            path : R.path("M587.032,540.183l-0.96,1.752c0,0,0.889,0.883,1.98,1.086s1.995-0.493,1.995-0.493L587.032,540.183z").attr(attr)
        }
        */
    };
}
$.fn.Rmap.citylist = {'0':{}};
$.fn.Rmap.citylistData = {
'1,021,':{textLng:[780,245],circleLng:[630,255],lineto:[800,255],name: '北京市',province:'北京'},
'1,015,':{textLng:[780,390],circleLng:[705,400],lineto:[800,400],name: '上海市',province:'上海'},
'1,030,017':{textLng:[540,604],circleLng:[580,520],lineto:[580,604],name: '广州市',province:'广东'},
'1,030,012':{textLng:[721,584],circleLng:[600,530],lineto:[741,585], name: '深圳市',province:'广东'},
'1,004,014':{textLng:[260,500],circleLng:[450,415],lineto:[300,500],name: '成都市',province:'四川'},
'1,012,012':{textLng:[385,587],circleLng:[588,415],lineto:[422,587],name: '武汉市',province:'湖北'},
'1,024,007':{textLng:[780,295],circleLng:[710,265],lineto:[800,300],name:'大连市',province:'辽宁'},
'1,024,005':{textLng:[780,225],circleLng:[735,235],lineto:[800,235],name:'沈阳市',province:'辽宁'},
'1,020,':{textLng:[506,117],circleLng:[642,268],lineto:[549,137],name:'天津市',province:'天津'},
'1,016,001':{textLng:[780,410],circleLng:[677,415],lineto:[800,415],name:'杭州市',province:'浙江'},
'1,016,006':{textLng:[780,490],circleLng:[700,425],lineto:[800,492],name:'宁波市',province:'浙江'},
'1,006,006':{textLng:[780,365],circleLng:[690,395],lineto:[800,375],name:'南京市',province:'江苏'},
'1,006,003':{textLng:[780,390],circleLng:[680,390],lineto:[800,400],name: '常州市',province:'江苏'},
'1,034,001':{textLng:[287.5,636],circleLng:[577,445],lineto:[327,636],name:'长沙市',province:'湖南'},
'1,006,011':{textLng:[780,417],circleLng:[685,395],lineto:[800,422],name: '无锡市',province:'江苏'},
'1,008,010':{textLng:[780,282],circleLng:[684,316],lineto:[800,291],name: '青岛市',province:'山东'},
'1,025,009':{textLng:[113,517],circleLng:[519,348],lineto:[153,517],name:'西安市',province:'陕西'}, 
'1,006,007':{textLng:[780,365],circleLng:[689,380],lineto:[800,375],name:'南通市',province:'江苏'},
'1,031,'   :{textLng:[151,550],circleLng:[481,426],lineto:[190,550],name:'重庆市',province:'重庆'},
'1,003,005':{textLng:[52,445],circleLng:[415,315],lineto:[92,445],name:'西宁市',province:'青海'},
'1,030,004':{textLng:[610,672],circleLng:[574,532],lineto:[651,672],name:'肇庆市',province:'广东'},
'1,010,001':{textLng:[460,38],circleLng:[570,230],lineto:[520,54],name:'呼和浩特市',province:'内蒙古'},
'1,033,001':{textLng:[74,489],circleLng:[445,325],lineto:[114,489],name:'兰州市',province:'甘肃'},
'1,030,020':{textLng:[540,672],circleLng:[577,534],lineto:[580,672],name:'江门市',province:'广东'},
'1,018,013':{textLng:[60.5,102],circleLng:[198,180],lineto:[136.5,118],name:'乌鲁木齐市',province:'新疆'},
'1,016,008':{textLng:[780,473],circleLng:[685,426],lineto:[800,483],name:'绍兴市',province:'浙江'},
'1,030,001':{textLng:[676.5,672],circleLng:[583,533],lineto:[716.5,672],name:'珠海市',province:'广东'},
'1,028,008':{textLng:[803.5,54],circleLng:[795,155],lineto:[856.5,69],name:'哈尔滨市',province:'黑龙江'},
'1,008,014':{textLng:[780,257],circleLng:[662,311],lineto:[800,267] ,name:'潍坊市',province:'山东'},
'1,014,006':{textLng:[377.5,672],circleLng:[618,440],lineto:[417.5,672],name:'南昌市',province:'江西'},
'1,019,008':{textLng:[780,625],circleLng:[648,510],lineto:[800,635],name:'厦门市',province:'福建'},
'1,006,012':{textLng:[780,308],circleLng:[644,350],lineto:[800,317],name:'徐州市',province:'江苏'},
'1,007,008':{textLng:[830,190],circleLng:[775,195],lineto:[853,197],name:'长春市',province:'吉林'},
'1,030,019':{textLng:[780,654],circleLng:[605,518],lineto:[800,654],name:'惠州市',province:'广东'},
'1,009,008':{textLng:[780,338],circleLng:[639,387],lineto:[800,346],name:'合肥市',province:'安徽'},
'1,008,005':{textLng:[793,225],circleLng:[643,304],lineto:[813,233],name:'济南市',province:'山东'},
'1,019,001':{textLng:[780,570],circleLng:[670,475],lineto:[800,570],name:'福州市',province:'福建'},
'1,030,005':{textLng:[480,672],circleLng:[569,537],lineto:[520,672],name:'中山市',province:'广东'},
'1,026,003':{textLng:[237,611],circleLng:[489,469],lineto:[277,611],name:'贵阳市',province:'贵州'},
'1,019,006':{textLng:[780,595],circleLng:[655,500],lineto:[800,605],name:'泉州市',province:'福建'},
'1,023,013':{textLng:[197,584],circleLng:[423,499],lineto:[237,584],name:'昆明市',province:'云南'},
'1,013,001':{textLng:[572,40],circleLng:[612,276],lineto:[612,60],name:'保定市',province:'河北'},
'1,005,011':{textLng:[326,672],circleLng:[504,527],lineto:[366,672],name:'南宁市',province:'广西'},
'1,013,008':{textLng:[332.5,59],circleLng:[573,286],lineto:[372,77],name:'太原市',province:'山西'},
'1,016,004':{textLng:[780,505],circleLng:[671,433],lineto:[800,515],name:'金华市',province:'浙江'},
'1,011,008':{textLng:[390,46],circleLng:[597,288],lineto:[442,64],name:'石家庄市',province:'河北'},
'1,016,010':{textLng:[780,540],circleLng:[684,456],lineto:[800,550],name:'温州市',province:'浙江'},
'1,030,016':{textLng:[429.5,672],circleLng:[567,525],lineto:[484.5,672],name:'佛山市',province:'广东'},
'1,032,016':{textLng:[251,72],circleLng:[584,337],lineto:[291,90],name:'郑州市',province:'河南'},
'1,006,008':{textLng:[780,444],circleLng:[692,398],lineto:[800,450],name:'苏州市',province:'江苏'},
'1,030,015':{textLng:[728.5,672],circleLng:[582,523],lineto:[768.5,672],name:'东莞市',province:'广东'}
};
/***颜色转换处理**/
!function(){
//十六进制颜色值域RGB格式颜色值之间的相互转换
var reg = /^#([0-9a-fA-f]{3}|[0-9a-fA-f]{6})$/;
/*RGB颜色转换为16进制*/
String.prototype.colorHex = function(){
    var that = this;
    if(/^(rgb|RGB)/.test(that)){
        var aColor = that.replace(/(?:\(|\)|rgb|RGB)*/g,"").split(",");
        var strHex = "#";
        for(var i=0; i<aColor.length; i++){
        
            var hex = Number(aColor[i]).toString(16);
            if(hex === "0"){
                hex += hex; 
            }
            strHex += hex;
        }
        if(strHex.length !== 7){
            strHex = that;  
        }
        return strHex;
    }else if(reg.test(that)){
        var aNum = that.replace(/#/,"").split("");
        if(aNum.length === 6){
            return that;    
        }else if(aNum.length === 3){
            var numHex = "#";
            for(var i=0; i<aNum.length; i+=1){
                numHex += (aNum[i]+aNum[i]);
            }
            return numHex;
        }
    }else{
        return that;    
    }
};
//-------------------------------------------------
/*16进制颜色转为RGB格式*/
String.prototype.colorRgb = function(){
    var sColor = this.toLowerCase();
    if(sColor && reg.test(sColor)){
        if(sColor.length === 4){
            var sColorNew = "#";
            for(var i=1; i<4; i+=1){
                sColorNew += sColor.slice(i,i+1).concat(sColor.slice(i,i+1));   
            }
            sColor = sColorNew;
        }
        //处理六位的颜色值
        var sColorChange = [];
        for(var i=1; i<7; i+=2){
            sColorChange.push(parseInt("0x"+sColor.slice(i,i+2)));  
        }
        return "RGB(" + sColorChange.join(",") + ")";
    }else{
        return sColor;  
    }
};
}();
//处理IE,chrome下mousewheel不能获取positon值的问题
(function($) {
    var a = [ "DOMMouseScroll", "mousewheel" ];
    $.event.special.mousewheel = {
        setup : function() {
            if (this.addEventListener) {
                for ( var d = a.length; d;) {
                    this.addEventListener(a[--d], b, false)
                }
            } else {
                this.onmousewheel = b
            }
        },
        teardown : function() {
            if (this.removeEventListener) {
                for ( var d = a.length; d;) {
                    this.removeEventListener(a[--d], b, false)
                }
            } else {
                this.onmousewheel = null
            }
        }
    };
    $.fn.extend({
        mousewheel : function(d) {
            return d ? this.bind("mousewheel", d) : this.trigger("mousewheel")
        },
        unmousewheel : function(d) {
            return this.unbind("mousewheel", d)
        }
    });
    function b(f) {
        var d = [].slice.call(arguments, 1), g = 0, e = true;
        if (f.wheelDelta) {
            g = f.wheelDelta / 120
        }
        if (f.detail) {
            g = -f.detail / 3
        }
        f = $.event.fix(f || window.event);
        f.type = "mousewheel";
        f.pageX = f.originalEvent.pageX;
        f.pageY = f.originalEvent.pageY;
        d.unshift(f, g);
        return ($.event.dispatch||$.event.handle).apply(this, d)
    }
})(jQuery);