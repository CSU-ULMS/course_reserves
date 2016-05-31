# README #

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* This repository is for the alternate Primo Courses Reserves UI.

### How do I get set up? ###

1. Add your Alma API key information to config_sample.php.
1. Rename config_sample.php to config.php
1. Rename courses_body_rename.php to courses_body.php
1. Change permissions for courses_body.php to grant write permissions to webserver user. For us, we changed the owner to apache (username for apache webserver) and gave permissions of 664.
1. Add update_course_list.php to cron and schedule for appropriate update interval.

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact