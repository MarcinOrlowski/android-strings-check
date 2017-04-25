Preface
=======

While working on some Android projects I faced small issue related to localisation files - lack of localisation files diff.
Since there’s no built-in mechanism that helps you keep all these files in sync, figure out which translation lacks
which strings I crafted small PHP command line script to help me keep my translations up to date with english base 
strings. Since this seems to be common problem for other translators as well, I decided to share my script. Feel 
free to use it as you want. I do not mind if you credit me anyway :)

Usage
=====

Script takes two strings.xml-type-o-files and cross-checks them to find if there’s any missing 
(present in base file but not in translated) or obsolete (present in translation file but no longer in base)
strings. Both files are passed as arguments while calling the script – first strings.xml is a **BASE** 
(it shall be that one you try to sync to, so in general case `values/strings.xml`) the other one is your **LANG**
(translated) file. In my case `values-pl/strings.xml`. To check these files do the following in the terminal:

    ./strings-check.php values/strings.xml values-pl/strings.xml

It will give you the output like this:
    
    Missing in <LANG> (You need to add these to your file)
    File: values-de/strings.xml
    ------------------------------------------------------
    show_full_header_action
    hide_full_header_action
    recreating_account
    Missing in EN (you probably shall remove it from your <LANG> file)
    File: values/strings.xml
    ------------------------------------------------------------------
    provider_note_yahoo
    Summary
    ----------------
    BASE file: 'values/strings.xml'
    LANG file: 'values-de/strings.xml'
       3 missing strings in your LANG file.
       1 obsolete strings in your LANG file.

Notes
=====

I use Debian so PHP interpreter for me resides in `/usr/bin/php`. On your distro it may be `/usr/local/bin/php` or elsewhere (do `which php` to find out). Either update 1st line in the script or just type `php` while invoking:

    php ./strings-check.php values/strings.xml values-pl/strings.xml
