window.Siglov = {};

Siglov.Views = {};
Siglov.Collections = {};
Siglov.Models = {};
Siglov.Routers = {};

window.routers = {};
window.models = {};
window.views = {};
window.collections = {};



Siglov.Models.Publicacion = Backbone.Model.extend({
    defaults: {
      titulo: '',
      contenido: '',
      is_active: true,
      position: 0,
    }
});

Siglov.Collections.Publicaciones = Backbone.Collection.extend({
    model: Siglov.Models.Publicacion,
    buscarPorSlug: function(slug){
      var model = _.find(this.collection, function(cliente){ 
          return cliente.edad &gt; 65 
      });  
    },
});

//vista de item, estas se van a guardar en window.views.publicaciones[]
Siglov.Views.Item = Backbone.View.extend({

    tagName: "div",

    className: 'publicacion',
    
    template: swig.compile($("#item_list_template").html()),

    events: {
      "click .publicacion-thumbnail" : "visualizarSingle",
      "click .publicacion-titulo" : "visualizarSingle",  
    },

    initialize: function() {
        this.model.on("change", this.render, this);
        this.id = "registro-" + this.model.get("id");
    },

    render: function() {
        var data = this.model.toJSON();
        this.$el.html(this.template(data))
                .attr({id: 'registro-'+this.model.get('id')})
                .addClass(this.getClassAdicional());
        return this;
    },

    visualizarSingle: function(){
    	window.routers.app.navigate("publicacion/" + this.model.get('slug'),true);
    },
    getClassAdicional: function(){
        var numero = Math.floor((Math.random()*10)+1);
        if(numero<4){
            return 'w1';
        }else if(numero<7){
            return 'w2';
        }else{
            return 'w3';
        }
    }
});

//Esta es la vista simple, esta oculta la vista de article.encabezado y article.publicaciones.

Siglov.Views.Show = Backbone.View.extend({

    tagName: "article",

    el: '.single-article',
    
    template: swig.compile($("#article_single_template").html()),

    events: {

    },

    initialize: function() {
        
        this.model.on("change", this.render, this);

        window.api.modelo.id = this.model.get('id');
    },

    regresar : function(e){
        e.preventDefault();
        e.stopPropagation();
        window.routers.app.navigate('/',true);
    },

    render: function() {
        var data = this.model.toJSON();
        this.$el.html(this.template(data));
        return this;
    },

    mostrar: function(){
       //oculta los articles .encabezado y .publicaciones
       var self = this;
       $("article.encabezado").fadeOut('fast');
       $("article.publicaciones").fadeOut('fast',function(){
       	  self.$el.fadeIn("fast");
          self.mostrarSlider();
       });
    },
    mostrarSlider: function(){
        iniciarlizarSlider();
    }

});


//vista coleccion que recibe todos los modelos.
Siglov.Views.ListView = Backbone.View.extend({

	tagName: 'article',

    el: '.publicaciones',
    
    //template: swig.compile($("#article_publicaciones_template").html()),
    
    initialize: function() {
        
        this.collection.on('add', this.addOne, this);
    	this.collection.on('reset', this.render, this);
       
    },
    
    AddOne: function(Publicacion) {
    	var indice = 0;
    	if(window.views.publicaciones && window.views.publicaciones.length){
    		indice = window.views.publicaciones.length;
    	}else{
    		indice = 0;
    		window.views.publicaciones = [];
    	}
    	window.views.publicaciones[indice]= new Siglov.Views.Item({model: Publicacion});
        var html = window.views.publicaciones[indice].render().el;
        this.$el.append(html);
    },
    
    render: function() {
    	this.borrarViewsItems();
        this.collection.forEach(this.AddOne,this);
        this.masonry();
        return this;
    },
    
    borrarViewsItems: function() {
    	var indice = 0;
    	if(window.views.publicaciones && window.views.publicaciones.length){
    		indice = window.views.publicaciones.length;
    	}else{
    		indice = 0;
    		window.views.publicaciones = [];
    	}
    	for(var cont = 0; cont < indice; cont++ ){
    		window.views.publicaciones[cont].remove();
    	}
    },

    mostrar: function(){
       //oculta el article.single-article
       var self = this;
       $("article.single-article").fadeOut('fast');
       $("article.encabezado").fadeIn('fast',function(){
       	  self.$el.fadeIn("fast");
       });
    },
    masonry: function(){
        $("article.publicaciones").removeClass("masonry").css({});

        $('article.publicaciones').masonry({
          // options
          itemSelector : '.publicacion',
          columnWidth : 254
        });
    },

});

