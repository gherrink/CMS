# Collect My Society

## Installationsanleitung

### Webserver
- clone this repository into the root directory of your webserver
- create the folder "assets" in this directory
- create the folder "runtime" in the folder "protected"
- for this folders you have to set read and writh excess for the webserver

### MySql
- create the DB "cms2" we recomand to use the "utf8_general_ci" as default charset 
- for this new DB you have to create an user "cms" with the password "BCv4r2hrfhw4ahrc" if you wish to change this password you have to go into protected/config/main.php and lock under 'db' => array( 'password' => 'BCv4r2hrfhw4ahrc' ) and change it
- execute the "script DB.sql" and "sql/rights/create.sql"


