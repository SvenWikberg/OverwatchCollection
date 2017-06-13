<?php
// return une chaine pour afficher une barre de progression grace aux parametre de la focntion
    // max_value est la valeur maximum de la progress bar
    // current_value est la valur actuelle de la barre
    // width_percent est la largeur de la barre en pourcentage
    // height_px est la hauteur de la barre en pixel
function GetProgressBar($max_value, $current_value, $width_percent, $height_px){
    $display = '';
    $display .= '<div style="width: ' . $width_percent . '%; height: ' . $height_px . 'px; border: 1px solid black;">';
    $display .=      '<div style="width: ' . ($current_value / $max_value) * 100 . '%; background-color: black; height: ' . $height_px . 'px;">';
    $display .=      '</div>';
    $display .= '</div>';

    return $display;
}
?>