Siglov.Routers.App = Backbone.Router.extend({
    routes: {
        "" : "root",
        "publicacion/:slug" : "showPublicacion",
        "categoria/:slug" : "showCategoria",
        "portada": 'showPortada'
    },
    
    root: function() {
        $(".loader").fadeIn();
        window.views.listview = new Siglov.Views.ListView({
                collection: window.collections.publicaciones,
        });
        views.listview.render();
        views.listview.mostrar();
        $(".loader").fadeOut();
    },
    
    showPublicacion: function(slug) {
        var models = window.collections.publicaciones.where({slug: slug});
        $(".loader").fadeIn();
        if(models.length){
            debugger;
            window.views.show = new  Siglov.Views.Show({model: models[0]});
            window.views.show.render();
            window.views.show.mostrar();
            $(".loader").fadeOut();
        }else{
            debugger;
            var model = null;
            $.ajax({
                url: window.api.url + "/" + slug,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    debugger;
                    model = new Siglov.Models.Publicacion(data);
                    window.views.show = new  Siglov.Views.Show({model: model});
                    window.views.show.render();
                    window.views.show.mostrar();
                    $(".loader").fadeOut();
                },
                error: function(data){
                  debugger;
                  window.routers.app.navigate("/",true);
                  console.log("Error al cargar el slug: "+slug);
                  console.log(data);
                  $(".loader").fadeOut();
                }
            });
        }
    },
    showCategoria: function(slug){
        debugger;
        $(".loader").fadeIn();
        if(window.api.status == slug){
            window.views.listview = new Siglov.Views.ListView({
                collection: window.collections.publicaciones,
            });
            views.listview.render();
            views.listview.mostrar();
            $(".loader").fadeOut();
        }else{
            $.ajax({
                url: window.api.urlCategorias + "/" + slug + "/publicaciones",
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    debugger;
                    window.api.status = slug;
                    window.collections.publicaciones.reset();
                    window.collections.publicaciones.add(data);
                    window.views.listview = new Siglov.Views.ListView({
                        collection: window.collections.publicaciones,
                    });
                    views.listview.render();
                    views.listview.mostrar();
                    $(".loader").fadeOut();
                },
                error: function(data){
                    debugger;
                  window.routers.app.navigate("/",true);
                  console.log("Error la categoria con slug: "+slug);
                  console.log(data);
                  $(".loader").fadeOut();
                }
            });
        }
    },
    showPortada: function(){
        debugger;
        $(".loader").fadeIn();
        if(window.api.status == 'portada'){
            window.views.listview = new Siglov.Views.ListView({
                collection: window.collections.publicaciones,
            });
            views.listview.render();
            views.listview.mostrar();
            $(".loader").fadeOut();
        }else{
            $.ajax({
                url: window.api.url,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    debugger;
                    window.api.status = 'portada';
                    window.collections.publicaciones.reset();
                    window.collections.publicaciones.add(data);
                    window.views.listview = new Siglov.Views.ListView({
                        collection: window.collections.publicaciones,
                    });
                    views.listview.render();
                    views.listview.mostrar();
                    $(".loader").fadeOut();
                },
                error: function(data){
                    debugger;
                  window.routers.app.navigate("/",true);
                  console.log("Error la categoria con slug: "+slug);
                  console.log(data);
                  $(".loader").fadeOut();
                }
            });
        }
    },
});
