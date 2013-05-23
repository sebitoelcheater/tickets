drop table person,event,ticket;

create table person (
rut varchar(14) primary key,
name varchar(30) not null,
last_name varchar(30) not null,
password varchar (20) not null,
birth_date date
);

create table event(
event_id serial primary key,
name  varchar(50) not null,
creator_id varchar(15) not null,
begin_timestamp timestamp not null,
end_timestamp timestamp not null,
description varchar(150),
ticket_image bytea,
constraint  user_id_event_fk foreign key(creator_id) references person(rut)
);-- bytea es un tipo de dato para archivos encontrado en google

create table ticket(
client_id varchar(15),
event_id integer,
valid boolean,
code text not null,
qr_image bytea,
constraint client_id_ticket_fk foreign key(client_id) references person(rut),
constraint event_id_ticket_fk foreign key(event_id) references event(event_id)
);
SET dateStyle TO European;

insert into person (rut,name,last_name,password,birth_date) values
('179615673','Gonzalo','Lopez','123456','24-12-1991'),
('111111111','Viejo','Caliente','123456','1-01-1'),
('179619938','Sebastian','Hernandez','123456','16-01-1992'),
('696969696','Arturo', 'Huaiquin', '123456','23-9-1969');

insert into event (name,creator_id,begin_timestamp,end_timestamp,description) values
('Evento para gays', 179619938, '14-01-1992 10:00:00','21-01-1992 23:00:01','Es un evento muy homosexual, homosexualizate'),
('Evento bonito',179615673,'01-01-2014 00:00:00','31-12-2014 23:59:59','Es un evento entretenido y lindo');

insert into ticket (client_id,event_id,valid,code) values
('111111111',1,true,'anaxagoras'),
('696969696',1,true,'salchicha caliente'),
('179619938',2,true,'peachepe');