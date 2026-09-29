@echo off
rem Levanta la plataforma accesible desde otras PCs de la misma red.
rem Requiere MySQL de XAMPP encendido. La API de Python queda solo local
rem (PHP la llama desde el servidor), lo unico expuesto es el puerto 8080.
cd /d "%~dp0"

set PUERTO=8080

start "API Transformer" /min .venv\Scripts\python.exe -m uvicorn api_asignacion:app --host 127.0.0.1 --port 8000

echo.
echo Abre desde otra PC en la misma red:
for /f "tokens=2 delims=:" %%i in ('ipconfig ^| findstr /c:"IPv4"') do echo    http://%%i:%PUERTO%/inicio.html
echo.
echo Ctrl+C para detener el servidor web (cierra tambien la ventana "API Transformer").
echo.

C:\xampp\php\php.exe -S 0.0.0.0:%PUERTO% -t .
