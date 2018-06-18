# program-specific databases
create database nhl_api_remodel character set utf8mb4 collate utf8mb4_unicode_ci;
create database nhl_api_remodel_PSA character set utf8mb4 collate utf8mb4_unicode_ci;
create database nhl_api_remodel_RawPSA character set utf8mb4 collate utf8mb4_unicode_ci;

# build three users, one for handling raw API data, one for PSA tables and the 
# last for handling production tables
# CHANGE THESE PASSWORDS
create user `nhl_api_remodel_PSA_user`@`localhost`
 identified by 'SOME_PASSWORD_OF_YOUR_CHOOSING'; # CHANGE THIS PASSWORD
create user `nhl_api_remodel_RawPSA_user`@`localhost`
 identified by 'SOME_PASSWORD_OF_YOUR_CHOOSING'; # CHANGE THIS PASSWORD
create user `nhl_api_remodel_production_user`@`localhost`
 identified by 'SOME_PASSWORD_OF_YOUR_CHOOSING'; # CHANGE THIS PASSWORD

# record attempted logins
create table `nhl_api_remodel`.`login_attempts` (
    `user_id` int(12) not null,
    `time_attempted` date
);

# conference data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`conferences` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# conference data (PSA)
create table `nhl_api_remodel_PSA`.`conferences` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `id` int(2),
    `name` varchar(20),
    `link` varchar(30),
    `abbreviation` varchar(2),
    `shortName` varchar(10),
    `active` bool
);

# conference data (Production)
create table `nhl_api_remodel`.`conferences` (
    `id` int(2) primary key unique not null,
    `name` varchar(20),
    `link` varchar(30),
    `abbreviation` varchar(2),
    `shortName` varchar(10),
    `active` bool
);

# divsion data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`divisions` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# divsion data (PSA)
create table `nhl_api_remodel_PSA`.`divisions` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `id` int(2),
    `name` varchar(30),
    `link` varchar(30),
    `abbreviation` varchar(2),
    `conference` int(2),
    `active` bool
);

# divsion data (Production)
create table `nhl_api_remodel`.`divisions` (
    `id` int(2) primary key unique not null,
    `name` varchar(30),
    `link` varchar(30),
    `abbreviation` varchar(2),
    `conference` int(2),
    `active` bool
);

# franchise data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`franchises` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# franchise data (PSA)
create table `nhl_api_remodel_PSA`.`franchises` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `franchiseId` int(2) primary key unique not null,
    `firstSeasonId` varchar(8),
    `mostRecentTeamId` int(3),
    `teamName` varchar(20),
    `locationName` varchar(20),
    `link` varchar(30)
);

# franchise data (Production)
create table `nhl_api_remodel`.`franchises` (
    `franchiseId` int(2) primary key unique not null,
    `firstSeasonId` varchar(8),
    `mostRecentTeamId` int(3),
    `teamName` varchar(20),
    `locationName` varchar(20),
    `link` varchar(30)
);

# people data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`people` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# people data (PSA)
create table `nhl_api_remodel_PSA`.`people` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `id` int(8),
    `fullName` varchar(50),
    `link` varchar(30),
    `firstName` varchar(30),
    `lastName` varchar(30),
    `primaryNumber` int(3),
    `birthDate` date,
    `currentAge` int(2),
    `birthCity` varchar(30),
    `birthStateProvince` varchar(5),
    `birthCountry` varchar(30),
    `nationality` varchar(5),
    `height` varchar(8),
    `weight` int(4),
    `active` bool,
    `alternateCaptain` bool,
    `captain` bool,
    `rookie` bool,
    `shootsCatches` varchar(2),
    `rosterStatus` varchar(2),
    `currentTeam` int(3),
    `primaryPosition` varchar(2)
);

