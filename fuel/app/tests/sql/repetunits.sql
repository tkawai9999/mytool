delete from repetunits;
alter table repetunits auto_increment=1;
insert into repetunits(name,dateword,sort_no,uid,delf,created_at,updated_at) values 
('日','day',1,5,0,now(),now()),
('週','week',2,5,0,now(),now()),
('月','month',3,5,0,now(),now()),
('年','year',4,5,0,now(),now());

