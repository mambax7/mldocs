Module Purpose
-----------------------------------------------------------------------
mldocs is designed as a user-friendly helpdesk application for the XOOPS
portal system. 

Installation Requirements
-----------------------------------------------------------------------
XOOPS 2.0.6+

Enabling Email Support Requires adds these requirements:
POP3 Email account(s)
Ability to create a cron job or scheduled task

Installation Instructions
-----------------------------------------------------------------------
Unzip archive to 'modules' directory. 
Install application using XOOPS module administration panel. 
Adjust module preferences as necessary.
Add archives departments (categories).
Setup XOOPS user accounts that represent helpdesk staff members.
Follow steps in "Block Styles" section of this document
All Set!!!

Upgrade Instructions
-----------------------------------------------------------------------
Unzip archive to 'modules' directory.
Update module through XOOPS module administration panel.
Click on 'Check Tables' from the mldocs Main Menu, or the pop-up menu.
Adjust module preferences as necessary.
Follow steps in "Block Styles" section of this document.
Templates in 0.75 have changed significantly. If you are running a custom
template set, you will need to remove them and Generate the new 
templates.
All Set!!!

Block Styles
-----------------------------------------------------------------------
xHelp 0.7 adds the ability to flag a archive as overdue. To see this 
flag in the mldocs blocks (My archives, Recently Viewed archives) you will
need to add the following style to your xoops theme's stylesheet:

#mldocs_dept_recent li.overdue {background-color:red;}
#mldocs_bOpenArchives li.overdue {background-color:red;}

In addition we recommend adding these styles to your theme's stylesheet

#mldocs_dept_recent li {list-style:none;}
#mldocs_bOpenArchives li {list-style:none;}

#mldocs_dept_recent ul, #mldocs_dept_recent li {margin:0; padding:0;}
#mldocs_bOpenArchives ul, #mldocs_bOpenArchives li {margin:0; padding:0;}

#mldocs_dept_recent li {margin:0;padding-left:18px; background:url('../../modules/mldocs/images/archive-small.png') no-repeat 0 50%; line-height:16px;padding-bottom:2px;}
#mldocs_bOpenArchives li {margin:0;padding-left:18px; background:url('../../modules/mldocs/images/archive-small.png') no-repeat 0 50%; line-height:16px;padding-bottom:2px;}



Email Archive Submission
-----------------------------------------------------------------------
To configure email archive submission some additional steps are 
necessary. First you need to create a POP3 email account for each
department that will receive email. Next, go to "Manage Departments" in
the mldocs Admin Panel. Next, edit the department you wish to hold the newly
created archives. Next, Add a new mailbox to monitor:

Mailbox Type - currently the only option is POP3.
Server - DNS name of mail server (get from your hosting provider)
Port - Mail Service Port Number.  For POP3 this is usually 110.
Username - Username to access mailbox (get from your hosting provider)
Password - Password to access mailbox (also get from your hosting provider)
Default Archive Priority - Adjust default priority for incoming archives.
Reply-To Email Address - the email address for this account. Used for 
    handling replies (responses) to archives.

Repeat this process for each mailbox you wish to monitor.

Once all mailboxes have been added, you need to setup a scheduled task
or a cron job to check these mailboxes on a regular basis.

For *nix machines the following crontab line should do the trick:

*/2 * * * * /usr/bin/wget -q <XOOPS_URL>/modules/mldocs/checkemail.php

The above line will check all the configured mailboxes, every other minute.

For windows servers you can try using Task Scheduler or runat with
this variant:
C:\php\php.exe "<XOOPS_ROOT_PATH>\modules\mldocs\checkemail.php"

If PHP was installed into a different directory from the default you
will need to adjust the path to php.exe accordingly.

In addition, there is a version of wget for windows:



Unfortunately we cannot support you in the configuration of this 
scheduled task. Please contact your hosting provider with any questions.

License
-----------------------------------------------------------------------
GPL see LICENSE.txt  and copyright BYOOS solutions  http://www.byoos.fr

Updates, Bugs or Feedback
-----------------------------------------------------------------------
For up-to-date versions of this application or to give feedback for the
application go to the mldocs development site:

http://mldocs.org

Translations
-----------------------------------------------------------------------
xHelp not available in your language? Want to help by translating mldocs
into your native tongue? Please come to the translators forum on the 
mldocs development site (url listed above) for more details.

Credits and Thanks
-----------------------------------------------------------------------
See the about page in mldocs Admin area