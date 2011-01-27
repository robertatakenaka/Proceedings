<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:mml="http://www.w3.org/1998/Math/MathML">
	<!--xsl:output method="xml" version="1.0" encoding="ISO-8859-1" indent="yes"/-->
	<xsl:include href="scielo_pmc_config.xsl"/>
	<xsl:include href="sci_navegation.xsl"/>
	<xsl:include href="sci_error.xsl"/>
	<xsl:include href="sci_toolbox.xsl"/>
	<xsl:variable name="LANGUAGE" select="//LANGUAGE"/>
	<xsl:variable name="SCIELO_REGIONAL_DOMAIN" select="//SCIELO_REGIONAL_DOMAIN"/>
	<xsl:variable name="show_toolbox" select="//toolbox"/>
	<xsl:template match="fulltext-service-list"/>
	<xsl:template match="/">
		<xsl:apply-templates select="//SERIAL"/>
	</xsl:template>
	<xsl:template match="SERIAL">
		<xsl:if test=".//mml:math">
			<xsl:processing-instruction name="xml-stylesheet"> type="text/xsl" href="/xsl/mathml.xsl"</xsl:processing-instruction>
		</xsl:if>
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>
					<xsl:value-of select="TITLEGROUP/TITLE" disable-output-escaping="yes"/> - <xsl:value-of select="normalize-space(ISSUE/ARTICLE/TITLE)" disable-output-escaping="yes"/>
				</title>
				<meta http-equiv="Pragma" content="no-cache"/>
				<meta http-equiv="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT"/>
				<meta Content-math-Type="text/mathml"/>
				<link rel="stylesheet" type="text/css" href="/css/screen.css"/>
				<xsl:apply-templates select="." mode="css"/>
				<link rel="STYLESHEET" TYPE="text/css" href="/css/scielo2.css"/>
				<script language="javascript" src="applications/scielo-org/js/httpAjaxHandler.js"/>
				<script language="javascript" src="article.js"/>
			</head>
			<body>
				<div class="container">
					<div class="top">
						<div id="issues"/>
						<xsl:call-template name="NAVBAR">
							<xsl:with-param name="bar1">articles</xsl:with-param>
							<xsl:with-param name="bar2">articlesiah</xsl:with-param>
							<xsl:with-param name="home">1</xsl:with-param>
							<xsl:with-param name="alpha">
								<xsl:choose>
									<xsl:when test=" normalize-space(//CONTROLINFO/APP_NAME) = 'scielosp' ">0</xsl:when>
									<xsl:otherwise>1</xsl:otherwise>
								</xsl:choose>
							</xsl:with-param>
							<xsl:with-param name="scope" select="TITLEGROUP/SIGLUM"/>
						</xsl:call-template>
					</div>
					<div class="content">
						<xsl:if test="$show_toolbox = 1">
							<xsl:call-template name="tool_box"/>
						</xsl:if>
						<h2>
							<xsl:apply-templates select="ISSUE" mode="titlegroup"/>
						</h2>
						<h2 id="printISSN">
							<xsl:apply-templates select="ISSUE/ISBN"/>
						</h2>
						<h3>
							<xsl:if test="TITLEGROUP/SIGLUM != 'bjmbr' ">
								<xsl:apply-templates select="ISSUE/STRIP">
									<xsl:with-param name="ARTICLE" select="'TRUE'"/>
								</xsl:apply-templates>
							</xsl:if>
						</h3>
						<h4 id="doi">
							<xsl:apply-templates select="ISSUE/ARTICLE/@DOI"/>&#160;
						</h4>
						<xsl:apply-templates select="ISSUE/ARTICLE/BODY"/>
						<xsl:if test="ISSUE/ARTICLE/fulltext">
							<xsl:apply-templates select="ISSUE/ARTICLE[fulltext]"/>
						</xsl:if>
						<div align="left"/>
						<div class="spacer">&#160;</div>
					</div>
					<div class="footer">
						<xsl:apply-templates select="ISSUE/COPYRIGHT"/>
						<xsl:apply-templates select="ISSUE/CONTACT"/>
					</div>
				</div>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="BODY">
		<xsl:apply-templates select="*|text()" mode="body-content"/>
	</xsl:template>
	<xsl:template match="*|text()" mode="body-content">
		<xsl:value-of select="." disable-output-escaping="yes"/>
	</xsl:template>
	
</xsl:stylesheet>
