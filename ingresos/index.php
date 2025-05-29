<?php
// Consulta XQuery para obtener el XML de ingresos
$xquery = 'doc("C:/xampp/htdocs/basex/ingresos/ingresos.xml")';

// Llama a BaseX REST API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/rest?query=" . urlencode($xquery));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, "admin:admin"); // Cambia si tienes otro usuario/contraseña
$xml = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

// Manejo de errores
if ($xml === false || empty($xml) || $http_code !== 200) {
    echo "<h2>Error al obtener XML de BaseX</h2>";
    echo "<pre>HTTP code: $http_code\ncURL error: $curl_error\nRespuesta:\n" . htmlspecialchars($xml) . "</pre>";
    exit;
}

// Aplica la transformación XSLT en PHP
$xsl = new DOMDocument();
$xsl->load('transformacion_ingresos.xsl');
$xmlDoc = new DOMDocument();
$xmlDoc->loadXML($xml);

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXML($xmlDoc);
?>