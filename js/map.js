/*
    Script made by Gonçalo Passos - University of Madeira (Personal Page: http://diogopassos.pt)
*/

var base_url = "//"+self.location.hostname + "/api/services/";
var layers_url = [];
var layers = [];
var layers_legend = [];
var layers_options = [];
var loaded_option;

var map = L.map('map').setView([32.7500, -16.9601], 11); // Creation of map, center in madeira , zoom level 11
L.control.scale().addTo(map); // add scale to map
map.attributionControl.addAttribution('Mapa base: &copy; Esri &mdash; Dados: Observatório Clima Madeira');

var base_map ;
var general_map =  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {});
var sat_map = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {});
var terrain_map = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}', {});
var river_map = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {});
var cities_map = L.tileLayer('http://2.tile.openstreetmap.se/hydda/roads_and_labels/{z}/{x}/{y}.png', {pane:'labels'});

map.createPane('labels');
map.getPane('labels').style.zIndex = 650;


layers_url['precepitacao-referencia'] = base_url + "precepitacao-referencia";
layers_url['temperatura-referencia'] = base_url + "temperatura-referencia";

// Layers Clima

layers_url['anomalia-da-temperatura-inverno-a2-2070-2099'] = base_url + "anomalia-da-temperatura-inverno-a2-2070-2099";
layers_url['anomalia-da-temperatura-primavera-a2-2070-2099'] = base_url + "anomalia-da-temperatura-primavera-a2-2070-2099";
layers_url['anomalia-da-temperatura-verao-a2-2070-2099'] = base_url + "anomalia-da-temperatura-verao-a2-2070-2099";
layers_url['anomalia-da-temperatura-outono-a2-2070-2099'] = base_url + "anomalia-da-temperatura-outono-a2-2070-2099";
layers_url['anomalia-da-precipitacao-anual-a2-2070-2099'] = base_url + "anomalia-da-precipitacao-anual-a2-2070-2099";
layers_url['anomalia-da-precipitacao-inverno-a2-2070-2099'] = base_url + "anomalia-da-precipitacao-inverno-a2-2070-2099";
layers_url['anomalia-da-precipitacao-primavera-a2-2070-2099'] = base_url + "anomalia-da-precipitacao-primavera-a2-2070-2099";
layers_url['anomalia-da-precipitacao-verao-a2-2070-2099'] = base_url + "anomalia-da-precipitacao-verao-a2-2070-2099";
layers_url['anomalia-da-precipitacao-outono-a2-2070-2099'] = base_url + "anomalia-da-precipitacao-outono-a2-2070-2099";

// Layers Agricultura

layers_url['areas-agricolas'] = base_url + "areas-agricolas";
layers_url['superficie-agricola-util-de-horticolas'] = base_url + "superficie-agricola-util-de-horticolas";
layers_url['superficie-agricola-util-da-bananeira'] = base_url + "superficie-agricola-util-da-bananeira";
layers_url['superficie-agricola-util-da-vinha'] = base_url + "superficie-agricola-util-da-vinha";
layers_url['necessidade-de-rega-do-bananeiro'] = base_url + "necessidade-de-rega-do-bananeiro";
layers_url['agricultura-banana'] = base_url + "agricultura-banana";
layers_url['agricultura-area-potencial-vinha'] = base_url + "agricultura-area-potencial-vinha";
layers_url['agricultura-area-potencial-banana'] = base_url + "agricultura-area-potencial-banana";
layers_url['rega-bananeiro-a2-2040-2069'] = base_url + "rega-bananeiro-a2-2040-2069";
layers_url['rega-bananeiro-a2-2070-2099'] = base_url + "rega-bananeiro-a2-2070-2099";
layers_url['rega-bananeiro-b2-2040-2069'] = base_url + "rega-bananeiro-b2-2040-2069";


