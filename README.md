# taskSQLi
TaskSQLi is a web guestbook penetration testing exercise.

**Warning: ONLY TO PRACTICE PENETRATION TESTING!**
This web application has several security issues.
It is strongly discouraged to use it in a production environment!

## The Task
Your task is to use the XSS vulnerability to get access to an SQL injection vulnerability via CSRF.

The objective is to get an administrator's password.

Have fun
~

## Setup

* Import `setup/sqli_guestbook.sql` to your local database
* Then configure the credentials in the `include/Connector.php` file
