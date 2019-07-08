<?php
require_once("../wp-load.php");
require_once 'class-wp-bootstrap-navwalker.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Observatório Clima-Madeira - DROTA</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>


    <!-- Modal -->
    <div class="modal" id="modalOption" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opções para o mapa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          <div class="modal-body">
              <div class="form-group row">
                  <label for="staticEmail" class="col-4 col-form-label"><b>Opacidade (%)</b></label>
                  <div class="col-8">
                    <input type="text"  class="form-control" id="inputOpacity">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-4 col-form-label"><b>Z-Index</b></label>
                  <div class="col-8">
                    <input type="text" class="form-control" id="inputZindex">
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button id="btn-Apply"type="button" class="btn btn-primary">Aplicar</button>
          </div>
        </div>
      </div>
    </div>

  
    <div>
      <nav class="navbar navbar-expand navbar-light bg-light justify-content-between">
          <a class="navbar-brand" href="#">Cartografia</a>
          <ul class="nav navbar-nav">
            <?php wp_nav_menu(array('theme_location' => 'primary','depth' => 2,  'container' => false, 'items_wrap' => '%3$s','walker' => new WP_Bootstrap_Navwalker(),)); ?>

          </ul>
      </nav>
    </div>




    <div class="wrapper">
      <div class="map-control">
        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listBase" ><span class="map-category"><i class="fas fa-chevron-down"></i> Mapas Base</span></a>
        <ul id="listBase" class="collapse show map-chooser">
          <li><input type="radio" name="map-type" value="general" checked> Mapa geral</li>
          <li><input type="radio" name="map-type" value="sat"> Mapa de satélite (ESRI)</li>
          <li><input type="radio" name="map-type" value="terrain"> Mapa digital de terreno (ESRI)</li>
          <li><input type="radio" name="map-type" value="river"> Mapa das ribeiras (ESRI)</li>
          <li><input type="checkbox" name="localidades" id="localidades"> Localidades</li>
        </ul>
        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listClima" ><span class="map-category"><i class="fas fa-chevron-down"></i> Clima</span></a>
        <ul id="listClima" class="collapse show map-chooser">

            <li><span class="map-name"> <input type="checkbox" name="layers" value="precepitacao-referencia"> Precepitação de referência (mm/dia)</span> <button onclick="options('precepitacao-referencia')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="temperatura-referencia"> Temperatura de referência</span> <button onclick="options('temperatura-referencia')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-temperatura-inverno-a2-2070-2099"> Anomalia da Temperatura Inverno A2 2070-2099</span> <button onclick="options('anomalia-da-temperatura-inverno-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-temperatura-primavera-a2-2070-2099"> Anomalia da Temperatura Primavera A2 2070-2099</span> <button onclick="options('anomalia-da-temperatura-primavera-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-temperatura-verao-a2-2070-2099"> Anomalia da Temperatura Verão A2 2070-2099</span> <button onclick="options('anomalia-da-temperatura-verao-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-temperatura-outono-a2-2070-2099"> Anomalia da Temperatura Outono A2 2070-2099</span> <button onclick="options('anomalia-da-temperatura-outono-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-precipitacao-anual-a2-2070-2099"> Anomalia da Precipitação Anual A2 2070-2099</span> <button onclick="options('anomalia-da-precipitacao-anual-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-precipitacao-inverno-a2-2070-2099"> Anomalia da Precipitação Inverno A2 2070-2099</span> <button onclick="options('anomalia-da-precipitacao-inverno-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-precipitacao-primavera-a2-2070-2099"> Anomalia da Precipitação Primavera A2 2070-2099</span> <button onclick="options('anomalia-da-precipitacao-primavera-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-precipitacao-verao-a2-2070-2099"> Anomalia da Precipitação Verão A2 2070-2099</span> <button onclick="options('anomalia-da-precipitacao-verao-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="anomalia-da-precipitacao-outono-a2-2070-2099"> Anomalia da Precipitação Outono A2 2070-2099</span> <button onclick="options('anomalia-da-precipitacao-outono-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
        </ul>
        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listAgricultura" ><span class="map-category"><i class="fas fa-chevron-down"></i> Agricultura</span></a>
        <ul id="listAgricultura" class="collapse show map-chooser">
            <li><span class="map-name"> <input type="checkbox" name="layers" value="areas-agricolas"> % da População Agrícola</span><button onclick="options('areas-agriculas')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="superficie-agricola-util-de-horticolas"> Superfície Agrícola Útil de Hortícolas</span><button onclick="options('superficie-agricola-util-de-horticolas')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="superficie-agricola-util-da-bananeira"> Superfície Agrícola Útil da Bananeira</span><button onclick="options('superficie-agricola-util-da-bananeira')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="superficie-agricola-util-da-vinha"> Superfície Agrícola Útil da Vinha</span><button onclick="options('superficie-agricola-util-da-vinha')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="necessidade-de-rega-do-bananeiro"> Necessidade de rega do bananeiro</span><button onclick="options('necessidade-de-rega-do-bananeiro')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="agricultura-banana"> Bananal</span><button onclick="options('agricultura-banana')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="agricultura-area-potencial-vinha"> Área potêncial da vinha</span><button onclick="options('agricultura-area-potencial-vinha')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="agricultura-area-potencial-banana"> Área potêncial da banana</span><button onclick="options('agricultura-area-potencial-banana')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="rega-bananeiro-a2-2040-2069"> Rega Bananeira A2 2040-2069</span><button onclick="options('rega-bananeiro-a2-2040-2069')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="rega-bananeiro-a2-2070-2099"> Rega Bananeira A2 2070-2099</span><button onclick="options('rega-bananeiro-a2-2070-2099')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="rega-bananeiro-b2-2040-2069"> Rega Bananeira B2 2040-2069</span><button onclick="options('rega-bananeiro-b2-2040-2069')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
        </ul>
        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listFlorestas" ><span class="map-category"><i class="fas fa-chevron-down"></i> Florestas</span></a>
        <ul id="listFlorestas" class="collapse show map-chooser">
            <li><span class="map-name"> <input type="checkbox" name="layers" value="areas-ardidas"> Áreas ardidas</span><button onclick="options('areas-ardidas')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="floresta-natural-da-madeira"> Floresta natural da Madeira</span><button onclick="options('floresta-natural-da-madeira')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-de-pinheiro-bravo"> Florestas de pinheiro bravo</span><button onclick="options('florestas-de-pinheiro-bravo')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-de-outros-carvalhos"> Florestas de outros carvalhos</span><button onclick="options('florestas-de-outros-carvalhos')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-de-eucalipto"> Florestas de eucalipto</span><button onclick="options('florestas-de-eucalipto')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-de-castanheiro"> Florestas de castanheiro</span><button onclick="options('florestas-de-castanheiro')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-abertas-de-pinheiro-bravo"> Florestas abertas de pinheiro bravo</span><button onclick="options('florestas-abertas-de-pinheiro-bravo')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-abertas-de-eucalipto"> Florestas abertas de eucalipto</span><button onclick="options('florestas-abertas-de-eucalipto')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="florestas-abertas-de-castanheiro"> Florestas abertas de castanheiro</span><button onclick="options('florestas-abertas-de-castanheiro')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="ifram"> IFRAM</span><button onclick="options('ifram')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>

        </ul>

        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listBiodiversidade" ><span class="map-category"><i class="fas fa-chevron-down"></i> Biodiversidade</span></a>
        <ul id="listBiodiversidade" class="collapse show map-chooser">
            <li><span class="map-name"> <input type="checkbox" name="layers" value="bis-bis-regulus-madeirensis"> Bis-bis (Regulus madeirensis)</span><button onclick="options('bis-bis-regulus-madeirensis')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="freira-do-bugio-pterodroma-deserta"> Freira do Bugio (Pterodroma deserta)</span><button onclick="options('freira-do-bugio-pterodroma-deserta')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="tentilhao-fringilla-coelebs"> Tentilhão (Fringilla coelebs)</span><button onclick="options('tentilhao-fringilla-coelebs')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="freira-da-madeira-pterodroma-madeira"> Freira da Madeira (Pterodroma madeira)</span><button onclick="options('freira-da-madeira-pterodroma-madeira')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="pombo-trocaz-columba-trocaz"> Pombo trocaz (Columba trocaz)</span><button onclick="options('pombo-trocaz-columba-trocaz')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="alveola-cinzenta-motacilla-cinerea"> Alvéola cinzenta (Motacilla cinerea)</span><button onclick="options('alveola-cinzenta-motacilla-cinerea')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="pintarroxo-comum-carduelis-cannabina"> Pintarroxo comum (Carduelis cannabina)</span><button onclick="options('pintarroxo-comum-carduelis-cannabina')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="aguia-de-asa-redonda-buteo-buteo"> Águia de asa redonda (Buteo buteo)</span><button onclick="options('aguia-de-asa-redonda-buteo-buteo')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="corre-caminhos-anthus-bertheloti"> Corre-caminhos (Anthus bertheloti)</span><button onclick="options('corre-caminhos-anthus-bertheloti')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="rede-de-areas-marinhas"> Rede de áreas marinhas</span><button onclick="options('rede-de-areas-marinhas')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="matos-pouco-densos-exoticos"> Matos pouco densos exóticos</span><button onclick="options('matos-pouco-densos-exoticos')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="matos-pouco-densos-autoctones"> Matos pouco densos autóctones</span><button onclick="options('matos-pouco-densos-autoctones')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="matos-densos-exoticos"> Matos densos exóticos</span><button onclick="options('matos-densos-exoticos')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="matos-densos-autoctones"> Matos densos autóctones</span><button onclick="options('matos-densos-autoctones')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="reserva-natural"> Reserva Natural</span><button onclick="options('reserva-natural')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="rede-natura-2000"> Rede Natura 2000</span><button onclick="options('rede-natura-2000')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="parque-natural"> Parque Natural</span><button onclick="options('parque-natural')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
        </ul>

        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listEnergia" ><span class="map-category"><i class="fas fa-chevron-down"></i> Energia</span></a>
        <ul id="listEnergia" class="collapse show map-chooser">
            <li><span class="map-name"> <input type="checkbox" name="layers" value="infraestruturas-energia"> Infraestruturas Energia</span><button onclick="options('infraestruturas-energia')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
        </ul>

        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listRecursosHidricos" ><span class="map-category"><i class="fas fa-chevron-down"></i> Recursos Hídricos</span></a>
        <ul id="listRecursosHidricos" class="collapse show map-chooser">
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Cloretos (Atual)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Cloretos (RCP 8.5 2070-2099)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Cloretos Furos (Atual)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Cloretos Furos (RCP 8.5 2070-2099)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Caudais Galerias (Atual)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Caudais Galerias (Cenário A2 2070-2099)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Caudais Nascentes (Atual)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Caudais Nascentes (Cenário A2 2070-2099)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Caudais Tuneis (Atual)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
            <li><span class="map-name"> <input type="checkbox" name="layers" value="val"> Vulnerabilidade Caudais Tuneis (Cenário A2 2070-2099)</span><button onclick="options('val')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
        </ul>

        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listHidrogeomorfologicos" ><span class="map-category"><i class="fas fa-chevron-down"></i> Riscos Hidrogeomorfológicos</span></a>
        <ul id="listHidrogeomorfologicos" class="collapse show map-chooser">
          <li><span class="map-name"> <input type="checkbox" name="layers" value="movimento-de-vertentes-suscetibilidade"> Aluviões</span><button onclick="options('movimento-de-vertentes-suscetibilidade')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="cheias"> Suscetibilidade Cheias</span><button onclick="options('cheias')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="deslizamento-de-vertentes"> Deslizamento de Vertentes</span><button onclick="options('deslizamento-de-vertentes')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          
        </ul>

        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listSaude" ><span class="map-category"><i class="fas fa-chevron-down"></i> Saúde Humana</span></a>
        <ul id="listSaude" class="collapse show map-chooser">
          <li><span class="map-name"> <input type="checkbox" name="layers" value="ondas-de-calor"> Ondas de Calor entre 1970-1999</span><button onclick="options('ondas-de-calor')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="ondas-de-calor-hyrzea"> Ondas de Calor 2010-2039</span><button onclick="options('ondas-de-calor-hyrzea')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="ondas-de-calor-a2-2040-2069"> Ondas de Calor A2 2040-2069</span><button onclick="options('ondas-de-calor-a2-2040-2069')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="ondas-de-calor-8y3c2b"> Ondas de Calor A2 2070-2099</span><button onclick="options('ondas-de-calor-8y3c2b')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
        </ul>

        <a  href="#" class="collapse-link" data-toggle="collapse" data-target="#listTurismo" ><span class="map-category"><i class="fas fa-chevron-down"></i> Turismo</span></a>
        <ul id="listTurismo" class="collapse show map-chooser">
          <li><span class="map-name"> <input type="checkbox" name="layers" value="empreendimentos-turisticos"> Empreendimentos Turisticos</span><button onclick="options('empreendimentos-turisticos')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="campos-de-golf"> Campos de Golf</span><button onclick="options('campos-de-golf')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>
          <li><span class="map-name"> <input type="checkbox" name="layers" value="aeroportos"> Aeroportos</span><button onclick="options('aeroportos')"  type="button" class="btn btn-primary btn-xs config-button"><i class="fas fa-cog"></i></button></li>        
        </ul>
      </div>

    


            <!-- <li><span class="map-name"> <input type="checkbox" name="layers" value="ondas-de-calor"> Ondas de calor</span><button onclick="options('ondas-de-calor')"  type="button" class="btn btn-primary btn-xs config-button" data-toggle="modal" data-target="#modelId"><i class="fas fa-cog"></i></button></li> -->
            

      <div id="map"></div>
    </div>

   
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="js/map.js"></script>
  </body>
</html>


