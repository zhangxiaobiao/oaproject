select t1.name as dept_name, count(*) as count
from tp_dept as t1
inner join tp_user as t2
where t1.pid=t2.dept_id
group by dept_name