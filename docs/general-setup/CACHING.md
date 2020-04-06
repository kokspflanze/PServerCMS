# Caching

## Config Cache

On each Request, the System merge all the different config files to one big config. To reduce this time you can enable the `config-cache`.

You just have to go to `config/application.php`, on line 3 you can find `$cache = false;`, just change it to `$cache = true;`.

With the next page load, there will be a cached config in `data`.

PS: The cache means that a change in the configuration will not be used until, you dont deleted the cache in `data`.
To clean the cache call `rm -f data/*.php` with the git bash or in your terminal, you have to stay in the directory of the pserverCMS.