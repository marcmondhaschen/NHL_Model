create database nhl_model;

# CHANGE THIS PASSWORD
create user `nhl_page_user`@`localhost`
 identified by 'SOME_PASSWORD_OF_YOUR_CHOOSING';


# build a table to log attempted logins
create table `nhl_model`.`login_attempts` (
    `user_id` int(12) not null,
    `time_attempted` date
);

create table `nhl_model`.`conferences` (
    `id` int(3) primary key unique not null,
    `name` varchar(100),
    `link` varchar(100),
    `abbreviation` varchar(2),
    `shortName` varchar(20),
    `active` bool
);


create table `nhl_model`.`divisions` (
    `id` int(3) primary key unique not null,
    `name` varchar(100),
    `link` varchar(100),
    `abbreviation` varchar(2),
    `conference` int(2),
    `active` bool
);


create table `nhl_model`.`franchises` (
    `franchiseId` int(2) primary key unique not null,
    `firstSeasonId` varchar(20),
    `mostRecentTeamId` int(2),
    `teamName` varchar(100),
    `locationName` varchar(100),
    `link` varchar(100)
);


create table `nhl_model`.`teams` (
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

create table `nhl_model`.`timezones` (
	`id` varchar(30),
    `offset` int(3),
    `tz` varchar(5)
);


create table `nhl_model`.`venues` (
    `name` varchar(100),
    `link` varchar(100),
    `city` varchar(100),
    `timezone` varchar(30)
);


create table `nhl_model`.`people` (
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


# grant rights to dedicated user, above, to selected tables
grant select, insert, delete on `nhl_model`.`login_attempts` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`teams` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`venues` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`divisions` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`conferences` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`franchises` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`timezones` to `nhl_page_user`@`localhost`;
grant select, insert, delete on `nhl_model`.`people` to `nhl_page_user`@`localhost`;

