<?php
/**
*@package	Scielo.org
*@version      2.0
*@author       Andr� Otero(andre.otero@bireme.org)
*@copyright     BIREME
*/

require_once(dirname(__FILE__)."/UserProfileDAO.php");
require_once(dirname(__FILE__)."/DBClass.php");
require_once(dirname(__FILE__)."/UserProfileClass.php");
//require_once(dirname(__FILE__)."/../includes/phpmailer/class.phpmailer.php");
require_once(dirname(__FILE__)."/../sgu/chamaWebService.php");
require_once(dirname(__FILE__)."/../classes/UserProfileAction.php");

define("DEF_FILE",dirname(__FILE__)."/../scielo.def");

/**
*Classe de Usu�rios do Scielo regional
*
*Encapsula as func�es de maniten��o dos usu�rios Utilisando os WebServices do 
*Sistema de Gerenciamento de Usu�rios (SGU) para isso
*Guarda al�m das informa��es b�sicas do usu�rio as inform��es sobre o perfil do usu�rio (as
*palavras-chave que ele ir� entrar no cadastro que ir� determinar o seu perfil atrav�s de trigramas
*@package	Scielo.org
*@version      2.0
*@author       Andr� Otero(andre.otero@bireme.org)
*@copyright     BIREME
*/
class UserClass {
/**
* Identificador do usu�rio
* @var integer
*/
	var $_id = 0;
/**
* Primeiro nome do Usu�rio
* @var string
*/
	var $_firstName = '';
/**
* Segundo nome do Usu�rio
* @var string
*/
	var $_lastName = '';
/**
* O sexo do usu�rio
* @var string
*/
	var $_gender = '';
/**
* O nome de Login do usu�rio (� �nico no sistema por�m n�o � chave)
* @var string
*/
	var $_login = '';
/**
* Endere�o de e-mail do usu�rio
* @var string
*/
	var $_email = '';
/**
* Senha do usu�rio, � gravado no bando o MD5 da senha do usu�rio e n�o a pr�pria senha por essa raz�o � um char[32] pois o MD5 tem sempre o mesmo tamanho
* @var char[32]
*/
	var $_password  = '';

/**
* Os perfis que o usu�rio ir� preencher no seu cadastro (do qual ser�o gerados trigramas para cada um)
* @var Object[] ProfileClass
*/
	var $_profiles  = array();

/**
* Referencia a classe mailer
* @var Object phpMailer classe de mailer
*/
	var $_mail  = null;

/**
* Token gerado pelo SGU para esse se��o de Login
* @var string $token Token gerado pelo SGU para esse se��o de Login
*/
	var $_token  = "";

/**
* Token gerado pelo SGU para traking do usu�rio
* @var string $token Token gerado pelo SGU para traking do usu�rio
*/
	var $_visitToken  = "";
/**
* Array com o conteudo do arquivo de defini��es do Scielo
* @var array $_def Array com o conteudo do arquivo de defini��es do Scielo
*/
	var $_def = array();

/**
* Grau de Forma��o do usu�rio
* @var string $_grauDeFormacao Grau de Forma��o do usu�rio
*/
	var $_grauDeFormacao = "";


/**
* Afiliacao do usuario (institu���o)
* @var string $_afiliacao Afiliacao do usuario (institu���o)
*/
	var $_afiliacao = "";

/**
* Construtor da Classe UserClass
*
* @param string $firstName Primeiro nome do Usu�rio
* @param string $lastName Segundo nome do Usu�rio
* @param string $login O nome de Login do usu�rio (� �nico no sistema por�m n�o � chave)
* @param string $email  Endere�o de e-mail do usu�rio
* @param char[32] $password senha do usu�rio, � gravado no bando o MD5 da senha do usu�rio e n�o a pr�pria senha por essa raz�o � um char[32] pois o MD5 tem sempre o mesmo tamanho
*/
	function UserClass($firstName='', $lastName='', $gender='', $login='', $email='', $password='',$afiliacao="", $grauDeFormacao=""){
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_gender = $gender;
		$this->_login = $login;
		$this->_email = $email;
		$this->_afiliacao = $afiliacao;
		$this->_grauDeFormacao = $grauDeFormacao;
		$this->_db = new DBClass();
		$this->_password = $password;
		$this->_def = parse_ini_file(DEF_FILE,true);
	}

/**
* "Zera" os campos da classe para que o loadUser os recarrege
*/
	function clearFields(){
		$this->_id = 0;
		$this->_firstName = '';
		$this->_lastName = '';
		$this->_gender = '';
		$this->_login = '';
		$this->_afiliacao = "";
		$this->_grauDeForcamao = "";
		$this->_email = '';
		$this->_password  = '';
		$this->_profiles  = array();
	}

/**
* Atribu� um valor para o campo ID da classe
* @param integer $id Identificador do usu�rio
*/
	function setID($id){
		$this->_id = $id;
	}

/**
* Atribu� um valor para o campo firstName da classe
* @param string $firstName Primeiro nome do Usu�rio
*/
	function setFirstName($firstName){
		$this->_firstName = $firstName;
	}

/**
* Atribu� um valor para o campo lastName da classe
* @param string $lastName Segundo nome do Usu�rio
*/
	function setLastName($lastName){
		$this->_lastName = $lastName;
	}

/**
* Atribu� um valor para o campo gender da classe
* @param string $gender O sexo do usu�rio
*/
	function setgender($gender){
		$this->_gender = $gender;
	}


/**
* Atribu� um valor para o campo login da classe
* @param string $login O nome de Login do usu�rio (� �nico no sistema por�m n�o � chave)
*/
	function setLogin($login){
		$this->_login = $login;
	}

/**
* Atribu� um valor para o campo email da classe
* @param string $email  Endere�o de e-mail do usu�rio
*/
	function setEmail($email){
		$this->_email = $email;
	}

/**
* Atribu� um valor para o campo afiliacao da classe
* @param string $afiliacao Afiliacao do usuario
*/
	function setAfiliacao($afiliacao){
		$this->_afiliacao = $afiliacao;
	}

/**
* Atribu� um valor para o campo Grau De Formacao da classe
* @param string $GrauDeFormacao Grau De Formacao do usuario
*/
	function setGrauDeFormacao($GrauDeFormacao){
		$this->_grauDeFormacao = $GrauDeFormacao;
	}


/**
* Adiciona um profile � instancia em mem�ria da classe UserClass
* @param Object [] $ProfileClass Uma instancia do Objeto Profile
*/
	function setProfiles($profile, $name=''){
//se o argumento � uma string, significa que estamos criando o usu�rio ainda, logo, devemos criar um
//objeto UserProfileClass, setar os seus atributos e adicionar � lista de Perfis do Usu�rio
		if(is_string($profile)){
			$p = new UserProfileClass();
			$p->setUserID($this->getID());
			$p->setProfileText($profile);
			$p->setProfileName($name);
			array_push ($this->_profiles, $p);
//se o argumento � um objeto significa que estamos recuperando o usu�rio da base, e j� trazemos o objeto
//UserProfileClass "pronto" precisamos apenas adicionar � lista de Perfis do Usu�rio
		}else	if (is_array($profile)){
			// array de UserProfile
			$this->_profiles = $profile;
		}else	if (is_object($profile)){
			array_push ($this->_profiles, $profile);
		}
	}

/**
* Atribu� um valor para o campo password da classe
* @param char[32] $password senha do usu�rio, � gravado no bando o MD5 da senha do usu�rio e n�o a pr�pria senha por essa raz�o � um char[32] pois o MD5 tem sempre o mesmo tamanho
*/
	function setPassword($password){
		$this->_password = $password;	
	}

/**
* Atribu� um valor para o campo token da classe
* @param string $token Token gerado pelo SGU para esse se��o de Login
*/
	function setToken($token){
		$this->_token = $token;
	}

/**
* Atribu� um valor para o campo visitToken da classe
* @param string $token Token gerado pelo SGU para esse se��o de Login
*/
	function setVisitToken($token){
		$this->_visitToken = $token;
	}

/**
* Recupera um valor para o campo token da classe
* @returns string $token Token gerado pelo SGU para esse se��o de Login
*/
	function getToken(){
		return $this->_token;
	}

/**
* Recupera um valor para o campo visitToken da classe
* @returns string $token Token gerado pelo SGU para esse se��o de Login
*/
	function getVisitToken(){
		return $this->_visitToken;
	}

/**
* Recupera um valor para o campo ID da classe
* @returns integer $id Identificador do usu�rio
*/
	function getID(){
		return (trim($this->_id));
	}

/**
* Recupera um valor para o campo firstName da classe
* @returns string $firstName Primeiro nome do Usu�rio
*/
	function getFirstName(){
		return (trim($this->_firstName));
	}

/**
* Recupera um valor para o campo lastName da classe
* @returns string $lastName Segundo nome do Usu�rio
*/
	function getLastName(){
		return (trim($this->_lastName));
	}


/**
* Recupera um valor para o campo gender da classe
* @returns string $login O nome de Login do usu�rio (� �nico no sistema por�m n�o � chave)
*/
	function getGender(){
		return (trim($this->_gender));
	}

/**
* Recupera um valor para o campo login da classe
* @returns string $login O nome de Login do usu�rio (� �nico no sistema por�m n�o � chave)
*/
	function getLogin(){
		return (trim($this->_login));
	}

/**
* Recupera um valor para o campo email da classe
* @returns string $email  Endere�o de e-mail do usu�rio
*/
	function getEmail(){
		return (trim($this->_email));
	}

/**
* Recupera um valor para o campo profiles da classe
* @returns Object [] ProfileClass O Array contendo os profiles do usu�rio
*/
	function getProfiles(){
		return ($this->_profiles);
	}

/**
* Recupera um valor para o campo password da classe
* @returns char[32] $password senha do usu�rio, � gravado no bando o MD5 da senha do usu�rio e n�o a pr�pria senha por essa raz�o � um char[32] pois o MD5 tem sempre o mesmo tamanho
*/
	function getPassword(){
		return (trim($this->_password));
	}

/**
* Recupera o valor para o campo afiliacao da classe
*/
	function getAfiliacao(){
		return $this->_afiliacao;
	}

/**
* Recupera o valor para o campo Grau De Formacao da classe
*/
	function getGrauDeFormacao(){
		return $this->_grauDeFormacao;
	}

/**
* Le o Token da Aplica��o de um meio persistente antes de tentar logar novamente a aplica��o
* @returns string $tokenApp Um string contendo o Token da Aplica��o
*/
	function getAppToken($reload = false){
		$ws = new ChamaWebService();

		$file = dirname(__FILE__)."/appToken.txt";

		if($reload){
			unlink($file);
			$fp = fopen($file,"wb");
			fclose($fp);
		}

		$size = filesize($file);

		if($size > 0)
		{
			//lendo o token do txt
			$fp = fopen($file,"r");
			$tokenApp = fread($fp,$size);
			fclose($fp);
		}else{
			//fazendo login da aplica��o e gravando no token . . .
			$param  =  '<loginAplicacao>';
			$param .=		'<senha>';
			$param .=			$this->_def['sgu']['app_pass'];
			$param .=		'</senha>';
			$param .=		'<login>';
			$param .=			$this->_def['sgu']['app_user'];
			$param .=		'</login>';
			$param .=  '</loginAplicacao>';
			$xml = $ws->retornoChamada('loginAplicacao',$param);
			preg_match_all("/\<token\>(.*?)\<\/token\>/s",  $xml, $token);
			$tokenApp = $token[1][0];
			//unlink($file);
			$fp = fopen($file, "w");
			fwrite($fp, $tokenApp);
			fclose($fp);
		}
		return $tokenApp;
	}


/**
* Adiciona um usu�rio no Banco de Dados
*
* Ele pega os dados que est�o armazenados nos campos da classe e adiciona no Banco
*al�m de atualizar o campo ID do usu�rio
* A inser��o de um usu�rio via SGU deve seguir o seguinte fluxo:
* 1 - De posse do Token do Login da aplica��o � criado um novo usu�rio com os seguintes campos
*		A - primeiroNome
*		B - segundoNome
*		C - Login
*		D - Senha
* 2 - Caso n�o haja nenhum erro (LOGIN_EXISTENTE, por ex) o sistema Loga o novo usu�rio e, 
*      de posse do Token do Usu�rio, atualiza os dados do usu�rio com o restante do cadastro (email, sexo, etc....)
* 3 - O sistema lista todos os dados do usu�rio para descobrir o ID dele na tabela, e o armazena no COOKIE
* 4 - Os perfis s�o criados e gravados nas tabelas existentes no Scielo
* 5 - Fim
* @returns mixed $result O id do usu�rio que foi inserido no banco de dados ou um array em casso de "erro" (login duplicado)
*/
	function AddUser($addProfiles = true){
	/*	
	n�o precisa mais disso pq o WS retorna uma mesagem avisando que o Login j� existe

	if($this->loginExists($this->getLogin()))
		return array("ERROR"=>"Login j� existente");
	*/
		$ws = new ChamaWebService();

		$tokenApp = $this->getAppToken();

		$param = '<novoUsuario>';
		$param .= 	'<tokenApp>'.$tokenApp.'</tokenApp>';
		$param .= 	'<primeiroNome>'.$this->_firstName.'</primeiroNome>';
		$param .= 	'<segundoNome>'.$this->_lastName.'</segundoNome>';
		$param .= 	'<login>'.$this->_login.'</login>';
		$param .= 	'<senha>'.$this->_password.'</senha>';
		$param .= '</novoUsuario>';
		
		$xml = $ws->retornoChamada('novoUsuario',$param);

		preg_match_all("/\<status\>(.*?)\<\/status\>/s",  $xml, $status);

		if($status[1][0] == "LOGIN_EXISTENTE")
		{
			return array("ERROR"=>"Login j� existente");
		}

		/*
		logando com o usuario recem cadastrado para pegar o Token dele e o seu ID
		*/

		$param =  '<loginUsuario>';
		$param .=  	'<idGrupoDados>'.$this->_def['sgu']['data_group_id'].'</idGrupoDados>';
		$param .=		'<tokenApp>'.$tokenApp.'</tokenApp>';
		$param .= 	'<login>'.$this->_login.'</login>';
		$param .= 	'<senha>'.$this->_password.'</senha>';
		$param .=		'<ip>'.$_SERVER['REMOTE_ADDR'].'</ip>';
		$param .=		'<userAgent>'.$_SERVER['HTTP_USER_AGENT'].'</userAgent>';
		$param .= '</loginUsuario>';

		$xml = $ws->retornoChamada('loginUsuario',$param);

		preg_match_all("/\<status\>(.*?)\<\/status\>/s",  $xml, $status);
		preg_match_all("/\<token\>(.*?)\<\/token\>/s",  $xml, $tokenUsuario);
		/*
			logo ap�s o cadastro o Status do Usu�rio � sempre DADOS_INCOMPLETOS !!!!!!!
		*/		
                if(($status[1][0] == "DADOS_INCOMPLETOS") || ($status[1][0] == "OK") )
                        $tokenUsuario = $tokenUsuario[1][0];
                else if($status[1][0] == "FALHA_SEGURANCA"){
                      $this->getAppToken(true);
                      $this->AddUser($addProfiles);
                }


		$param = '<atualizaDados>';
		$param .=		'<dados>';
		/*
		montando XML com os dados a atualizar do usu�rio
		*/

		$dado = '<map>'."\n";
		$dado .=     '<entry>'."\n";
		$dado .=         '<string>FIRST_NAME</string>'."\n";
		$dado .=         '<string>'.$this->_firstName.'</string>'."\n";
		$dado .=     '</entry>'."\n";
		$dado .=     '<entry>'."\n";
		$dado .=         '<string>LAST_NAME</string>'."\n";
		$dado .=         '<string>'.$this->_lastName.'</string>'."\n";
		$dado .=     '</entry>'."\n";
		$dado .=     '<entry>'."\n";
		$dado .=         '<string>EMAIL_ADDRESS</string>'."\n";
		$dado .=         '<string>'.$this->_email.'</string>'."\n";
		$dado .=     '</entry>'."\n";
		$dado .=     '<entry>'."\n";
		$dado .=         '<string>GENDER</string>'."\n";
		$dado .=         '<string>'.$this->_gender.'</string>'."\n";
		$dado .=     '</entry>'."\n";
		$dado .=     '<entry>'."\n";
		$dado .=         '<string>AFILIACAO</string>'."\n";
		$dado .=         '<string>'.$this->_afiliacao.'</string>'."\n";
		$dado .=     '</entry>'."\n";
		$dado .=     '<entry>'."\n";
		$dado .=         '<string>GRAU_DE_FORMACAO</string>'."\n";
		$dado .=         '<string>'.$this->_grauDeFormacao.'</string>'."\n";
		$dado .=     '</entry>'."\n";
		$dado .= '</map>'."\n";

		/**
		*	colocando os caracteres & < > do XML como entidades HTML, pq ele vai
		*	dentro do envelope SOAP . . . pelo menos eh assim que o WS espera receber os dados
		*/
		$param .= htmlspecialchars($dado);
		$param .=		'</dados>';
		$param .=		'<tokenUsuario>';
		$param .=			$tokenUsuario;
		$param .=		'</tokenUsuario>';
		$param .= '</atualizaDados>';


		/**
		*atualizando os dados do usuario
		*seria bom fazer um tratamento para
		*no caso de ocorrer alguma exce��o . . .
		*/

		$retorno = $ws->retornoChamada('atualizaDados',$param);
		/**
		*	Adicionando os perfis do usu�rio
		*/
		if($addProfiles)
		{
			$this->addUserProfiles();
		}

		$this->loadUser($tokenUsuario);

		return $this->getID();
	}

/**
* Grava os dados sobre os perfis do usu�rio
*
* Essa tarefa estava dentro de addUser, foi retirada pois o cadastro agora � feito em dois passos (1o dados do ususario, 2o dados do perfil)
*/
	function addUserProfiles(){

		$tokenUsuario = $_COOKIE['userToken'];

		$userProfileDAO = new UserProfileDAO();
		$profiles = $this->_profiles;

		$this->loadUser($tokenUsuario);

		foreach($profiles as $profile)
		{
			if ($profile->getProfileText()){
				$profile->setUserID($this->getID());
				$userProfileDAO->AddUserProfile($profile);
			}
		}
		$this->setToken($tokenUsuario);
		$this->loadUser($tokenUsuario);

/**
*	Gravando no banco os artigos dos seus perfis
*/
		$userProfileDAO = new UserProfileDAO();
		$currentProfiles = $userProfileDAO->getUserProfilesStatusOn($this->getID());
		$userProfileAction = new UserProfileAction();
		$userProfileAction->generateProfileArticleRelationship($currentProfiles);	
	}

/**
* Altera os dados do usu�rio no Banco de Dados
*
* Ele pega os dados que est�o armazenados nos campos da classe e adiciona no Banco
* @returns integer $sucess 1 em caso de sucesso, 0 em caso de erro
*/
	function UpdateUser($updateProfiles = true){
		$ws = new ChamaWebService();
//atualizando os dados do usu�rio
		
		$param = '<atualizaDados>';
		$param .=		'<dados>';
		/*
		montando XML com os dados a atualizar do usu�rio
		*/
		$dado = '<map>'."\n";

		if($this->_firstName != '')
		{
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>FIRST_NAME</string>'."\n";
			$dado .=         '<string>'.$this->_firstName.'</string>'."\n";
			$dado .=     '</entry>'."\n";
		}

		if($this->_lastName != ''){
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>LAST_NAME</string>'."\n";
			$dado .=         '<string>'.$this->_lastName.'</string>'."\n";
			$dado .=     '</entry>'."\n";
		}
		if($this->_email != '')
		{
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>EMAIL_ADDRESS</string>'."\n";
			$dado .=         '<string>'.$this->_email.'</string>'."\n";
			$dado .=     '</entry>'."\n";
		}

		if($this->_password != ""){
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>PASSWORD</string>'."\n";
			$dado .=         '<string>'.$this->_password.'</string>'."\n";
			$dado .=     '</entry>'."\n";		
		}

		if($this->_gender != '')
		{
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>GENDER</string>'."\n";
			$dado .=         '<string>'.$this->_gender.'</string>'."\n";
			$dado .=     '</entry>'."\n";
		}

		if($this->_grauDeFormacao != '')
		{
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>GRAU_DE_FORMACAO</string>'."\n";
			$dado .=         '<string>'.$this->_grauDeFormacao.'</string>'."\n";
			$dado .=     '</entry>'."\n";
		}

		if($this->_afiliacao != '')
		{
			$dado .=     '<entry>'."\n";
			$dado .=         '<string>AFILIACAO</string>'."\n";
			$dado .=         '<string>'.$this->_afiliacao.'</string>'."\n";
			$dado .=     '</entry>'."\n";
		}

		$dado .= '</map>'."\n";
		/*
			colocando os caracteres & < > do XML como entidades HTML, pq ele vai
			dentro do envelope SOAP . . . pelo menos eh assim que o WS espera receber os dados
		*/
		$param .= htmlspecialchars($dado);
		$param .=		'</dados>';
		$param .=		'<tokenUsuario>';
		$param .=			$this->getToken();
		$param .=		'</tokenUsuario>';
		$param .= '</atualizaDados>';

		/*
		atualizando os dados do usuario
		seria bom fazer um tratamento para
		no caso de ocorrer alguma exce��o . . .
		*/
		if($dado !=  '<map>'."\n".'</map>'."\n")
		{
			$retorno = $ws->retornoChamada('atualizaDados',$param);
		}

		if($updateProfiles){
			$this->updateProfiles();
		}

		$this->loadUser($this->getToken());
	}


/**
* Atuliza os dados sobre os perfis do usu�rio
*
* Essa tarefa estava dentro de addUser, foi retirada pois o cadastro agora � feito em dois
*passos (1o dados do ususario, 2o dados do perfil)
*/
	function updateProfiles(){
		$perfis = $this->getProfiles();

		$userProfileDAO = new UserProfileDAO();
		foreach($perfis as $perfil){
			$userProfileDAO->UpdateUserProfile($perfil);
		}

		$userProfileDAO = new UserProfileDAO();
		$currentProfiles = $userProfileDAO->getUserProfilesStatusOn($this->getID());

		$userProfileAction = new UserProfileAction();
		$userProfileAction->generateProfileArticleRelationship($currentProfiles);	
	}

/**
* Carrega nos campos da classe os valores que est�o armazenados no Banco de Dados
* @param string $token Token do usu�rio, gerado pelo Login
* @returns integer $sucess 1 em caso de sucesso, 0 em caso de erro
*/
	function loadUser($token){

		$ws = new ChamaWebService();
		$param =  '<todosDados>';
		$param .=		'<tokenUsuario>'.$token.'</tokenUsuario>';
		$param .= '</todosDados>';

		$this->clearFields();

		$xml = $ws->retornoChamada('todosDados',$param);

		preg_match_all("/\<entry\>(.*?)\<\/entry\>/s",  $xml, $entry);
		preg_match_all("/\<status\>(.*?)\<\/status\>/s",  $xml, $status);

		$this->setToken($token);

		if($status[1][0] != "OK")
			return 0;

		for($i = 0; $i < count($entry[1]); $i++)
		{
			preg_match_all("/\<string>(.*?)\<\/string\>/s",  trim($entry[1][$i]), $string);

/*
terminar de fazer isso com TODOS os campos . . . 
hehehehe
*/
			if($string[1][0] == "IDENTIFICADOR")
			{
				$this->setID($string[1][1]);
			}

			if($string[1][0] == "FIRST_NAME")
			{
				$this->setFirstName($string[1][1]);
			}

			if($string[1][0] == "LAST_NAME")
			{
				$this->setLastName($string[1][1]);
			}

			if($string[1][0] == "GENDER")
			{
				$this->setGender($string[1][1]);
			}

			if($string[1][0] == "EMAIL_ADDRESS")
			{
				$this->setEMail($string[1][1]);
			}

			if($string[1][0] == "AFILIACAO")
			{
				$this->setAfiliacao($string[1][1]);
			}
			if($string[1][0] == "GRAU_DE_FORMACAO")
			{
				$this->setGrauDeFormacao($string[1][1]);
			}
		}

	//carregando os dados do profile do usu�rio
			$userProfileDAO = new UserProfileDAO();
			$this->setProfiles( $userProfileDAO->getUserProfilesStatusOn($this->getID()));
			return 1;
	}

/**
* Verifica se o login que estamos tentando inserir na base j� existe
* @param string $login Login que estamos tentando inserir
* @returns integer $sucess 1 se o login j� existir e 0 se o login n�o existir
*/
	function loginExists($login, $id=0){
		if($id == 0)
			$strsql = "SELECT user_login FROM users WHERE user_login = '".trim($login)."'" ;
		else
			$strsql = "SELECT user_login FROM users WHERE user_login = '".trim($login)."' AND user_id <> ".$id ;
		$res = $this->_db->databaseQuery($strsql);
		if(count($res) > 0)
			return 1;
		else
			return 0;
		
	}

/**
* Verifica se o login e senha que est�o nos campos do objeto, se o login for v�lido os demais campos do objeto ser�o preenchidos
* @returns mixed $sucess 1 se o login e senha forem v�lidos ou 0 se o login n�o for v�lido
*/
	function validateUser(){

		$ws = new ChamaWebService();

		$tokenApp = $this->getAppToken();

		$param = '<loginUsuario>';
		$param .=  	'<idGrupoDados>'.$this->_def['sgu']['data_group_id'].'</idGrupoDados>';
		$param .=		'<tokenApp>'.$tokenApp.'</tokenApp>';
		$param .= 	'<login>'.$this->_login.'</login>';
		$param .= 	'<senha>'.$this->_password.'</senha>';
		$param .=		'<ip>'.$_REQUEST['ip'].'</ip>';
		$param .= '</loginUsuario>';

		$xml = $ws->retornoChamada('loginUsuario',$param,true);

		preg_match_all("/\<status\>(.*?)\<\/status\>/s",  $xml, $status);
		preg_match_all("/\<entry\>(.*?)\<\/entry\>/s",  $xml, $entry);
		preg_match_all("/\<token\>(.*?)\<\/token\>/s",  $xml, $tokenUsuario);
		preg_match_all("/\<tokenVisit\>(.*?)\<\/tokenVisit\>/s",  $xml, $tokenVisita);

		for($i = 0; $i < count($entry); $i++)
		{

			preg_match_all("/\<string>(.*?)\<\/string\>/s",  $entry[1][$i], $string);
			if($string[1][0] == "IDENTIFICADOR")
			{
				$userID = $string[1][1];
				break;
			}
		}
		if($status[1][0] == "OK")
		{
			$this->setToken($tokenUsuario[1][0]);
			$this->setVisitToken($tokenVisita[1][0]);
			$this->loadUser($tokenUsuario[1][0]);
			return 1;
		}
		else if($status[1][0] == "FALHA_SEGURANCA")
		{
			//erro no token da app . . .
			$this->getAppToken(true);
			$this->validateUser();
		}else
			return 0;
	}

/**
* Gera uma nova senha e envia para o email cadastrado do usu�rio
* @returns mixed $sucess 1 a senha foi enviada com sucesso ou um array com a descricao do erro
*/
	function createNewPassword(){

		$login = $this->getLogin();

		$ws = new ChamaWebService();

		$tokenApp = $this->getAppToken();

		$param = '<enviarSenha>';
		$param .=  	'<login>'.$this->getLogin().'</login>';
		$param .=		'<tokenApp>'.$tokenApp.'</tokenApp>';
		$param .= '</enviarSenha>';

		$xml = $ws->retornoChamada('enviarSenha',$param,true);

		$inicio = strpos($xml,"<status>") +8;
		$fim = strpos($xml,"</status>");

		$status = substr($xml, $inicio,$fim-$inicio);

		if($status == "LOGIN_INVALIDO")
		{
			return array("ERROR"=>"1");
		}else{
			return 1;
		}
	}

/**
* Faz o logout do usu�rio
*/
	function logout(){
		$ws = new ChamaWebService();

		$param = '<logOffUsuario>';
		$param .=	'<tokenUsuario xsi:type="xsd:string">'.$this->getToken().'</tokenUsuario>';
		$param .='</logOffUsuario>';

		$xml = $ws->retornoChamada('logOffUsuario',$param,true);

		$inicio = strpos($xml,"<status>") +8;
		$fim = strpos($xml,"</status>");

		$status = substr($xml, $inicio,$fim-$inicio);

		if($status != "OK")
		{
			return array("ERROR"=>"1");
		}else{
			return 1;
		}
	}

}

?>
