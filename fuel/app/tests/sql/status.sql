delete from statuses;
alter table statuses auto_increment=1;
insert into statuses(name,sort_no,delf,created_at,updated_at) values 
('未',1,0,now(),now()),
('対応中',2,0,now(),now()),
('保留',3,0,now(),now()),
('完了',4,0,now(),now()),
('ゴミ',5,1,now(),now());

