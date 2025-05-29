<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" indent="yes" />
  <xsl:key name="por-tipo" match="ingreso" use="@tipo" />
  <xsl:template match="/">
    <html>
      <head>
        <title>Knockout Zone - Economic Result</title>
        <style>
          body {
          font-family: 'Bahnschrift';
          margin: 70px;
          }
          table {
          width: 100%;
          border-collapse: collapse;
          border: 0;
          box-shadow: 3px 5px #00000066;
          }
          th {
          color: #fff;
          font-weight: bolder;
          background: linear-gradient(to right bottom, #00b7c4, #007e98);
          padding: 8px;
          text-align: left;
          }
          td {
          font-family: 'Bahnschrift Light';
          padding: 8px;
          }
        </style>
      </head>
      <body>
        <h1>Knockout Zone - Economic Summary</h1>
        <table border="1">
          <tr>
            <th>Type</th>
            <th>Total</th>
          </tr>
          <xsl:for-each
            select="ingresos/ingreso[generate-id() = generate-id(key('por-tipo', @tipo)[1])]">
            <tr>
              <td>
                <xsl:value-of select="@tipo" />
              </td>
              <td>
                <xsl:value-of
                  select="format-number(sum(key('por-tipo', @tipo)/monto), '#,##0.00 €')" />
              </td>
            </tr>
          </xsl:for-each>
        </table>

        <xsl:for-each
          select="ingresos/ingreso[generate-id() = generate-id(key('por-tipo', @tipo)[1])]">
          <h2>
            <xsl:value-of select="@tipo" />
          </h2>
          <table border="1">
            <tr>
              <th>Date</th>
              <th>Amount €</th>
              <th>Description</th>
            </tr>
            <xsl:for-each select="key('por-tipo', @tipo)">
              <tr>
                <td>
                  <xsl:value-of select="fecha" />
                </td>
                <td>
                  <xsl:value-of select="format-number(monto, '#,##0.00 €')" />
                </td>
                <td>
                  <xsl:value-of select="descripcion" />
                </td>
              </tr>
            </xsl:for-each>
          </table>
        </xsl:for-each>


        <table border="1">
          <tr>
            <h1>Total of All Income</h1>
            <td>
              <xsl:value-of select="format-number(sum(ingresos/ingreso/monto), '#,##0.00 €')" />
            </td>
          </tr>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>