<?php

function form_dropdownpro($name = '', $objects = array(), 
        $valuefield, $textfield, $selected = array(), $extra = '')
{
    /**
    * Definieert de form_dropdown. 
    */
    $options[0] = '-- Selecteer --';
    foreach ($objects as $object) {
        $options[$object->{$valuefield}] = $object->{$textfield};
    }

    return form_dropdown($name, $options, $selected, $extra);
}

function form_radiogroup($name = '', $objects = array(),
        $valuefield, $textfield)
{
    /**
     * Definieert de form_radiogroup.
     */
    $result =  '';
    
    $i = 0;
    foreach ($objects as $object) {
        $data = array('name' => $name, 'id' => $name . $i, 
            'value' => $object->{$valuefield});
        $result .= "<div>" . form_radio($data) . $object->{$textfield} .
                "</div>\n";
        $i++;
    }
    
    return $result;
}

