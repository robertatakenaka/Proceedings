<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:variable name="SETTINGS" select="document(concat('file:///home/proceedings/www/htdocs/xml/',//CONTROLINFO/LANGUAGE,'/settings.xml'))"/>
<xsl:variable name="COUNTRY_LIST" select="document(concat('file:///home/proceedings/www/htdocs/xml/',//CONTROLINFO/LANGUAGE,'/country.xml'))"/>

<!-- Get Vol. No. Suppl. Strip
      Parameter:
        Element - Name of Element   -->

 <xsl:template name="GetStrip">
 	
  <xsl:param name="vol" />
  <xsl:param name="num" />
  <xsl:param name="suppl" />
  <xsl:param name="lang" />

  <xsl:value-of select="$num"/>
  <xsl:if test="$vol">,&#160;v.<xsl:value-of select="$vol"/></xsl:if>
  
 </xsl:template>

 <!-- Get Number in specified language -->
 <xsl:template name="GetNumber">
  <xsl:param name="num" />
  <xsl:param name="lang" />
  <xsl:param name="strip" />
   <xsl:choose>
        <xsl:when test="starts-with($num,'SPE')">
          <xsl:choose>
            <xsl:when test="$lang='en'">special<xsl:if test="$strip">&#160;issue</xsl:if></xsl:when>
            <xsl:otherwise><xsl:if test="$strip">no.</xsl:if>especial</xsl:otherwise>
          </xsl:choose>
          <xsl:if test="string-length($num) > 3">
           <xsl:value-of select="concat(' ',substring($num,4))"/>
          </xsl:if>
        </xsl:when>
        <xsl:when test="starts-with($num,'MON')"> 
          <xsl:choose>
            <xsl:when test="$lang='en'">monograph<xsl:if test="$strip">&#160;issue</xsl:if></xsl:when>
            <xsl:otherwise><xsl:if test="$strip">no.</xsl:if>monográfico</xsl:otherwise>
          </xsl:choose>
          <xsl:if test="string-length($num) > 3">
           <xsl:value-of select="concat(' ',substring($num,4))"/>
          </xsl:if>
        </xsl:when>
	<xsl:otherwise>
	  <xsl:if test="$strip">no.</xsl:if><xsl:value-of select="$num"/>
	</xsl:otherwise>	
    </xsl:choose>
</xsl:template>

 <!-- Get Supplement in specified language -->
<xsl:template name="GetSuppl">
  <xsl:param name="num" />
  <xsl:param name="suppl" />
  <xsl:param name="lang" />
  <xsl:param name="strip" />
   <xsl:if test="$suppl">
       <xsl:if test="$num">&#160;</xsl:if>
       <xsl:choose>
	    <xsl:when test="$lang='en'">suppl.</xsl:when>
	    <xsl:otherwise>supl.</xsl:otherwise>
	 </xsl:choose>
       <xsl:if test="$suppl!=0"><xsl:value-of select="$suppl"/></xsl:if>
    </xsl:if> 
</xsl:template>

<!-- Shows bibliografic strip -->
<xsl:template name="SHOWSTRIP">
  <xsl:param name="SHORTTITLE" />
  <xsl:param name="VOL" />
  <xsl:param name="NUM" />
  <xsl:param name="SUPPL"  />
  <xsl:param name="CITY" />
  <xsl:param name="MONTH" />
  <xsl:param name="YEAR" />

  <xsl:if  test ="$SHORTTITLE"><xsl:value-of select="normalize-space($SHORTTITLE)" /></xsl:if>
  <xsl:if  test ="$VOL">&#160;<xsl:value-of select="normalize-space($VOL)" /></xsl:if>
  <xsl:if  test ="$NUM">&#160;<xsl:value-of select="normalize-space($NUM)" /></xsl:if>
  <xsl:if  test ="$SUPPL">&#160;<xsl:value-of select="normalize-space($SUPPL)" /></xsl:if>
  <xsl:if  test ="$CITY">&#160;<xsl:value-of  select ="normalize-space($CITY)" /></xsl:if>
  <xsl:if  test ="$MONTH">&#160;<xsl:value-of select="normalize-space($MONTH)" /></xsl:if>
  <xsl:if  test ="$YEAR">&#160;<xsl:value-of select ="normalize-space($YEAR)" /></xsl:if>
</xsl:template>


<!-- Prints Information about authors, title and strip 
   Parameters:
             NORM - (abn | iso | van)
             LANG - language code
	      LINK = 1 - prints authors with link
	      SHORTTITLE - Opcional
-->
<xsl:template name="PrintAbstractHeaderInformation">
  <xsl:param name="LANG" />
  <xsl:param name="NORM" />  
  <xsl:param name="AUTHLINK">0</xsl:param>
  <xsl:param name="PID" />
  <xsl:param name="STRIP" />
  

  <xsl:choose>
   <xsl:when test=" $NORM = 'iso' ">
    <!--xsl:call-template name="PrintArticleReferenceISO"-->
    <xsl:call-template name="PrintArticleReferenceElectronicISO">
     <xsl:with-param name="LANG" select="$LANG"/>
     <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
     <xsl:with-param name="AUTHORS" select="AUTHORS"/>
     <xsl:with-param name="ARTTITLE" select="TITLE | SECTION"/>
     <xsl:with-param name="STRIP" select="$STRIP"/>
     <xsl:with-param name="PID" select="$PID"/>
   </xsl:call-template>
   </xsl:when>
   <xsl:when test=" $NORM = 'van' ">
    <xsl:call-template name="PrintArticleReferenceVAN"> 
     <xsl:with-param name="LANG" select="$LANG"/>
     <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
     <xsl:with-param name="AUTHORS" select="AUTHORS"/>
     <xsl:with-param name="ARTTITLE" select="TITLE | SECTION"/>
	 <xsl:with-param name="STRIP" select="ISSUEINFO/STRIP" />
     <xsl:with-param name="PID" select="$PID"/>
   </xsl:call-template>
   </xsl:when>
   <xsl:when test=" $NORM = 'abn' ">
    <xsl:call-template name="PrintArticleReferenceABN">
     <xsl:with-param name="LANG" select="$LANG"/>
     <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
     <xsl:with-param name="AUTHORS" select="AUTHORS"/>
     <xsl:with-param name="ARTTITLE" select="TITLE | SECTION"/>
	 <xsl:with-param name="STRIP" select="ISSUEINFO/STRIP" />
     <xsl:with-param name="PID" select="$PID"/>
    </xsl:call-template>
   </xsl:when>
  </xsl:choose>
  
</xsl:template>


