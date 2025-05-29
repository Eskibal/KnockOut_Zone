xquery version "3.1";
 
import module namespace xslt = "http://basex.org/modules/xslt";
 
let $xml := file:read-text("ingresos.xml")
let $xsl := file:read-text("transformacion_ingresos.xsl")
return xslt:transform-text($xml, $xsl)