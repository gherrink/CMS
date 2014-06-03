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

## Usage

### User rights
You have the folowing rights witch grand you full permission:
- MSITE on editing Sites
- MMENU on editing Menu
- MNEWS on editing news
- MGALLERY on editing gallery

to give your user this rights for now you have to type folowing link "url to your website/right/Assign?user=mrbirne&role=role from above"