// Layers Florestas
layers_url['areas-ardidas'] = base_url + "areas-ardidas";
layers_url['floresta-natural-da-madeira'] = base_url + "floresta-natural-da-madeira";
layers_url['florestas-de-pinheiro-bravo'] = base_url + "florestas-de-pinheiro-bravo";
layers_url['florestas-de-outros-carvalhos'] = base_url + "florestas-de-outros-carvalhos";
layers_url['florestas-de-eucalipto'] = base_url + "florestas-de-eucalipto";
layers_url['florestas-de-castanheiro'] = base_url + "florestas-de-castanheiro";
layers_url['florestas-abertas-de-pinheiro-bravo'] = base_url + "florestas-abertas-de-pinheiro-bravo";
layers_url['florestas-abertas-de-eucalipto'] = base_url + "florestas-abertas-de-eucalipto";
layers_url['florestas-abertas-de-castanheiro'] = base_url + "florestas-abertas-de-castanheiro";
layers_url['ifram'] = base_url + "ifram";


// Layers Biodiversidade

layers_url['bis-bis-regulus-madeirensis'] = base_url + "bis-bis-regulus-madeirensis";
layers_url['freira-do-bugio-pterodroma-deserta'] = base_url + "freira-do-bugio-pterodroma-deserta";
layers_url['tentilhao-fringilla-coelebs'] = base_url + "tentilhao-fringilla-coelebs";
layers_url['freira-da-madeira-pterodroma-madeira'] = base_url + "freira-da-madeira-pterodroma-madeira";
layers_url['pombo-trocaz-columba-trocaz'] = base_url + "pombo-trocaz-columba-trocaz";
layers_url['alveola-cinzenta-motacilla-cinerea'] = base_url + "alveola-cinzenta-motacilla-cinerea";
layers_url['pintarroxo-comum-carduelis-cannabina'] = base_url + "pintarroxo-comum-carduelis-cannabina";
layers_url['aguia-de-asa-redonda-buteo-buteo'] = base_url + "aguia-de-asa-redonda-buteo-buteo";
layers_url['corre-caminhos-anthus-bertheloti'] = base_url + "corre-caminhos-anthus-bertheloti";
layers_url['rede-de-areas-marinhas'] = base_url + "rede-de-areas-marinhas";
layers_url['matos-pouco-densos-exoticos'] = base_url + "matos-pouco-densos-exoticos";
layers_url['matos-pouco-densos-autoctones'] = base_url + "matos-pouco-densos-autoctones";
layers_url['matos-densos-exoticos'] = base_url + "matos-densos-exoticos";
layers_url['matos-densos-autoctones'] = base_url + "matos-densos-autoctones";
layers_url['reserva-natural'] = base_url + "reserva-natural";
layers_url['rede-natura-2000'] = base_url + "rede-natura-2000";
layers_url['parque-natural'] = base_url + "parque-natural";

// Layers Energia

layers_url['infraestruturas-energia'] = base_url + "infraestruturas-energia";


//  Layers Riscos Hidrogeomorfológicos
layers_url['movimento-de-vertentes-suscetibilidade'] = base_url + "movimento-de-vertentes-suscetibilidade";
layers_url['cheias'] = base_url + "cheias";
layers_url['deslizamento-de-vertentes'] = base_url + "deslizamento-de-vertentes";

// Layers Saúde Humana

layers_url['ondas-de-calor'] = base_url + "ondas-de-calor";
layers_url['ondas-de-calor-hyrzea'] = base_url + "ondas-de-calor-hyrzea";
layers_url['ondas-de-calor-a2-2040-2069'] = base_url + "ondas-de-calor-a2-2040-2069";
layers_url['ondas-de-calor-8y3c2b'] = base_url + "ondas-de-calor-8y3c2b";



// Layers Turismo

layers_url['empreendimentos-turisticos'] = base_url + "empreendimentos-turisticos";
layers_url['campos-de-golf'] = base_url + "campos-de-golf";
layers_url['aeroportos'] = base_url + "aeroportos";

base_map = general_map;
base_map.addTo(map);


initOptions(); // init options for loaded urls maps.

/*
    Event: base map change
*/


$("input[name=map-type]").change(function(){
    map.removeLayer(base_map);
    base_map = sat_map;
    

    var map_type = $(this).val();
    switch(map_type) {
        case "general": base_map = general_map; break;
        case "sat": base_map = sat_map; break;
        case "terrain": base_map = terrain_map; break;
        case "river": base_map = river_map; break;
        
    }

    base_map.addTo(map);
});

/*
    Event: localidade checkbox changed
*/

