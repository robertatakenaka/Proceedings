<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:include href="sci_navegation.xsl"/>
	<xsl:include href="sci_error.xsl"/>
	<xsl:variable name="forceType" select="//CONTROLINFO/ENABLE_FORCETYPE"/>
	<xsl:output method="html" indent="no"/>
	<xsl:template match="SERIAL">
		<html>
			<head>
				<title>
					<xsl:value-of select="TITLEGROUP/TITLE" disable-output-escaping="yes"/> - Home page</title>
				<meta http-equiv="Pragma" content="no-cache"/>
				<meta http-equiv="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT"/>
				<link rel="STYLESHEET" TYPE="text/css" href="/css/scielo.css"/>
				<!-- link pro RSS aparecer automaticamente no Browser -->
				<xsl:call-template name="AddRssHeaderLink">
					<xsl:with-param name="pid" select="//CURRENT/@PID"/>
					<xsl:with-param name="lang" select="//LANGUAGE"/>
					<xsl:with-param name="server" select="CONTROLINFO/SCIELO_INFO/SERVER"/>
					<xsl:with-param name="script">rss.php</xsl:with-param>
				</xsl:call-template>
			</head>
			<body bgcolor="#FFFFFF" link="#000080" vlink="#800080">
				<xsl:call-template name="NAVBAR">
					<xsl:with-param name="bar1">issues</xsl:with-param>
					<xsl:with-param name="bar2">articlesiah</xsl:with-param>
					<xsl:with-param name="alpha">
						<xsl:choose>
							<xsl:when test=" normalize-space(//CONTROLINFO/APP_NAME) = 'scielosp' ">0</xsl:when>
							<xsl:otherwise>1</xsl:otherwise>
						</xsl:choose>
					</xsl:with-param>
					<xsl:with-param name="scope" select="TITLEGROUP/SIGLUM"/>
				</xsl:call-template>
				<xsl:apply-templates select="CONTROLINFO">
					<xsl:with-param name="YEAR" select="substring(@LASTUPDT,1,4)"/>
					<xsl:with-param name="MONTH" select="substring(@LASTUPDT,5,2)"/>
					<xsl:with-param name="DAY" select="substring(@LASTUPDT,7,2)"/>
				</xsl:apply-templates>
				<br/>
				<hr/>
				<p align="center">
					<xsl:apply-templates select="ISSUE/COPYRIGHT"/>
					<xsl:apply-templates select="ISSUE/CONTACT"/>
				</p>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="CONTROLINFO[normalize-space(LANGUAGE)='en']">
		<xsl:param name="YEAR"/>
		<xsl:param name="MONTH"/>
		<xsl:param name="DAY"/>
		<table cellspacing="0" border="0" cellpadding="7" width="100%">
			<tr>
				<td width="30%" align="LEFT" valign="TOP">
					<p class="nomodel" align="left">
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=pt&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">portugu�s</font>
						</a>
						<br/>
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=es&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">espa�ol</font>
						</a>
						<br/>
					</p>
					<p class="nomodel" align="left">
						<font class="nomodel" color="#000080">
					Updated on<br/>
							<xsl:call-template name="GET_MONTH_NAME">
								<xsl:with-param name="LANG" select="'en'"/>
								<xsl:with-param name="MONTH" select="$MONTH"/>
							</xsl:call-template>&#160;<xsl:value-of select="$DAY"/>,&#160;<xsl:value-of select="$YEAR"/>
						</font>
					</p>
					<br/>
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/iaboutj.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>en/aboutj.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<!--a>
			<xsl:attribute name="href">http://<xsl:value-of
				select="SCIELO_INFO/SERVER"/><xsl:value-of
				select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of
				select="/SERIAL/TITLEGROUP/SIGLUM"/>/iedboard.htm</xsl:attribute>
			<img>
				<xsl:attribute name="src"><xsl:value-of
					select="SCIELO_INFO/PATH_GENIMG"/>en/edboard.gif</xsl:attribute>
				<xsl:attribute name="border">0</xsl:attribute>
			</img>
			</a><br/-->
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/iinstruc.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>en/instruc.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/iprintversion.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>en/printversion.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<!--a>
				<xsl:attribute name="href">http://<xsl:value-of
					select="SCIELO_INFO/SERVER"/><xsl:value-of
					select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of
					select="/SERIAL/TITLEGROUP/SIGLUM"/>/isubscrp.htm</xsl:attribute>
				<img>
					<xsl:attribute name="src"><xsl:value-of
						select="SCIELO_INFO/PATH_GENIMG"/>en/subscri.gif</xsl:attribute>
					<xsl:attribute name="border">0</xsl:attribute>
				</img>
			</a><br/-->
					<xsl:apply-templates select="//submission-online-url">
						<xsl:with-param name="imgPath" select="concat(SCIELO_INFO/PATH_GENIMG,//CONTROLINFO/LANGUAGE)"/>
					</xsl:apply-templates>
