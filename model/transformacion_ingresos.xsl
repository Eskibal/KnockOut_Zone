<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="2.0">
    <xsl:output method="html" indent="yes"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Resumen Económico Web</title>
                <link rel="stylesheet" type="text/css" href="ingresos.css"/>
            </head>
            <body>
                <h1>Resumen por Tipo de Ingreso</h1>
                <table border="1">
                    <tr>
                        <th>Tipo de Ingreso</th>
                        <th>Total</th>
                    </tr>
                    <xsl:for-each-group select="//ingresos/ingreso" group-by="@tipo">
                        <tr>
                            <td>
                                <xsl:value-of select="current-grouping-key()"/>
                            </td>
                            <td>
                                <xsl:value-of select="format-number(sum(current-group()/monto), '#,##0.00')"/>
                            </td>
                        </tr>
                    </xsl:for-each-group>
                </table>
                
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>