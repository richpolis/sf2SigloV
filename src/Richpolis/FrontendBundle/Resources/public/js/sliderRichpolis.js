//Slideshow con jQuery sin plugins
//Cali Rojas
//www.lewebmonster.com

/* modificado por Ricardo Alcantara Gomez <richpolis@gmail.com>*/
 
$(function(){
    //variable para el temporizador y tomamos la clase que contiene las imagenes
    var tmrTemporizador=null, $objSlideShow=$('.slider-container'),$objPagerShow=$('.bx-pager');

    //ocultamos la ultima imagen (por defecto aparece de primera)
    $objSlideShow.find('.slide:gt(0)').hide();

     
    //funcion que contiene el temporizador
    $.fntSlideShow=function(){
        //le asignamos el codigo al temporizador
        tmrTemporizador=setInterval(function(){
            //variables para almacenar los elementos (actual y el que sigue en la lista)
            var $objActual, $objSiguiente, $objPagerActual,$objPagerSiguiente;
             
            //si ningun item de la lista tiene la clase clsImagenActiva
            if($objSlideShow.has('.clsImagenActiva').length==0){
                //buscamos la primer imagen y se la asignamos
                $objSlideShow.find('div.slide:first').addClass('clsImagenActiva');
				$objPagerShow.find('.bx-pager-item a:first').addClass('active');
            }
             
            //obtenemos la imagen que esta activa (visible)
            $objActual=$objSlideShow.find('.clsImagenActiva');

			$objPagerActual = $objPagerShow.find('.bx-pager-item a.active');
             
            //aun es el fin de la lista de imagenes?
            if($objActual.next().length>0){
                //bien, entonces tomamos el siguiente elemento y lo almacenamos
                $objSiguiente=$objActual.next();
				$objPagerSiguiente = $objPagerActual.next();
            }else{
                //es el fin de la lista? la siguiente imagen sera la primera de la lista
                $objSiguiente=$objSlideShow.find('div.slide:first-child');
				$objPagerSiguiente=$objPagerShow.find('div.bx-pager-item a:first-child');
            }
             
            //mostramos suavemente el siguiente elemento (por si estuviera invisible)
			//a la imagen actual le eliminamos la clase clsActiva y la ocultamos
            $objActual.removeClass('clsImagenActiva').fadeOut('slow',function(){
				$objActual.find(".slide-titulo").css({"top": "-50px"});
				$objPagerActual.removeClass('active');
			});
            //y le asignamos la clase clsImagenActiva
            $objSiguiente.addClass('clsImagenActiva').fadeIn('slow',function(){
				$objSiguiente.find(".slide-titulo").css({"top": "0px"});
				$objPagerSiguiente.addClass("active");
			});
            
        },8000); //cada tres segundos se volvera a ejecutar
    };
     
    //al colocar el puntero del raton sobre el slideshow este se pausa
    $objSlideShow.hover(function(){
        //detenemos el temporizador
        clearInterval(tmrTemporizador);
		$(".slide-descripcion").css({'bottom':'0px'});
    }, //al retirar el puntero del slideshow volvemos a activar el temporizador
    function(){
        //llamada a la funcion que contiene el temporizador
		$(".slide-descripcion").css({'bottom':'-115px'});	
        $.fntSlideShow();

    });
     
    //iniciamos el slideshow
    $.fntSlideShow();
});