<xsl:if test=" ENABLE_STAT_LINK = 1 or ENABLE_CIT_REP_LINK = 1 ">
						<!-- xsl:element name="a">
				<xsl:attribute name="href">
					<xsl:value-of select="'{SCIELO_INFO/STAT_SERVER}stat_biblio/index.php?lang='" />
					<xsl:value-of select="LANGUAGE" />
					<xsl:value-of select="'&amp;issn='" />
					<xsl:value-of select="/SERIAL/ISSN" />
				</xsl:attribute>
			</xsl:element -->
						<a href="{SCIELO_INFO/STAT_SERVER}stat_biblio/index.php?lang={LANGUAGE}&amp;issn={/SERIAL/ISSN}">
							<img>
								<xsl:attribute name="src"><xsl:value-of select="concat(SCIELO_INFO/PATH_GENIMG,'en/statist.gif')"/></xsl:attribute>
								<xsl:attribute name="border">0</xsl:attribute>
							</img>
						</a>
					</xsl:if>
				</td>
				<td width="70%" align="LEFT" valign="TOP">
					<p align="left">
						<xsl:call-template name="ImageLogo">
							<xsl:with-param name="src">
								<xsl:value-of select="SCIELO_INFO/PATH_SERIMG"/>
								<xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/glogo.gif</xsl:with-param>
							<xsl:with-param name="alt">
								<xsl:value-of select="/SERIAL/TITLEGROUP/TITLE" disable-output-escaping="yes"/>
							</xsl:with-param>
						</xsl:call-template>
						<br/>
						<br/>
						<xsl:apply-templates select="/SERIAL/ISBN">
							<xsl:with-param name="LANG" select="normalize-space(LANGUAGE)"/>
							<xsl:with-param name="SERIAL" select="1"/>
						</xsl:apply-templates>
					</p>
					<p align="left">
						<!--font color="#000080"><br/>
					<xsl:apply-templates select="/SERIAL/PUBLISHERS/PUBLISHER" />
				</font-->
						<xsl:apply-templates select="/SERIAL/MISSION"/>
						<xsl:apply-templates select="/SERIAL/CHANGESINFO">
							<xsl:with-param name="LANG" select="normalize-space(LANGUAGE)"/>
						</xsl:apply-templates>
					</p>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="CONTROLINFO[normalize-space(LANGUAGE)='pt']">
		<xsl:param name="YEAR"/>
		<xsl:param name="MONTH"/>
		<xsl:param name="DAY"/>
		<table cellspacing="0" border="0" cellpadding="7" width="100%">
			<tr>
				<td width="30%" align="LEFT" valign="TOP">
					<p class="nomodel" align="left">
						<xsl:choose>
							<xsl:when test="$forceType=0">
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=en&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">english</font>
						</a>
						<br/>
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=es&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">espa�ol</font>
						</a>
						<br/>
</xsl:when>
							<xsl:otherwise>
<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=en&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">english</font>
						</a>
						<br/>
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=es&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">espa�ol</font>
						</a>
						<br/>
