<?
//consulta a instancia para pegar o COOKIE se jah logado
//ini_set("display_errors","1");
//error_reporting(E_ALL);
session_start();
$dir = dirname(__FILE__);

$defi = parse_ini_file($dir."/../../../scielo.def",true);

if($defi['services']['show_login'] != "0"){

$loginURL = "http://".$defi['SCIELO_REGIONAL']['SCIELO_REGIONAL_DOMAIN']. $defi['SCIELO_REGIONAL']['check_login_url'];
	
	if(isset($_GET['userID']))
	{
			if (strpos($_SERVER["REQUEST_URI"],"lng"))
			{
				$self_url = str_replace("en",$_GET['lng'],"http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
			}else{
				$self_url = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."&lng=".$_GET['lng'];
			}
			$inicio = strpos($self_url,"userID") -1 ;
			$self_url = substr($self_url, 0, $inicio);

			header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
			setcookie("userID",$_GET['userID'],time()+3600,"/");
			setcookie("userToken",$_GET['userToken'],time()+3600,"/");
			setcookie("tokenVisit",$_GET['tokenVisit'],time()+3600,"/");
			setcookie("firstName",$_GET['firstName'],time()+3600,"/");
			setcookie("lastName",$_GET['lastName'],time()+3600,"/");
			setcookie("userToken",$_GET['userToken'],time()+3600,"/");
			session_write_close();
			Header("Location: ".$self_url);
			exit;
	}
	/*
	se nao verificou no Regional o Login do usuario vai verificar
	*/
	if(!isset($_SESSION['checkedLogin']))
	{

		$self_url = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

		$inicio = strpos($self_url,"userID") -1 ;

		if($inicio > 0){
		   $self_url = substr($self_url, 0, $inicio);
		}

		$_SESSION['checkedLogin'] = "true";
		session_write_close();
		header("Location: ".$loginURL."?origem=".urlencode($self_url));
	}
}
?>
