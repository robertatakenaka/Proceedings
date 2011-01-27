@echo off
rem Este arquivo é uma chamada para o 
rem EnviaBasesScielo.bat com parâmetros STANDARD

cls

echo === ATENCAO ===
echo Este arquivo fara a transferencia das bases dos seguintes eventos
echo.
echo Tecle CONTROL-C para sair ou ENTER para verificar os eventos...

pause > nul

notepad \scieloproceedings\serial\scilista.lst

cls
echo === ATENCAO ===
echo.
echo Sera executado o seguinte comando:
echo EnviaBasesScielo.bat \scieloproceedings transf\EnviaBasesLogOnSaludPublica.txt log\EnviaBasesSaludPublicaPadrao.log cria 3
echo.
echo Tecle CONTROL-C para sair ou ENTER para continuar...

pause > nul

EnviaBasesScielo.bat \scieloproceedings transf\EnviaBasesLogOnSaludPublica.txt log\EnviaBasesSaludPublicaPadrao.log cria 3