window.Usuarios = {};

Usuarios.Views = {};
Usuarios.Collections = {};
Usuarios.Models = {};
Usuarios.Routers = {};

window.routers = {};
window.models = {};
window.views = {};
window.collections = {};


Usuarios.Models.Usuario = Backbone.Model.extend({
    defaults: {
      username: '',
      nombre: '',
      email: '',
      grupo: 1,
      twitter: '',
      facebook: '',
    }
});

Usuarios.Collections.Usuarios = Backbone.Collection.extend({
    model: Usuarios.Models.Usuario,
});

//esta vista recibe un modelo UsuarioModel para que pueda renderear su contenido
Usuarios.Views.Item = Backbone.View.extend({

    tagName: "tr",
    
    template: swig.compile($("#item_table_template").html()),
    
    initialize: function() {
        this.model.on("change", this.render, this);
    },
    render: function() {
        var data = this.model.toJSON();
        this.$el.html(this.template(data)).attr({id: 'registro-'+this.model.get('id')});
        return this;
    }

});

//esta vista es para visualizar el show_template
Usuarios.Views.Show = Backbone.View.extend({

    /*el: '#contenidoPagina',*/
    
    template: swig.compile($("#show_template").html()),

    events: {
        'click #botonRegresar': 'regresar',
        'click #botonEliminar' : 'eliminar',
    },
    initialize: function() {
        this.model.on("change", this.render, this);
        window.api.modelo.id = this.model.get('id');
    },
    regresar : function(e){
        e.preventDefault();
        e.stopPropagation();
        console.log("regresar");
        window.routers.app.navigate('/',true);
    },
    eliminar : function(e){
        $(".loader").fadeIn();
        e.preventDefault();
        e.stopPropagation();
        if(!window.api.accion.eliminar && window.api.modelo.id == this.model.get('id')){
            window.api.accion.eliminar = true;
            console.log("Accion eliminar");
            this.model.urlRoot = window.api.url;
            this.model.destroy({
                success: function(){
                    window.collections.usuarios.reset();
                    var xhr = window.collections.usuarios.fetch();
                    xhr.done(function(){
                        window.routers.app.navigate('/',true);
                        $(".loader").fadeOut();
                        window.api.accion.eliminar = false;
                    });
                }
            });
        }
    },
    render: function() {
        var data = this.model.toJSON();
        this.$el.html(this.template(data));
        return this;
    }

});

//esta vista es para visualizar el formulario
Usuarios.Views.FormNew = Backbone.View.extend({

    /*el: '#contenidoPagina',*/
    
    events: {
        'click #botonRegresar': 'regresar',
        'click #botonGuardar' : 'guardar',
    },
    initialize: function(data) {
        this.contenido = data;
        window.api.modelo.id = 0;
    },
    regresar : function(e){
        e.stopPropagation();
        console.log("regresar");
        window.routers.app.navigate('/',true);
    },
    guardar: function(e){
        debugger;
        e.preventDefault();
        e.stopPropagation();
        var self = this;
        if(!window.api.accion.guardar  && window.api.modelo.id == 0){
            window.api.accion.guardar=true;
            if(this.validarForm()){
                $(".loader").fadeIn();
                var data = $("#formUsuarios").serialize();
                $.ajax({
                    url: $("#formUsuarios").attr('action'),
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                }).done(function(data, textStatus,jqXHR){
                    debugger;
                    window.api.accion.guardar=false;
                    console.log("Creado")
                    console.log(data)
                    var model = new Usuarios.Models.Usuario(data);
                    window.collections.usuarios.add(model);
                    window.routers.app.navigate("show/"+model.get('id'),true);
                    $(".loader").fadeOut();
                }).fail(function(data, textStatus,jqXHR){
                    debugger;
                    window.api.accion.guardar=false;
                    $(".loader").fadeOut();
                    console.log(data);
                    self.parseErrores(data);
                });
            }else{
                window.api.accion.guardar = false;
                $(".loader").fadeOut();
            }
        }
    },
    render: function() {
        this.$el.html(this.contenido.data);
        return this;
    },
    validarForm: function(){
        var exprPassword = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
        var exprEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var password = {
            'first':$("#password_first").val(),
            'second':$("#password_second").val(),
        }
        var $nombre = $("input#nombre");
        var $email = $("input#email");
        
        if(password.first.length <= 3){
            this.errorNoty("El password no es correcto.");
            $("input#password_first").focus();
            return false;
        }else if(password.first!=password.second){
            this.errorNoty("Las contraseñas deben coincidir.");
            $("input#password_first").focus();
            return false;
        }else if(!exprPassword.test(password.first)){
            this.errorNoty("La contraseña debe de ser 6 a 8 caracteres, minimo un digito, sin caracteres especiales.");
            $("input#password_first").focus();
            return false;
        }
        
        
        // validar el nombre 
        if($nombre.val().length == 0){
            this.errorNoty("El nombre esta vacio.");
            $nombre.focus();
            return false;
        }else if($nombre.val().length < 3){
            this.errorNoty("El nombre es demasiado corto, minimo 3 caracteres");
            $nombre.focus();
            return false;
        }
        
        
        if ( !exprEmail.test($email.val()) ){
            this.errorNoty("El email es incorrecto.");
            $email.focus();
            return false;
        }
        return true;
    },
    errorNoty: function(mensaje){
        noty({
            text: mensaje,
            layout:'topRight',
            type:'error',
            timeout:2000
        });
    },
    parseErrores: function(data){
        debugger;
        var json = $.parseJSON(data.responseText);
         var children = json.errors.children;
        var stringError ="";
        var cont=0;
        var contb=0;
        for(cont = 0; cont< children.length;  cont++){
            if(children[cont]['errors']){
                for(contb=0; contb<children[cont]['errors'];contb++){
                    stringError +=children[cont]['errors'][contb];
                }
            }
        }
        this.errorNoty(stringError);
    }

});

