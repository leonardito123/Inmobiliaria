-- Seed: 002_agents.sql

INSERT IGNORE INTO `agents`
  (`name`, `email`, `phone`, `bio`, `country_code`, `languages`, `specialties`, `active`)
VALUES
('Sofía Martínez',  'sofia@havre-estates.com',  '+52 55 1234 5678', 'Especialista en propiedades de lujo en CDMX con 8 años de experiencia.',    'MX', '["es","en"]',      '["venta","desarrollo"]', 1),
('Diego Ramírez',   'diego@havre-estates.com',  '+52 55 8765 4321', 'Experto en renta vacacional y propiedades de inversión en México.',          'MX', '["es","en","fr"]', '["renta","venta"]',      1),
('Valentina Gómez', 'vale@havre-estates.com',   '+57 1 234 5678',   'Asesora certificada en el mercado inmobiliario de Medellín y Bogotá.',       'CO', '["es","en"]',      '["venta","renta"]',      1),
('Andrés Herrera',  'andres@havre-estates.com', '+57 300 123 4567', 'Experto en desarrollos y preventas en Colombia.',                           'CO', '["es"]',            '["desarrollo","venta"]', 1),
('Catalina Ruiz',   'cata@havre-estates.com',   '+56 9 1234 5678',  'Especialista en propiedades premium en Santiago con enfoque en Las Condes.', 'CL', '["es","en"]',      '["venta","renta"]',      1);
