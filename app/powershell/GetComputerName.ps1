Import-Module ActiveDirectory

Function Get-ComputerName
{
    Param(
        [string]$ip
    ) #end param
    
        
    $ComputerName = Get-ADComputer -Filter * -Properties * | Where-Object { $_.IPv4Address -like $ip } | Sort-Object LastLogonDate -descending | Select-Object CN -first 1
    
    Write-Host -NoNewLine $ComputerName.CN
}

Get-ComputerName $args[0]