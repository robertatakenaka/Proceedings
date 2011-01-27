<?php
$dir = dirname(__FILE__)."/";

include($dir."DBClass.php");
include($dir."UserProfileClass.php");
require($dir."../includes/phpmailer/class.phpmailer.php");

/**
*@package	Scielo.org
*@version      1.0
*@author       Andr� Otero(andre.otero@bireme.org)
*@copyright     BIREME
*/

/**
*Classe de Usu�rios do Scielo regional
*
*Encapsula as func�es CRUD em uma classe, assim temos "independencia" do Banco de dados
*a ser utilizado.
*Guarda al�m das informa��es b�sicas do usu�rio as inform��es sobre o perfil do usu�rio (as
*palavras-chave que ele ir� entrar no cadastro que ir� determinar o seu perfil atrav�s de trigramas
*@package	Scielo.org
*@version      1.0
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
* Construtor da Classe UserClass
*
* @param string $firstName Primeiro nome do Usu�rio
* @param string $lastName Segundo nome do Usu�rio
* @param string $login O nome de Login do usu�rio (� �nico no sistema por�m n�o � chave)
* @param string $email  Endere�o de e-mail do usu�rio
* @param char[32] $password senha do usu�rio, � gravado no bando o MD5 da senha do usu�rio e n�o a pr�pria senha por essa raz�o � um char[32] pois o MD5 tem sempre o mesmo tamanho
*/
	function UserClass($firstName='', $lastName='', $gender='', $login='', $email='', $password=''){
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_gender = $gender;
		$this->_login = $login;
		$this->_email = $email;
		$this->_db = new DBClass();
		$this->_mail = new PHPMailer();
		/*
		prevenindo gravar o Hash de null no banco
		*/
		if($password != ''){
			$this->_password = md5($password);
		}else{
			$this->_password = '';
		}
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
* Recupera um valor para o campo ID da classe
* @param integer $id Identificador do usu�rio
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
* Adiciona um usu�rio no Banco de Dados
*
* Ele pega os dados que est�o armazenados nos campos da classe e adiciona no Banco
*al�m de atualizar o campo ID do usu�rio
* @returns mixed $result O id do usu�rio que foi inserido no banco de dados ou um array em casso de "erro" (login duplicado)
*/
	function AddUser(){

	if($this->loginExists($this->getLogin()))
		return array("ERROR"=>"Login j� existente");


		$strsql = "INSERT INTO users (user_firstname, user_lastname, user_gender, user_login, user_email, user_password) VALUES ('".$this->_firstName. "','".$this->_lastName. "','". $this->_gender."','". $this->_login. "','".$this->_email. "','".md5($this->_password). "')";
		$result = $this->_db->databaseExecInsert($strsql);

		$this->setID($result);
		foreach($this->_profiles as $profile)
		{

			$strsql = "INSERT INTO scielo_user_profiles (user_id, profile_text, profile_name) VALUES (".$this->getID().",'".$profile->getProfileText()."','".$profile->getProfileName()."')";
			$this->_db->databaseExecInsert($strsql);
		}
		$this->loadUser($result);
		return $result;
	}

/**
* Altera os dados do usu�rio no Banco de Dados
*
* Ele pega os dados que est�o armazenados nos campos da classe e adiciona no Bancp
* @returns integer $sucess 1 em caso de sucesso, 0 em caso de erro
*/
	function UpdateUser(){

	if($this->loginExists($this->getLogin(), $this->getID()))
		return array("ERROR"=>"Login j� existente");
//atualizando os dados do usu�rio
		
		$strsql = "UPDATE users SET user_firstname = '".$this->getFirstName()."', user_lastname = '".$this->getLastName()."', user_gender = '".$this->getGender()."', user_login = '".$this->getLogin()."' , user_email = '".$this->getEMail()."'";
		if($this->getPassword() != '')
			$strsql .= " , user_password = '".md5($this->getPassword())."'";
		$strsql .= " WHERE user_id = ".$this->getID();

			$this->_db->databaseExecUpdate($strsql);
//atualizando os dados dos perfis do usu�rio
		$perfis = $this->getProfiles();

		foreach($perfis as $perfil){
			$strsql = "UPDATE scielo_user_profiles SET profile_text = '".$perfil->getProfileText()."', profile_name = '".$perfil->getProfileName()."' WHERE user_id = ".$perfil->getUserID()." and profile_id = ".$perfil->getProfileID()." ";
			$this->_db->databaseExecUpdate($strsql);
		}
		$this->loadUser($this->getID());
	}

/**
* Carrega nos campos da classe os valores que est�o armazenados no Banco de Dados
* @param integer $id Identificador do usu�rio
* @returns integer $sucess 1 em caso de sucesso, 0 em caso de erro
*/
	function loadUser($id){

		$this->clearFields();

//carregando os dados do usu�rio
		$strsql = "SELECT * FROM  users WHERE users.user_id = ".$id;
		$ret = $this->_db->databaseExecInsert($strsql);
		$arr = $this->_db->databaseQuery($strsql);
		if(count($arr) > 0){
			$this->setID($arr[0]['user_id']);
			$this->setFirstName($arr[0]['user_firstname']);
			$this->setLastName($arr[0]['user_lastname']);
			$this->setGender($arr[0]['user_gender']);
			$this->setLogin($arr[0]['user_login']);
			$this->setEMail($arr[0]['user_email']);

	//carregando os dados do profile do usu�rio
			$strsql = "SELECT * FROM  scielo_user_profiles WHERE user_id = ".$id;
			$ret = $this->_db->databaseExecInsert($strsql);
			$arr = $this->_db->databaseQuery($strsql);

			foreach($arr  as $p)
			{
				$profile = new UserProfileClass();
				$profile->setUserID($p['user_id']);
				$profile->setProfileID($p['profile_id']);
				$profile->setProfileText($p['profile_text']);
				$profile->setProfileName($p['profile_name']);
				$this->setProfiles($profile);
			}
			return 1;
		}
		else
		{
			return 0;
		}
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
		$strsql = "SELECT * FROM users WHERE user_login = '".$this->getLogin()."' AND user_password = '".md5($this->getPassword())."'" ;
		$res = $this->_db->databaseQuery($strsql);

		if(count($res) > 0)
		{
			$this->loadUser($res[0]['user_id']);
			return 1;
		}
		else
			return 0;
	}

/**
* Gera uma nova senha e envia para o email cadastrado do usu�rio
* @returns mixed $sucess 1 a senha foi enviada com sucesso ou um array com a descricao do erro
*/
	function createNewPassword(){

		$strsql = "SELECT * FROM users WHERE user_login = '".$this->getLogin()."'" ;
		$res = $this->_db->databaseQuery($strsql);
		if(count($res) == 0)
		{
			return array("ERROR"=>"1");
		}
		else
		{
			$newPassword = substr(md5(rand()),0,7);
			$strsql = "UPDATE users SET user_password = '".md5($newPassword)."' WHERE user_login = '".$this->getLogin()."'" ;

			$this->_db->databaseQuery($strsql);
			$msg = "<p>Voc� est� recebendo uma nova senha para acessar o portal Scielo</p>";
			$msg .= "<p><b>Senha:</b> ".$newPassword."</p>";

			$this->_mail->From     = "scielo@bireme.br";
			$this->_mail->FromName = "Scielo";
			$this->_mail->Subject  = "Envio de Nova senha";
			$this->_mail->Host     = "brm.bireme.br";
			$this->_mail->Mailer   = "smtp";
			$this->_mail->IsHTML(true);

			$this->_mail->Body = $msg;
			$this->_mail->AddAddress($res[0]['user_email'], $res[0]['user_firstname']." ". $res[0]['user_lastname']);
			$send = $this->_mail->Send();

			if(!$send)
				return array("ERROR" => $this->_mail->ErrorInfo);
			else
				return 1;
		}
	}

}

?>