<?php
function cleanAndBind($argsArray, $stmt)
{
    //TODO: figure out how the foreach works
    foreach ($argsArray as $argKey => $argValue) {
        $argValue = htmlspecialchars(strip_tags($argValue));
        $stmt->bindParam(":$argKey", $argsArray[$argKey]);
    }

    return $stmt;
}
