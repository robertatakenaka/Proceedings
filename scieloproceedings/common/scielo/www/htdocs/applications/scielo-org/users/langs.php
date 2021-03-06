<?
/**
* defini��o das constantes para os r�tulos dos formul�rios
* usados para multilanguage
*/

include_once(dirname(__FILE__)."/../../../php/include.php");


$ini = parse_ini_file(dirname(__FILE__)."/../scielo.def" , true);
$url = $ini['scielo_org_urls']['home'];

$langs = array("pt","en","es");

if(!in_array($lang,$langs)){
	$lang = "pt";
}

if($lang == "pt")
{
/*
r�tulos tela DATASUS
*/
define("DATASUS","Indicadores de Sa�de");

/*
r�tulos tela Article References
*/
define("SCIELO.ORG"," indicou um artigo para voc�.");
define("ARTICLE_REFERENCES","Refer�ncias do Artigo");
define('NO_DATA_FOR_GRAPHIC','Gr�fico n�o dispon�vel, dados em processamento.');

/*
r�tulos para a tela envio de artigo por email
*/
define("TO_EMAIL","Email do destinat�rio:");
define("TO_NAME","Nome do destinat�rio:");
define("COMMENTS","Coment�rios:");
define("ARTICLE_TITLE","T�tulo: ");
define("ARTICLE_SUGGESTION","SciELO: Artigo recomendado de ");
/*
r�tulos para a tela envio de nova senha
*/
define("FORGOT_TITLE","Envio de nova senha");
define("BUTTON_SEND_NEW_PASSORD","Enviar nova senha");
define("UNKNOW_USER_ERROR","Usu�rio n�o encontrado");
define("SEND_NEW_PASSWORD_SUCCESS","Senha enviada com sucesso !!!");

/*
r�tulos para a tela de login
*/
define("HELLO_STRING","Ol�, ");
define("EDIT_USER_DATA","Meus dados");
define("LOGIN_TITLE","Login de usu�rio");
define("BUTTON_LOGIN","Login");
define("BUTTON_LOGOUT","Sair");
define("FORGOT_PASSWORD","Enviar-me nova senha  ");
define("REGISTER","Cadastre-se");
define("FOR_SERVICES","para servi�os personalizados");
define("LOGIN_ERROR","Login/Senha inv�lidos");
define("FIELD_LOGIN_ALREADY_EXISTS","Login j� existe !!!");
define("REQUIRED_FIELD_TEXT"," * Campos Obrigat�rios");
define("LOGOUT_DONE","Logout realizado com sucesso !!!");
define("NOT_LOGED","Usu�rio n�o logado, por favor, visite <a target=\"_blank\" href=\"".$url."\">Scielo</a> e se logue");

/*
rotulos da tela de cadastro/alteracao de usuario
*/
define("REGISTER_NEW_USER_TITLE","Cadastro de Novo Usu�rio");
define("UPDATE_USER_TITLE","Atualiza��o dos dados");
define("FIELD_FIRST_NAME","Nome");
define("FIELD_LAST_NAME","Sobrenome");
define("FIELD_GENDER","Sexo");
define("FIELD_GENDER_MALE","Masculino");
define("FIELD_GENDER_FEMALE","Feminino");
define("FIELD_PASSWORD","Senha");
define("FIELD_PASSWORD_CONFIRMATION","Confirma��o");
define("FIELD_PASSWORD_CHANGE_MESSAGE","(somente preencha caso deseje alterar sua senha)");
define("FIELD_EMAIL","E-Mail");
define("FIELD_LOGIN","Login");
define("FIELD_AFILIATION","Institui��o");
define("FIELD_DEGREE","Select|Selecione,Ensino_Fundamental|Ensino Fundamental (1o Grau),Ensino_Medio|Ensino M�dio (2o Grau),Ensino_Tecnico|Ensino Profissional De N�vel T�cnico,Graduacao|Gradua��o,Especializacao|Especializa��o,Mestrado_Profissionalizante|Mestrado Profissionalizante,Mestrado|Mestrado,Doutorado|Doutorado,MBA|MBA,Pos_Doutorado|P�s Doutorado,PHD|PHD");
define("STEP","Passo");
define("OF","de");

/*
r�tulos para o cadastro de avise-me
*/
define("ADD_TO_SHELF_OK","Artigo adicionado � cole��o com sucesso !!!");
define("REMOVE_FROM_SHELF_OK","Artigo removido da cole��o com sucesso !!!");
define("REMOVE_CITED_ALERT_OK","Alerta de cita��o removido com sucesso !!!");
define("REMOVE_ACCESS_ALERT_OK","Alerta de acesso removido com sucesso !!!");
define("ALERT_CITED_OK","Aviso quando for citado cadastrado com sucesso !!!");
define("ALERT_ACCESSED_OK","Cadastro para envio de estat�sticas de acesso realizado com sucesso !!!");

/*
r�tulos dos links para os servi�os de usu�rios
*/
define("PERSONAL_DATA","Dados pessoais");
define("PROFILE","Perfil");
define("PROFILES","Perfis");
define("VIEW_BY","Visualizar Lista por");
define("MY_SHELF","Minha Cole��o");
define("MY_LINKS","Meus Links");
define("MY_NEWS","Minhas Noticias");
define("MY_ARTICLE_PROFILE","Artigos do Perfil");
define("MY_NEW_ARTICLE_PROFILE","Artigos Novos do Perfil");
define("ORDER_BY","Ordenado por");
define("RELEVANCE","Relev�ncia");
define("DATE","Data");
define("MY_ALERTS","Meus Alertas");
define("REMOVE_FROM_SHELF","Remover da cole��o");
define("CITATIONS","Cita��es");
define("ACCESS_STATS","Estat�sticas de acessos");
define("ARTICLE_ACCESS","Acessos ao Artigo");
define("ACCESSES","Acessos");
define("MONTHS","Meses");
define("REMOVE_ALERT","Remover alerta");
define("REMOVE_ACCESS_ALERT","N�o receber mais alertas de acessos desse artigo");
define("REMOVE_CITED_ALTER","N�o receber mais alertas de cita��o desse artigo");
define("MONTH_LIST", "jan,fev,mar,abr,mai,jun,jul,ago,set,out,nov,dez");
define("CITED_BY","Citado Por");
define("SIMILARYS_IN","Similares em");
define("SEE","Ver");
define("SEE_HISTORY","Ver Hist�rico");
define("CHOOSE_PERIOD", "Escolha por ano:");
define("START_YEAR", "De:");
define("LAST_YEAR", "At�:");
define("BUTTON_REFRESH", "Atualizar gr�fico");
define("GRAFIC_STATS_FALSE", "N�o existem dados estat�sticos para o per�odo selecionado");
/*
textos das mensagens de erro
*/
define("FIELD_FIRST_NAME_ERROR_DESCRIPTION","*");
define("FIELD_LAST_NAME_ERROR_DESCRIPTION","*");
define("FIELD_GENDER_ERROR_DESCRIPTION","*");
define("FIELD_PASSWORD_ERROR_DESCRIPTION","*");
define("FIELD_EMAIL_ERROR_DESCRIPTION","*");
define("FIELD_LOGIN_ERROR_DESCRIPTION","*");
define("FIELD_PROFILE_ONE","Perfil 1");
define("FIELD_PROFILE_TWO","Perfil 2");
define("FIELD_PROFILE_TREE","Perfil 3");
define("FIELD_PROFILE_NAME","Nome");
define("FIELD_PROFILE_DESCRIPTION_TEXT","Descri��o");
define("BUTTON_NEW_USER","Gravar");
define("BUTTON_UPDATE_USER","Atualizar");
define("BUTTON_BACK","Voltar");
define("BUTTON_CANCEL","Cancelar");
define("BUTTON_CLOSE","Fechar");
define("REGISTER_NEW_USER_SUCESS","Dados Gravados com sucesso !!!");
define("UPDATE_USER_SUCESS","Dados Atualizados com sucesso !!!");

/*
textos para a pagina��o
*/
define("FIRST_PAGE","Primeira");
define("LAST_PAGE","�ltima");
define("PAGE","P�gina");

/*
textos para a r�gua de navega��o
*/
define("HOME","home");
define("SEARCH_JOURNALS","Pesquisa peri�dicos");
define("JOURNALS_ALPHABETIC_LIST","Peri�dicos por ordem alfab�tica");

/*
segundo nivel SciELO em n�meros
*/
define("NUMBERS","SciELO em n�meros");
define("CITATION","Cita��es");
define("CO_AUTHORS","Co-autoria");
define("USAGE","Uso do site");
define("BRASIL","Brasil");
define("CHILE","Chile");
define("CUBA","Cuba");
define("PUBLIC_HEALTH","Sa�de P�blica");
define("SPAIN","Espanha");
define("VENEZUELA","Venezuela");

/*
pesquisa por titulos
*/
define("FIND_RESULTS","resultados encontrados :");

/*
artigos do meu perfil
*/
define("TOOLS","Ferramentas");

/*
minhas noticias
*/
define("ADD","Adicionar");
define("ADD_FEED","Adicionar RSS Feed");
define("REMOVE_FEED","Remover RSS Feed");
define("RSS_PROBLEM","Ocorreu um erro ao tentar abrir o RSS Feed");
define("REMOVE_FEED_CONFIRM","Confirma a remo��o do Feed ?");
define("PUBLISH_IN_HOME_PAGE","Publicar na Home Page");
define("REMOVE_FROM_HOME_PAGE","Remover da Home Page");
define("ALL_FEEDS","Todos os Feeds");
/*
meus links
*/
define("ADD_LINK","Adicionar Link");

/*
	USER SHELF FOLDERS
*/

define("MONITORED_ACCESS","acesso monitorado");
define("MONITORED_CITATIONS","cita��es monitoradas");
define("MOVE_TO","mover para");
define("MY_FOLDERS","Minhas Pastas");
define("ADD_FOLDER","Adicionar pasta");
define("INCOMING_FOLDER","Pasta de Entrada");
define("DATE_SORT","Data");
define("MY_RANKING","Meu ranking");
define("EDIT_FOLDER","Editar Pasta");
define("DELETE_FOLDER","Remover Pasta");
define("FOLDER_NAME","Nome da Pasta");
define("MOVE_FOLDER_TO","Mover Para");
define("BUTTON_MOVE","mover");
define("BUTTON_CANCEL","cancelar");
define("BUTTON_REMOVE","remover");
define("BUTTON_EDIT","editar");
define("BUTTON_CREATE","salvar");
define("MOVE_CONTENT_TO_OTHER_FOLDER","mover conte�do para outra pasta");
define("REMOVE_CONTENT","remover conte�do");
define("SHOW_BY_RATE"," por Ranking");
define("SHOW_BY_DATE"," por Data");

/*
 USER LINKS
*/

define("REMOVE_LINK","deletar link");
define("EDIT_LINK","editar link");
define("ADD_LINK","Incluir link");
define("LINK_TITLE","T�tulo do Link");
define("LINK_URL","URL do Link");
define("LINK_DESCRIPTION","Descri��o do Link");
define("IN_HOME","p�gina inicial");
define("DO_YOU_REALY_WANT_TO_REMOVE_IT","Deseja realmente excluir este link?");
define("ENVIAR_ARTIGO_POR_EMAIL","Enviar artigo por e-mail");
define("SEND","enviar e-mail");
define("CLOSE","fechar janela");
define("ARTICLE_SUBMITED_WITH_SUCCESS","artigo enviado com sucesso");
define("SEARCHING_IN","buscando em");
define("SIMILARITY","relev�ncia");
/*
Collexis Instances Name
*/
define("ARR","SCI_OVERALL|SciELO Regional,SCI_SCIELOBR|SciELO Brasil,SCI_SCIELOCL|SciELO Chile,SCI_SCIELOCB|SciELO Cuba,SCI_SCIELOESP| SciELO Espanha,SCI_SCIELOVE|SciELO Venezuela,SCI_SCIELOSP|SciELO Sa�de P�blica,SCI_SCIELOSS|SciELO Ci�ncias Sociais");

define("FULL_TEXT","texto completo");
}


