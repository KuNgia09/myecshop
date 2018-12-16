$(function(){
	$('.homeNavBar .level').on('mouseenter',function(){
		$(this).addClass('paper');
	}).on('mouseleave',function(){
		$(this).removeClass('paper');
	})
    $('.foot .show-more').on('click',function(){
        $(this).hide();
        $(this).next('.hide-collapse').show();
        $(this).parent().prev().addClass('open');
    })
    $('.foot .hide-collapse').on('click',function(){
        $(this).hide();
        $(this).prev('.show-more').show();
        $(this).parent().prev().scrollTop(0).removeClass('open');
    })
    $(function(){
        var diva = $('.class-style .class-style-tow .class-container');
        $(diva).each(function(){
            if($(this).height()>60){
                $(this).parent().next().children('.show-more').show();
                console.log(12125)
            }
            console.log($(this).height())
        })

    })

});