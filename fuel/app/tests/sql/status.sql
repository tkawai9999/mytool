delete from statuses;
alter table statuses auto_increment=1;
insert into statuses(name,sort_no,uid,delf,created_at,updated_at) values 
('未',1,5,0,now(),now()),
('対応中',2,5,0,now(),now()),
('保留',3,5,0,now(),now()),
('完了',4,5,0,now(),now()),
('ゴミ',5,5,1,now(),now());

