<?php

function em_aff_ligne_input(string $libelle, array $attributs = array(), string $prefix_id = 'text'): string{
    $html='<tr>';
    $html.='<td><label for="';
    $html.=$prefix_id;
    $html.= $attributs['name'];
    $html.='">';
    $html.=$libelle;
    $html.='</label></td>';
    $html.='<td><input id="';
    $html.= $prefix_id;
    $html.= $attributs['name'];
    $html.='"';

    foreach ($attributs as $cle => $value){
        $html.=' ';
        $html.= $cle;
        $html.= ($value !== null ? "='{$value}'" : '');
    }
    $html.='></td></tr>';
    return $html;
}