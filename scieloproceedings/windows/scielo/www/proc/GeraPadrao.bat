@echo off
rem Este arquivo é uma chamada para o 
rem GeraScielo.bat com parâmetros STANDARD

cls

echo === ATENCAO ===
echo Este arquivo executara o processamento dos seguintes eventos
echo.
echo Tecle CONTROL-C para sair ou ENTER para verificar os eventos...

pause > nul

call notepad \scieloproceedings\serial\scilista.lst

cls
echo === ATENCAO ===
echo.
echo Sera executado o seguinte comando:
echo GeraScielo.bat \scieloproceedings \scieloproceedings\web log\GeraPadrao.log adiciona
echo.
echo Tecle CONTROL-C para sair ou ENTER para continuar...

pause > nul


if "%1"=="novo" goto NOVO
if not "%1"=="novo" goto NORMAL


:NOVO
cls
echo === ATENCAO ===
echo.
echo Voce escolheu a opcao "novo" e a sua base sera reinicializada!
echo.
echo Tecle CONTROL-C para sair ou ENTER para continuar...

pause > nul

deltree /Y \scieloproceedings\web\bases-work\*.*
call ExtraiRevistasArtigo.bat \scieloproceedings \scieloproceedings\web log\ExtraiRevistasArtigo.bat adiciona

:NORMAL
call GeraScielo.bat \scieloproceedings \scieloproceedings\web log\GeraPadrao.log adiciona