# How to enable debugger?

_WARNING: never do that in production, everyone can see your configuration with all data!_

You can find the disabled debug-config in `config/autoload`.
Now you have to rename `debug.local.php.dist` to `debug.local.php`. Than you can see all errors on the page.
You get also a `DebugToolbar`, to see your config and all queries to the database.