delete from categories;
alter table categories auto_increment=1;
insert into categories(name,sort_no,uid,delf,created_at,updated_at) values 
('category3',3,5,0,now(),now()),
('category1',1,5,0,now(),now()),
('category2',2,5,0,now(),now()),
('category4',4,5,1,now(),now());

