# Log all queries

_WARNING: that function ALL data into a txt file, that can include private data!_

You don´t trust the SQL Queries and think there are SQL-Injects? You can LOG all queries to check what happen.

Just go to `config/autoload`, there you have to rename `sqllogging.php.dist` to `sqllogging.php`.

Now you will see a file in `data/DoctrineORMModule` named smth like `sql-logging-2031-01-01.txt` just with the current date.