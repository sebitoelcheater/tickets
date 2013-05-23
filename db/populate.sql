drop table instance,sale,person,event,ticket;

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
description varchar(150),
constraint  user_id_event_fk foreign key(creator_id) references person(rut)
);

create table instance(
instance_id serial,
event_id integer,
begin_timestamp timestamp not null,
end_timestamp timestamp not null,
constraint event_id_fk foreign key(event_id) references event(event_id)
);

create table ticket(
ticket_id serial primary key,
event_id integer,
description text,
type_name varchar(20) not null,
qr_image bytea,
constraint event_id_ticket_fk foreign key(event_id) references event(event_id)
);

create table sale(
client_id varchar(15) not null,
ticket_type integer not null,
qr_code text not null,
qr_img bytea,
valid boolean not null,
constraint sale_pk primary key (client_id,ticket_type),
constraint client_id_sale_fk foreign key(client_id) references person(rut),
constraint ticket_type_sale_fk foreign key(ticket_type) references ticket(ticket_id)
);


create view full_instance as
select *
from instance as i inner join event as e on (i.event_id = e.event_id);

create view sale_data as
select *
from sale as s inner join ticket as t on (s.ticket_type = t.ticket_id) inner join person on (person.rut = client.id);


SET dateStyle TO European;

insert into person (rut,name,last_name,password,birth_date) values
('179615673','Gonzalo','Lopez','123456','24-12-1991'),
('111111111','Viejo','Caliente','123456','1-01-1'),
('179619938','Sebastian','Hernandez','123456','16-01-1992'),
('696969696','Arturo', 'Huaiquin', '123456','23-9-1969');

insert into event (name,creator_id,description) values
('Evento para gays', 179619938,'Es un evento muy homosexual, homosexualizate'),
('Evento bonito',179615673,'Es un evento entretenido y lindo');

insert into instance (event_id,begin_timestamp,end_timestamp) values
(1,'14-01-1992 10:00:00','21-01-1992 23:00:01'),
(2,'01-01-2014 00:00:00','31-12-2014 23:59:59');

insert into ticket (event_id,description,type_name) values
(1,'Si te ven esta entrada serás violado','Entrada de ollo'),
(1,'Con esta entrada violas a la gente','Entrada de palo'),
(2,'Con esta entrada te conviertes en dragon','Dragon');

insert into sale (client_id,ticket_type,qr_code,valid) values
('696969696',1,'Weon Idiota',true),
('179619938',2,'HACHEDOSO',true),
('111111111',1,'teta en la cara',true),
('179615673',3,'mochila linda',true),
('179619938',3,'neo parking',true);

