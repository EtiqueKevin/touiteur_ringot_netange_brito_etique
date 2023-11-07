<?php

function em_aff_ligne_input(string $libelle, array $attributs = array(), string $prefix_id = 'text'): void{
    echo    '<tr>',
    '<td><label for="', $prefix_id, $attributs['name'], '">', $libelle, '</label></td>',
    '<td><input id="', $prefix_id, $attributs['name'], '"';

    foreach ($attributs as $cle => $value){
        echo ' ', $cle, ($value !== null ? "='{$value}'" : '');
    }
    echo '></td></tr>';
}