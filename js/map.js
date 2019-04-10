/*
    Script made by Gonçalo Passos - University of Madeira (Personal Page: http://diogopassos.pt)
*/

var base_url = "http://clima-madeira.lan/api/";
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


layers_url['necessidade-de-rega-do-bananeiro'] = base_url + "necessidade-de-rega-do-bananeiro";
layers_url['ondas-de-calor'] = base_url + "ondas-de-calor";


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

    console.log("loaded layers:",layers);
});

/*
    Function: add layer / legend
*/

function addLayer(layername) {

    var url = layers_url[layername];
    $.get( url, function( data ) {
        console.log(data);

        var corner1 = L.latLng(data.bounds[1], data.bounds[0]), corner2 = L.latLng(data.bounds[3], data.bounds[2]);
        var bounds =  L.latLngBounds(corner1,corner2);
        layers[layername] = L.tileLayer(layers_url[layername]+"/{z}/{x}/{y}.png",{zIndex: 2, opacity: layers_options[layername].opacity,  zIndex: layers_options[layername].zindex, bounds: bounds,minZoom:data.minzoom,maxZoom:data.maxzoom});
        layers[layername].addTo(map);
        layers_legend[layername] = L.control({position: 'bottomright'});
        console.log("layer_Dat",layers[layername] );

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

console.log("Lista de params:",getQueryString());


