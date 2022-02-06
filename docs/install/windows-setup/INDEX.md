# How to install the PServerCMS on Windows

This guide requires `Visual Studio 2015`. There should be also no other webserver running on port 80 and no other PHP should be installed. If there are conflicts please delete the old parts or edit the configs.

## Setup a WebServer + PHP + different extensions

requires `Visual Studio 2015` and above

## DownloadList

- [PHP 7.4.27](https://windows.php.net/downloads/releases/php-7.4.27-Win32-vc15-x64.zip) OR [PHP 7.4.27 Archive](https://windows.php.net/downloads/releases/archives/php-7.4.27-Win32-VC15-x64.zip), use the archive version if the first link not work or download the latest 7.4.X VC14 x64 Thread Safe
- [Apache](https://www.apachehaus.com/cgi-bin/download.plx?dli=QVXRXNaBTQ10kentmWwYFVKVlUGR1UwNVTtxmR) (latest apache for x64)
- [Visual C++ Redistributable](https://www.microsoft.com/en-us/download/details.aspx?id=48145)
- [ODBC Driver 11](https://www.microsoft.com/en-us/download/details.aspx?id=36434)
- [mssql-extension](https://github.com/microsoft/msphpsql/releases/download/v5.10.0/Windows-7.4.zip)

![DownloadList](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/download.png)

## Install dependencies 

Please install `vc_redist.x64.exe` or `vc_redist.x86.exe` and  `msodbcsql.msi`

Continue with [Apache + PHP Setup](/install/windows-setup/APACHE.md)
