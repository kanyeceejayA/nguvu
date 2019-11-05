
# Initial view
drop view list_startups_view;
create view list_startups_view as
SELECT 	startups.s_id,
		`logo`,
		startups.`name` as name,
		type.type as type,
		location,
		sum(equity.amount)+sum(grants.amount) as funding,
		startups.f_year,
		status,
		`website`,
		`facebook`,
		`twitter`,
		`linkedin`
from startups
JOIN type on startups.type_id=type.type_id 
JOIN status on startups.status_id = status.status_id
JOIN equity on startups.s_id
JOIN grants on startups.s_id
GROUP BY startups.s_id


drop view single_startups_view;
create view single_startups_view as
SELECT 	startups.s_id,
		`logo`,
		startups.`name` as name,
		type.type as type,
		type2.type as type2,
		email,
		funding_stage,
		employees,
		description,
		location,
		funding,
		startups.f_year,
		status,
		`website`,
		`facebook`,
		`twitter`,
		`linkedin`,
		founders,
		countries
from startups
LEFT JOIN type on startups.type_id=type.type_id
LEFT JOIN type type2 on startups.type_id2=type2.type_id 
LEFT JOIN status on startups.status_id = status.status_id
LEFT JOIN (SELECT s_id,sum(amount) funding from deals group by s_id) d on d.s_id=startups.s_id
LEFT JOIN (SELECT s_id,  GROUP_CONCAT(f_name) founders from founders GROUP by s_id) f on startups.s_id = f.s_id
LEFT JOIN 
	(select f.s_id, GROUP_CONCAT(c.name) as countries 
		from startups s 
		JOIN c_of_operation f on f.s_id = s.s_id 
		JOIN countries c on c.country_id=f.c_id 
		GROUP BY f.s_id) c 
	on c.s_id = startups.s_id
GROUP BY startups.s_id

drop view investors_view;
create view investors_view as
select 
	i.inv_id,
	logo,
	name,
	phone,
	email,
	location,
	sector,
	status,
	website,
	facebook,
	twitter,
	linkedin,
	description,
	countries
from investors i
LEFT JOIN 
	(select f.inv_id, GROUP_CONCAT(c.name) as countries 
		from investors s 
		JOIN c_of_focus f on f.inv_id = s.inv_id 
		JOIN countries c on c.country_id=f.c_id 
		GROUP BY f.inv_id) c
	on c.inv_id = i.inv_id
GROUP BY i.inv_id


drop view funding_view;
create view funding_view as
SELECT 
f.d_id,
f.amount,
f.round,
f.d_date,
f.source,
f.inv_id,
f.s_id,
i.name as inv_name,
s.name as s_name 
from deals f 
join investors i on f.inv_id = i.inv_id
join startups s on f.s_id = s.s_id