<!-- Prints Article Reference  in ISO 690:1987 Format
	
	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	AUTHORS: AUTHORS element Node
	ARTTITLE: Title of the article
	FPAGE: first page of the article
	LPAGE: last page of the article
	strip: strip
-->
 <xsl:template name="PrintArticleReferenceISO">
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK">0</xsl:param>
  <xsl:param name="AUTHORS" />
  <xsl:param name="ARTTITLE" />
  <!--xsl:param name="VOL" />
  <xsl:param name="NUM" />
  <xsl:param name="SUPPL" />
  <xsl:param name="MONTH" />
  <xsl:param name="YEAR" />
  <xsl:param name="ISBN" /-->
  <xsl:param name="FPAGE" />
  <xsl:param name="LPAGE" />
  <xsl:param name="ISSUE" />
  <!--xsl:param name="SHORTTITLE" select="//TITLEGROUP/SHORTTITLE" /-->
  <xsl:param name="BOLD">1</xsl:param>

  <xsl:call-template name="PrintAuthorsISO">
   <xsl:with-param name="AUTHORS" select="$AUTHORS" />
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
  </xsl:call-template>
  <xsl:if test="$ARTTITLE">
   <xsl:choose>
    <xsl:when test=" $BOLD = 1">
     <font class="negrito">
      <xsl:value-of select="concat(' ', $ARTTITLE)" disable-output-escaping="yes" />
     </font>.
    </xsl:when>
    <xsl:otherwise>
     <xsl:value-of select="concat(' ', $ARTTITLE)" disable-output-escaping="yes" />.
    </xsl:otherwise>
   </xsl:choose>
  </xsl:if>
  <!--
  <i><xsl:value-of select="concat(' ', $SHORTTITLE)" disable-output-escaping="yes" /></i>,
  <xsl:value-of select="concat(' ', $MONTH)" /><xsl:value-of select="concat(' ', $YEAR)" />,
  <xsl:if test="$VOL"><xsl:value-of select="concat(' vol.', $VOL)" /><xsl:if test="$NUM">,</xsl:if></xsl:if>
  <xsl:if test="$NUM"><xsl:value-of select="concat(' no.', $NUM)" /><xsl:if test="$SUPPL">,</xsl:if></xsl:if>
  <xsl:if test="$SUPPL">
    <xsl:choose>
     <xsl:when test=" $LANG='en' "> suppl</xsl:when>
     <xsl:otherwise> supl</xsl:otherwise>
    </xsl:choose>
    <xsl:if test="$SUPPL>0">.<xsl:value-of select="$SUPPL" /></xsl:if>
  </xsl:if> 
  -->
  <xsl:if test="$FPAGE and $LPAGE">
   <xsl:value-of select="concat(', p.', $FPAGE, '-', $LPAGE)" />
  </xsl:if>
  <!--
  <xsl:value-of select="concat('. ISBN	 ', $ISBN, '.')" />
  -->
 </xsl:template>
 
