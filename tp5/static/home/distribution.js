function round(status,id,_this) {
        var str='<ul class="menus clearfix">';
        var str2 = '</ul>';
        if(status === '0'){
            $.post(url,{"id":id},function (e) {
                if(!e){
                    layer.msg('无更多数据');return;
                };
                $.each(e,function (i,item) {
                    str +=("<li class='clearfix z_menu' data-status='0' data-id="+item.id+">"+"<span>-"+item.nick_name+"</span></li>")
                });
                $(_this).after(str+str2);
                $(_this).attr('data-status',1);
                $('.layui-layer-loading1').remove();

                $(_this).next($(".menus")).slideToggle("slow");
            })
        }else{
            $(_this).next($(".menus")).slideToggle("slow");
        }

    }


    $(".menu").click(function(){

        var id=$(this).attr("data-id");
        var status = $(this).attr('data-status');
        round(status,id,this);

    });
    $("body").delegate(".z_menu", "click", function(){
        var id=$(this).attr("data-id");
        var status = $(this).attr('data-status');
        round(status,id,this);
    });

 function withdrawal(_this) {
    layer.open({
        type: 1,
        area: ['600px', '400px'],
        shade: 0.5,
        title: false, //不显示标题
        content: '<div id="distribution_withdrawal" ><script >var loding = layer.load(0, {shade: false}); </script></div>',
        cancel: function () {
            $('.layui-layer-loading0').remove();
        }
    });

    $.post($(_this).data('url'), {}, function (str) {
        $('.layui-layer-loading0').remove();
        $('#distribution_withdrawal').html(str);

    });


}