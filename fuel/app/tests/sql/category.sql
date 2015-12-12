delete from categories;
alter table categories auto_increment=1;
insert into categories(name,sort_no,delf,created_at,updated_at) values 
('category3',3,0,now(),now()),
('category1',1,0,now(),now()),
('category1',2,0,now(),now());
('category4',4,1,now(),now());

