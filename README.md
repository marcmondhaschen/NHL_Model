*** IF YOU INTEND TO USE THIS CODE IN A PUBLIC ENVIRONMENT, ***
*** CHANGE THE PASSWORD IN config/db.COPYinc.php and config/mysql_setupCOPY.sql  ***
*** AND THEN RENAME BOTH FILES TO 'db.inc.php' and 'mysql_setup.sql' ***
*** LOG IN TO YOUR LOCAL MYSQL SERVER AS ROOT AND RUN 'mysql_setup.sql' ***

This project is a simple exhibition of an JSON API->MySQL ETL & database 
wrapped into a humble PHP MVC.

My first objective is described as follows:

Source data for this project are fetched from the NHL's (as yet, undocumented) 
open API. No API key is required to access the NHL's data.

Data is first fetched from the NHL and stored to a 'raw' MySQL storage schema.
This layer records both the URI query string employed, and the NHL's (typically 
JSON) response, along with some logging data.

These data are then transformed and loaded into a second MySQL schema which 
keeps them in nearly the same format as they are to be stored in production data.

A set of filtering objects assesses the this second layer and uses it to update
or initialize production a third, 'production' MySQL storage schema. 

This 'production' schema's data are to represent a 4NF, and 'complete as 
possible' dataset which captures a local copy of the data offered by the NHL API.

Comments and critique of this MVC and ETL are heartily welcomed at 
marcmondhaschen@<the ubiquitous google mail service>.com