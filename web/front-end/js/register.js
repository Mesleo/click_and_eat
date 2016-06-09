(function(){

    var inputCoords, divLocation, selectProvincia, selectLocalidad;

    function initVars(){
        inputCoords = $("#restaurante_coordenadas");
        divLocation = $('.info-coordenadas');
        selectProvincia = $('#provincias');
        selectLocalidad = $('#localidades');
    }

    function checkGeolocation(){
        if ("geolocation" in navigator) {
            navigator.geolocation.watchPosition(function(position) {
                inputCoords.attr("placeholder", position.coords.latitude+"/"+position.coords.longitude);
                inputCoords.val(position.coords.latitude+"/"+position.coords.longitude);
                divLocation.html("Las coordenadas de su ubicación actual son: <ul><li class='li-position item-not-style'>Latitud: "+position.coords.latitude+
                    "</li><li class='li-position item-not-style'>Longitud: "+position.coords.longitude+"</li></ul>");
            });
        } else {
            divLocation.html("La localización no está disponible en su navegador");
        }
    }

    function changeLocalidades(b){
        $("#select-localidades select").empty();
        $.getJSON('ciudades?provincia='+b,function(data){
            $.each(data, function(id,value){
                $("#select-localidades select").append('<option value="'+value[2]+'">'+value[0]+' ('+value[1]+') </option>');
            });
        });
    }

    initVars();
    checkGeolocation();

    $('#provincias').change(function() {
        changeLocalidades($('#provincias').val());
    });

    $('ul').css("padding", "0");
    $('li:not(.item-not-style)').addClass("alert alert-danger");
    $('li:not(.item-not-style)').css("listStyle", "none");
})();