if ($lang=="en")
{

/*
r�tulos tela DATASUS
*/
define("DATASUS","Health Indicators");

/*
r�tulos tela Article References
*/

define("ARTICLE_REFERENCES","Article References");
define('NO_DATA_FOR_GRAPHIC','Graphic unavailable, data in processing.');

/*
r�tulos para a tela envio de artigo por email
*/
define("TO_EMAIL","To Email:");
define("TO_NAME","To:");
define("COMMENTS","Comments:");
define("ARTICLE_TITLE","Title: ");
define("ARTICLE_SUGGESTION","SciELO: Recommended article from ");

/*
r�tulos para a tela envio de nova senha
*/
define("FORGOT_TITLE","New password send");
define("BUTTON_SEND_NEW_PASSORD","Send new password");
define("UNKNOW_USER_ERROR","User not found");
define("SEND_NEW_PASSWORD_SUCCESS","New password sent successfully !!!");

/*
r�tulos para a tela de login
*/
define("HELLO_STRING","Hello, ");
define("EDIT_USER_DATA","Edit user data");
define("LOGIN_TITLE","User Login");
define("BUTTON_LOGIN","Login");
define("BUTTON_LOGOUT","Logout");
define("FORGOT_PASSWORD","Send me a new password");
define("REGISTER","Register");
define("FOR_SERVICES","for personalized services");
define("LOGIN_ERROR","User/Login invalid");
define("LOGOUT_DONE","Logout was made successfully !!!");
define("NOT_LOGED","User not logged, please, visit <a target=\"_blank\" href=\"".$url."\">Scielo</a> and log in");

/*
rotulos da tela de cadastro/alteracao de usuario
*/
define("REGISTER_NEW_USER_TITLE","New user registration");
define("UPDATE_USER_TITLE","Update user data");
define("FIELD_FIRST_NAME","First Name");
define("FIELD_LAST_NAME","Last Name");
define("FIELD_GENDER","Gender");
define("FIELD_GENDER_MALE","Male");
define("FIELD_GENDER_FEMALE","Female");
define("FIELD_PASSWORD","Password");
define("FIELD_PASSWORD_CONFIRMATION","Confirmation");
define("FIELD_PASSWORD_CHANGE_MESSAGE","(fill it in only to change the password)");
define("FIELD_EMAIL","E-Mail");
define("FIELD_LOGIN","Login");
define("FIELD_AFILIATION","Afilliation");
define("FIELD_DEGREE","Select|Select,Ensino_Fundamental|Basic Education,Ensino_Medio|High School,Ensino_Tecnico|Technical Studies,Graduacao|Graduate Study,Especializacao|Specialization,Mestrado_Profissionalizante|Professional Master's Degree,Mestrado|Master's Degree,Doutorado|Doctorate,MBA|MBA,Pos_Doutorado|Post Doctorate,PHD|PhD");
define("FIELD_LOGIN_ALREADY_EXISTS","Login already exists !!!");
define("REQUIRED_FIELD_TEXT"," * Mandatory fields");
define("STEP","Step");
define("OF","of");

/*
r�tulos para o cadastro de avise-me
*/
define("ADD_TO_SHELF_OK","Article added to collection successfully !!!");
define("REMOVE_FROM_SHELF_OK","Article removed from collection successfully !!!");
define("REMOVE_CITED_ALERT_OK","Citation alert removed successfully !!!");
define("REMOVE_ACCESS_ALERT_OK","Access alert removed successfully !!!");
define("ALERT_CITED_OK","Acknowledgment when article will be cited registered successfully !!!");
define("ALERT_ACCESSED_OK","Registration to receive statistics of access was made successfully !!!");

/*
r�tulos dos links para os servi�os de usu�rios
*/
define("PERSONAL_DATA","Personal data");
define("PROFILE","Profile");
define("PROFILES","Profiles");
define("VIEW_BY","View list by");
define("MY_SHELF","My Collection");
define("MY_LINKS","My Links");
define("MY_NEWS","My News");
define("MY_ARTICLE_PROFILE","Articles of my profiles");
define("MY_NEW_ARTICLE_PROFILE","New articles of my profiles");
define("ORDER_BY","Sorted by");
define("RELEVANCE","Relevance");
define("DATE","Date");
define("MY_ALERTS","My Alerts");
define("REMOVE_FROM_SHELF","Remove from collection");
define("CITATIONS","Citations");
define("ACCESS_STATS","Access Stats");
define("ARTICLE_ACCESS","Article Access");
define("ACCESSES","Access");
define("MONTHS","Months");
define("REMOVE_ALERT","Remove alert");
define("REMOVE_ACCESS_ALERT","I do not want to receive any further alerts of accesses of  this article");
define("REMOVE_CITED_ALTER","I do not want to receive any further alerts of citations to  this article");
define("MONTH_LIST", "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sept,Oct,Nov,Dec");
define("CITED_BY","Cited By");
define("SIMILARYS_IN","Similars in");
define("SEE","See");
define("SEE_HISTORY","See History");
define("CHOOSE_PERIOD", "Choose by Year:");
define("START_YEAR", "From:");
define("LAST_YEAR", "To:");
define("BUTTON_REFRESH", "Change graphic");
define("GRAFIC_STATS_FALSE", "Do not exists statistic data for the selected period");

/*
textos das mensagens de erro
*/
define("FIELD_FIRST_NAME_ERROR_DESCRIPTION","*");
define("FIELD_LAST_NAME_ERROR_DESCRIPTION","*");
define("FIELD_GENDER_ERROR_DESCRIPTION","*");
define("FIELD_PASSWORD_ERROR_DESCRIPTION","*");
define("FIELD_EMAIL_ERROR_DESCRIPTION","*");
define("FIELD_LOGIN_ERROR_DESCRIPTION","*");
define("FIELD_PROFILE_ONE","Profile 1");
define("FIELD_PROFILE_TWO","Profile 2");
define("FIELD_PROFILE_TREE","Profile 3");
define("FIELD_PROFILE_NAME","Name");
define("FIELD_PROFILE_DESCRIPTION_TEXT","Description");
define("BUTTON_NEW_USER","Record");
define("BUTTON_UPDATE_USER","Update");
define("BUTTON_BACK","Back");
define("BUTTON_CANCEL","Cancel");
define("BUTTON_CLOSE","Close");
define("REGISTER_NEW_USER_SUCESS","New user registration done successfully !!!");
define("UPDATE_USER_SUCESS","Update user data successfully !!!");

/*
textos para a pagina��o
*/
define("FIRST_PAGE","First");
define("LAST_PAGE","Last");
define("PAGE","Page");

/*
textos para a r�gua de navega��o
*/
define("HOME","home");
define("SEARCH_JOURNALS","Search by journals");
define("JOURNALS_ALPHABETIC_LIST","Peri�dicos por ordem alfab�tica");

/*
segundo nivel SciELO em n�meros
*/
define("NUMBERS","SciELO in numbers");
define("CITATION","Citations");
define("CO_AUTHORS","Co-authors");
define("USAGE","Site usage");
define("BRASIL","Brasil");
define("CHILE","Chile");
define("CUBA","Cuba");
define("PUBLIC_HEALTH","Public Health");
define("SPAIN","Spain");
define("VENEZUELA","Venezuela");

/*
pesquisa por titulos
*/
define("FIND_RESULTS","results :");

/*
artigos do meu perfil
*/
define("TOOLS","Tools");

/*
minhas noticias
*/
define("ADD","Add");
define("ADD_FEED","Add RSS Feed");
define("REMOVE_FEED","Remove RSS Feed");
define("RSS_PROBLEM","An error has occurred when trying open the RSS Feed");
define("REMOVE_FEED_CONFIRM","Are you sure ?");
define("PUBLISH_IN_HOME_PAGE","Publish in Home Page");
define("REMOVE_FROM_HOME_PAGE","Remove from Home Page");
define("ALL_FEEDS","All Feeds");


/*
	USER SHELF FOLDERS
*/

define("MONITORED_ACCESS","monitored access");
define("MONITORED_CITATIONS","monitored citations");
define("MOVE_TO","move to");
define("MY_FOLDERS","My Folders");
define("ADD_FOLDER","Add folder");
define("INCOMING_FOLDER","Incoming Folder");
define("SHOW_FOLDERLIST_BY","show list by:");
define("DATE_SORT","Date");
define("MY_RANKING","My ranking");
define("EDIT_FOLDER","Edit Folder");
define("DELETE_FOLDER","Remove Folder");
define("FOLDER_NAME","Folder Name");
define("MOVE_FOLDER_TO","Move to");
define("BUTTON_MOVE","move");
define("BUTTON_CANCEL","cancel");
define("BUTTON_REMOVE","remove");
define("BUTTON_EDIT","edit");
define("BUTTON_CREATE","create");
define("MOVE_CONTENT_TO_OTHER_FOLDER","move content to another folder");
define("REMOVE_CONTENT","remove content");
define("SHOW_BY_RATE"," by Ranking");
define("SHOW_BY_DATE"," by Date");

/*
 USER LINKS
*/

define("REMOVE_LINK","delete link");
define("EDIT_LINK","edit link");
define("ADD_LINK","add link");
define("LINK_TITLE","Link Title");
define("LINK_URL","Link URL");
define("LINK_DESCRIPTION","Link Description");
define("IN_HOME","show in home");
define("DO_YOU_REALY_WANT_TO_REMOVE_IT","Do you realy want to remove it?");
define("ENVIAR_ARTIGO_POR_EMAIL","Send article by mail");
define("SEND","send mail");
define("CLOSE","close window");
define("ARTICLE_SUBMITED_WITH_SUCCESS","article submited with success");
define("SEARCHING_IN","searching in");
define("SIMILARITY","similarity");
/*
Collexis Instances Name
*/
define("ARR","SCI_OVERALL|SciELO Regional,SCI_SCIELOBR|SciELO Brazil,SCI_SCIELOCL|SciELO Chile,SCI_SCIELOCB|SciELO Cuba,SCI_SCIELOESP| SciELO Spain,SCI_SCIELOVE|SciELO Venezuela,SCI_SCIELOSP|SciELO Public Health,SCI_SCIELOSS|SciELO Social Sciences");

define("FULL_TEXT","full text");
}

