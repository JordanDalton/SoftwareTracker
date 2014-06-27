@Echo OFF
set _BATCH_ROOT_=%~dp0
set _TARGET_COMPUTER_= %1

:: Change to the batch root directory
::
cd "%_BATCH_ROOT_%"

:: Now execute the GetInstalledSoftware.ps1 file
::
powershell .\GetInstalledSoftware.ps1 "%_TARGET_COMPUTER_%"