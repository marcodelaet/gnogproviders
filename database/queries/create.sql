
/***********************************
 GNOG DB ACCESS
 user: it_gnog
 pwd: GN0g&tM@rco2o22

secondary: it_gnog_reader
pwd: GN0gR&@d&r

123456: e10adc3949ba59abbe56e057f20f883e
***********************************/

CREATE DATABASE IF NOT EXISTS gnogcrm_db;

USE gnogcrm_db;

#SETTINGS
CREATE TABLE IF NOT EXISTS settings (
id VARCHAR(40) PRIMARY KEY NOT NULL,
setting_key VARCHAR(50) NOT NULL,
setting_value VARCHAR(200) NOT NULL,
setting_description TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

#INSERTING DEFAULT SETTINGS
INSERT INTO settings (id,setting_key, setting_value, setting_description, is_active, created_at, updated_at) 
VALUES 
(UUID(),'spreedsheet_file_location','./public/sheets/','Location where the spreedsheets are','Y',now(),now()),
(UUID(),'billboards_file_name','carteleras.xlsx','Spreedsheet contains all billboard locations, providers,values and codes','Y',now(),now());



# CURRENCIES
CREATE TABLE IF NOT EXISTS currencies (
id VARCHAR(3) PRIMARY KEY NOT NULL,
rate FLOAT NOT NULL,
orderby TINYINT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# USERS
CREATE TABLE IF NOT EXISTS users (
id VARCHAR(40) PRIMARY KEY NOT NULL,
username VARCHAR(20) NOT NULL UNIQUE,
user_language VARCHAR(5) NOT NULL,
email VARCHAR(60) NOT NULL UNIQUE,
level_account INT NOT NULL,
user_type VARCHAR(20) NOT NULL,
mobile_international_code VARCHAR(3),
mobile_prefix VARCHAR(3),
mobile_number VARCHAR(12),
authentication_string VARCHAR(32) NOT NULL,
password_last_changed DATETIME,
token VARCHAR(250),
account_locked ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


# VIEW USERS
CREATE VIEW view_users AS (
	SELECT
	(id) AS UUID,
	username,
	user_language,
	email,
	level_account,
	user_type,
	mobile_international_code,
	mobile_prefix,
	mobile_number,
	CONCAT('+',mobile_international_code,mobile_prefix,mobile_number) AS mobile,
	token,
	account_locked,
	CONCAT((id),username,email,'+',mobile_international_code,mobile_number) AS search
	FROM 
	users
);

# INSERTING USER
INSERT INTO users (id, username, email,mobile_international_code, mobile_prefix,mobile_number,authentication_string,password_last_changed,account_locked,created_at,updated_at) VALUES (UUID(),'marcodelaet','it@gnog.com.br','55','11','11989348999','e10adc3949ba59abbe56e057f20f883e',NOW(),'N',NOW(),NOW());


# GOAL
CREATE TABLE IF NOT EXISTS `goals` (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40) NOT NULL,
goal_month VARCHAR(2) NOT NULL,
goal_year VARCHAR(4) NOT NULL,
currency_id VARCHAR(3) NOT NULL,
goal_amount BIGINT NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# VIEW GOALS
CREATE VIEW view_goals AS (
	SELECT
	u.username,
	(g.user_id) AS UUID,
	g.goal_amount,
	g.goal_month,
	g.goal_year,
	g.currency_id,
	(g.goal_amount / c.rate) * cusd.rate AS goal_USD,
	(g.goal_amount / c.rate) * cmxn.rate AS goal_MXN,
	(g.goal_amount / c.rate) * cbrl.rate AS goal_BRL,
	(g.goal_amount / c.rate) * ceur.rate AS goal_EUR
	FROM 
	goals g
	INNER JOIN users u 
	ON g.user_id = u.id
	INNER JOIN currencies c 
	ON c.id = g.currency_id
	INNER JOIN currencies cusd ON cusd.id = 'USD'
	INNER JOIN currencies cbrl ON cbrl.id = 'BRL'
	INNER JOIN currencies cmxn ON cmxn.id = 'MXN'
	INNER JOIN currencies ceur ON ceur.id = 'EUR'
);

# PROFILES
CREATE TABLE IF NOT EXISTS `profiles` (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40),
photo VARCHAR(200),
country VARCHAR(3),
aboutme TEXT,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# TOKENS
CREATE TABLE IF NOT EXISTS `tokens` (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40),
token VARCHAR(250),
expires TIMESTAMP NOT NULL,
module_name VARCHAR(20),
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# drop table advertisers;

# ADVERTISERS
CREATE TABLE IF NOT EXISTS advertisers (
id VARCHAR(40) PRIMARY KEY NOT NULL,
corporate_name VARCHAR(40) NOT NULL UNIQUE,
address	TEXT NOT NULL,
is_agency ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# CONTACTS
CREATE TABLE IF NOT EXISTS contacts (
id VARCHAR(40) PRIMARY KEY NOT NULL,
module_name VARCHAR(40) NOT NULL, # advertiser / provider
contact_name VARCHAR(20) NOT NULL,
contact_surname VARCHAR(20),
contact_email VARCHAR(60) NOT NULL UNIQUE,
contact_position VARCHAR(20),
contact_client_id VARCHAR(40),
phone_international_code VARCHAR(3),
phone_prefix VARCHAR(3),
phone_number VARCHAR(12),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# drop view view_advertisers;

# VIEW CONTACTS - ADVERTISER
CREATE VIEW view_advertisercontacts AS (
SELECT 
	id AS contact_id,
	contact_name,
	contact_surname,
	contact_email,
	contact_position,
	contact_client_id,
	phone_international_code,
	phone_prefix,
	phone_number
	FROM contacts
	WHERE module_name = 'advertiser' AND is_active='Y'
);

# VIEW CONTACTS - PROVIDER
CREATE VIEW view_providercontacts AS (
SELECT 
	id AS contact_id,
	contact_name,
	contact_surname,
	contact_email,
	contact_position,
	contact_client_id,
	phone_international_code,
	phone_prefix,
	phone_number
	FROM contacts
	WHERE module_name = 'provider' AND is_active='Y'
);

# VIEW ADVERTISERS
CREATE VIEW view_advertisers AS (
	SELECT
	(adv.id) AS UUID,
	ct.contact_id,
	adv.corporate_name,
	adv.address,
	ct.contact_name,
	ct.contact_surname,
	ct.contact_email,
	ct.contact_position,
	ct.contact_client_id,
	ct.phone_international_code,
	ct.phone_prefix,
	ct.phone_number,
	CONCAT('+',ct.phone_international_code,ct.phone_prefix,ct.phone_number) AS phone,
	adv.is_agency,
	adv.is_active,
	CONCAT((adv.id),adv.corporate_name,ct.contact_name,ct.contact_surname,ct.contact_email,'+',ct.phone_international_code,ct.phone_number) AS search
	FROM 
	advertisers adv
	LEFT JOIN view_advertisercontacts ct ON ct.contact_client_id = adv.id
);

# PRODUCTS
CREATE TABLE IF NOT EXISTS products (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name VARCHAR(40) NOT NULL,
description TEXT,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN PRODUCTS TABLE
INSERT INTO products (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES 
((UUID()),'Banner IAB','Banner IAB','Y','Y',NOW(),NOW()),
((UUID()),'Retargeting','Retargeting','Y','Y',NOW(),NOW()),
((UUID()),'Native Ads','Native Ads','Y','Y',NOW(),NOW()),
((UUID()),'Push Notification','Push Notification','Y','Y',NOW(),NOW()),
((UUID()),'Pre Installation App Telcel Android','Pre Installation App Telcel Android','Y','Y',NOW(),NOW()),
((UUID()),'App Opening Telcel Android','App Opening Telcel Android','Y','Y',NOW(),NOW()),
((UUID()),'Native Video','Native Video','Y','Y',NOW(),NOW()),
((UUID()),'Video','Video','Y','Y',NOW(),NOW()),
((UUID()),'Interactive Video','Interactive Video','Y','Y',NOW(),NOW()),
((UUID()),'Rich Media','Rich Media','Y','Y',NOW(),NOW()),
((UUID()),'SMS Telcel and Movistar','SMS Telcel and Movistar','Y','Y',NOW(),NOW()),
((UUID()),'Whatsapp Notification','Whatsapp Notification','Y','Y',NOW(),NOW()),
((UUID()),'Sponsored data Telcel','Sponsored data Telcel','Y','Y',NOW(),NOW()),
((UUID()),'Sponsored data Movistar','Sponsored data Movistar','Y','Y',NOW(),NOW()),
((UUID()),'Audio Ads','Audio Ads','Y','Y',NOW(),NOW()),
((UUID()),'Audio+ SMS','Audio+ SMS','Y','Y',NOW(),NOW()),
((UUID()),'Voice Blaster','Voice Blaster','Y','Y',NOW(),NOW()),
((UUID()),'HTML5 Mobile','HTML5 Mobile','Y','Y',NOW(),NOW()),
((UUID()),'Video Rewards','Video Rewards','Y','Y',NOW(),NOW()),
((UUID()),'E-mail Marketing','E-mail Marketing','Y','Y',NOW(),NOW()),
((UUID()),'FB Messenger Notification','FB Messenger Notification','Y','Y',NOW(),NOW()),
((UUID()),'Time Air','Time Air','Y','Y',NOW(),NOW()),
((UUID()),'Periodical','Periodical','N','Y',NOW(),NOW()),
((UUID()),'Magazines','Magazines','N','Y',NOW(),NOW()),
((UUID()),'Radio','Radio','N','Y',NOW(),NOW()),
((UUID()),'TV','TV','N','Y',NOW(),NOW()),
((UUID()),'GYM','GYM','N','Y',NOW(),NOW()),
((UUID()),'CENTROS COMERCIALES','CENTROS COMERCIALES','N','Y',NOW(),NOW()),
((UUID()),'OOH','OOH','N','Y',NOW(),NOW());

#STATUSES
CREATE TABLE IF NOT EXISTS statuses (
id TINYINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
NAME VARCHAR(40) NOT NULL,
percent TINYINT NOT NULL,
DESCRIPTION TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN STATUSES TABLE
INSERT INTO statuses (NAME,percent,DESCRIPTION,is_active,created_at,updated_at) 
VALUES 
('Lost',0,'Lost','Y',NOW(),NOW()),
('Sent',25,'Sent','Y',NOW(),NOW()),
('In negociation',50,'In negociation','Y',NOW(),NOW()),
('Advanced Negociation',75,'Advanced Negociation','Y',NOW(),NOW()),
('Verbal approval',90,'Verbal approval','Y',NOW(),NOW()),
('Approved',100,'Approved','Y',NOW(),NOW());

#SALE MODELS
CREATE TABLE IF NOT EXISTS salemodels (
id VARCHAR(40) PRIMARY KEY NOT NULL,
NAME VARCHAR(40) NOT NULL,
DESCRIPTION TEXT,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN SALEMODELS TABLE
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES 
((UUID()),'CPM','CPM','Y','Y',NOW(),NOW()),
((UUID()),'CPC','CPC','Y','Y',NOW(),NOW()),
((UUID()),'CPA/CPS','CPA/CPS','Y','Y',NOW(),NOW()),
((UUID()),'CPL','CPL','Y','Y',NOW(),NOW()),
((UUID()),'Instalation','Instalation','Y','Y',NOW(),NOW()),
((UUID()),'Opening','Opening','Y','Y',NOW(),NOW()),
((UUID()),'Message','Message','Y','Y',NOW(),NOW()),
((UUID()),'CPV','CPV','Y','Y',NOW(),NOW()),
((UUID()),'SMS','SMS','Y','Y',NOW(),NOW()),
((UUID()),'MB','MB','Y','Y',NOW(),NOW()),
((UUID()),'Notification','Notification','Y','Y',NOW(),NOW()),
((UUID()),'CPE','CPE','Y','Y',NOW(),NOW()),
((UUID()),'CPE + SMS','CPE + SMS','Y','Y',NOW(),NOW()),
((UUID()),'Simple page','Simple page','N','Y',NOW(),NOW()),
((UUID()),'Double page','Double page','N','Y',NOW(),NOW()),
((UUID()),'Front page','Front page','N','Y',NOW(),NOW()),
((UUID()),'Back cover','Back cover','N','Y',NOW(),NOW()),
((UUID()),'20 seconds Spot','20 seconds Spot','N','Y',NOW(),NOW()),
((UUID()),'30 seconds Spot','30 seconds Spot','N','Y',NOW(),NOW()),
((UUID()),'Comercial','Comercial','N','Y',NOW(),NOW()),
((UUID()),'Billboard','Billboard','N','Y',NOW(),NOW()),
((UUID()),'Mupie','Mupie','N','Y',NOW(),NOW()),
((UUID()),'Digital Screen','Digital Screen','N','Y',NOW(),NOW()),
((UUID()),'Cartelera','Cartelera','N','Y',NOW(),NOW()),
((UUID()),'Vallas Moviles','Vallas Moviles','N','Y',NOW(),NOW()),
((UUID()),'Vallas Fijas','Vallas Fijas','N','Y',NOW(),NOW()),
((UUID()),'Activacion en Calle','Activacion en Calle','N','Y',NOW(),NOW()),
((UUID()),'Kiosko','Kiosko','N','Y',NOW(),NOW()),
((UUID()),'Cartelera Digital','Cartelera Digital','N','Y',NOW(),NOW()),
((UUID()),'Publiandantes','Publiandantes','N','Y',NOW(),NOW()),
((UUID()),'Publicidad en bar','Publicidad en bar','N','Y',NOW(),NOW()),
((UUID()),'Bajo Puentes','Bajo Puentes','N','Y',NOW(),NOW()),
((UUID()),'Muro','Muro','N','Y',NOW(),NOW()),
((UUID()),'Restaurantes','Restaurantes','N','Y',NOW(),NOW()),
((UUID()),'Pendones','Pendones','N','Y',NOW(),NOW()),
((UUID()),'Vitral Escalera','Vitral Escalera','N','Y',NOW(),NOW()),
((UUID()),'Activacion','Activacion','N','Y',NOW(),NOW()),
((UUID()),'Pluma Estacionamiento','Pluma Estacionamiento','N','Y',NOW(),NOW()),
((UUID()),'Mampara','Mampara','N','Y',NOW(),NOW()),
((UUID()),'Mall Rack','Mall Rack','N','Y',NOW(),NOW()),
((UUID()),'Banner Caminadora','Banner Caminadora','N','Y',NOW(),NOW()),
((UUID()),'Espejo','Espejo','N','Y',NOW(),NOW()),
((UUID()),'Espejo en baños','Espejo en baños','N','Y',NOW(),NOW()),
((UUID()),'Activacion Gym','Activacion Gym','N','Y',NOW(),NOW()),
((UUID()),'Pantallas','Pantallas','N','Y',NOW(),NOW());

# PROVIDERS
CREATE TABLE IF NOT EXISTS providers (
id VARCHAR(40) PRIMARY KEY NOT NULL,
NAME VARCHAR(40) NOT NULL UNIQUE,
address	TEXT,
webpage_url VARCHAR(200),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


# PROVIDERSXPRODUCT
CREATE TABLE IF NOT EXISTS providersxproduct (
id VARCHAR(40) PRIMARY KEY NOT NULL,
provider_id VARCHAR(40) NOT NULL,
product_id VARCHAR(40) NOT NULL,
salemodel_id VARCHAR(40),
product_price INTEGER,
currency VARCHAR(3),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


# VIEW PROVIDERS
CREATE VIEW view_providers AS (
	SELECT
	(pv.id) AS UUID,
	(pp.product_id) AS product_id,
	pd.name AS product_name,
	(pp.salemodel_id) AS salemodel_id,
	sm.name AS salemodel_name,
	pp.product_price / 100 AS product_price,
	pp.product_price AS product_price_int,
	pp.currency,
	pv.name,
	pv.webpage_url,
	pv.address,
	ct.id AS contact_provider_id,
	ct.contact_name,
	ct.contact_surname,
	ct.contact_email,
	ct.contact_position,
	ct.phone_international_code,
	ct.phone_prefix,
	ct.phone_number,
	CONCAT('+',ct.phone_international_code,ct.phone_prefix,ct.phone_number) AS phone,
	pv.is_active,
	CONCAT((pv.id),pd.name,sm.name,pv.name,pv.webpage_url,ct.contact_name,ct.contact_surname,ct.contact_email,'+',ct.phone_international_code,ct.phone_number) AS search
	FROM 
	providers pv
	LEFT JOIN providersxproduct pp ON pp.provider_id = pv.id
	LEFT JOIN products pd ON pd.id = pp.product_id
	LEFT JOIN salemodels sm ON sm.id = pp.salemodel_id
	LEFT JOIN contacts ct ON (ct.module_name = 'provider' AND ct.is_active='Y') AND (ct.contact_client_id = pv.id)
);

#PROPOSALS
CREATE TABLE IF NOT EXISTS proposals (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40) NOT NULL,
advertiser_id VARCHAR(40) NOT NULL,
agency_id VARCHAR(40),
contact_id VARCHAR(40),
status_id TINYINT NOT NULL,
offer_name VARCHAR(40) NOT NULL,
DESCRIPTION TEXT NOT NULL,
start_date DATETIME NOT NULL,
stop_date DATETIME NOT NULL,
is_pixel  ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# VIEW
CREATE TABLE IF NOT EXISTS viewpoints (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name VARCHAR(40) NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

INSERT INTO viewpoints (id,name,is_active,created_at,updated_at) 
VALUES 
(UUID(),'Frontal','Y',NOW(),NOW()),
(UUID(),'Cruzada','Y',NOW(),NOW()),
(UUID(),'Natural','Y',NOW(),NOW());

# BILLBOARD
CREATE TABLE IF NOT EXISTS billboards (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name_key VARCHAR(20) UNIQUE NOT NULL,
address TEXT,
state VARCHAR(20),
category VARCHAR(30) NOT NULL,
coordenates VARCHAR(40) NOT NULL,
latitud VARCHAR(40) NOT NULL,
longitud VARCHAR(40) NOT NULL,
price_int BIGINT NOT NULL,
cost_int BIGINT NOT NULL,
width INT NOT NULL,
height INT NOT NULL,
photo VARCHAR(200),
provider_id VARCHAR(40),
salemodel_id VARCHAR(40) NOT NULL,
viewpoint_id VARCHAR(40) NOT NULL,
is_iluminated ENUM('N','Y') NOT NULL,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
INDEX name_key_index (name_key)
);

# ADDING FK PROVIDER
ALTER TABLE `billboards`
    ADD CONSTRAINT `fk_provider` 
	FOREIGN KEY (`provider_id`)
    REFERENCES `providers` (`id`);

# ADDING FK SALE MODEL
ALTER TABLE `billboards`
    ADD CONSTRAINT `fk_salemodel` 
	FOREIGN KEY (`salemodel_id`)
    REFERENCES `salemodels` (`id`);

# ADDING FK VIEWPOINT
ALTER TABLE `billboards`
    ADD CONSTRAINT `fk_viewpoint` 
	FOREIGN KEY (`viewpoint_id`)
    REFERENCES `viewpoints` (`id`);


INSERT INTO billboard (id,name_key,address,state,category,coordenates,latitud,longitud,price_int,cost_int,width,height,photo,
provider_id,salemodel_id,viewpoint_id,is_iluminated, is_digital, is_active, created_at, updated_at) 
VALUES
(UUID(),'key','address','state','category','coordenates','latitud','longitud',price_int,cost_int,width,height,'photo',provider_id,salemodel_id,viewpoint_id,'is_iluminated','is_digital','Y',now(),now());


# VIEW BILLBOARDS
CREATE VIEW view_billboards AS 
(
	SELECT
	b.id as UUID,
	b.name_key as name,
	b.category as category,
	b.address as address,
	b.state as state,
	b.height / 100 as height,
	b.width / 100 as width,
	b.coordenates as coordenates,
	b.latitud as latitud,
	b.longitud as longitud,
	b.price_int as price_int,
	(b.price_int * 100) / 100 as price,
	b.cost_int as cost_int,
	(b.cost_int * 100) / 100 as cost,
	b.is_iluminated as is_iluminated,
	b.is_digital as is_digital,
	b.is_active as is_active,
	p.name as provider_name,
	sm.name as salemodel_name,
	sm.id as salemodel_id,
	vp.id as viewpoint_id,
	p.id as provider_id,
	vp.name as viewpoint_name,
	b.photo as photo,
    pb.proposalproduct_id as proposalproduct_id,
    pb.is_active as is_productbillboard_active,
	CONCAT(name_key,p.name,sm.name,vp.name,b.state,b.address) as search
	FROM billboards b
	INNER JOIN providers p ON b.provider_id = p.id
	INNER JOIN salemodels sm ON b.salemodel_id = sm.id
	INNER JOIN viewpoints vp ON b.viewpoint_id = vp.id
    LEFT JOIN productsxbillboards pb ON b.id = pb.billboard_id 
);



/*
     [i]['Tipo'] 			- product_id
     [i]['Clave'] 			- name_key 
     [i]['Dirección']		- address
     [i]['Estado']			- state
     [i]['Vista']			- viewpoint_id
     [i]['Base']			- width
     [i]['Alto']			- height
     [i]['Iluminación']		- is_iluminated
     [i]['Latitud']			- latitud
     [i]['Longitud']		- longitud
     [i]['Tarifa Publicada']- price
     [i]['Categoría (NSE)']	- category
     [i]['Renta']			- cost_int
     [i]['Proveedor']		- provider_id
*/


# PROPOSALS x PRODUCTS
CREATE TABLE IF NOT EXISTS proposalsxproducts (
id VARCHAR(40) PRIMARY KEY NOT NULL,
proposal_id VARCHAR(40),
product_id VARCHAR(40),
salemodel_id VARCHAR(40),
provider_id VARCHAR(40),
state VARCHAR(50),
price_int BIGINT,
currency VARCHAR(3) NOT NULL,
quantity INTEGER,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# PRODUCTS x BILLBOARDS
CREATE TABLE IF NOT EXISTS productsxbillboards (
id VARCHAR(40) PRIMARY KEY NOT NULL,
proposalproduct_id VARCHAR(40),
billboard_id VARCHAR(40),
price_int BIGINT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# VIEW PROPOSALS
CREATE VIEW view_proposals AS (
	SELECT
	(pps.id) AS UUID,
	ppp.id as proposalproduct_id,
	(ppp.product_id) AS product_id,
	pd.name AS product_name,
	(ppp.salemodel_id) AS salemodel_id,
	sm.name AS salemodel_name,
	(ppp.provider_id) AS provider_id,
	pv.name AS provider_name,
    ppp.state AS state,
	(pps.user_id) AS user_id,
	u.username,
	(pps.advertiser_id) AS client_id,
	adv.corporate_name AS client_name,
	(pps.agency_id) AS agency_id,
	age.corporate_name AS agency_name,
	pps.status_id,
	s.name AS status_name,
	s.percent AS status_percent,
	pps.offer_name,
	pps.description,
	pps.start_date,
	pps.stop_date,
	TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1 AS month_diff_data, 
	ppp.price_int / 100 AS price,
	ppp.price_int AS price_int,
	ppp.currency,
	ppp.quantity,
	c.rate AS rate,
	c.id AS currency_c,
	(ppp.price_int * ppp.quantity) AS amount_int,
	(ppp.price_int * ppp.quantity) / 100 AS amount,
	((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) AS amount_per_month_int,
	((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100 AS amount_per_month,
	CASE 
	WHEN c.id = 'USD' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate)
	) END  AS amount_USD_int,
	CASE
	WHEN c.id = 'USD' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate) / 100
	) END AS amount_USD,
	CASE
	WHEN c.id = 'USD' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) END AS amount_per_month_USD_int,
	CASE
	WHEN c.id = 'USD' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) END AS amount_per_month_USD,
	
	CASE
	WHEN c.id = 'MXN' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate)
	) END  AS amount_MXN_int,
	CASE
	WHEN c.id = 'MXN' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate) / 100
	) END AS amount_MXN,
	CASE
	WHEN c.id = 'MXN' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) END AS amount_per_month_MXN_int,
	CASE
	WHEN c.id = 'MXN' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) END AS amount_per_month_MXN,
	
	CASE
	WHEN c.id = 'BRL' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate)
	) END  AS amount_BRL_int,
	CASE
	WHEN c.id = 'BRL' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate) / 100
	) END AS amount_BRL,
	CASE
	WHEN c.id = 'BRL' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) END AS amount_per_month_BRL_int,
	CASE
	WHEN c.id = 'BRL' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) END AS amount_per_month_BRL,
	
	CASE
	WHEN c.id = 'EUR' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate)
	) END  AS amount_EUR_int,
	CASE
	WHEN c.id = 'EUR' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate) / 100
	) END AS amount_EUR,
	CASE
	WHEN c.id = 'EUR' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1))
	) END AS amount_per_month_EUR_int,
	CASE
	WHEN c.id = 'EUR' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100
	) END AS amount_per_month_EUR,
	pps.is_pixel,
	pps.is_active,
	b.id as billboard_id,
	b.name_key as billboard_name,
	b.height as billboard_height,
	b.width as billboard_width,
	smb.name as billboard_salemodel_name,
	pvb.name as billboard_provider_name,
	vp.name as billboard_viewpoint_name,
	(b.cost_int / 100) as billboard_cost,
	b.cost_int as billboard_cost_int,
	b.state as billboard_state,
	(pb.price_int / 100) as billboard_price,
	pb.price_int as billboard_price_int,
	pb.is_active as is_proposalbillboard_active,
	ppp.is_active as is_proposalproduct_active,
	CONCAT((pps.id),pd.name,sm.name,pv.name,u.username,adv.corporate_name,pps.offer_name,ppp.currency) AS search
	FROM 
	proposals pps
	LEFT JOIN proposalsxproducts ppp ON ppp.proposal_id = pps.id
	LEFT JOIN products pd ON pd.id = ppp.product_id
	LEFT JOIN productsxbillboards pb ON pb.proposalproduct_id = ppp.id 
	LEFT JOIN salemodels sm ON sm.id = ppp.salemodel_id
	LEFT JOIN providers pv ON pv.id = ppp.provider_id
	LEFT JOIN billboards b ON b.id = pb.billboard_id
	LEFT JOIN viewpoints vp ON vp.id = b.viewpoint_id
	LEFT JOIN salemodels smb ON smb.id = b.salemodel_id
	LEFT JOIN providers pvb ON pvb.id = b.provider_id
	INNER JOIN currencies c ON c.id = ppp.currency
	INNER JOIN currencies cusd ON cusd.id = 'USD'
	INNER JOIN currencies cmxn ON cmxn.id = 'MXN'
	INNER JOIN currencies cbrl ON cbrl.id = 'BRL'
	INNER JOIN currencies ceur ON ceur.id = 'EUR'
	INNER JOIN statuses s ON s.id = pps.status_id
	INNER JOIN users u ON u.id = pps.user_id
	INNER JOIN advertisers adv ON adv.id = pps.advertiser_id
	LEFT JOIN advertisers age ON age.id = pps.agency_id
);

