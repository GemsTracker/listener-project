@echo off

php  -d memory_limit=256M -f public\start_server.php -- %1 %2 %3 %4

if %errorlevel% NEQ 0 echo Errorlevel is: %errorlevel%