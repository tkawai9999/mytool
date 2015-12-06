delete from statuses;
alter table statuses auto_increment=1;
insert into statuses(name,sort_no,delf) values 
('未',1,0),
('対応中',2,0),
('保留',3,0),
('完了',4,0),
('ゴミ',5,1);

