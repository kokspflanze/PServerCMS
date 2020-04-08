# Task Sheduler for crons

open your Task Sheduler and create a new task

![open](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_1.jpg)

type in a name as you want and take all setting

![change name](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_2.jpg)

go to tab "Trigger" and add the trigger

![trigger](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_3.jpg)

then create a new action where Programm/Script =`C:\php\php.exe` and Arguments=`C:\Apache24\htdocs\pserverCMSFull\public\index.php player-history`

![new action](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_4.jpg)

press okay and the first Cronjob is finished


For the second one you have to do the same except:
- other name
- Trigger like screenshot
- for Arguments=`C:\Apache24\htdocs\pserverCMSFull\public\index.php user-codes-cleanup`

![open](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_5.jpg)

![open](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_6.jpg)

![open](https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/docs/images/TASK_SHEDULER/IMG_7.jpg)


## Recommend

You can also add the following tasks

### Sitemap
This should run each hour.
```php
C:\Apache24\htdocs\pserverCMSFull\public\index.php https://example.io/
```

Change `https://example.io/` to your own Domain