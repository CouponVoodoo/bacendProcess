cd C:\xampp\htdocs\cpnVodo

SET /a i=1

:loop
IF %i%==3 GOTO END
echo This is iteration %i%.
start "Title1" php.exe bulkNodeCreation.php %i%
SET /a i=%i%+1
GOTO LOOP

:end




