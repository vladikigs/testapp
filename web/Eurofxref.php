<?php

class Eurofxref {

    function transformFo($xml) {
        $xmldom = new DOMDocument();
        $xmldom->loadXML($xml);
        $xsldom = new DomDocument();
        $xsldom->load("stylesheets/TestApp/DocumentListFromPdf.xsl");
        $proc = new XSLTProcessor();
        $proc->importStyleSheet($xsldom);
        $res = $proc->transformToXML($xmldom);
        return $res;
    }

    function transformPdf($xml) {
        $url = "https://demo01.ilb.ru/fopservlet/fopservlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new Exception($res . PHP_EOL . $url . " " . curl_error($ch), 450);
        }
        curl_close($ch);
        return $res;
    }
}
?>