<!-- Prints Article Reference (Electronic) in ISO 690-2:1997 Format
	
	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	AUTHORS: AUTHORS element Node
	ARTTITLE: Title of the article
	VOL: Volumn
	NUM: Number
	SUPPL: Supplement
	MONTH: month name
	YEAR: year
	CURR_DATE: current date in yyyymmdd format
	PID: pid of the article
	ISBN: issn of the journal
	FPAGE: first page of the article
	LPAGE: last page of the article
	SHORTTITLE: short title of the journal
 -->
 <xsl:template name="PrintArticleReferenceElectronicISO">
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK">0</xsl:param>
  <xsl:param name="AUTHORS" />
  <xsl:param name="ARTTITLE" />
  <xsl:param name="STRIP" />
  <xsl:param name="PID" />


  <xsl:call-template name="PrintAuthorsISO">
   <xsl:with-param name="AUTHORS" select="$AUTHORS" />
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
  </xsl:call-template>
  <xsl:if test="$ARTTITLE != '' ">
   <!--font class="negrito"-->
    <xsl:value-of select="concat(' ', $ARTTITLE)" disable-output-escaping="yes" />.
   <!--/font> -->
  </xsl:if>  
  In 
  <i>
  <xsl:apply-templates select="$STRIP/publicationTitles/publicationTitle[@type='prefix']" mode="bibstrip">
  	<xsl:with-param name="sep" select="' '"/>
  </xsl:apply-templates>
  <xsl:apply-templates select="$STRIP/TITLE" mode="bibstrip">
  	<xsl:with-param name="sep" select="', '"/>
  </xsl:apply-templates>
  </i>
  <xsl:apply-templates select="$STRIP/EVENT/DATE[@ID='FIRST']" mode="year">
  	<xsl:with-param name="sep" select="''"/>
  </xsl:apply-templates>
  <xsl:apply-templates select="$STRIP/PUBL/CITY" mode="bibstrip">
  	<xsl:with-param name="prefix" select="', '"/>
  </xsl:apply-templates>
  <xsl:if test="$STRIP/PUBL/STATE or $STRIP/PUBL/COUNTRY"> (</xsl:if>
  <xsl:apply-templates select="$STRIP/PUBL/STATE" mode="bibstrip">
  	<xsl:with-param name="prefix" select="''"/>
  </xsl:apply-templates>
  <xsl:if test="$STRIP/PUBL/STATE and $STRIP/PUBL/COUNTRY">, </xsl:if>
  <xsl:apply-templates select="$STRIP/PUBL/COUNTRY" mode="bibstrip"/>
  <xsl:if test="$STRIP/PUBL/STATE or $STRIP/PUBL/COUNTRY">) </xsl:if>
  [online].
  
  <xsl:apply-templates select="$STRIP/PUBL/DATE" mode="year"/>

  
  <xsl:if test="$STRIP/DATE[@ID='SYSTEM']">
   <xsl:choose>
    <xsl:when test=" $LANG = 'en' "> [cited </xsl:when>
    <xsl:when test=" $LANG = 'pt' "> [citado </xsl:when>
    <xsl:when test=" $LANG = 'es' "> [citado </xsl:when>
   </xsl:choose>
   <xsl:value-of select="concat( substring($STRIP/DATE[@ID='SYSTEM'],7,2),' ')" />
   <xsl:call-template name="GET_MONTH_NAME">
    <xsl:with-param name="LANG" select="$LANG" />
    <xsl:with-param name="MONTH" select="substring($STRIP/DATE[@ID='SYSTEM'],5,2)" />
   </xsl:call-template>
   <xsl:value-of select="concat(' ',substring($STRIP/DATE[@ID='SYSTEM'],1,4),']')" />
  </xsl:if>.
  
  
<!--
  <xsl:if test="$FPAGE and $LPAGE">
   <xsl:value-of select="concat(', p.', $FPAGE, '-', $LPAGE, '.')" />
  </xsl:if>-->
  <xsl:choose>
   <xsl:when test=" $LANG = 'en' "> Available from World Wide Web: </xsl:when>
   <xsl:when test=" $LANG = 'pt' "> Disponível em  World Wide Web: </xsl:when>
   <xsl:when test=" $LANG = 'es' "> Disponible en la World Wide Web: </xsl:when>
  </xsl:choose>
  
  &lt;<!--a>	<xsl:call-template name="AddScieloLink" >
  	 <xsl:with-param name="seq" select="$PID" />
  	 <xsl:with-param name="script">sci_arttext</xsl:with-param>
  	</xsl:call-template-->http://<xsl:value-of select="//CONTROLINFO/SCIELO_INFO/SERVER"/><xsl:value-of select="//CONTROLINFO/SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_arttext&amp;pid=<xsl:value-of select="$PID"/>&amp;lng=<xsl:value-of select="$LANG"/>&amp;nrm=iso<!--/a-->&gt;.
	
	
 </xsl:template>
 
<!-- Prints Authors list  in ISO Format: SURNAME1, Name1, SURNAME2, Name2, SURNAME3, Name3 et al.   
       or

       SURNAME1, Name1 and SURNAME2, Name2       (if num authors <= 3 authors)
       
	Parameters:
	AUTHORS: AUTHORS element Node
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
-->  		  		 
 <xsl:template name="PrintAuthorsISO">
  <xsl:param name="AUTHORS"/>
  <xsl:param name="LANG"/>
  <xsl:param name="AUTHLINK"/> 
  
  <xsl:apply-templates select="$AUTHORS/AUTH_PERS/AUTHOR" mode="PERS_ISO">
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
   <xsl:with-param name="NUM_CORP" select="count($AUTHORS/AUTH_CORP/AUTHOR)" />
  </xsl:apply-templates>

  <xsl:apply-templates select="$AUTHORS/AUTH_CORP/AUTHOR" mode="CORP_ISO">
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="MAX" select="4 - count($AUTHORS/AUTH_PERS/AUTHOR)" />
  </xsl:apply-templates>

 </xsl:template>

<!-- Prints Author (Person) in ISO Format 

	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	NUM_CORP: number of corporative authors

-->  		  		
 <xsl:template match="AUTHOR" mode="PERS_ISO">
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK" />
  <xsl:param name="NUM_CORP" />
  <xsl:variable name="length" select="normalize-space(string-length(NAME))" />
  
  <xsl:choose>
    <!-- If number of authors > 3 prints et al. and terminate -->
   <xsl:when test=" position() = 4 "><i> et al</i>. </xsl:when> 
   <xsl:when test=" position() > 4 "></xsl:when>
  
   <xsl:otherwise>
    <!-- Prints author in format SURNAME1, Name1, SURNAME2, Name2, SURNAME3, Name3 et al -->
    <xsl:call-template name="CreateAuthor">
     <xsl:with-param name="SURNAME" select="UPP_SURNAME" /> <!-- Uppercase -->
     <!--xsl:with-param name="NAME">
      <xsl:value-of select=" normalize-space(translate(NAME, '.', '')) " /><xsl:if
       test=" substring(NAME, $length, 1) = '.' ">.</xsl:if>
     </xsl:with-param-->
     <xsl:with-param name="NAME" select="NAME" />
     <xsl:with-param name="SEARCH"><xsl:if test=" $AUTHLINK = 1 "><xsl:value-of select="@SEARCH" /></xsl:if></xsl:with-param>
     <xsl:with-param name="LANG" select="$LANG" />
     <xsl:with-param name="NORM">iso</xsl:with-param>
     <xsl:with-param name="SEPARATOR">,</xsl:with-param>
    </xsl:call-template>
    <xsl:choose>
     <xsl:when test=" position() = last() and $NUM_CORP = 0 ">
      <xsl:if test=" substring (NAME, $length, 1) != '.' ">.</xsl:if><xsl:text> </xsl:text>
     </xsl:when>
     <!-- Case next author is the last one (not et al), displays ' and ' or equivalent form -->
     <xsl:when test=" position() != 3 and
       ( (position() = last()-1and $NUM_CORP = 0) or (position() = last() and $NUM_CORP = 1) )">
       <xsl:choose>
        <xsl:when test=" $LANG = 'en' "> and </xsl:when>
        <xsl:when test=" $LANG = 'pt' "> e </xsl:when>
        <xsl:when test=" $LANG = 'es' "> y </xsl:when>
       </xsl:choose>
      </xsl:when>
      <!-- Separate authors names by ', '. -->
      <xsl:when test=" position() != 3 ">, </xsl:when>   
    </xsl:choose>
   </xsl:otherwise>
  
  </xsl:choose>
 </xsl:template>

<!-- Prints Author (Corporative) in ISO Format  The max number of authors to be printed is passed as an   argument.

	Parameters:
	LANG: language
	MAX: max number of authors
-->  		  		
 <xsl:template match="AUTHOR" mode="CORP_ISO">
   <xsl:param name="LANG" />
   <xsl:param name="MAX" />

   <xsl:choose>
    <xsl:when test=" position() = $MAX "><i> et al</i>. </xsl:when>
    <xsl:when test=" position() > $MAX "></xsl:when>
    <xsl:otherwise>
     <xsl:value-of select="normalize-space(UPP_ORGNAME)"  disable-output-escaping="yes" />
     <xsl:if test="ORGNAME and ORGDIV">. </xsl:if>
     <xsl:value-of select="normalize-space(ORGDIV)"  disable-output-escaping="yes" />
     <xsl:choose>
      <xsl:when test=" position() = last() ">. </xsl:when>
      
      <xsl:when test=" position() = last() - 1 and last() != $MAX ">
       <xsl:choose>
        <xsl:when test=" $LANG = 'en' "> and </xsl:when>
        <xsl:when test=" $LANG = 'pt' "> e </xsl:when>
        <xsl:when test=" $LANG = 'es' "> y </xsl:when>
       </xsl:choose>
      </xsl:when>
      
      <xsl:when test=" position() + 1 != $MAX ">, </xsl:when>
      </xsl:choose>
    </xsl:otherwise>
   </xsl:choose>

 </xsl:template>

<!-- Prints an Author with surname and name separated by a separator string. If search expression is defined,
 prints a link to search engine passing language and format as parameters.
 
Parameters:
 SURNAME: Surname 
 NAME: Name
 SEARCH: Search Expression
 LANG: language
 NORM: format
 SEPARATOR: separator string
-->
 <xsl:template name="CreateAuthor">
  <xsl:param name="SURNAME" />
  <xsl:param name="NAME" />
  <xsl:param name="SEARCH" />
  <xsl:param name="LANG" />
  <xsl:param name="NORM" />
  <xsl:param name="SEPARATOR" />

  <xsl:variable name="SERVER" select="//SERVER" />
  <xsl:variable name="PATH_WXIS" select="//PATH_WXIS" />
  <xsl:variable name="PATH_DATA_IAH" select="//PATH_DATA_IAH"/>
  <xsl:variable name="PATH_CGI_IAH" select="//PATH_CGI_IAH"/>
  <xsl:variable name="LANG_IAH">
   <xsl:choose>
     <xsl:when test=" $LANG='en' ">i</xsl:when>
     <xsl:when test=" $LANG='es' ">e</xsl:when>
     <xsl:when test=" $LANG='pt' ">p</xsl:when>
   </xsl:choose>
  </xsl:variable>

  <xsl:choose>
   <!-- if SEARCH expression is present prints the link -->
   <xsl:when test=" $SEARCH != '' ">
    <a href="http://{$SERVER}{$PATH_WXIS}{$PATH_DATA_IAH}?IsisScript={$PATH_CGI_IAH}iah.xis&amp;base={$BASE_ARTICLE}^dlibrary&amp;format={$NORM}.pft&amp;lang={$LANG_IAH}&amp;nextAction=lnk&amp;indexSearch=AU&amp;exprSearch={$SEARCH}">     
     <xsl:value-of select="$SURNAME" disable-output-escaping="yes" />
     <!-- Displays separator character and space -->
     <xsl:if test=" $NAME and $SURNAME ">
      <xsl:value-of select="concat($SEPARATOR, ' ')" />
     </xsl:if>
     <xsl:value-of select="$NAME" disable-output-escaping="yes" />
    </a>
   </xsl:when>
   <!-- Otherwise, prints only the author -->
   <xsl:otherwise>
     <xsl:value-of select="$SURNAME" disable-output-escaping="yes" />
     <!-- Displays separator character and space -->
     <xsl:if test=" $NAME and $SURNAME ">
      <xsl:value-of select="concat($SEPARATOR, ' ')" />
     </xsl:if>
     <xsl:value-of select="$NAME" disable-output-escaping="yes" />
   </xsl:otherwise>
  </xsl:choose>
 </xsl:template>

<!-- Prints Article Reference  in Vancouver Format
	
	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	AUTHORS: AUTHORS element Node
	ARTTITLE: Title of the article
	VOL: Volumn
	NUM: Number
	SUPPL: Supplement
	MONTH: month name (abbrev)
	YEAR: year
	ISBN: issn of the journal
	SHORTTITLE: short title of the journal
-->
 <xsl:template name="PrintArticleReferenceVAN"> 
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK">0</xsl:param>
  <xsl:param name="AUTHORS" />
  <xsl:param name="ARTTITLE" />
  <xsl:param name="STRIP" />
  <xsl:param name="PID" />

  <xsl:call-template name="PrintAuthorsVAN">
   <xsl:with-param name="AUTHORS" select="$AUTHORS" />
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
  </xsl:call-template>
  
  <xsl:variable name="text"><xsl:value-of select="$ARTTITLE" disable-output-escaping="yes" /></xsl:variable>
  <xsl:if test="$ARTTITLE">
    <xsl:value-of select="concat(' ', $ARTTITLE)" disable-output-escaping="yes" />.
  </xsl:if><xsl:text> In: </xsl:text>
  <!--font class="negrito">, editors</font>.-->
  <xsl:apply-templates select="$STRIP/publicationTitles/publicationTitle[@type='prefix']" mode="bibstrip">
  	<!--xsl:with-param name="prefix"  select="' ['"/>
  	<xsl:with-param name="sep"  select="' online];'"/-->
  </xsl:apply-templates>
  <!--xsl:apply-templates select="$STRIP/EVENT/NUM" mode="ordinal"/-->
  <xsl:apply-templates select="$STRIP/TITLE" mode="bibstrip">
  </xsl:apply-templates>
   <xsl:choose>
    <xsl:when test=" $LANG = 'en' "> [Proceedings online]; </xsl:when>
    <xsl:when test=" $LANG = 'pt' "> [Anais online]; </xsl:when>
    <xsl:when test=" $LANG = 'es' "> [Anales electrónicos]; </xsl:when>
   </xsl:choose>

  <xsl:if test="$STRIP/EVENT/DATE[@ID='FIRST']">
  	<xsl:call-template name="period">
	  	<xsl:with-param name="first"  select="$STRIP/EVENT/DATE[@ID='FIRST']"/>
  		<xsl:with-param name="last"  select="$STRIP/EVENT/DATE[@ID='LAST']"/>
  		<xsl:with-param name="lang"  select="$LANG"/>		
	</xsl:call-template>	
  </xsl:if>
	<xsl:text>; </xsl:text>
  
  <xsl:if test="$STRIP/EVENT/CITY or $STRIP/EVENT/COUNTRY">
	  <xsl:apply-templates select="$STRIP/EVENT/CITY" mode="bibstrip"/>
	  <xsl:apply-templates select="$STRIP/EVENT/STATE" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>
	  <xsl:apply-templates select="$STRIP/EVENT/COUNTRY" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>	  
	  <xsl:text>. </xsl:text>
  </xsl:if>

  <!--xsl:if test="$STRIP/PUBL/CITY or $STRIP/PUBL/COUNTRY">
	  <xsl:apply-templates select="$STRIP/PUBL/CITY" mode="bibstrip"/>
	  <xsl:apply-templates select="$STRIP/PUBL/STATE" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>
	  <xsl:apply-templates select="$STRIP/PUBL/COUNTRY" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>	  
	  <xsl:text>: </xsl:text>
  </xsl:if>
  <xsl:apply-templates select="$STRIP/PUBL/PUBLISHERS/PUBLISHER" mode="bibstrip">
    	<xsl:with-param name="sep" select="'; '"/>
  </xsl:apply-templates-->

  <xsl:apply-templates select="$STRIP/PUBL/DATE" mode="year"/>

  <xsl:if test="$STRIP/DATE[@ID='SYSTEM']">
   <xsl:choose>
    <xsl:when test=" $LANG = 'en' "> [cited </xsl:when>
    <xsl:when test=" $LANG = 'pt' "> [citado </xsl:when>
    <xsl:when test=" $LANG = 'es' "> [citado </xsl:when>
   </xsl:choose>
   <xsl:value-of select="concat(' ', substring($STRIP/DATE[@ID='SYSTEM'],1,4),' ')" />
   <xsl:call-template name="GET_MONTH_NAME">
    <xsl:with-param name="LANG" select="$LANG" />
    <xsl:with-param name="MONTH" select="substring($STRIP/DATE[@ID='SYSTEM'],5,2)" />
    <xsl:with-param name="ABREV" select="'TRUE'" />
   </xsl:call-template>
   <xsl:value-of select="concat(' ',substring($STRIP/DATE[@ID='SYSTEM'],7,2),'].')" /></xsl:if>
  
  <xsl:choose>
   <xsl:when test=" $LANG = 'en' "> Available from: </xsl:when>
   <xsl:when test=" $LANG = 'pt' "> Disponível em: </xsl:when>
   <xsl:when test=" $LANG = 'es' "> Disponible en: </xsl:when>
  </xsl:choose>
  
  <xsl:variable name="href">http://<xsl:value-of select="//CONTROLINFO/SCIELO_INFO/SERVER"/><xsl:value-of select="//CONTROLINFO/SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_arttext&amp;pid=<xsl:value-of select="$PID"/>&amp;lng=<xsl:value-of select="$LANG"/>&amp;nrm=van</xsl:variable>
  URL: <!--xsl:element name="a">
  			<xsl:attribute name="href"--><xsl:value-of select="$href" /><!--/xsl:attribute><xsl:value-of select="$href" />			
		</xsl:element-->.
  
 </xsl:template>
 
 
 <!-- Prints Authors list  in Vancouver Format:
       Surname1 Name1, Surname2  Name2, Surname3  Name3, Surname4 Name4, Surname5  Name5, Surname6  Name6 et al.   or

       Surname1 Name1, Surname2 Name2       (if num authors <= 6 authors)

	Parameters:
	AUTHORS: AUTHORS element Node
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
-->  		  	
 <xsl:template name="PrintAuthorsVAN">
  <xsl:param name="AUTHORS"/>
  <xsl:param name="LANG"/>
  <xsl:param name="AUTHLINK"/> 
  
  <xsl:apply-templates select="$AUTHORS/AUTH_PERS/AUTHOR" mode="PERS_VAN">
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
   <xsl:with-param name="NUM_CORP" select="count($AUTHORS/AUTH_CORP/AUTHOR)" />
  </xsl:apply-templates>

  <xsl:apply-templates select="$AUTHORS/AUTH_CORP/AUTHOR" mode="CORP_VAN">
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="MAX" select="7 - count($AUTHORS/AUTH_PERS/AUTHOR)" />
  </xsl:apply-templates>

 </xsl:template>

<!-- Prints Author (Person) in Vancouver Format 

	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	NUM_CORP: number of corporative authors

-->  		  		
 <xsl:template match="AUTHOR" mode="PERS_VAN">
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK" />
  <xsl:param name="NUM_CORP" />
  <xsl:variable name="length" select="normalize-space(string-length(NAME))" />
  
  <xsl:choose>
    <!-- If number of authors > 3 prints et al. and terminate -->
   <xsl:when test=" position() = 7 "><i> et al</i>. </xsl:when> 
   <xsl:when test=" position() > 7 "></xsl:when>
  
   <xsl:otherwise>
    <!-- Prints author in format Surname1 Name1, Surname2 Name2, Surname3 Name3,
          Surname4 Name4, Surname5 Name5, Surname6 Name6 et al -->
    <xsl:call-template name="CreateAuthor">
     <xsl:with-param name="SURNAME" select="SURNAME" /> <!-- Uppercase -->
     <!--xsl:with-param name="NAME">
      <xsl:value-of select=" normalize-space(translate(NAME, '.', '')) " /><xsl:if
       test=" substring(NAME, $length, 1) = '.' ">.</xsl:if>
     </xsl:with-param-->
     <xsl:with-param name="NAME" select="NAME" />
     <xsl:with-param name="SEARCH"><xsl:if test=" $AUTHLINK = 1 "><xsl:value-of select="@SEARCH" /></xsl:if></xsl:with-param>
     <xsl:with-param name="LANG" select="$LANG" />
     <xsl:with-param name="NORM">van</xsl:with-param>
     <xsl:with-param name="SEPARATOR"></xsl:with-param>
    </xsl:call-template>
    <xsl:choose>
     <!-- Last author -->
     <xsl:when test=" position() = last() and $NUM_CORP = 0 ">
      <xsl:if test=" substring (NAME, $length, 1) != '.' ">.</xsl:if><xsl:text> </xsl:text>
     </xsl:when>
     <!-- Separate authors names by ', '. -->
      <xsl:when test=" position() != 6 ">, </xsl:when>   
    </xsl:choose>
   </xsl:otherwise>
  
  </xsl:choose>
 </xsl:template>
 
<!-- Prints Author (Corporative) in Vancouver Format  The max number of authors to be printed is passed as an   argument.

	Parameters:
	LANG: language
	MAX: max number of authors
-->  		  
 <xsl:template match="AUTHOR" mode="CORP_VAN">
   <xsl:param name="LANG" />
   <xsl:param name="MAX" />

   <xsl:choose>
    <xsl:when test=" position() = $MAX "><i> et al</i>. </xsl:when>
    <xsl:when test=" position() > $MAX "></xsl:when>
    <xsl:otherwise>
     <xsl:value-of select="normalize-space(ORGNAME)"  disable-output-escaping="yes" />
     <xsl:if test="ORGNAME and ORGDIV">. </xsl:if>
     <xsl:value-of select="normalize-space(ORGDIV)"  disable-output-escaping="yes" />
     <xsl:choose>
      <xsl:when test=" position() = last() ">. </xsl:when>            
      <xsl:when test=" position() + 1 != $MAX ">, </xsl:when>
      </xsl:choose>
    </xsl:otherwise>
   </xsl:choose>

 </xsl:template>

<!-- Prints Article Reference  in ABNT Format
	
	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	AUTHORS: AUTHORS element Node
	ARTTITLE: Title of the article
	VOL: Volumn
	NUM: Number
	SUPPL: Supplement
	MONTH: month name (abbrev)
	YEAR: year
	CITY: city of the publication
	ISBN: issn of the journal
	SHORTTITLE: short title of the journal
-->
 <xsl:template name="PrintArticleReferenceABN">
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK">0</xsl:param>
  <xsl:param name="AUTHORS" />
  <xsl:param name="ARTTITLE" />
  <xsl:param name="STRIP" />
  <xsl:param name="PID" />
  		
  <xsl:call-template name="PrintAuthorsABN">
   <xsl:with-param name="AUTHORS" select="$AUTHORS" />
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
  </xsl:call-template>
  <xsl:if test="$ARTTITLE">
    <xsl:value-of select="concat(' ', $ARTTITLE)" disable-output-escaping="yes" />
  </xsl:if>
  
  <xsl:apply-templates select="$STRIP/publicationTitles/publicationTitle[@type='upperCase']" mode="bibstrip">
	<xsl:with-param name="prefix" select="'. In: '"/>
  	<xsl:with-param name="sep" select="', '"/>
  </xsl:apply-templates>
  
  <xsl:apply-templates select="$STRIP/EVENT/NUM" mode="bibstrip">
  	<xsl:with-param name="sep" select="'., '"/>
  </xsl:apply-templates>
  <xsl:apply-templates select="$STRIP/EVENT/DATE[@ID='FIRST']" mode="year"/><xsl:text>, </xsl:text>
  
  <xsl:if test="$STRIP/EVENT/CITY or $STRIP/EVENT/COUNTRY">
	  <xsl:apply-templates select="$STRIP/EVENT/CITY" mode="bibstrip"/>
	  <!--xsl:apply-templates select="$STRIP/EVENT/STATE" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>
	  <xsl:apply-templates select="$STRIP/EVENT/COUNTRY" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates-->	  
	  <xsl:text>. </xsl:text>
  </xsl:if>
	<b>
   <xsl:choose>
    <xsl:when test=" $LANG = 'en' "> Proceedings online... </xsl:when>
    <xsl:when test=" $LANG = 'pt' "> Anais eletrônicos... </xsl:when>
    <xsl:when test=" $LANG = 'es' "> Anales electrónicos... </xsl:when>
   </xsl:choose>
	</b>

  <!--xsl:if test="$STRIP/PUBL/CITY or $STRIP/PUBL/COUNTRY">
	  <xsl:apply-templates select="$STRIP/PUBL/CITY" mode="bibstrip"/>
	  <xsl:apply-templates select="$STRIP/PUBL/STATE" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>
	  <xsl:apply-templates select="$STRIP/PUBL/COUNTRY" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>	  
	  <xsl:text>: </xsl:text>
  </xsl:if-->

  <xsl:apply-templates select="$STRIP/PUBL/PUBLISHERS/PUBLISHER" mode="bibstrip">
    	<xsl:with-param name="sep" select="', '"/>
  </xsl:apply-templates>

  <!--xsl:apply-templates select="$STRIP/PUBL/DATE" mode="year"/>.-->
  
  <xsl:choose>
   <xsl:when test=" $LANG = 'en' "> Available from: </xsl:when>
   <xsl:when test=" $LANG = 'pt' "> Disponível em: </xsl:when>
   <xsl:when test=" $LANG = 'es' "> Disponible en: </xsl:when>
  </xsl:choose>
  &lt;http://<xsl:value-of select="//CONTROLINFO/SCIELO_INFO/SERVER"/><xsl:value-of select="//CONTROLINFO/SCIELO_INFO/PATH_DATA"/>scielo.php?script=sci_arttext&amp;pid=<xsl:value-of select="$PID"/>&amp;lng=<xsl:value-of select="$LANG"/>&amp;nrm=abn<!--/a-->&gt;.
  <xsl:if test="$STRIP/DATE[@ID='SYSTEM']">
   <xsl:choose>
    <xsl:when test=" $LANG = 'en' "> Acess on: </xsl:when>
    <xsl:when test=" $LANG = 'pt' "> Acesso em: </xsl:when>
    <xsl:when test=" $LANG = 'es' "> Aceso en: </xsl:when>
   </xsl:choose>
   <xsl:value-of select="concat(' ', substring($STRIP/DATE[@ID='SYSTEM'],7,2),' ')" />
   <xsl:call-template name="GET_MONTH_NAME">
    <xsl:with-param name="LANG" select="$LANG" />
    <xsl:with-param name="ABREV" select="'TRUE'" />
    <xsl:with-param name="MONTH" select="substring($STRIP/DATE[@ID='SYSTEM'],5,2)" />
   </xsl:call-template>.
   <xsl:value-of select="concat(' ',substring($STRIP/DATE[@ID='SYSTEM'],1,4))" />.
  </xsl:if>  
  
 </xsl:template>

<!-- Prints Authors list  in ABNT Format: Surname1, Name1, Surname2, Name2, Surname3, Name3 et al.   
       or

       Surname1, Name1 and Surname2, Name2       (if num authors <= 3 authors)
       
	Parameters:
	AUTHORS: AUTHORS element Node
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
-->  
 <xsl:template name="PrintAuthorsABN">
  <xsl:param name="AUTHORS"/>
  <xsl:param name="LANG"/>
  <xsl:param name="AUTHLINK"/> 
  
  <xsl:apply-templates select="$AUTHORS/AUTH_PERS/AUTHOR" mode="PERS_ABN">
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
   <xsl:with-param name="NUM_CORP" select="count($AUTHORS/AUTH_CORP/AUTHOR)" />
  </xsl:apply-templates>

  <xsl:apply-templates select="$AUTHORS/AUTH_CORP/AUTHOR" mode="CORP_ABN">
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="MAX" select="4 - count($AUTHORS/AUTH_PERS/AUTHOR)" />
  </xsl:apply-templates>

 </xsl:template>

<!-- Prints Author (Person) in ABNT Format 

	Parameters:
	LANG: language
	AUTHLINK: Flag '1' = print link for each author.
	NUM_CORP: number of corporative authors

-->  		  		
 <xsl:template match="AUTHOR" mode="PERS_ABN">
  <xsl:param name="LANG" />
  <xsl:param name="AUTHLINK" />
  <xsl:param name="NUM_CORP" />
  <xsl:variable name="length" select="normalize-space(string-length(NAME))" />
  
  <xsl:choose>
    <!-- If number of authors > 3 prints et al. and terminate -->
   <xsl:when test=" position() = 4 "><i> et al</i>. </xsl:when> 
   <xsl:when test=" position() > 4 "></xsl:when>
  
   <xsl:otherwise>
    <!-- Prints author in format SURNAME1, Name1, SURNAME2, Name2, SURNAME3, Name3 et al -->
    <xsl:call-template name="CreateAuthor">
     <xsl:with-param name="SURNAME" select="UPP_SURNAME" /> <!-- Uppercase -->
     <xsl:with-param name="NAME" select="NAME" />
     <xsl:with-param name="SEARCH"><xsl:if test=" $AUTHLINK = 1 "><xsl:value-of select="@SEARCH" /></xsl:if></xsl:with-param>
     <xsl:with-param name="LANG" select="$LANG" />
     <xsl:with-param name="NORM">abn</xsl:with-param>
     <xsl:with-param name="SEPARATOR">,</xsl:with-param>
    </xsl:call-template>
    <xsl:choose>
     <xsl:when test=" position() = last() and $NUM_CORP = 0 ">
      <xsl:if test=" substring (NAME, $length, 1) != '.' ">.</xsl:if><xsl:text> </xsl:text>
     </xsl:when>
     <!-- Case next author is the last one (not et al), displays ' and ' or equivalent form -->
     <xsl:when test=" position() != 3 and
       ( (position() = last()-1and $NUM_CORP = 0) or (position() = last() and $NUM_CORP = 1) )">
       <xsl:choose>
        <xsl:when test=" $LANG = 'en' "> and </xsl:when>
        <xsl:when test=" $LANG = 'pt' "> e </xsl:when>
        <xsl:when test=" $LANG = 'es' "> y </xsl:when>
       </xsl:choose>
      </xsl:when>
      <!-- Separate authors names by ', '. -->
      <xsl:when test=" position() != 3 ">, </xsl:when>   
    </xsl:choose>
   </xsl:otherwise>
  
  </xsl:choose>
 </xsl:template>
 
<!-- Prints Author (Corporative) in ABNT Format  The max number of authors to be printed is passed as an   argument.

	Parameters:
	LANG: language
	MAX: max number of authors
-->  		  
 <xsl:template match="AUTHOR" mode="CORP_ABN">
   <xsl:param name="LANG" />
   <xsl:param name="MAX" />

   <xsl:choose>
    <xsl:when test=" position() = $MAX "><i> et al</i>. </xsl:when>
    <xsl:when test=" position() > $MAX "></xsl:when>
    <xsl:otherwise>
     <xsl:value-of select="normalize-space(ORGNAME)"  disable-output-escaping="yes" />
     <xsl:if test="ORGNAME and ORGDIV">. </xsl:if>
     <xsl:value-of select="normalize-space(ORGDIV)"  disable-output-escaping="yes" />
     <xsl:choose>
      <xsl:when test=" position() = last() ">. </xsl:when>
      
      <xsl:when test=" position() = last() - 1 and last() != $MAX ">
       <xsl:choose>
        <xsl:when test=" $LANG = 'en' "> and </xsl:when>
        <xsl:when test=" $LANG = 'pt' "> e </xsl:when>
        <xsl:when test=" $LANG = 'es' "> y </xsl:when>
       </xsl:choose>
      </xsl:when>
      
      <xsl:when test=" position() + 1 != $MAX ">, </xsl:when>
      </xsl:choose>
    </xsl:otherwise>
   </xsl:choose>

 </xsl:template>

<xsl:template match="AUTHORS">
 <xsl:param name="NORM"/>
 <xsl:param name="LANG"/>
 <xsl:param name="AUTHLINK">0</xsl:param>
 
 <xsl:apply-templates select="AUTH_PERS/AUTHOR" mode="PERS">
   <xsl:with-param name="NORM" select="$NORM" />
   <xsl:with-param name="LANG" select="$LANG" />
   <xsl:with-param name="AUTHLINK" select="$AUTHLINK" />
   <xsl:with-param name="NUM_CORP" select="count(AUTH_CORP/AUTHOR)"/>
  </xsl:apply-templates>
 
  <xsl:apply-templates select="AUTH_CORP/AUTHOR" mode="CORP" /> 
</xsl:template>

 <xsl:template match="AUTHOR" mode="PERS">
   <xsl:param name="NORM" />
   <xsl:param name="LANG" />
   <xsl:param name="AUTHLINK" />
   <xsl:param name="NUM_CORP" />
   
   <xsl:call-template name="CreateAuthor">
    <xsl:with-param name="SURNAME" select="SURNAME" />
    <xsl:with-param name="NAME" select="NAME" />
    <xsl:with-param name="SEARCH"><xsl:if test=" $AUTHLINK = 1 "><xsl:value-of select="@SEARCH" /></xsl:if></xsl:with-param>
    <xsl:with-param name="LANG" select="$LANG" />
    <xsl:with-param name="NORM" select="$NORM"></xsl:with-param>
    <xsl:with-param name="SEPARATOR">,</xsl:with-param>
   </xsl:call-template>
   
   <xsl:if test=" position() != last() or $NUM_CORP > 0 ">; </xsl:if>

  </xsl:template>

 <xsl:template match="AUTHOR" mode="CORP">

     <xsl:value-of select="normalize-space(ORGNAME)"  disable-output-escaping="yes" />
     <xsl:if test="ORGNAME and ORGDIV">. </xsl:if>
     <xsl:value-of select="normalize-space(ORGDIV)"  disable-output-escaping="yes" />
     <xsl:if test=" position() != last() ">, </xsl:if>
     
 </xsl:template>

<xsl:template match="STRIP">

	<xsl:param name="ARTICLE"/>
		
	<xsl:if test="not($ARTICLE)">
    <FONT class="nomodel" color="#800000">
     <xsl:choose>
       <xsl:when test="//CONTROLINFO[LANGUAGE='en']">Table of contents</xsl:when>
	   <xsl:when test="//CONTROLINFO[LANGUAGE='es']">Tabla de contenido</xsl:when>
	   <xsl:when test="//CONTROLINFO[LANGUAGE='pt']">Sumário</xsl:when>
     </xsl:choose>
    </FONT><BR/>
	</xsl:if>
    <font color="#800000">
	 
	 <!--xsl:apply-templates select="publicationTitles/publicationTitle[@type='prefix-part']" mode="bibstrip"/-->
	 <xsl:apply-templates select="SHORTTITLE" mode="bibstrip">
	 	<xsl:with-param name="sep" select="' '"/>
	 </xsl:apply-templates>
	 <!--xsl:apply-templates select="SUBTITLE" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>
	 <xsl:apply-templates select="EVENT/NUM" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 	<xsl:with-param name="sep" select="'., '"/>
	 </xsl:apply-templates-->
	 
   <xsl:call-template name="GET_MONTH_NAME">
    <xsl:with-param name="LANG" select="//CONTROLINFO/LANGUAGE" />
    <xsl:with-param name="MONTH" select="substring(EVENT/DATE[@ID='FIRST'],5,2)" />
    <xsl:with-param name="ABREV" select="'TRUE'" />
   </xsl:call-template>. <xsl:value-of select="concat(' ', substring(EVENT/DATE[@ID='FIRST'],1,4),' ')" />

	 <!--xsl:apply-templates select="EVENT/CITY" mode="bibstrip"/>
	 <xsl:apply-templates select="EVENT/STATE" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>	 
	 <xsl:apply-templates select="EVENT/COUNTRY" mode="bibstrip">
	 	<xsl:with-param name="prefix" select="', '"/>
	 </xsl:apply-templates>
	 <xsl:text>. </xsl:text-->
	 
	 
    </font>
</xsl:template>

<xsl:template match="*|@*|text()" mode="bibstrip">
	<xsl:param name="prefix" select="' '" />
	<xsl:param name="sep" />
  <xsl:if  test =".!=''">
  	<xsl:value-of select="$prefix"/>
	<xsl:value-of select="normalize-space(.)" />
  	<xsl:value-of select="$sep"/>
 </xsl:if>
</xsl:template>

<xsl:template match="DATE" mode="year">
  <xsl:if  test =".!=''">
	<xsl:value-of select="normalize-space(substring(.,1,4))" />
 </xsl:if>
</xsl:template>

<xsl:template match="COUNTRY" mode="bibstrip">
	<xsl:param name="prefix" select="' '" />
	
  <xsl:if  test =".!=''">
    	<xsl:value-of select="$prefix"/>
  	<xsl:variable name="c" select="."/>
	<xsl:apply-templates select="$COUNTRY_LIST//option[c=$c]/v" />
 </xsl:if>
</xsl:template>

<xsl:template match="ISBN/@TYPE" mode="bibstrip">
	<xsl:param name="prefix"/>
	<xsl:param name="sep" select="'. '" />
	
  <xsl:if  test =".!=''">
  	<xsl:variable name="c" select="."/>
  	<xsl:value-of select="$prefix"/>
	<xsl:call-template name="GET_ISBN_TYPE">
  		<xsl:with-param name="TYPE" select="."/>
  		<xsl:with-param name="LANG" select="//CONTROLINFO/LANGUAGE"/>
	</xsl:call-template>
  	<xsl:value-of select="$sep"/>
 </xsl:if>
</xsl:template>

<xsl:template match="publicationTitle/part" mode="bibstrip">
	<xsl:param name="prefix"/>
	<xsl:param name="sep" select="'. '" />
	
  <xsl:if test ="position()=last() or position()=1">
	<xsl:value-of select="."/>
 </xsl:if>
</xsl:template>

<xsl:template match="NUM" mode="ordinal">
	<xsl:param name="LANG" select="//CONTROLINFO/LANGUAGE"/>
	
	<xsl:value-of select="."/>
	<xsl:choose>
		<xsl:when test="$LANG='es'">
			<xsl:choose>
				<xsl:when test="substring(.,string-length(.))='1' or substring(.,string-length(.))='2'">er</xsl:when>
				<xsl:otherwise>&#186;</xsl:otherwise>
			</xsl:choose>
		</xsl:when>
		<xsl:when test="$LANG='en'">
			<xsl:choose>
				<xsl:when test=".='1'">st</xsl:when>
				<xsl:when test=".='2'">nd</xsl:when>
				<xsl:when test=".='3'">rd</xsl:when>
				<xsl:otherwise>th</xsl:otherwise>
			</xsl:choose>
		</xsl:when>
		<xsl:otherwise>&#186;</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="period">
	<xsl:param name="first"/>
	<xsl:param name="last"/>	
	<xsl:param name="lang"/>	
	<xsl:param name="dot"/>	
	

	<xsl:choose>
		<xsl:when test="$first=$last">
		   <xsl:value-of select="substring($first,1,4)" />&#160;
		   <xsl:call-template name="GET_MONTH_NAME">
		    <xsl:with-param name="ABREV" select="'TRUE'" />
		    <xsl:with-param name="LANG" select="$lang" />
		    <xsl:with-param name="MONTH" select="substring($first,5,2)" />
		   </xsl:call-template><xsl:value-of select="$dot"/>
		   &#160;<xsl:value-of select="substring($first,7,2)" />
		</xsl:when>
		<xsl:when test="substring($first,1,6)=substring($last,1,6)">
		   <xsl:value-of select="substring($first,1,4)" />&#160;
		   <xsl:call-template name="GET_MONTH_NAME">
		    <xsl:with-param name="LANG" select="$lang" />
		    <xsl:with-param name="MONTH" select="substring($first,5,2)" />
		    <xsl:with-param name="ABREV" select="'TRUE'" />
		   </xsl:call-template><xsl:value-of select="$dot"/>&#160;<xsl:value-of select="substring($first,7,2)" />-<xsl:value-of select="substring($last,7,2)" />
		</xsl:when>
		<xsl:when test="substring($first,1,4)=substring($last,1,4)">
		   <xsl:value-of select="substring($first,1,4)" />&#160;
		   <xsl:call-template name="GET_MONTH_NAME">
		    <xsl:with-param name="LANG" select="$lang" />
		    <xsl:with-param name="MONTH" select="substring($first,5,2)" />
		    <xsl:with-param name="ABREV" select="'TRUE'" />
		   </xsl:call-template><xsl:value-of select="$dot"/>&#160;<xsl:value-of select="substring($first,7,2)" />-<xsl:call-template name="GET_MONTH_NAME">
		    <xsl:with-param name="LANG" select="$lang" />
		    <xsl:with-param name="MONTH" select="substring($last,5,2)" />
		    <xsl:with-param name="ABREV" select="'TRUE'" />
		   </xsl:call-template><xsl:value-of select="$dot"/>&#160;<xsl:value-of select="substring($last,7,2)" />
		</xsl:when>
		<xsl:otherwise>
		   <xsl:value-of select="substring($first,1,4)" />&#160;
		   <xsl:call-template name="GET_MONTH_NAME">
		    <xsl:with-param name="LANG" select="$lang" />
		    <xsl:with-param name="MONTH" select="substring($first,5,2)" />
		    <xsl:with-param name="ABREV" select="'TRUE'" />
		   </xsl:call-template><xsl:value-of select="$dot"/>&#160;<xsl:value-of select="substring($first,7,2)" />-<xsl:value-of select="substring($last,1,4)" />&#160;<xsl:call-template name="GET_MONTH_NAME">
		    <xsl:with-param name="LANG" select="$lang" />
		    <xsl:with-param name="MONTH" select="substring($last,5,2)" />
		    <xsl:with-param name="ABREV" select="'TRUE'" />
		   </xsl:call-template><xsl:value-of select="$dot"/>&#160;<xsl:value-of select="substring($last,7,2)" />
		</xsl:otherwise>
	</xsl:choose>
	
</xsl:template>


</xsl:stylesheet>
	
	