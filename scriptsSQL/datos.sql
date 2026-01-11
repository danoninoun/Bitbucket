≥	-- 1. Insertamos las provincias
≥	INSERT INTO provincias (nombre) VALUES 
≥	('Madrid'),      -- ID 1
≥	('Barcelona'),   -- ID 2
≥	('Sevilla'),     -- ID 3
≥	('Valencia'),    -- ID 4
≥	('Zaragoza'),    -- ID 5
≥	('Málaga');      -- ID 6
≥	
≥	-- 2. Insertamos los departamentos
≥	INSERT INTO departamentos (nombre) VALUES 
≥	('Tecnología e Informática'),
≥	('Recursos Humanos'),
≥	('Contabilidad y Finanzas'),
≥	('Marketing y Ventas'),
≥	('Logística');
≥	
≥	-- 3. Insertamos las sedes
≥	-- Nota: La BBDD exige indicar la provincia (id_provincia). 
≥	INSERT INTO sedes (nombre, id_provincia) VALUES 
≥	('Sede Central', 1),       -- Madrid
≥	('Delegación Norte', 2),   -- Barcelona
≥	('Delegación Sur', 3),     -- Sevilla
≥	('Delegación Este', 4);    -- Valencia
