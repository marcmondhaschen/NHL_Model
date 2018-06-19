*** IF YOU INTEND TO USE THIS CODE IN A PUBLIC ENVIRONMENT, ***

*** CHANGE THE PASSWORD IN config/db.COPYinc.php and config/mysql_setupCOPY.sql  ***

*** AND THEN RENAME BOTH FILES TO 'db.inc.php' and 'mysql_setup.sql' ***

*** LOG IN TO YOUR LOCAL MYSQL SERVER AS ROOT AND RUN 'mysql_setup.sql' ***


This project is a simple exhibition of an JSON API->MySQL ETL & database 
wrapped into a humble PHP MVC.


Current objectives are:

Source data for this project are fetched from the NHL's (as yet, undocumented) 
open API. No API key is required to access the NHL's data. These actions are
performed by "Collector" classes, and data thereafter is passed as a "RawPSAData"
object.

Data is then stored to a "rawPSA" MySQL storage schema. This layer records both 
the URI query string employed, and the NHL's (typically JSON) response, along 
with some logging data. Data is fetched to and from the "rawPSA" schema by 
"RawPSADataAgent" classes, which continues to pass this data as "RawPSAData" 
objects.

"RawPSAData" objects are fetched from the "rawPSA" schema by the "RawPSADataAgent"
and passed to "TableTransform" classes. These classes convert the JSON response 
within the RawPSAData object into associative arrays which mimic the MySQL table 
structures in the "PSA" and "prod" schemas. These associative arrays, along with
new logging data about the "TableTransform" process are stored to "PSAData" 
objects and passed to a "PSADataAgent".

Like the "RawPSADataAgent" class before it, the "PSADataAgent" uses the 
associative array of transformed JSON data to build table records in the "PSAData" 
schema. The "PSADataAgent" classes are also responsible for fetching data from
the "PSAData" schema, and pass the data as "PSAData" objects.  

"PSAData" objects are consumed by a "ProductionLoader" class. These classes 
communicate with "ProdDataAgent" classes about whether or not the data contained 
within a given "PSAData" object is a valid and timely update to production data.

If the "ProdDataAgent deems the data contained in the "PSAData" payload to be 
relevant, it uses the associative array in the data object to write 'insert' or
'update' statements, as appropriate, to the "prod" schema

Prioritized objectives, thereafter, include:

Controller classes to interact with Collectors, TableTransforms, 
ProductionLoaders, and the DataAgents between them.

Data validation steps within the data classes ("RawPSAData" and "PSAData")

Formalized unit test classes for each existing class.


Comments and critique of this MVC and ETL are heartily welcomed at 
marcmondhaschen@<the ubiquitous google mail service>.com

"NHL" is a registered trademark of the National Hockey League. Team names are
registered trademarks of their respective franchises. Hockey is cool and fun, but
not as cool and fun as hockey lawyers!