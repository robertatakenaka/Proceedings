rem CriaInvertido
rem Parametro 1: invertido a ser criado

call batch\VerifPresencaParametro.bat %0 @%1 invertido a ser criado

call batch\InformaLog.bat %0 x Cria invertido: %1
%CISIS_DIR%\mx null count=0 ifupd/create=%1
if errorlevel==1 batch\AchouErro.bat %0 mx seq:nul ifupd/create:%1