</xsl:otherwise>
						</xsl:choose>
					</p>
					<p class="nomodel" align="left">
						<font class="nomodel" color="#000080">
					Atualizado em<br/>
							<xsl:call-template name="GET_MONTH_NAME">
								<xsl:with-param name="LANG" select="'pt'"/>
								<xsl:with-param name="MONTH" select="$MONTH"/>
							</xsl:call-template>&#160;<xsl:value-of select="$DAY"/>,&#160;<xsl:value-of select="$YEAR"/>
						</font>
					</p>
					<br/>
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/paboutj.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>pt/aboutj.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<!--a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/pedboard.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>pt/edboard.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/-->
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/pinstruc.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>pt/instruc.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<!--a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/psubscrp.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>pt/subscri.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/-->
                                          <a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/pprintversion.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>pt/printversion.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<xsl:apply-templates select="//submission-online-url">
						<xsl:with-param name="imgPath" select="concat(SCIELO_INFO/PATH_GENIMG,//CONTROLINFO/LANGUAGE)"/>
					</xsl:apply-templates>
					<xsl:if test=" ENABLE_STAT_LINK = 1 or ENABLE_CIT_REP_LINK = 1 ">
						<a href="{SCIELO_INFO/STAT_SERVER}stat_biblio/index.php?lang={LANGUAGE}&amp;issn={/SERIAL/TITLEID}">
							<img>
								<xsl:attribute name="src"><xsl:value-of select="concat(SCIELO_INFO/PATH_GENIMG,'pt/statist.gif')"/></xsl:attribute>
								<xsl:attribute name="border">0</xsl:attribute>
							</img>
						</a>
					</xsl:if>
				</td>
				<td width="70%" align="LEFT" valign="TOP">
					<p align="left">
						<xsl:call-template name="ImageLogo">
							<xsl:with-param name="src">
								<xsl:value-of select="SCIELO_INFO/PATH_SERIMG"/>
								<xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/glogo.gif</xsl:with-param>
							<xsl:with-param name="alt">
								<xsl:value-of select="/SERIAL/TITLEGROUP/TITLE" disable-output-escaping="yes"/>
							</xsl:with-param>
						</xsl:call-template>
						<br/>
						<br/>
						<xsl:apply-templates select="/SERIAL/ISBN">
							<xsl:with-param name="LANG" select="normalize-space(LANGUAGE)"/>
							<xsl:with-param name="SERIAL" select="1"/>
						</xsl:apply-templates>
					</p>
					<p align="left">
						<!--font color="#000080">Publica��o de<br/>
					<xsl:apply-templates select="/SERIAL/PUBLISHERS/PUBLISHER" />
				</font-->
						<font color="#800000">
							<br/>
						</font>Miss�o<br/>
<xsl:apply-templates select="/SERIAL/MISSION"/>
						<xsl:apply-templates select="/SERIAL/CHANGESINFO">
							<xsl:with-param name="LANG" select="normalize-space(LANGUAGE)"/>
						</xsl:apply-templates>
					</p>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="CONTROLINFO[normalize-space(LANGUAGE)='es']">
		<xsl:param name="YEAR"/>
		<xsl:param name="MONTH"/>
		<xsl:param name="DAY"/>
		<table cellspacing="0" border="0" cellpadding="7" width="100%">
			<tr>
				<td width="30%" align="LEFT" valign="TOP">
					<p class="nomodel" align="left">
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=en&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">english</font>
						</a>
						<br/>
				<a>
							<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_serial&amp;lng=pt&amp;pid=<xsl:value-of select="/SERIAL/TITLEID"/>&amp;nrm=<xsl:value-of select="normalize-space(STANDARD)"/></xsl:attribute>
							<font class="linkado" size="-2">portugu�s</font>
						</a>
						<br/>
					</p>
										<p class="nomodel" align="left">
						<font class="nomodel" color="#000080">
					Actualizado en<br/>
							<xsl:call-template name="GET_MONTH_NAME">
								<xsl:with-param name="LANG" select="'es'"/>
								<xsl:with-param name="MONTH" select="$MONTH"/>
							</xsl:call-template>&#160;<xsl:value-of select="$DAY"/>,&#160;<xsl:value-of select="$YEAR"/>
						</font>
					</p>
					<br/>
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/eaboutj.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>es/aboutj.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<!--a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/eedboard.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>es/edboard.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/-->
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/einstruc.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>es/instruc.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
					<a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/eprintversion.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>es/printversion.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/>
						<!--a>
						<xsl:attribute name="href">http://<xsl:value-of select="SCIELO_INFO/SERVER"/><xsl:value-of select="SCIELO_INFO/PATH_SERIAL_HTML"/><xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/esubscrp.htm</xsl:attribute>
						<img>
							<xsl:attribute name="src"><xsl:value-of select="SCIELO_INFO/PATH_GENIMG"/>es/subscri.gif</xsl:attribute>
							<xsl:attribute name="border">0</xsl:attribute>
						</img>
					</a>
					<br/-->
					<xsl:apply-templates select="//submission-online-url">
						<xsl:with-param name="imgPath" select="concat(SCIELO_INFO/PATH_GENIMG,//CONTROLINFO/LANGUAGE)"/>
					</xsl:apply-templates>
