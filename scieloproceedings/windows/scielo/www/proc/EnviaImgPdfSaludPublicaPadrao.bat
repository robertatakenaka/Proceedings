@echo off
rem Este arquivo é uma chamada para o 
rem EnviaImgPdfScielo.bat com parâmetros STANDARD

cls

echo === ATENCAO ===
echo Este arquivo fara a transferencia das imagens/pdfs dos seguintes eventos
echo.
echo Tecle CONTROL-C para sair ou ENTER para verificar os eventos...

pause > nul

notepad \scieloproceedings\serial\scilista.lst

cls
echo === ATENCAO ===
echo.
echo Sera executado o seguinte comando:
echo EnviaImgPdfScielo.bat \scieloproceedings transf\EnviaImgPdfLogOnSaludPublica.txt log\EnviaImgPdfSaludPublicaPadrao.log cria \scieloproceedings\web\htdocs
echo.
echo Tecle CONTROL-C para sair ou ENTER para continuar...

pause > nul

EnviaImgPdfScielo.bat \scieloproceedings transf\EnviaImgPdfLogOnSaludPublica.txt log\EnviaImgPdfSaludPublicaPadrao.log cria \scieloproceedings\web\htdocs