$("input[name=localidades]").change(function() {
    if ($(this).is(':checked')) {
        cities_map.addTo(map);
    }
    else
    {
        map.removeLayer(cities_map);
    }
});

/*
    Event: layers checkbox changed.
*/

$("input[name=layers]").change(function() {

    // remove all loaded layers
    for (var key in layers) {
        map.removeLayer(layers[key]);
    } 
    // remove all loaded legends
    for (var key in layers_legend) {
        map.removeControl(layers_legend[key]);
    } 



   
    // get list of checked layers
    var layers_checked = [];
    $('input[name=layers]:checked').each(function() {
        layers_checked.push($(this).attr('value'));
    });

    var query_string = "";
    
    // add layers and legend
    var i = 0;
    layers_checked.forEach(function(element) {
        addLayer(element);
        if(i == 0){
            query_string+=element+"="+layers_options[element].opacity+","+layers_options[element].zindex;
        } else {
            query_string+="&"+element+"="+layers_options[element].opacity+","+layers_options[element].zindex;
        }
        
        i++;
    });

    window.history.pushState('', '', '?'+query_string);

    
});

/*
    Function: add layer / legend
*/

function addLayer(layername) {

    var url = layers_url[layername];
    $.get( url, function( data ) {
        

        var corner1 = L.latLng(data.bounds[1], data.bounds[0]), corner2 = L.latLng(data.bounds[3], data.bounds[2]);
        var bounds =  L.latLngBounds(corner1,corner2);
        layers[layername] = L.tileLayer(layers_url[layername]+"/tiles/{z}/{x}/{y}.png",{zIndex: 2, opacity: layers_options[layername].opacity,  zIndex: layers_options[layername].zindex, bounds: bounds,minZoom:data.minzoom,maxZoom:data.maxzoom});
        layers[layername].addTo(map);
        layers_legend[layername] = L.control({position: 'bottomright'});
        

        layers_legend[layername].onAdd = function (map) {
            var div = L.DomUtil.create('div', 'info');
            div.innerHTML = data.legend;
            return div;
        }

        layers_legend[layername].addTo(map);
    });

   
}

/*
    Function: initialize all options
*/

function initOptions() {
    for (var key in layers_url) {
        layers_options[key] = {opacity:1,zindex:2};
    } 

}

/*
    Function: Populate all inputs with current setting of options modal
*/

function options(el) {
    $('#modalOption').modal();
    $('#inputOpacity').val(layers_options[el].opacity*100);
    $('#inputZindex').val(layers_options[el].zindex);
    loaded_option = el;
}


/*
    Event: Click event of apply button in options modal
*/

$('#btn-Apply').click(function () {

    layers_options[loaded_option].opacity = $('#inputOpacity').val() / 100;
    layers_options[loaded_option].zindex = $('#inputZindex').val() ;

    if(layers[loaded_option] != null) {
        layers[loaded_option].setOpacity(layers_options[loaded_option].opacity);
        layers[loaded_option].setZIndex(layers_options[loaded_option].zindex);
    }
    
    var layers_checked = [];

    $('input[name=layers]:checked').each(function() {
        layers_checked.push($(this).attr('value'));
    });
    
    var i = 0;
    var query_string = "";
    layers_checked.forEach(function(element) {
       
        if(i == 0){
            query_string+=element+"="+layers_options[element].opacity+","+layers_options[element].zindex;
        } else {
            query_string+="&"+element+"="+layers_options[element].opacity+","+layers_options[element].zindex;
        }
        
        i++;
    });
    window.history.pushState('', '', '?'+query_string);
    $('#modalOption').modal('hide');
    
});

function getQueryString() {
    var url = window.location.search;
    url = url.replace("?", '');
    var vars = url.split('&');
    
    var result = [];

    if(url != "") {
        vars.forEach(function(element) {
            var var2 = element.split('=');
            result[var2[0]] = var2[1];
        });
    }
    else
    {
        result = undefined;
    }

    return result;
}

function loadSettings() {
    var settings = getQueryString();
    for(el in settings) {
        var options = settings[el].split(',');
        layers_options[el].opacity = options[0];
        layers_options[el].zindex = options[1];
        
        $('input[value='+ el +']').attr('checked', true);
       
        addLayer(el);
    }
  

    
}

loadSettings();



