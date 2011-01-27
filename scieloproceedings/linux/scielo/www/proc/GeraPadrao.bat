export PATH=$PATH:.
rem Este arquivo é uma chamada para o 
rem GeraSciELO.bat com parâmetros STANDARD

clear
echo === ATENCAO ===
echo 
echo Este arquivo executara o seguinte comando
echo GeraSciELO.bat .. /scielo/web log/GeraPadrao.log adiciona
echo 
echo Tecle CONTROL-C para sair ou ENTER para continuar...

rem read pause

GeraSciELO.bat .. .. log/GeraPadrao.log adiciona

cat >msg.txt <<!
A equipe SciELO,


Processamento de SciELLO.Proceedings de `date '+%d/%m/%Y'` concluido sem relato de erros.
Por favor, efetuem os testes de liberacao (http://test.proceedings.scielo.br/).

Francisco Jose Lopes / Marcelo M. Bottura
OFI . Operacao de Fontes de Informacao
fjlopes@bireme.br / marcelo@bireme.br
Phone: +55 (11) 5576-9817 | Fax: +55 (11) 5575-8868
!

mail -s "Termino de processamento do SciELO.Proceeding"  scielo@listas.bireme.br <msg.txt
