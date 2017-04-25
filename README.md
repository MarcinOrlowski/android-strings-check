What it is?
===========
It's developer tool that serves as Simple Android localization resource files (`values/strings.xml`) cross checker.

While working on some Android projects back in 2010 I started to face problems keeping all translations in sync.
The more languages were added to the project the bigger chanllenge it become to ensure no language stays behind.

Since there were no built-in mechanism to helps me check out which translation lacks what strings, I crafted 
this small PHP script to help me with the task.

Usage
=====

Script takes two strings resource files and cross-checks them. First file is considered BASE (reference)
one, second is expected to be translation (LANG) of reference file. Once crosscheck is made report is 
gerating listing all the keys of strings present in BASE but missing in LANG file but alos listing orphaned
keys - present in LANG but not found in BASE.

Lets'ch check how LANG `values-pl/strings.xml` matches BASE `values/strings.xml` file:

    ./strings-check.php values/strings.xml values-pl/strings.xml

The report will look like this:
    
    Missing in <LANG> (You need to add these to your file)
    File: values-pl/strings.xml
    ------------------------------------------------------
    show_full_header_action
    hide_full_header_action
    recreating_account
    
    Missing in BASE (you probably shall remove it from your <LANG> file)
    File: values/strings.xml
    ------------------------------------------------------------------
    provider_note_yahoo
    
    Summary
    ----------------
    BASE file: 'values/strings.xml'
    LANG file: 'values-pl/strings.xml'
       3 missing strings in your LANG file.
       1 obsolete strings in your LANG file.

If you need to deal with more translations, then you need to compare them one by one, yet this shall bash loop should do the trick
(assuming you got all translations in single `strings.xml` file in each `values-*` folder):

    for i in values-*/strings.xml ; do ./strings-check.php values/strings.xml ${i} ; done

Notes
=====

I use Debian so PHP interpreter for me resides in `/usr/bin/php`. On your distro it may be `/usr/local/bin/php` or elsewhere (do `which php` to find out). Either update 1st line in the script or just type `php` while invoking:

    php ./strings-check.php values/strings.xml values-pl/strings.xml

Requirements
============

 - PHP 5 (PHP 4 should work as well though)
 - DOM extension (should be enabled by default these days)

Project support
===============

 `Fonty` is free software and you can use it fully free of charge in any of your projects, open source or
 commercial, however if you feel it prevent you from reinventing the wheel, helped having your projects
 done or simply saved you time and money  then then feel free to donate to the project by sending some
 spare BTC to `1LbfbmZ1KfSNNTGAEHtP63h7FPDEPTa3Yo`.

 ![BTC](btc.png)


Contributing
============

 Please report any issue spotted using [GitHub's project tracker](https://github.com/MarcinOrlowski/android-strings-check/issues).

 If you'd like to contribute to the this project, please [open new ticket](https://github.com/MarcinOrlowski/android-strings-check/issues)
 **before doing any work**. This will help us save your time in case I'd not be able to accept such changes. But if all is good and
 clear then follow common routine:

  * fork the project
  * create new branch
  * do your changes
  * send pull request


License
=======

  * Written and copyrighted &copy;2010-2017 by Marcin Orlowski <mail (#) marcinorlowski (.) com>
  * licensed under the Apache 2.0 license
