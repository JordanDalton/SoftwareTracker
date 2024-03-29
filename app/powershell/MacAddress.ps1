Function Get-MACAddress {

    param ($strComputer)
    
    # Query WMI and obtain the first MAC address
    #
    $MACAddress = get-wmiobject -class "Win32_NetworkAdapterConfiguration" -computername $strComputer | Where{$_.IpEnabled -Match "True"} | Select-Object MACAddress -first 1
    
    # Return the MAC address as a string.
    #
    return $MACAddress.MACAddress

}