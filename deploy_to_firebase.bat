@echo off
title Deploy NEWS @ DOHA to Firebase Hosting
cd /d c:\xampp\htdocs\NEWSATDOHA
color 0b
echo ================================================================
echo         NEWS @ DOHA - FIREBASE HOSTING DEPLOYMENT
echo ================================================================
echo.
echo Project: newsatdoha
echo Target:  https://newsatdoha.web.app
echo.
echo [1/2] Authenticating with Google Firebase...
call npx firebase-tools login
echo.
echo [2/2] Deploying static website in public/ to Firebase Hosting...
call npx firebase-tools deploy --only hosting --project newsatdoha
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
