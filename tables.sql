create database if not exists `backend_db` character set `utf8` collate `utf8_general_ci`;

use `backend_db`;

create table if not exists `ci_sessions` (
    `id` varchar(128) not null,
    `ip_address` varchar(45) not null,
    `timestamp` int(10) unsigned default 0 not null,
    `data` blob not null,
    key `ci_sessions_timestamp` (`timestamp`)
);

alter table `ci_sessions` add primary key (`id`, `ip_address`);


create database if not exists `frontend_db` character set `utf8` collate `utf8_general_ci`;