# MODULES
CREATE TABLE modules (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name VARCHAR(20) NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# LOG HISTORY
CREATE TABLE loghistory (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40) NOT NULL,
module_name VARCHAR(20) NOT NULL,
description TEXT NOT NULL,
user_token VARCHAR(250) NOT NULL,
form_token VARCHAR(250),
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# TRANSLATES
CREATE TABLE translates (
id VARCHAR(40) PRIMARY KEY NOT NULL,
code_str VARCHAR(20) NOT NULL,
text_eng TEXT NOT NULL,
text_esp TEXT,
text_ptbr TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'only_admin', 'Only admin can select executive', 'Solamente gerentes pueden seleccionar ejecutivos', 'Apenas Administradores podem selecionar Executivos', 'Y', NOW(), NOW()),
(UUID(), 'offer_campaign', 'Offer / Campaign', 'Oferta / Campaña', 'Oferta / Campanha', 'Y', NOW(), NOW()),
(UUID(), 'advertiser', 'Advertiser', 'Cliente', 'Anunciante', 'Y', NOW(), NOW()),
(UUID(), 'assign_executive', 'Assign Executive', 'Ejecutivo', 'Executivo', 'Y', NOW(), NOW()),
(UUID(), 'amount', 'Amount', 'Monto', 'Valor total', 'Y', NOW(), NOW()),
(UUID(), 'monthly', 'Monthly', 'Mensual', 'Mensal', 'Y', NOW(), NOW()),
(UUID(), 'status', 'Status', 'Status', 'Status', 'Y', NOW(), NOW()),
(UUID(), 'settings', 'Settings', 'Configuraciones', 'configurações', 'Y', NOW(), NOW()),
(UUID(), 'list_of_proposals', 'List of Proposals / Goals', 'Lista de propuestas / Metas', 'Lista de propostas / Metas', 'Y', NOW(), NOW()),
(UUID(), 'goals_of_month', 'Goal of the month', 'Metas / Mes:', 'Metas / Mês', 'Y', NOW(), NOW()),
(UUID(), 'total_reached', 'Total Reached', 'Total Alcanzado', 'Total Alcançado', 'Y', NOW(), NOW()),
(UUID(), 'reached', 'Reached', 'Alcanzado', 'Alcançado', 'Y', NOW(), NOW()),
(UUID(), 'dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Y', NOW(), NOW()),
(UUID(), 'proposals', 'Proposals', 'Propuestas', 'Propostas', 'Y', NOW(), NOW()),
(UUID(), 'providers', 'Provider', 'Proveedor', 'Provedor', 'Y', NOW(), NOW()),
(UUID(), 'provider', 'Providers', 'Proveedores', 'Provedores', 'Y', NOW(), NOW()),
(UUID(), 'advertisers', 'Advertisers', 'Clientes', 'Anunciantes', 'Y', NOW(), NOW()),
(UUID(), 'user_settings', 'User Settings', 'Configuraciones', 'Configurações', 'Y', NOW(), NOW()),
(UUID(), 'profile', 'Profile', 'Perfil', 'Perfil', 'Y', NOW(), NOW()),
(UUID(), 'change_password', 'Change Password', 'Cambiar contraseña', 'Mudar Senha', 'Y', NOW(), NOW()),
(UUID(), 'users', 'Users', 'Usuários', 'Usuários', 'Y', NOW(), NOW()),
(UUID(), 'logout', 'Logout', 'Salir', 'Sair', 'Y', NOW(), NOW()),
(UUID(), 'lost', 'Lost', 'Perdido', 'Perdido', 'Y', NOW(), NOW()),
(UUID(), 'sent', 'Sent', 'Enviada', 'Enviada', 'Y', NOW(), NOW()),
(UUID(), 'in_negociation', 'In negociation', 'en negociación', 'Em negociação', 'Y', NOW(), NOW()),
(UUID(), 'advanced_negociation', 'Advanced negociation', 'Negociación avanzada', 'Negociação Avançada', 'Y', NOW(), NOW()),
(UUID(), 'verbal_approval', 'Verbal approval', 'Aprobación verbal', 'Aprovação verbal', 'Y', NOW(), NOW()),
(UUID(), 'approved', 'Approved', 'Aprobado', 'Aprovado', 'Y', NOW(), NOW()),
(UUID(), 'executive', 'Executive', 'Ejecutivo', 'Executivo', 'Y', NOW(), NOW()),
(UUID(), 'january', 'January', 'Enero', 'Janeiro', 'Y', NOW(), NOW()),
(UUID(), 'february', 'February', 'Febrero', 'Fevereiro', 'Y', NOW(), NOW()),
(UUID(), 'march', 'March', 'Marzo', 'Março', 'Y', NOW(), NOW()),
(UUID(), 'april', 'April', 'Abril', 'Abril', 'Y', NOW(), NOW()),
(UUID(), 'may', 'May', 'Mayo', 'Maio', 'Y', NOW(), NOW()),
(UUID(), 'june', 'June', 'Junio', 'Junho', 'Y', NOW(), NOW()),
(UUID(), 'july', 'July', 'Julio', 'Julho', 'Y', NOW(), NOW()),
(UUID(), 'august', 'August', 'Agosto', 'Agosto', 'Y', NOW(), NOW()),
(UUID(), 'september', 'September', 'Septiembre', 'Setembro', 'Y', NOW(), NOW()),
(UUID(), 'octuber', 'Octuber', 'Octubre', 'Outubro', 'Y', NOW(), NOW()),
(UUID(), 'november', 'November', 'Noviembre', 'Novembro', 'Y', NOW(), NOW()),
(UUID(), 'december', 'December', 'Diciembre', 'Dezembro', 'Y', NOW(), NOW()),
(UUID(), 'client', 'Client', 'Cliente', 'Cliente', 'Y', NOW(), NOW()),
(UUID(), 'agency', 'Agency', 'Agencia', 'Agência', 'Y', NOW(), NOW()),
(UUID(), 'offer_name', 'Offer Name', 'Nombre de la campaña', 'Nome da Campanha', 'Y', NOW(), NOW()),
(UUID(), 'description', 'Description', 'Descripción', 'Descrição', 'Y', NOW(), NOW()),
(UUID(), 'start_date', 'Start date', 'Fecha início', 'Data inicial', 'Y', NOW(), NOW()),
(UUID(), 'stop_date', 'Stop date', 'Fecha final', 'Data final', 'Y', NOW(), NOW()),
(UUID(), 'products', 'Products', 'Productos', 'Produtos', 'Y', NOW(), NOW()),
(UUID(), 'product', 'Product', 'Producto', 'Produto', 'Y', NOW(), NOW()),
(UUID(), 'sale_model', 'Sale model', 'Modelo de venta', 'Modelo de venda', 'Y', NOW(), NOW()),
(UUID(), 'digital_product', 'Digital Product', 'Producto Digital', 'Produto Digital', 'Y', NOW(), NOW()),
(UUID(), 'currency', 'Currency', 'Moneda', 'Moeda', 'Y', NOW(), NOW()),
(UUID(), 'unit_price', 'Unit Price', 'Precio Unitario', 'Preço Unitário', 'Y', NOW(), NOW()),
(UUID(), 'quantity', 'Quantity', 'Cantidad', 'Quantidade', 'Y', NOW(), NOW()),
(UUID(), 'total', 'Total', 'Total', 'Total', 'Y', NOW(), NOW()),
(UUID(), 'save', 'Save', 'Ahorrar', 'Salvar', 'Y', NOW(), NOW()),
(UUID(), 'pixel_required', 'Pixel required', 'Píxel requerido', 'Pixel requerido', 'Y', NOW(), NOW()),
(UUID(), 'proposal', 'Proposal', 'Propuesta', 'Proposta', 'Y', NOW(), NOW()),
(UUID(), 'new', 'New', 'Generando', 'Gerando', 'Y', NOW(), NOW()),
(UUID(), 'please_select', 'Please, select ', 'Por favor, seleccione ', 'Por favor, escolha ', 'Y', NOW(), NOW()),
(UUID(), 'offer_campaign', 'Offer / Campaign', 'Oferta / Campaña', 'Campanha', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'add', 'New', 'Añadir', 'Adicionar', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'billboard', 'Billboard', 'Cartelera', 'Painel', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'dimensions', 'Dimensions', 'Dimensiones', 'Dimensões', 'Y', NOW(), NOW()),
(UUID(), 'viewpoint', 'View', 'Vista', 'Visão', 'Y', NOW(), NOW()),
(UUID(), 'key', 'Key', 'Clave', 'Chave', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'state', 'State', 'Estado', 'UF', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'upload', 'Upload Invoices', 'Ingressar Facturas', 'Upload de Invoices', 'Y', NOW(), NOW()),
(UUID(), 'upload_files', 'Upload Files', 'Subir Archivos', 'Upload de Arquivos', 'Y', NOW(), NOW()),
(UUID(), 'month', 'Month', 'Mês', 'Mês', 'Y', NOW(), NOW()),
(UUID(), 'search', 'Search', 'Buscar', 'Buscar', 'Y', NOW(), NOW()),
(UUID(), 'payed_at', 'Payed at', 'Fecha de pago', 'Data de Pagamento', 'Y', NOW(), NOW());
(UUID(), 'choose', 'Choose', 'Elejir', 'Escolha', 'Y', NOW(), NOW()),
(UUID(), 'invoice_file', 'Invoice file', 'archivo de Facturación', 'arquivo de Fatura', 'Y', NOW(), NOW()),
(UUID(), 'po_file', 'Purchase Order file', 'archivo de Orden de Compra', 'arquivo de Ordem de Compra', 'Y', NOW(), NOW()),
(UUID(), 'report_file', 'Report file', 'archivo de Report', 'arquivo de Relatório', 'Y', NOW(), NOW()),
(UUID(), 'presentation_file', 'Presentation file', 'archivo de Presentación', 'arquivo de Apresentação', 'Y', NOW(), NOW()),
(UUID(), 'username', 'User Name', 'Nombre del usuario', 'Usuario', 'Y', NOW(), NOW()),
(UUID(), 'email', 'E-Mail', 'Correo', 'Email', 'Y', NOW(), NOW()),
(UUID(), 'mobile_number', 'Mobile Number', 'Teléfono Mobile', 'Celular', 'Y', NOW(), NOW()),
(UUID(), 'password', 'Password', 'Contraseña', 'Senha', 'Y', NOW(), NOW()),
(UUID(), 'retype', 'Retype', 'Volver a escribir', 'Redigite', 'Y', NOW(), NOW()),
(UUID(), 'areacode', 'Area Code', 'Código de AREA', 'Código de Área', 'Y', NOW(), NOW()),
(UUID(), 'number', 'Number', 'Numero', 'Numero', 'Y', NOW(), NOW()),
(UUID(), 'user', 'User', 'Usuario', 'Usuário', 'Y', NOW(), NOW()),
(UUID(), 'offer', 'Offer', 'Campaña', 'Campanha', 'Y', NOW(), NOW()),
(UUID(), 'phone_number', 'Phone Number', 'Teléfono', 'Telefone', 'Y', NOW(), NOW()),
(UUID(), 'product', 'Product', 'Producto', 'Produto', 'Y', NOW(), NOW()),
(UUID(), 'any_to_select', 'Any', 'No hay', 'Nenhum', 'Y', NOW(), NOW()),
(UUID(), 'to_select', 'enable to select', 'disponible para seleccionar', 'disponível para selecionar', 'Y', NOW(), NOW()),
(UUID(), 'files', 'Files', 'Archivos', 'Arquivos', 'Y', NOW(), NOW());


# FILES
CREATE TABLE IF NOT EXISTS files (
id VARCHAR(40) PRIMARY KEY NOT NULL,
file_location VARCHAR(240) NOT NULL,
file_name VARCHAR(240) NOT NULL,
file_type VARCHAR(40) NOT NULL,
invoice_id VARCHAR(40),
user_id VARCHAR(40) NOT NULL,
description TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INVOICES
CREATE TABLE IF NOT EXISTS invoices (
id VARCHAR(40) PRIMARY KEY NOT NULL,
provider_id VARCHAR(40) NOT NULL,
invoice_month VARCHAR(2) NOT NULL,
invoice_year VARCHAR(4) NOT NULL,
proposalproduct_id VARCHAR(40),
invoice_status VARCHAR(200),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# ADDING FK USER
ALTER TABLE files
    ADD CONSTRAINT fk_user 
	FOREIGN KEY (user_id)
    REFERENCES users (id);

# ADDING FK INVOICE
ALTER TABLE files
    ADD CONSTRAINT fk_invoice 
	FOREIGN KEY (invoice_id)
    REFERENCES invoices (id);


# ADDING FK PROPOSALPRODUCT
ALTER TABLE invoices
    ADD CONSTRAINT fk_proposalproduct 
	FOREIGN KEY (proposalproduct_id)
    REFERENCES proposalsxproducts (id);

# ADDING FK PROVIDER
ALTER TABLE invoices
    ADD CONSTRAINT fk_providerInvoice 
	FOREIGN KEY (provider_id)
    REFERENCES providers (id);

# VIEW CREATION_USER_PROVIDER
CREATE VIEW view_full_profiles_data AS (
SELECT 
c.id as contact_id,
c.module_name as contact_module_name,
c.contact_email as contact_email,
c.contact_client_id as contact_client_id,
p.id as provider_id,
a.id as advertiser_id,
c.contact_name as contact_name,
c.contact_surname as contact_surname,
c.contact_position as contact_position,
c.is_active as contact_is_active,
p.name as provider_name,
a.corporate_name as advertiser_name,
p.is_active as provider_is_active,
a.is_active as advertiser_is_active,
u.username as username, 
u.user_language as user_language, 
u.email as user_email, 
u.level_account as user_level_account, 
u.user_type as user_type,
u.mobile_international_code as user_international_code, 
u.mobile_number as user_mobile_number, 
u.authentication_string as authentication_string,
c.phone_international_code as contact_international_code,
c.phone_number as contact_phone_number,
u.token as user_token, 
u.account_locked as user_locked_status,
pf.photo as profile_photo,
pf.aboutme as profile_aboutme,
pf.country as profile_country,
u.id as user_id
FROM 
contacts c 
LEFT JOIN providers p ON (p.id = c.contact_client_id AND c.module_name = 'provider')
LEFT JOIN advertisers a ON (a.id = c.contact_client_id AND c.module_name = 'advertiser')
LEFT JOIN users u ON c.contact_email = u.email
LEFT JOIN profiles pf ON pf.user_id = u.id
);