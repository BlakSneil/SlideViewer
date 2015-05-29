<?php

function createDeepZoomTile($level, $x, $y, $tileWidth, $tileHeight, $slidePath, $tilePath) {

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
    echo "MAX DIMENSION: " . $osrLevelDimensions[0]['maxDim'] . "\n";

	// 2) calcolo il massimo livello N di deepzoom con la formula 2^(N)>=M, dove M dimensione massima della slide
    $maxDeepZoomLayer = ceil(log($osrLevelDimensions[0]['maxDim'], 2));
    echo "MAX DEEPZOOM LAYER: $maxDeepZoomLayer\n";

	// 3) calcolo la dimensione massima del livello deepzoom richiesto ($level) dividendo M per 2 finché da N non arrivo a $level
    $levelMaxDim = $osrLevelDimensions[0]['maxDim'];
    for ($l = $maxDeepZoomLayer; $l > $level; $l--) { 
        $levelMaxDim = ceil($levelMaxDim / 2);
    }
    echo "LEVEL MAX DIM: $levelMaxDim\n";

	// 4) scelgo il livello di openslide che ha un numero di pixel >= a $levelMaxDim
    // TODO: migliorare, è poco efficiente
    $bestLevel = 0;
    for ($i = 1; $i < $osrLevelCount; $i++) {
        if ($osrLevelDimensions[$i]['maxDim'] > $levelMaxDim)
            $bestLevel = $i;
    }
    echo "BEST LEVEL: $bestLevel\n";

	// 5) prendo la regione della slide al livello $bestLevel in base alle coordinate x e y, secondo la proporzione   tileDim : $levelMaxDim = ? : $osrLevelDimensions[$bestLevel]['maxDim']
    // NB: write_png wants x and y coordinates in slide's level 0 reference frame and region width and height in operating level reference frame
    $region_w = ceil($tileWidth * $osrLevelDimensions[$bestLevel]['maxDim'] / $levelMaxDim);
    $region_h = $region_w;
    $region_x = $x * $region_w;
    $region_y = $y * $region_h;

    if ($region_x + $region_w > $osrLevelDimensions[$bestLevel]['width']) {
        $region_w = $osrLevelDimensions[$bestLevel]['width'] - $region_x;
    }
    if ($region_y + $region_h > $osrLevelDimensions[$bestLevel]['height']) {
        $region_h = $osrLevelDimensions[$bestLevel]['height'] - $region_y;
    }

    $r_w = ceil($tileWidth * $osrLevelDimensions[0]['maxDim'] / $levelMaxDim);
    $r_h = $r_w;
    $region_x = $x * $r_w;
    $region_y = $y * $r_h;

    echo "GETTING REGION: x=$region_x   y=$region_y   w=$region_w   h=$region_h\n";

    // TODO: png progressiva?

    write_jpg($osr, $tilePath, $region_x, $region_y, $bestLevel, $region_w, $region_h, $tileWidth, $tileHeight);

    openslide_close($osr);
}