//esta vista es para visualizar el formulario
Usuarios.Views.FormEdit = Backbone.View.extend({

    /*el: '#contenidoPagina',*/
    
    events: {
        'click #botonRegresar': 'regresar',
        'click #botonGuardar' : 'guardar',
        'click #botonEliminar' : 'eliminar',
    },
    
    initialize: function(data) {
        this.contenido = data;
        window.api.modelo.id = this.model.get('id');
    },
    
    regresar : function(e){
        e.stopPropagation();
        console.log("regresar");
        window.routers.app.navigate('/',true);
    },
    
    guardar: function(e){
        debugger;
        e.preventDefault();
        e.stopPropagation();
        if(!window.api.accion.guardar && window.api.modelo.id == this.model.get('id')){
            window.api.accion.guardar = true;
            var self = this;
            if(this.validarForm()){
                $(".loader").fadeIn();
                var data = $("#formUsuarios").serialize();
                $.ajax({
                    url: $("#formUsuarios").attr('action'),
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                }).done(function(data, textStatus, jqXHR){
                    window.collections.usuarios.reset();
                    var xhr = window.collections.usuarios.fetch();
                    xhr.done(function(){
                        window.routers.app.navigate('show/'+window.api.modelo.id,true);
                        window.api.accion.guardar = false;
                        $(".loader").fadeOut();
                    });
                }).fail(function(data, textStatus, errorThrown){
                   debugger;
                   $(".loader").fadeOut();
                   console.log($.parseJSON(data.responseText));
                   self.parseErrores(data);
                   window.api.accion.guardar = false;
                });
            }else{
                window.api.accion.guardar = false;
                $(".loader").fadeOut();
            }
        }
    },
    
    eliminar : function(e){
        var self = this;
        $(".loader").fadeIn();
        e.preventDefault();
        e.stopPropagation();
        if(!window.api.accion.eliminar  && window.api.modelo.id == this.model.get('id')){
            window.api.accion.eliminar = true;
            console.log("Accion eliminar");
            this.model.urlRoot = window.api.url;
            this.model.destroy({
                success: function(){
                    window.collections.usuarios.reset();
                    var xhr = window.collections.usuarios.fetch();
                    xhr.done(function(){
                        window.routers.app.navigate('/',true);
                        window.api.accion.eliminar = false;
                        $(".loader").fadeOut();
                    });
                }
            });
        }
    },
    
    render: function() {
        this.$el.html(this.contenido.data);
        return this;
    },

    validarForm: function(){
        var exprPassword = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
        var exprEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var password = {
            'first':$("#password_first").val(),
            'second':$("#password_second").val(),
        }
        var $nombre = $("input#nombre");
        var $email = $("input#email");
        if(password.first.length>0 && password.second.length==0){
            $("#password_first").val("");
        }else{
            if(password.first!=password.second){
                this.errorNoty("Las contraseñas deben coincidir.");
                $("input#password_first").focus();
                return false;
            }else if(password.first.length>0){
                if(!exprPassword.test(password.first)){
                    this.errorNoty("La contraseña debe de ser 6 a 8 caracteres, minimo un digito, sin caracteres especiales.");
                    $("input#password_first").focus();
                    return false;
                }
            } 
        }
        // validar el nombre 
        if($nombre.val().length == 0){
            this.errorNoty("El nombre esta vacio.");
            $nombre.focus();
            return false;
        }else if($nombre.val().length < 3){
            this.errorNoty("El nombre es demasiado corto, minimo 3 caracteres");
            $nombre.focus();
            return false;
        }
        
        if ( !exprEmail.test($email.val()) ){
            this.errorNoty("El email es incorrecto.");
            $email.focus();
            return false;
        }
        return true;
    },

    errorNoty: function(mensaje){
        noty({
            text: mensaje,
            layout:'topRight',
            type:'error',
            timeout:2000
        });
    },
    
    parseErrores: function(data){
        debugger;
        var json = $.parseJSON(data.responseText);
        var children = json.errors.children;
        var stringError ="";
        var cont=0;
        var contb=0;
        for(cont = 0; cont< children.length;  cont++){
            if(children[cont]['errors']){
                for(contb=0; contb<children[cont]['errors'];contb++){
                    stringError +=children[cont]['errors'][contb];
                }
            }
        }
        this.errorNoty(stringError);
    }

});


