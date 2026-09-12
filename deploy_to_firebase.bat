@echo off
title Deploy NEWS @ DOHA to Firebase Hosting
cd /d "%~dp0"
color 0b
echo ================================================================
echo         NEWS @ DOHA - FIREBASE HOSTING DEPLOYMENT
echo ================================================================
echo.
echo Project: newsatdoha
echo Target:  https://newsatdoha.web.app
echo.
echo [1/2] Authenticating with Google Firebase...
call .\node_modules\.bin\firebase.cmd login
echo.
echo [2/2] Deploying static website in public/ to Firebase Hosting...
call .\node_modules\.bin\firebase.cmd deploy --only hosting --project newsatdoha
echo.
echo ================================================================
echo [SUCCESS] Your website is now LIVE on Firebase Hosting!
echo.
echo View your live site:
echo   - https://newsatdoha.web.app
echo   - https://newsatdoha.firebaseapp.com
echo ================================================================
echo.
pause
