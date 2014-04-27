/* 
 * Son todas las sentencias javascript para que funcione la aplicacion de frontend
 */
$(document).on('ready',function(){
  
  $( "a.mostrar-categorias,.flechita" ).click(function(e) {
    e.preventDefault();
    e.stopPropagation()
    if($( "div.menu-secundario" ).hasClass('active')){
      $( "li.menu-secundario-item,.flechita" ).fadeOut("slow",function(){
          $( "div.menu-secundario" ).removeClass("active");  
      });
    }else{
      $( "div.menu-secundario" ).addClass("active");
      $( "li.menu-secundario-item,.flechita" ).fadeIn("slow");
    }
  });

  $("li.menu-secundario-item a").on("click",function(e){
    $('li.menu-secundario-item a.active').removeClass('active');
    $(this).addClass('active');
  });

    $(".totop").hide();
  
    $(".loader").fadeIn();
    window.routers.app = new Siglov.Routers.App();
    window.collections.publicaciones = new Siglov.Collections.Publicaciones();
    window.collections.publicaciones.url=window.api.url;
    var xhr = window.collections.publicaciones.fetch();
    xhr.done(function(){
        $(".loader").fadeOut();
        Backbone.history.start({
            root : '/',
            pushState:false
        });
    });
    
    $("a.mostrar-contacto").click(function(){
        iniciarlizarFormContacto();
        $("#formulario_contacto").find(".form-response-output,.errores").fadeOut("fast");
    });
    
    $(".slide-descripcion-boton").on('click',function(){
       window.routers.app.navigate($(this).data("url"),true);
    });
    
    $(window).scroll(function(){
      if ($(this).scrollTop()>300)
      {
        $('.totop').slideDown();
      } 
      else
      {
        $('.totop').slideUp();
      }
    });

    $('.totop a').click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop: 0}, 500);
    });
    
});

function iniciarlizarSlider(){
  debugger;
  $('.galeria-container').bxSlider({
      video: true,
      useCSS: false,
      slideWidth: 638
   });
}

function iniciarlizarFormContacto(){
    $("input.form-submit").click( function() {
        $('img.ajax-loader').css({visibility: 'visible'});
        $("img.ajax-loader").fadeIn("fast",function(){
            $.post("{{path('frontend_contacto')}}",$("form.form-contacto").serialize(),
            function(data){
                actualizaFormularioContacto(data);
                setTimeout(function(){
                    $("#formulario_contacto").find(".form-response-output").fadeOut("fast");
                },2000);
                
            });    
        });
    });
}

function actualizaFormularioContacto(data){
  $("#formulario_contacto").parent().html(data);
}

