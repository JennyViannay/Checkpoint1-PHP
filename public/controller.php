<?php
function cast_query_results($rs) {
    $fields = PDOStatement::getColumnMeta($rs);
    $data = array();
    $types = array();
    foreach($fields as $field) {
        switch($field->type) {
            case 3:
                $types[$field->name] = 'int';
                break;
            case 4:
                $types[$field->name] = 'float';
                break;
            default:
                $types[$field->name] = 'string';
                break;
        }
    }
    while($row=PDOStatement::getColumnMeta($rs)) array_push($data,$row);
        for($i=0;$i<count($data);$i++) {
            foreach($types as $name => $type) {
                settype($data[$i][$name], $type);
            }
        }
        return $data;
}