<xsl:if test=" ENABLE_STAT_LINK = 1 or ENABLE_CIT_REP_LINK = 1 ">
						<a href="{SCIELO_INFO/STAT_SERVER}stat_biblio/index.php?lang={LANGUAGE}&amp;issn={/SERIAL/TITLEID}">
							<img>
								<xsl:attribute name="src"><xsl:value-of select="concat(SCIELO_INFO/PATH_GENIMG,'es/statist.gif')"/></xsl:attribute>
								<xsl:attribute name="border">0</xsl:attribute>
							</img>
						</a>
					</xsl:if>
				</td>
				<td width="70%" align="LEFT" valign="TOP">
					<p align="left">
						<xsl:call-template name="ImageLogo">
							<xsl:with-param name="src">
								<xsl:value-of select="SCIELO_INFO/PATH_SERIMG"/>
								<xsl:value-of select="/SERIAL/TITLEGROUP/SIGLUM"/>/glogo.gif</xsl:with-param>
							<xsl:with-param name="alt">
								<xsl:value-of select="/SERIAL/TITLEGROUP/TITLE" disable-output-escaping="yes"/>
							</xsl:with-param>
						</xsl:call-template>
						<br/>
						<br/>
						<xsl:apply-templates select="/SERIAL/ISBN">
							<xsl:with-param name="LANG" select="normalize-space(LANGUAGE)"/>
							<xsl:with-param name="SERIAL" select="1"/>
						</xsl:apply-templates>
					</p>
					<p align="left">
						<!--font color="#000080">Publicaci�n del<br/>
					<xsl:apply-templates select="/SERIAL/PUBLISHERS/PUBLISHER" />
				</font-->
<font color="#800000">
							<br/>
						</font>Misi�n<br/>
						<xsl:apply-templates select="/SERIAL/MISSION"/>
						<xsl:apply-templates select="/SERIAL/CHANGESINFO">
							<xsl:with-param name="LANG" select="normalize-space(LANGUAGE)"/>
						</xsl:apply-templates>
					</p>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="PUBLISHER">
		<xsl:if test=".!=''">
			<font color="#000080">
				<xsl:value-of select="$SETTINGS//label[@id='publisher']"/>
				<br/>
				<xsl:value-of select="NAME" disable-output-escaping="yes"/>
				<br/>
			</font>
		</xsl:if>
	</xsl:template>
	<xsl:template match="MISSION">
		<xsl:if test=".!=''">
			<font color="#800000">
				<br/>
			</font>
			<xsl:value-of select="$SETTINGS//label[@id='mission']"/>
			<br/>
			<font color="#000080">
				<xsl:value-of select="." disable-output-escaping="yes"/>
				<br/>
			</font>
			<br/>
		</xsl:if>
	</xsl:template>
<xsl:template match="submission-online-url">
		<xsl:param name="imgPath"/>
		<a>
			<xsl:attribute name="href"><xsl:value-of select="."/></xsl:attribute>
			<img>
				<xsl:attribute name="src"><xsl:value-of select="$imgPath"/>/submission.gif</xsl:attribute>
				<xsl:attribute name="border">0</xsl:attribute>
			</img>
		</a>
		<br/>
	</xsl:template>
</xsl:stylesheet>
