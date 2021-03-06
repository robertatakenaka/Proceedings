<?php
    include_once ( "classDefFile.php" );
    include_once ( "../class.XSLTransformer.php" );
//    include_once ( "classScielo.php" );
	include_once ( "version-4.1-like-4.0.php" );
	include_once ( "scielo-ws.php" );

	define ( "DEFNAME", "scielo.def" );
    define ( "DEFAULT_CACHE_EXPIRES", 180 );
	$defFile = parse_ini_file(dirname(__FILE__)."/../scielo.def");
    $metadataPrefixList = array ( "oai_dc" => array( "ns" => "http://www.openarchives.org/OAI/2.0/oai_dc/",
                                                     "schema" => "http://www.openarchives.org/OAI/2.0/oai_dc.xsd") );
/*
	$repositoryName = "SciELO Online Library Collection";
	$earliestDatestamp = "1996-01-01";
*/        
    $debug_str = "";

	/******************************************* Func�es *********************************************/
    
    function debugstring ( $str )
    {
        global $debug, $debug_str;
        
        if ( $debug )
        {
            $debug_str .= $str;
        }
    }
    
    function printdebug ()
    {
        global $debug, $debug_str;
        
        if ( $debug )
        {
            echo $debug_str;
            exit;
        }
    }

	/************************************** parseResumptionToken *************************************/
    
    function parseResumptionToken ( $resumptionToken )
    {
        global $metadataPrefix, $control, $set, $from, $until;

        $params = split ( ":", $resumptionToken );
                
        $metadataPrefix = "oai_dc"; 
        $control = $params[ 0 ];
        $set = $params[ 1 ];
        $from = $params[ 2 ];
        $until = $params[ 3 ];

        if ( !$control ) return false;
        
        if ( $from && !isDatestamp ( $from ) ) return false;

        if ( $until && !isDatestamp ( $until ) ) return false;

        if ( $set && !is_Set ( $set ) ) return false;
    
        return true;
    }

	/********************************************** is_Set ************************************************/

    function is_Set ( $set )
    {
        return eregi ( "^[0-9a-z]{4}-[0-9a-z]{4}", $set );
    }

	/******************************************* isDatestamp **********************************************/
        
    function isDatestamp ( $date )
    {
        return ereg ( "^[0-9]{4}-[0-9]{2}-[0-9]{2}", $date );
    }

	/******************************************* isValidPrefix *******************************************/

	function isValidPrefix ( $metadataPrefix )
	{
		global $metadataPrefixList;

		reset ( $metadataPrefixList );

		while ( list ( $key, )  = each ( $metadataPrefixList ) )
		{
			if ( $key == $metadataPrefix ) return true;
		}

		return false;
	}

	/**************************************** createOAIErrorpacket ****************************************/
    
    function createOAIErrorpacket ( $request_uri, $verb, $errorcode, $error = "" )
    {
     	$payload = "<error code=\"$errorcode\">$error</error>\n";
       	$packet = generateOAI_packet ( $request_uri, $verb, $payload );
        return $packet;
    }
    
	/**************************************** generateOAI_packet ****************************************/

    function generateOAI_packet ( $request_uri, $verb, $payload )
    {
        global $identifier, $metadataPrefix, $from, $until, $set, $resumptionToken;
        
        $envelop  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $envelop .= "<OAI-PMH xmlns=\"http://www.openarchives.org/OAI/2.0/\"\n";
        $envelop .= "         xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n";
        $envelop .= "         xsi:schemaLocation=\"http://www.openarchives.org/OAI/2.0/\n";
        $envelop .= "          http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd\">\n";

//        $responseDate = date ( "Y-m-d\TH:i:sO" );
//        $responseDate = substr ( $responseDate, 0, -2 ) . ":" . substr ( $responseDate, -2 );
        $responseDate = gmdate ( "Y-m-d\TH:i:s\Z" );
        
        $envelop .= " <responseDate>" . $responseDate . "</responseDate>\n";
        $envelop .= " <request verb=\"" . $verb . "\"";

        if ( $metadataPrefix && !$resumptionToken )
        {
        	$envelop .= " metadataPrefix=\"" . $metadataPrefix . "\"";
        }

        if ( $identifier && !$resumptionToken  )
        {
        	$envelop .= " identifier=\"" . $identifier . "\"";
        }

        if ( $from  && !$resumptionToken )
        {
        	$envelop .= " from=\"" . $from . "\"";
        }

        if ( $until  && !$resumptionToken )
        {
        	$envelop .= " until=\"" . $until . "\"";
        }

        if ( $set  && !$resumptionToken )
        {
        	$envelop .= " set=\"" . $set . "\"";
        }
                
        if ( $resumptionToken )
        {
        	$envelop .= " resumptionToken=\"" . $resumptionToken . "\"";
        }

        $envelop .= ">" . $request_uri . "</request>\n";

        $envelop .= $payload;

        $envelop .= "</OAI-PMH>\n";

        return $envelop;
    }

	/**************************************** generatePayload ****************************************/

    function generatePayload ( $ws_client_url, $service, $service_name, $parameters, $xsl )
    {
        global $debug, $defFile;
			//die($service_name." - ".$service);
			switch ( $service_name )
			{
			case "Identify": 
				{
				$response = listRecords( $set = $parameters["set"], $from = $parameters["from"], $until = $parameters["until"], $control = $parameters["control"], $lang = "en", $nrm = "iso", $count = 30, $debug = false );
				break;
				}
			case "ListMetadataFormats":
				{
				$response = getAbstractArticle( $set = $parameters["set"], $from = $parameters["from"], $until = $parameters["until"], $control = $parameters["control"], $lang = "en", $nrm = "iso", $count = 30, $debug = false );
				break;
				}
			case "ListIdentifiers":
				{
				$response = listRecords( $set = $parameters["set"], $from = $parameters["from"], $until = $parameters["until"], $control = $parameters["control"], $lang = "en", $nrm = "iso", $count = 30, $debug = false );
				break;
				}
			case "ListSets":
				{
				$response = getTitles($lang = "en", $debug = false );
				break;
				}				
			case "ListRecords":
				{
				$response = ListRecords( $set = $parameters["set"], $from = $parameters["from"], $until = $parameters["until"], $control = $parameters["control"], $lang = "en", $nrm = "iso", $count = 30, $debug = false );
				break;
				}
			case "GetRecord":
				{
				$response = getAbstractArticle( $pid = $parameters["pid"],$lang = "en", $ws = $parameters["ws_oai"], $debug = false );
				break;
				}
			}
       // $result = "";
        if ( !$debug )
        {
			$transform = new XSLTransformer ();
			if (getenv("ENV_SOCKET")!="true"){  //socket
				$xsl = file_get_contents($defFile["PATH_OAI"].$xsl);
			} else {
				$xsl = str_replace('.XSL','',strtoupper($xsl));
			}
	    	$transform->setXslBaseUri($defFile["PATH_OAI"]);	
    	    $transform->setXsl ( $xsl );
	        $transform->setXml ( $response );
	        $transform->transform();
            if ( $transform->getError() )
    	    {
	            // Transformation error
                echo "XSL Transformation error\n";
    	        echo $transform->getError();
	            $transform->destroy();
	            exit ();
    	    }
			
	        $result = $transform->getOutput();
	        $transform->destroy();
        }

	    return $result;
    }

	/**************************************** verbo GetRecord **************************************/

    function getRecord_OAI ( $request_uri, $ws_client_url, $xslPath, $identifier, $metadataPrefix )
    {
        global $debug;
        
    	if ( !isset ( $identifier ) || empty ( $identifier ) )
    	{
    		$result = "<error code=\"badArgument\">Missing or empty identifier</error>\n";
    	}
    	else if ( !isset ( $metadataPrefix ) || empty ( $metadataPrefix ) )
    	{
    		$result = "<error code=\"badArgument\">Missing or empty metadataPrefix</error>\n";
    	}
    	else if ( !isValidPrefix ( $metadataPrefix ) )
    	{
    		$result = "<error code=\"cannotDisseminateFormat\"/>\n";
    	}
    	else
    	{
	        $parameters = array ( "pid" => str_replace ( "oai:scielo:", "", $identifier ),
                                  "lang" => "en", 
                                  "tlng" => "en", 
                                  "ws_oai" => true );
                                  
            if ( $debug ) $parameters[ "debug" ] = true;
                                  
	       // $xsl = $xslPath . "GetRecord.xsl";
			 $xsl = "GetRecord.xsl";
	    	$result = generatePayload ( $ws_client_url, "getAbstractArticle", "GetRecord", $parameters, $xsl );
	    }

	    $oai_packet = generateOAI_packet ( $request_uri, "GetRecord", $result );

//	    $oai_packet = str_replace ( "localhost", "200.6.42.159", $oai_packet);

	    return $oai_packet;
    }

	/**************************************** verbo Identify **************************************/

    function Identify_OAI ( $request_uri, $ws_client_url, $xslPath )
    {
    	global $repositoryName, $earliestDatestamp, $adminEmails;

    	$payload  = " <Identify>\n";
    	$payload .= "  <repositoryName>$repositoryName</repositoryName>\n";
    	$payload .= "  <baseURL>$request_uri</baseURL>\n";
    	$payload .= "  <protocolVersion>2.0</protocolVersion>\n";
    	for ( $i = 0; $i < sizeof ( $adminEmails ); $i++ )
    	{
    		$payload .= " <adminEmail>" . $adminEmails[ $i ] . "</adminEmail>\n";
    	}
        
//    	$payload .= "  <earliestDatestamp>$earliestDatestamp</earliestDatestamp>\n";
        $parameters = array (
                "set" => "", 
                "from" => "19700101", 
                "until" => "", 
                "control" => "",
                "lang" => "en",
                "nrm" => "iso",
                "count" => 1
        );

        if ( $debug ) $parameters[ "debug" ] = true;
            
       // $xsl = $xslPath . "Identify.xsl";
		 $xsl = "Identify.xsl";
	   	$result = generatePayload ( $ws_client_url, "listRecords","Identify", $parameters, $xsl );
        
        $payload .= trim ( str_replace ( "datestamp", "earliestDatestamp", $result ) );

    	$payload .= "  <deletedRecord>no</deletedRecord>\n";
    	$payload .= "  <granularity>YYYY-MM-DD</granularity>\n";
    	$payload .= " </Identify>\n";

    	$oai_packet = generateOAI_packet ( $request_uri, "Identify", $payload );

//	    $oai_packet = str_replace ( "localhost", "200.6.42.159", $oai_packet);

    	return $oai_packet;
    }

	/************************************ verbo ListMetadataFormats **********************************/

    function ListMetadataFormats_OAI ( $request_uri, $ws_client_url, $xslPath, $identifier = "" )
    {
    	global $debug, $metadataPrefixList;

    	$payload = "";

    	if ( $identifier )
    	{
	        $parameters = array ( "pid" => str_replace ( "oai:scielo:", "", $identifier ),
                                  "lang" => "en", 
                                  "tlng" => "en", 
                                  "ws_oai" => true );
                                  
            if ( $debug ) $parameters[ "debug" ] = true;

        	//$xsl = $xslPath . "ListMetadataFormats.xsl";
			$xsl = "ListMetadataFormats.xsl";
    		$payload = generatePayload ( $ws_client_url, "getAbstractArticle","ListMetadataFormats", $parameters, $xsl );
		}

    	if ( trim ( $payload ) == "" )
    	{
			$payload  = " <ListMetadataFormats>\n";

	    	reset ( $metadataPrefixList );

	    	while ( list ( $metadataPrefix, $data ) = each ( $metadataPrefixList ) )
	    	{
	    		$payload .= "  <metadataFormat>\n";
	    		$payload .= "   <metadataPrefix>$metadataPrefix</metadataPrefix>\n";
	    		$payload .= "   <schema>" . $data[ "schema" ] . "</schema>\n";
	    		$payload .= "   <metadataNamespace>" . $data[ "ns" ] . "</metadataNamespace>\n";
	    		$payload .= "  </metadataFormat>\n";
	    	}

			$payload .= " </ListMetadataFormats>\n";
		}

    	$oai_packet = generateOAI_packet ( $request_uri, "ListMetadataFormats", $payload );

//	    $oai_packet = str_replace ( "localhost", "200.6.42.159", $oai_packet);

    	return $oai_packet;
    }

	/**************************************** verbo ListSets *****************************************/

    function ListSets_OAI ( $request_uri, $ws_client_url, $xslPath, $resumptionToken = "" )
    {
        global $debug;
        
        //$xsl = $xslPath . "ListSets.xsl";
		$xsl = "ListSets.xsl";
		$parameters = array ( "lang" => "en" );
        
        if ( $debug ) $parameters[ "debug" ] = true;

    	$result = generatePayload ( $ws_client_url, "getTitles", "ListSets", $parameters, $xsl );

	    $oai_packet = generateOAI_packet ( $request_uri, "ListSets", $result );

//	    $oai_packet = str_replace ( "localhost", "200.6.42.159", $oai_packet);

	    return $oai_packet;
    }

	/**************************************** ListIdOrRecords_OAI ****************************************/
    
    function ListIdOrRecords_OAI ( $verb, $request_uri, $ws_client_url, $xslPath, $metadataPrefix, $set = "", $from = "", $until = "", $control = "" )
    {
        global $debug;

    	if ( !isset ( $metadataPrefix ) || empty ( $metadataPrefix ) )
    	{
    		$result = "<error code=\"badArgument\">Missing or empty metadataPrefix</error>\n";
    	}
    	else if ( !isValidPrefix ( $metadataPrefix ) )
    	{
    		$result = "<error code=\"cannotDisseminateFormat\"/>\n";
    	}
    	else
    	{
            if ( $from ) $from = substr ( $from, 0, 4 ) . substr ( $from, 5, 2 ) . substr ( $from, 8, 2 );

            if ( $until ) $until = substr ( $until, 0, 4 ) . substr ( $until, 5, 2 ) . substr ( $until, 8, 2 );

	        $parameters = array (
                "set" => $set, 
                "from" => $from, 
                "until" => $until, 
                "control" => $control,
                "lang" => "en",
                "nrm" => "iso",
                "count" => 40
            );

            if ( $debug ) $parameters[ "debug" ] = true;
            
	        //$xsl = $xslPath . "$verb.xsl";
			$xsl = "$verb.xsl";
	    	$result = generatePayload ( $ws_client_url, "listRecords", $verb, $parameters, $xsl );
	    }

	    $oai_packet = generateOAI_packet ( $request_uri, $verb, $result );
        
//	    $oai_packet = str_replace ( "localhost", "200.6.42.159", $oai_packet);

	    return $oai_packet;    
    }

	/******************************************* Principal *******************************************/

    if ( isset ( $_SERVER ) && !isset ( $DOCUMENT_ROOT ) )
	{
		$DOCUMENT_ROOT = $_SERVER[ "DOCUMENT_ROOT" ];
	}
    
    $DOCUMENT_ROOT = trim ( $DOCUMENT_ROOT );
    
    $dirChar = ( strpos ( $DOCUMENT_ROOT, "\\" ) === false ) ? "/" : "\\";

    if ( substr ( $DOCUMENT_ROOT, -1 ) == $dirChar )
    {
	    $def = $DOCUMENT_ROOT . DEFNAME;
    }
    else
    {
	    $def = $DOCUMENT_ROOT . $dirChar . DEFNAME;
    }

    debugstring ( "\$def=$def\n" );    
    $deffile = new DefFile ( $def );

    $ws_client_url = "http://" . $deffile->getKeyValue("SERVER_SCIELO") . $deffile->getKeyValue("PATH_DATA") . "ws/scielo-ws.php";
    debugstring ( "\$ws_client_url=$ws_client_url\n" );    

    $self = "http://" . $deffile->getKeyValue("SERVER_SCIELO") . $deffile->getKeyValue("PATH_DATA") . "oai/scielo-oai.php";

	$xslPath = "http://" . $deffile->getKeyValue("SERVER_SCIELO") . $deffile->getKeyValue("PATH_DATA") . "oai/";
    debugstring ( "\$xslPath=$xslPath\n" );    
    
	$repositoryName = trim ( $deffile->getKeyValue("SITE_NAME") );
	$adminEmails = array ( trim ( $deffile->getKeyValue("E_MAIL") ) );

    switch ( $verb )
    {
    	case "Identify":
			$packet = Identify_OAI ( $self, $ws_client_url, $xslPath );
            break;

		case "ListMetadataFormats":
			$packet = ListMetadataFormats_OAI ( $self, $ws_client_url, $xslPath, $identifier );
			break;

    	case "GetRecord":
        	$packet = getRecord_OAI ( $self, $ws_client_url, $xslPath, $identifier, $metadataPrefix );
            break;

		case "ListSets":
			$packet = ListSets_OAI ( $self, $ws_client_url, $xslPath, $resumptionToken );
			break;
            
        case "ListIdentifiers":
        case "ListRecords":
            if ( $resumptionToken && !parseResumptionToken ( $resumptionToken ) )
            {
                $packet = createOAIErrorpacket ( $self, $verb, "badResumptionToken" );
                break;
            }
            
            if ( $from && !isDatestamp ( $from ) )
            {
                $packet = createOAIErrorpacket ( $self, $verb, "badArgument", "Invalid date format" );
                break;
            }

            if ( $until && !isDatestamp ( $until ) )
            {
                $packet = createOAIErrorpacket ( $self, $verb, "badArgument", "Invalid date format" );
                break;
            }

            $packet = ListIdOrRecords_OAI ( $verb, $self, $ws_client_url, $xslPath, $metadataPrefix, $set, $from, $until, $control );
			break;

        default:
            $packet = createOAIErrorpacket ( $self, $verb, "badVerb", "Illegal OAI verb" );
        	break;
    }
    
    printdebug ();

    header ( "Content-Type: text/xml" );
    echo $packet;
?>