# people data (Production)
create table `nhl_api_remodel`.`people` (
    `id` int(8),
    `fullName` varchar(50),
    `link` varchar(30),
    `firstName` varchar(30),
    `lastName` varchar(30),
    `primaryNumber` int(3),
    `birthDate` date,
    `currentAge` int(2),
    `birthCity` varchar(30),
    `birthStateProvince` varchar(5),
    `birthCountry` varchar(30),
    `nationality` varchar(5),
    `height` varchar(8),
    `weight` int(4),
    `active` bool,
    `alternateCaptain` bool,
    `captain` bool,
    `rookie` bool,
    `shootsCatches` varchar(2),
    `rosterStatus` varchar(2),
    `currentTeam` int(3),
    `primaryPosition` varchar(2)
);

# team data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`teams` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# team data (PSA)
create table `nhl_api_remodel_PSA`.`teams` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `id` int(3) primary key unique not null,
    `name` varchar(30),
    `link` varchar(30),
    `venue` varchar(30),
    `abbreviation` varchar(10),
    `teamName` varchar(30),
    `locationName` varchar(30),
    `firstYearOfPlay` int(4),
    `division` int(3),
    `conference` int(3),
    `shortName` varchar(20),
    `officialSiteUrl` varchar(50),
    `franchiseId` int(3),
    `active` bool
);

# team data (Production)
create table `nhl_api_remodel`.`teams` (
    `id` int(3) primary key unique not null,
    `name` varchar(30),
    `link` varchar(30),
    `venue` varchar(30),
    `abbreviation` varchar(10),
    `teamName` varchar(30),
    `locationName` varchar(30),
    `firstYearOfPlay` int(4),
    `division` int(3),
    `conference` int(3),
    `shortName` varchar(20),
    `officialSiteUrl` varchar(50),
    `franchiseId` int(3),
    `active` bool
);

# timezone data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`timezones` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# timezone data (PSA)
create table `nhl_api_remodel_PSA`.`timezones` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `id` varchar(30),
    `offset` int(3),
    `tz` varchar(5)
);

# timezone data (Production)
create table `nhl_api_remodel`.`timezones` (
    `id` varchar(30),
    `offset` int(3),
    `tz` varchar(5)
);

# venue data (raw)
# query_response's mediumtext datatype means that these results won't be stored in line
create table `nhl_api_remodel_RawPSA`.`venues` (
    `query_string` varchar(200),
    `filter` varchar(100),
    `datetime` date,
    `query_response` varchar(10000),
#    `query_response` mediumtext, 
    `errormessage` varchar (100)
)

# venue data (PSA)
create table `nhl_api_remodel_PSA`.`venues` (
    `queryNumber` mediumint primary key unique not null auto_increment,
    `queryTime` date,
    `name` varchar(100),
    `link` varchar(100),
    `city` varchar(100),
    `timezone` varchar(30)
);

# venue data (Production)
create table `nhl_api_remodel`.`venues` (
    `name` varchar(100),
    `link` varchar(100),
    `city` varchar(100),
    `timezone` varchar(30)
);

# grant rights to dedicated users, above, to selected tables
grant select, insert on `nhl_api_remodel`.`login_attempts` to `nhl_api_remodel_production_user`@`localhost`;
grant insert on `nhl_api_remodel`.`login_attempts` to `nhl_api_remodel_PSA_user`@`localhost`;
grant insert on `nhl_api_remodel`.`login_attempts` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`conferences` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`conferences` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`conferences` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`divisions` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`divisions` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`divisions` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`franchises` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`franchises` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`franchises` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`people` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`people` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`people` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`teams` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`teams` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`teams` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`timezones` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`timezones` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`timezones` to `nhl_api_remodel_RawPSA_user`@`localhost`;

grant select, insert, delete on `nhl_api_remodel`.`venues` to `nhl_api_remodel_production_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_PSA`.`venues` to `nhl_api_remodel_PSA_user`@`localhost`;
grant select, insert, delete on `nhl_api_remodel_RawPSA`.`venues` to `nhl_api_remodel_RawPSA_user`@`localhost`;