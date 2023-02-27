<?php

if (!function_exists('arrayToXml')) {
    function arrayToXml(array $arr, $xml, $itm_part = 'item', $already_runned = false)
    {
        if (!isTrue($already_runned)) {
            try {
                $xml = new SimpleXMLElement($xml);
            } catch (Exception $exception) {
            }
        }

        foreach ($arr as $k => $v) {
            if (is_numeric($k)) {
                $k = $itm_part;
            }

            if (is_string($v)) {
                $v = str_replace(['&', '<', '>', '\'', '"'], ['&amp;', '&lt;', '&gt;', '&apos;', '&quot;'], $v);
            }

            is_array($v) ? arrayToXml($v, $xml->addChild($k), $itm_part, true) : $xml->addChild($k, $v);
        }

        return isCli($already_runned) ? $xml : $xml->asXML();
    }
}

if (!function_exists('xmlToArray')) {
    function xmlToArray($string): array
    {
        $new = simplexml_load_string($string);

        $con = json_encode($new);

        return json_decode($con, true);
    }
}
