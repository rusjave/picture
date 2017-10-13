jQuery(document).ready(function($){
    "use strict";

    if ($('div.portfolio').length) {
        $('div.portfolio').each(function(){

            'use strict';

            var portfolio=$(this);

            var getPortMasonry=function(mod){
                'use strict';

                var $container=$('.portfolio-container',mod),modwidth=$container.outerWidth(true),$gutter=($container.data('type')=='vcimage' || $container.data('type')=='imagefull' || $container.data('type')=='imagefixheightfull')?0:30,
                masonryCol=($container.data('col'))?$container.data('col'):2;



                    if($(window).width() >= 992 && $(window).width() < 1024){

                        masonryCol=($container.data('col'))?$container.data('col')-1:2;

                    }else if($(window).width() >= 768 && $(window).width() < 992){
                        masonryCol=($container.data('col')==6)?4: ($container.data('col')==5)?3:($container.data('col')==4)?2:2;

                    }else if($(window).width() >= 480 && $(window).width() < 768){
                        
                        masonryCol=2;

                    }else if($(window).width() < 480){
                        masonryCol=1;   
                    }


                    function adjustItem(element,gap,modwidth){


                          for (var index = 0; index < element.length; ++index) {


                                var targetWidth=$(element[index]).data('width') + (gap/modwidth*$(element[index]).data('width'));
                                targetWidth=Math.floor(targetWidth*10)/10;
                                $(element[index]).width(targetWidth);

                            }

                    }

                    masonryCol=Math.floor((modwidth-($gutter*(masonryCol - 1)))/masonryCol);

                    var someRow=[],curWidth=0;

                    $(".portfolio-item",$container)
                            .each(function(i,el){
                                if($container.data('type')=='text'){
                                    $(this).width(masonryCol).height(masonryCol+30);
                                    $('.post-image-container',$(this)).height(masonryCol/2);
                                }
                                else if($container.data('type')=='imagefixheightfull'){


                                    var img=$('.post-image img',$(el)),imgWidth=img.data('width'),imgHeight=img.data('height'),gap=modwidth - curWidth;

                                    if(gap > imgWidth){

                                        curWidth=curWidth+imgWidth;
                                        someRow.push(img);
                                    }
                                    else{

                                        if(gap >= imgWidth/2){

                                            someRow.push(img);
                                            curWidth=curWidth+imgWidth;
                                            adjustItem(someRow,modwidth-curWidth,curWidth);
                                            someRow=[];
                                            curWidth=0;

                                        }
                                        else{

                                            adjustItem(someRow,gap,(someRow.length > 1)?curWidth:someRow[0].data('width'));
                                            someRow=[img];
                                            curWidth=imgWidth;
                                        }
                                    }
                                }
                                else{
                                      $('img',$(this)).width(masonryCol);
                                      $('.top-image',$(this)).height(masonryCol);
                                      $('figcaption',$(this)).outerHeight(masonryCol);
                                      $(this).width(masonryCol).height(masonryCol);
                                }
                        });
                    

                    var reloadMore=function($el){
                        'use strict';

                            $('.portfolio-navigation .more-post',$el.parents('.portfolio')).unbind('click').click(function(e){
                                    e.preventDefault();

                                    var scriptUrl=$(this).attr('href'),hashChanged=true,removeItem = $(this),
                                    $preloader=$('<div class="portfolio_loader"></div>'),$navigation_container=$(this).parents('.portfolio-navigation');
                                    $navigation_container.append($preloader);
                                    $(this).remove();


                                     $.ajax({
                                        url: scriptUrl+'&t='+$.now()+'&type='+$el.data('type')+'&col='+$el.data('col'),
                                        type: 'get',
                                        dataType: 'html',
                                        async: true,
                                        success: function(html) {

                                            var filtered=$(html).find('.portfolio-item');  
                                            var navigation=$(html).find('.portfolio-navigation .more-post'); 

                                                filtered.each(function(i,el){

                                                if($el.data('type')=='text'){

                                                   
                                                    $(el).width(masonryCol).height(masonryCol);
                                                    $('.post-image-container',$(el)).height(masonryCol/2);
                                                }
                                                else if($el.data('type')=='imagefixheightfull'){

                                                   var img=$('.post-image img',$(el)),imgWidth=img.data('width'),imgHeight=img.data('height'),gap=modwidth - curWidth;

                                                    if(gap > imgWidth){

                                                        curWidth=curWidth+imgWidth;
                                                        someRow.push(img);
                                                    }
                                                    else{

                                                        if(gap >= imgWidth/2){

                                                            someRow.push(img);
                                                            curWidth=curWidth+imgWidth;
                                                            adjustItem(someRow,modwidth-curWidth,curWidth);
                                                            someRow=[];
                                                            curWidth=0;

                                                        }
                                                        else{

                                                            adjustItem(someRow,gap,(someRow.length > 1)?curWidth:someRow[0].data('width'));
                                                            someRow=[img];
                                                            curWidth=imgWidth;
                                                        }
                                                    }

                                                }
                                                else{

                                                  $('img',$(el)).width(masonryCol);
                                                   $(el).width(masonryCol).height(masonryCol);
                                                }

                                                $el.isotope('insert',$(el)).isotope('reloadItems');

                                            });

                                            $('.popup-gallery',$('<div>'+html+'</div>')).each(function(i,el){

                                                $(el).insertBefore('.md-overlay');
                                                
                                            });

                                            $navigation_container.append(navigation.css('display','inline-block'));
                                            $preloader.remove();


                                            initModal();
                                            reloadMore($el);
                                            hashChanged=false;
                                            $(window).resize();

                                        } 
                                        

                                     });
                           });
                        },
                        initModal=function () {
                        var overlay = document.querySelector( '.md-overlay' );
                        [].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {
                            var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                                close = modal.querySelector( '.md-close' );
                            function removeModal( hasPerspective ) {
                                classie.remove( modal, 'md-show' );
                                if( hasPerspective ) {
                                    classie.remove( document.documentElement, 'md-perspective' );
                                }
                            }
                            function removeModalHandler() {
                                removeModal( classie.has( el, 'md-setperspective' ) ); 
                            }
                            el.addEventListener( 'click', function( ev ) {

                                if(!$('.modal_preloader').length){
                                    $('body').prepend("<div class='modal_preloader'><div class='modal_spinner-container'><div class='modal_loader'></div></div></div>");
                                }

                                if(!modal.loaded){
                                    $('.modal_loader').fadeIn('slow');
                                    $('.modal_preloader').delay(350).fadeIn('slow'); 

                                    if($('img',modal).length){

                                        var all=$('img',modal).length,elDone=1,timeout = null;


                                        $('img',modal).each(function(i,e){

                                            var im=$(this).attr('rel'),
                                                img = new Image();
                                                $(this).attr('src',im);
                                                img.src = im;
                                                img.onload=function() {
                                                    timeout = setTimeout(function() {
                                                        if (img.complete) {
                                                            $('.modal_loader').fadeOut('slow');
                                                            $('.modal_preloader').delay(350).fadeOut('slow'); 
                                                            modal.loaded=true;
                                                            classie.add( modal, 'md-show' );    
                                                            clearTimeout(timeout);
                                                        }
                                                    },1000);
                                                    elDone=elDone+1;
                                                };

                                                if(all=elDone){
//                                                    modal.loaded=true;
//                                                    classie.add( modal, 'md-show' );
                                                }
                                        });

                                    }
                                    else{
                                        modal.loaded=true;
                                    }
                                }

                                if(modal.loaded){
                                    classie.add( modal, 'md-show' );
                                }

                                overlay.removeEventListener( 'click', removeModalHandler );
                                overlay.addEventListener( 'click', removeModalHandler );
                                if( classie.has( el, 'md-setperspective' ) ) {
                                    setTimeout( function() {
                                        classie.add( document.documentElement, 'md-perspective' );
                                    }, 25 );
                                }
                            });
                            close.addEventListener( 'click', function( ev ) {
                                ev.stopPropagation();
                                removeModalHandler();
                            });
                        });
                    };


                    try{

                        if($container.data('type')=='imagefixheightfull'){


                            $container.isotope({
                                  itemSelector: '.portfolio-item',
                                  layoutMode: 'fitRows'
                            }); 

                            var filter=$('.dt-featured-filter a',mod),$navigation=$('.portfolio-navigation');

                            if(filter.length && $('.portfolio-item',$container).length){

                                        filter.click(function(e){
                                        var selector = $(this).data('filter');
                                        if(selector!==undefined){
                                                e.preventDefault();
                                                $('.more-post',$navigation).hide();
                                                        if(selector=='*'){
                                                             $container.isotope( {filter:'*'}).isotope('reloadItems');


                                                        }else{
                                                            $container.isotope({filter:selector});
                                                            $navigation.find(selector).css('display','inline-block');
                                                        }                           
                                        }
                                        $(this).parents('ul').find('a,li').removeClass('active');
                                        $(this).addClass('active').parent().addClass('active');
                                        return false;

                                    });
                                        

                            }

                        }
                        else{

                            $container.isotope({
                                  itemSelector: '.portfolio-item',
                                  layoutMode:'masonry',
                                  masonry: { 
                                    columnWidth: masonryCol,
                                    gutter:$gutter  
                                  }
                            }); 

                            var filter=$('.dt-featured-filter a',mod),$navigation=$('.portfolio-navigation');

                            if(filter.length && $('.portfolio-item',$container).length){

                                        filter.click(function(e){
                                        var selector = $(this).data('filter');
                                        if(selector!==undefined){
                                                e.preventDefault();
                                                $('.more-post',$navigation).hide();
                                                        if(selector=='*'){
                                                             $container.isotope( {filter:'*'}).isotope('reloadItems');


                                                        }else{
                                                            $container.isotope({filter:selector});
                                                            $navigation.find(selector).css('display','inline-block');
                                                        }                           
                                        }
                                        $(this).parents('ul').find('a,li').removeClass('active');
                                        $(this).addClass('active').parent().addClass('active');
                                        return false;

                                    });
                                        

                            }
                            else{
                                 $('.more-post',mod).show();
                            }
                        }


                       reloadMore($container);
                    }
                    catch(err){}



            }

            getPortMasonry(portfolio);

           $(window).smartresize(function(){
              getPortMasonry(portfolio);
            })

        });
       }

});

