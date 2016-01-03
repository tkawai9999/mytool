delete from todos;
alter table todos auto_increment=1;
insert into todos(name,start_date,end_date,repeat_flag,repeat_unit_id,repeat_interval,end_date_real,status_id,category_id,note,sort_no,delf,created_at,updated_at) values 
('task_untreated1',NULL,NULL,0,NULL,NULL,NULL,1,1,'untreated',1,0,now(),now()),
('task_untreated2',NULL,now()+interval 3 day,0,NULL,NULL,NULL,1,2,'untreated',2,0,now(),now()),
('task_untreated3',NULL,now()+interval 14 day,0,NULL,NULL,NULL,1,3,'untreated',3,0,now(),now()),
('task_untreated4',NULL,now()+interval 1 month,0,NULL,NULL,NULL,1,2,'untreated',4,0,now(),now()),
('task_untreated5',NULL,now()+interval -3 day,0,NULL,NULL,NULL,1,2,'untreated',4,0,now(),now()),
('task_during1',NULL,NULL,0,NULL,NULL,NULL,2,1,'during',2,0,now(),now()),
('task_during2',NULL,now()+interval 1 month,0,NULL,NULL,NULL,2,3,'during',6,0,now(),now()),
('task_hold1',NULL,now()+interval 1 month,0,NULL,NULL,NULL,3,1,'hold',6,0,now(),now()),
('task_finished1',NULL,now()+interval 3 day,0,NULL,NULL,NULL,4,1,'hold',6,0,now(),now()),
('task_delf1',NULL,NULL,0,NULL,NULL,NULL,4,1,'delf',6,1,now(),now()),
('task_delf2',NULL,NULL,0,NULL,NULL,NULL,4,4,'delf',6,1,now(),now()), 
('task_pk1','2016/01/12 09:50:00','2016/06/11 23:59:00',1,2,1,'2016/01/19 09:50:00',1,2,'pk',2,0,now(),now()),
('task_pk2',NULL,NULL,0,NULL,NULL,NULL,1,2,'pk',1,0,now(),now());