//vista collecio que recibe todos los modelos.
Usuarios.Views.Table = Backbone.View.extend({

    el: '#contenidoPagina',
    
    template: swig.compile($("#table_template").html()),
    
    initialize: function() {

        this.cuerpoTabla = "#cuerpoTabla";
        
        this.collection.on("add", this.AddOne,this);
        //esta es para que ejecute el render inicial
        //this.render();
    },
    
    AddOne: function(usuario) {
        var usuarioView = new Usuarios.Views.Item({model: usuario});
        var html = usuarioView.render().el;
        $(this.cuerpoTabla).append(html);
    },
    
    render: function() {
        this.$el.html(this.template());
        this.collection.forEach(this.AddOne,this);
        this.inicializarDatatable();
        return this;
    },
    
    inicializarDatatable: function() {
        $('#datatable').dataTable({
            "sPaginationType": "full_numbers",
            "sNext": "Siguiente",
            "sLast": "Ultimo",
            "sFirst": "Primero",
            "sPrevious": "Anterior",
        });
    },
});

Usuarios.Routers.App = Backbone.Router.extend({
    routes: {
        "" : "root",
        "new" : "new",
        "edit/:id" : "edit",
        "show/:id" : "show",
    },
    
    root: function() {
        window.views.table = new Usuarios.Views.Table({
            collection: window.collections.usuarios,
        });
        views.table.render();
    },
    
    new: function() {
        $(".loader").fadeIn();
        $.ajax({
           type: 'GET',
           url: window.api.url + "/new",
           dataType: 'html',
        }).done(function(data){
            debugger;
            if(window.views.formEdit)window.views.formEdit.remove();
            if(window.views.show)window.views.show.remove();
            window.views.formNuevo = new  Usuarios.Views.FormNew({data: data});
            $("#contenidoPagina").html(views.formNuevo.render().el).fadeIn("fast");
            $(".loader").fadeOut();
            
        }).fail(function(){
            $(".loader").fadeOut();
            alert("Error al cargar la pagina de nuevo registro");
        });
    },
    edit: function(id) {
        $(".loader").fadeIn();
        $.ajax({
           type: 'GET', 
           url: window.api.url + "/" +id+"/edit",
           dataType: 'html',
        }).done(function(data){
            debugger;
            if(window.views.formNuevo)window.views.formNuevo.remove();
            if(window.views.show)window.views.show.remove();
            var model = window.collections.usuarios.get(id);
            window.views.formEdit = new  Usuarios.Views.FormEdit({data: data, model: model});
            $("#contenidoPagina").html(views.formEdit.render().el).fadeIn("fast");
            $(".loader").fadeOut();
        }).fail(function(){
            $(".loader").fadeOut();
            alert("Error al cargar la pagina de editar registro");
        });
    },
    show: function(id) {
        debugger;
        if(window.views.formNuevo)window.views.formNuevo.remove();
        if(window.views.formEdit)window.views.formEdit.remove();
        var model = window.collections.usuarios.get(id);
        window.views.show = new  Usuarios.Views.Show({model: model});
        $("#contenidoPagina").html(views.show.render().el).fadeIn("fast");
    },
});
