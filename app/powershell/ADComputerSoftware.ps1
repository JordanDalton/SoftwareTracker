. '.\GetInstalledSoftware.ps1'

Import-Module ActiveDirectory

# Get-ADComputer -Filter {OperatingSystem -Like "Windows*"} -Property * | Format-Table Name,OperatingSystem,OperatingSystemServicePack -Wrap -Auto

$computers = Get-ADComputer -Filter { OperatingSystem -Like "Windows*" } -Property * | Select Name

$UnreachableComputers = @()

foreach( $computer in $computers )
{
    $ComputerName = $computer.Name
    
    if( ! (Test-Connection -Cn $ComputerName -BufferSize 16 -Count 1 -ea 0 -quiet))
    {
        "Problem connecting to $ComputerName"
        
        $UnreachableComputers += $ComputerName
    }
    
    else {
        Get-InstalledSoftware $ComputerName > ./computers/$ComputerName.txt
    }
}



$UnreachableComputers | out-file "C:/apps/softwaretracker/app/powershell/unreachables.txt"