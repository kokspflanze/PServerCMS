# Frequently Asked Questions

## Could not be decoded as an encoding key was not found
You have to set a `ioncube-key` in your php.ini, or its the wrong key.

example in your php.ini
````
ioncube.loader.key.pservercms = dfg3egsg34g4gdfg
````

## You get a white page with a HTTP-Code 500

Check your Webserver `error-log`
possible error, roles not added [Create the Roles](http://localhost:3000/#/general-setup/CONFIG?id=create-the-roles)


## Application error on page

Enable the debugger to see the error [How to enable debugger?](/general-setup/DEBUGGER.md)

## How to get Admin to the Admin-Panel

[How to get access to the AdminPanel?](/general-setup/ADMIN-PANEL-ACCESS.md)