<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>
    <xsl:template match="/">
        <html>
        <head>
            <title>Students and Grades</title>
            <style>
            table { border-collapse: collapse; width: 80%; margin: 20px auto; }
            th, td { border: 1px solid #333; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            h1 { text-align: center; }
            tr:nth-child(even) { background-color: #f9f9f9; }
            </style>
        </head>
        <body>
            <h1>Students and Grades</h1>
            <table>
            <tr>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Grades</th>
            </tr>
            <xsl:for-each select="Students/Student">
                <tr>
                <td><xsl:value-of select="id"/></td>
                <td><xsl:value-of select="last_name"/></td>
                <td><xsl:value-of select="first_name"/></td>
                <td><xsl:value-of select="all_grades"/></td>
                </tr>
            </xsl:for-each>
            </table>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
