cd C:\cpnVodo\
set /a i = 1
:loop

del "check.txt" 
php.exe checkScrapedUrls.php %i% > check.txt
set /p VAR=<check.txt
set "filemask=check.txt"

for %%A in (%filemask%) do if %%~zA==0 (echo hvgsh 
exit)

start "Title1" php.exe loadTest.php %i%
echo start >check.txt
set /a i = %i%+1
goto loop


