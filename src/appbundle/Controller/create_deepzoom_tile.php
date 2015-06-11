<?php

function createDeepZoomTile($level, $x, $y, $tileDim, $slidePath, $tilePath) {

    $osr = openslide_open($slidePath);

    if ($osr == NULL) {
        echo "File $slidePath is not supported.\n";
        die();
    } else if (openslide_get_error($osr)) {
        echo "Failed to open slide $slidePath: " . openslide_get_error($osr). ".\n";
        openslide_close($osr);
        die();
    } else

	// 1) estraggo dalla slide le dimensioni dei vari livelli
    $osrLevelCount = openslide_get_level_count($osr);

    for ($i = 0; $i < $osrLevelCount; $i++) {
        $ww = new_int64_t_p();
        $hh = new_int64_t_p();

        openslide_get_level_dimensions($osr, $i, $ww, $hh);

        $osrLevelDimensions[$i]['width'] = int64_t_p_value($ww);
        $osrLevelDimensions[$i]['height'] = int64_t_p_value($hh);
        $osrLevelDimensions[$i]['maxDim'] = max(int64_t_p_value($ww), int64_t_p_value($hh));

        echo "LEVEL $i DIMENSION: " . int64_t_p_value($ww) . " " . int64_t_p_value($hh) . "\n";
    }
    //echo "MAX DIMENSION: " . $osrLevelDimensions[0]['maxDim'] . "\n";

	// 2) calcolo il massimo livello N di deepzoom con la formula 2^(N)>=M, dove M dimensione massima della slide
    $maxDeepZoomLayer = ceil(log($osrLevelDimensions[0]['maxDim'], 2));
    //echo "MAX DEEPZOOM LAYER: $maxDeepZoomLayer\n";

	// 3) calcolo la dimensione massima del livello deepzoom richiesto ($level) dividendo M per 2 finché da N non arrivo a $level
    $exp = $maxDeepZoomLayer - $level;
    $requiredLevelWidth = ceil($osrLevelDimensions[0]['width'] / pow(2, $exp));
    $requiredLevelHeight = ceil($osrLevelDimensions[0]['height'] / pow(2, $exp));

    //echo "REQUIRED LEVEL WIDTH: $requiredLevelWidth      REQUIRED LEVEL HEIGHT: $requiredLevelHeight\n";


	// 4) scelgo il livello di openslide che ha un numero di pixel >= a $levelMaxDim
    // TODO: migliorare, è poco efficiente
    $bestLevel = 0;
    for ($i = 1; $i < $osrLevelCount; $i++) {
        if ($osrLevelDimensions[$i]['maxDim'] > max($requiredLevelWidth, $requiredLevelHeight))
            $bestLevel = $i;
    }
    //echo "BEST LEVEL: $bestLevel\n";

    // 5) calcolo e aggiusto le dimensioni della tile, aggiungendo un pixel di sovrapposizione per le tile non di confine e stando attendo a non sforare le dimensioni del livello
    $tileWidth = $tileDim;
    $tileX = $x * $tileWidth;
    if ($x > 0) {
        $tileX -= 1;
        $tileWidth += 1;
    }
    if ($tileX + $tileWidth > $requiredLevelWidth) {
        $tileWidth = $requiredLevelWidth - $tileX;
    } else if ($tileX + $tileWidth < $requiredLevelWidth) {
        $tileWidth += 1;
    }

    $tileHeight = $tileDim;
    $tileY = $y * $tileHeight;
    if ($y > 0) {
        $tileY -= 1;
        $tileHeight += 1;
    }
    if ($tileY + $tileHeight > $requiredLevelHeight) {
        $tileHeight = $requiredLevelHeight - $tileY;
    } else if ($tileY + $tileHeight < $requiredLevelHeight) {
        $tileHeight += 1;
    }

    //echo "TILE_WIDTH: $tileWidth   TILE_HEIGHT: $tileHeight\n";

    // 6) converto tutte le misure nello spazio della slide usando le dovute proporzioni
    // NB: write_png wants x and y coordinates in slide's level 0 reference frame and region width and height in operating level reference frame

    // $tileWidth : $requiredLevelWidth = $regionWidth : $osrLevelDimensions[$bestLevel]['width']
    $regionWidth = round($tileWidth * $osrLevelDimensions[$bestLevel]['width'] / $requiredLevelWidth);
    $regionHeight = round($tileHeight * $osrLevelDimensions[$bestLevel]['height'] / $requiredLevelHeight);

    // $tileX : $requiredLevelWidth = $regionX : $osrLevelDimensions[$bestLevel]['width']
    $regionX = round($tileX * $osrLevelDimensions[0]['width'] / $requiredLevelWidth);
    $regionY = round($tileY * $osrLevelDimensions[0]['height'] / $requiredLevelHeight);


    //echo "GETTING REGION: x=$regionX   y=$regionY   w=$regionWidth   h=$regionHeight\n";


    // 7) ritaglio la regione
    // TODO: png progressiva?
    write_jpg($osr, $tilePath, $regionX, $regionY, $bestLevel, $regionWidth, $regionHeight, $tileWidth, $tileHeight);

    openslide_close($osr);
}