if ($lang=="es")
{

/*
r�tulos tela DATASUS
*/
define("DATASUS","Indicadores de Salud");

/*
r�tulos tela Article References
*/

define("ARTICLE_REFERENCES","Referencias del art�culo");
define('NO_DATA_FOR_GRAPHIC','Gr�fico no disponible, datos en procesamiento.');

/*
r�tulos para a tela envio de artigo por email
*/
define("TO_EMAIL","Correo Electr�nico del Destinatario:");
define("TO_NAME","Destinatario:");
define("COMMENTS","Coment�rios:");
define("ARTICLE_TITLE","T�tulo: ");
define("ARTICLE_SUGGESTION","SciELO: Art�culo recomendado de ");

/*
r�tulos para a tela envio de nova senha
*/
define("HELLO_STRING","Hola, ");
define("FORGOT_TITLE","Nueva clave de acceso");
define("BUTTON_SEND_NEW_PASSORD","Env�o de nueva clave de acceso");
define("UNKNOW_USER_ERROR","Usuario no encontrado");
define("SEND_NEW_PASSWORD_SUCCESS","Clave de acceso enviada con �xito");

/*
r�tulos para a tela de login
*/
define("LOGIN_TITLE","Login de usuario");
define("EDIT_USER_DATA","Actualizar los datos personales");
define("BUTTON_LOGIN","Login");
define("BUTTON_LOGOUT","Salir");
define("FORGOT_PASSWORD","Env�eme una nueva clave de acceso");
define("REGISTER","Reg�strese");
define("FOR_SERVICES","para servicios personalizados");
define("LOGIN_ERROR","Usuario/Clave inv�lidos");
define("LOGOUT_DONE","Logout realizado con �xito!!!");
define("NOT_LOGED","Usuario no logado, por favor, visitar <a target=\"_blank\" href=\"".$url."\">Scielo</a> y entrar");

/*
rotulos da tela de cadastro/alteracao de usuario
*/
define("REGISTER_NEW_USER_TITLE","Registro de nuevo usuario");
define("UPDATE_USER_TITLE","Actualizaci�n de sus datos");
define("FIELD_FIRST_NAME","Nombre");
define("FIELD_LAST_NAME","Apellido");
define("FIELD_GENDER","G�nero");
define("FIELD_GENDER_MALE","Masculino");
define("FIELD_GENDER_FEMALE","Femenino");
define("FIELD_PASSWORD","Clave de acceso");
define("FIELD_PASSWORD_CONFIRMATION","Confirmaci�n");
define("FIELD_PASSWORD_CHANGE_MESSAGE","(Llene apenas si desea cambiar su clave de acceso)");
define("FIELD_EMAIL","Correo Electr�nico");
define("FIELD_LOGIN","Login");
define("FIELD_AFILIATION","Instituici�n");
define("FIELD_DEGREE","Select|Selecione,Ensino_Fundamental|Ense�anza o Educaci�n B�sica,Ensino_Medio|Ense�anza o Educaci�n Media,Ensino_Tecnico|Ense�anza o Educaci�n T�cnico-Profesional,Graduacao|Superior Universitario de Grado,Especializacao|Especializaci�n,Mestrado_Profissionalizante|Maestr�a Profisionalizante,Mestrado|Maestr�a,Doutorado|Doctorado,MBA|MBA,Pos_Doutorado|Pos Doctorado,PHD|PhD");
define("FIELD_LOGIN_ALREADY_EXISTS","Login ya existe !!!");
define("REQUIRED_FIELD_TEXT"," * Campos obligatorios");
define("STEP","Passo");
define("OF","de");

/*
r�tulos para o cadastro de avise-me
*/
define("ADD_TO_SHELF_OK","Artigo adicionado a la colecci�n");
define("REMOVE_FROM_SHELF_OK","Artigo retirado de la colecci�n");
define("REMOVE_CITED_ALERT_OK","Alerta de citaci�n retirado");
define("REMOVE_ACCESS_ALERT_OK","Alerta de acesso retirado");
define("ALERT_CITED_OK","Alerta de cuando el art�culo es citado fue registrado con �xito");
define("ALERT_ACCESSED_OK","Registro para recibimiento de estad�sticas de acceso del art�culo realizado con �xito");

/*
r�tulos dos links para os servi�os de usu�rios
*/
define("PERSONAL_DATA","Datos personales");
define("PROFILE","Perfil");
define("PROFILES","Perfiles");
define("VIEW_BY","Ver la Lista por");
define("MY_SHELF","Mi Colecci�n");
define("MY_LINKS","Mis Enlaces");
define("MY_NEWS","Mis Not�cias");
define("MY_ARTICLE_PROFILE","Art�culos de mi perfil");
define("MY_NEW_ARTICLE_PROFILE","Art�culos nuevos de mi perfil");
define("ORDER_BY","Ordenado por");
define("RELEVANCE","Relevancia");
define("DATE","Fecha");
define("MY_ALERTS","Mis Alertas");
define("REMOVE_FROM_SHELF","Retirar de mi colecci�n");
define("CITATIONS","Citaciones");
define("ACCESS_STATS","Estad�sticas de accesos");
define("ARTICLE_ACCESS","Accesos al art�culo");
define("ACCESSES","Accesos");
define("MONTHS","Meses");
define("REMOVE_ALERT","Retirar alerta");
define("REMOVE_ACCESS_ALERT","No quiero m�s recibir alertas de accessos de este art�culo");
define("REMOVE_CITED_ALTER","No quiero m�s recibir alertas de citaciones a este art�culo");
define("MONTH_LIST", "ene,feb,mar,abr,mayo,jun,jul,ago,sept,oct,nov,dic");
define("CITED_BY","Citado Por");
define("SIMILARYS_IN","Similares en");
define("SEE","Ver");
define("SEE_HISTORY","Ver Hist�rico");
define("CHOOSE_PERIOD", "Elegir por a�o:");
define("START_YEAR", "De:");
define("LAST_YEAR", "Hasta:");
define("BUTTON_REFRESH", "Actualizar gr�fico");
define("GRAFIC_STATS_FALSE", "No hay datos estad�sticos para el periodo elegido");
/*
textos das mensagens de erro
*/
define("FIELD_FIRST_NAME_ERROR_DESCRIPTION","*");
define("FIELD_LAST_NAME_ERROR_DESCRIPTION","*");
define("FIELD_GENDER_ERROR_DESCRIPTION","*");
define("FIELD_PASSWORD_ERROR_DESCRIPTION","*");
define("FIELD_EMAIL_ERROR_DESCRIPTION","*");
define("FIELD_LOGIN_ERROR_DESCRIPTION","*");
define("FIELD_PROFILE_ONE","Perfil 1");
define("FIELD_PROFILE_TWO","Perfil 2");
define("FIELD_PROFILE_TREE","Perfil 3");
define("FIELD_PROFILE_NAME","T�tulo");
define("FIELD_PROFILE_DESCRIPTION_TEXT","Descripci�n");
define("BUTTON_NEW_USER","Record");
define("BUTTON_UPDATE_USER","Update");
define("BUTTON_BACK","Volver");
define("BUTTON_CANCEL","Cancelar");
define("BUTTON_CLOSE","Cerrar");
define("REGISTER_NEW_USER_SUCESS","Nuevo usuario registrado con �xito");
define("UPDATE_USER_SUCESS","Actualizaci�n de datos hecha con �xito");

/*
textos para a pagina��o
*/
define("FIRST_PAGE","Primera ");
define("LAST_PAGE","�ltima");
define("PAGE","P�gina");

define("HOME","home");
define("SEARCH_JOURNALS","B�squeda por Peri�dicos");
define("JOURNALS_ALPHABETIC_LIST","Peri�dicos por ordem alfab�tica");

/*
segundo nivel SciELO em n�meros
*/
define("NUMBERS","SciELO en n�meros");
define("CITATION","Citas de revistas");
define("CO_AUTHORS","Co-autoria");
define("USAGE","Uso del sitio");
define("BRASIL","Brasil");
define("CHILE","Chile");
define("CUBA","Cuba");
define("PUBLIC_HEALTH","Salud P�blica");
define("SPAIN","Espa�a");
define("VENEZUELA","Venezuela");

/*
pesquisa por titulos
*/
define("FIND_RESULTS","resultados encontrados :");

/*
artigos do meu perfil
*/
define("TOOLS","Herramientas");

/*
minhas noticias
*/
define("ADD","A�adir RSS Feed");
define("ADD_FEED","A�adir RSS Feed");
define("REMOVE_FEED","Remover RSS Feed");
define("RSS_PROBLEM","Se ocurrri� un error al abrir el RSS Feed");
define("REMOVE_FEED_CONFIRM","Esta seguro?");
define("PUBLISH_IN_HOME_PAGE","Publicar en la Home");
define("REMOVE_FROM_HOME_PAGE","Remover de la Home");
define("ALL_FEEDS","Todos los Feeds");

/*
	USER SHELF FOLDERS
*/

define("MONITORED_ACCESS","acceso monitorado");
define("MONITORED_CITATIONS","citaciones monitoradas");
define("MOVE_TO","mover para");
define("MY_FOLDERS","Mis Carpetas");
define("ADD_FOLDER","a�adir carpeta");
define("INCOMING_FOLDER","Carpeta de Entrada");
define("SHOW_FOLDERLIST_BY","mirar lista por:");
define("DATE_SORT","Fecha");
define("MY_RANKING","Mi clasificaci�n");
define("EDIT_FOLDER","Editar Carpeta");
define("DELETE_FOLDER","Apagar Carpeta");
define("FOLDER_NAME","Nombre de la Carpeta");
define("MOVE_FOLDER_TO","Mover Para");
define("BUTTON_MOVE","mover");
define("BUTTON_CANCEL","cancelar");
define("BUTTON_REMOVE","apagar");
define("BUTTON_EDIT","editar");
define("BUTTON_CREATE","crear");
define("MOVE_CONTENT_TO_OTHER_FOLDER","mover conten�do para otra carpeta");
define("REMOVE_CONTENT","apagar conten�do");
define("SHOW_BY_RATE"," por Ranking");
define("SHOW_BY_DATE"," por Fecha");

/*
 USER LINKS
*/

define("REMOVE_LINK","remover direcci�n eletr�nica");
define("EDIT_LINK","editar direcci�n eletr�nica");
define("ADD_LINK","a�adir direcci�n eletr�nica");
define("LINK_TITLE","T�tulo de la direcci�n eletr�nica");
define("LINK_URL","URL de la direcci�n eletr�nica");
define("LINK_DESCRIPTION","Descripci�n de la direcci�n eletr�nica");
define("IN_HOME","a�adir a primera p�gina");
define("DO_YOU_REALY_WANT_TO_REMOVE_IT","Desea realmente apagar la direcci�n eletr�nica?");
define("ENVIAR_ARTIGO_POR_EMAIL","Enviar art�culo por e-mail");
define("SEND","enviar e-mail");
define("CLOSE","cerrar ventana");
define("ARTICLE_SUBMITED_WITH_SUCCESS","art�culo enviado com �xito");
define("SEARCHING_IN","procurando em");
define("SIMILARITY","relev�ncia");
/*
Collexis Instances Name
*/
define("ARR","SCI_OVERALL|SciELO Regional,SCI_SCIELOBR|SciELO Brasil,SCI_SCIELOCL|SciELO Chile,SCI_SCIELOCB|SciELO Cuba,SCI_SCIELOESP| SciELO Espa�a,SCI_SCIELOVE|SciELO Venezuela,SCI_SCIELOSP|SciELO Salud P�blica,SCI_SCIELOSS|SciELO Ci�ncias Sociales");

define("FULL_TEXT","texto completo");
}
?>
