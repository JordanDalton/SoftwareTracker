$step=$args[0]

. '.\InstalledSoftware.ps1'

Get-InstalledSoftware $step > ./computers/$step.txt