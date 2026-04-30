-- Datos de prueba para propiedades
INSERT INTO properties (slug, type, country_code, city, price, currency, bedrooms, bathrooms, sqm, status, featured, meta_title, meta_desc) VALUES
('penthouse-reforma-mx', 'venta', 'MX', 'CDMX', 8500000, 'MXN', 4, 3, 380, 'available', 1, 'Penthouse Reforma Premium', 'Lujoso penthouse en la Avenida Reforma, 380m² con vistas panorámicas'),
('dpto-polanco-mx', 'venta', 'MX', 'CDMX', 5200000, 'MXN', 3, 2, 280, 'available', 0, 'Departamento Polanco', 'Elegante departamento en el corazón de Polanco'),
('casa-lomas-mx', 'venta', 'MX', 'CDMX', 12000000, 'MXN', 5, 4, 550, 'available', 1, 'Casa Lomas', 'Casa de ensueño en Lomas de Chapultepec con alberca'),
('apto-sabaneta-co', 'venta', 'CO', 'Medellín', 650000000, 'COP', 3, 2, 160, 'available', 0, 'Apartamento Sabaneta', 'Moderno apartamento en la zona de Sabaneta'),
('loft-laureles-co', 'venta', 'CO', 'Medellín', 450000000, 'COP', 2, 1, 120, 'available', 1, 'Loft Laureles', 'Loft contemporáneo en el corazón de Laureles'),
('casa-las-condes-cl', 'venta', 'CL', 'Santiago', 950000000, 'CLP', 4, 3, 320, 'available', 0, 'Casa Las Condes', 'Residencia familiar en la exclusiva comuna de Las Condes'),
('depto-ñuñoa-cl', 'venta', 'CL', 'Santiago', 480000000, 'CLP', 3, 2, 150, 'available', 1, 'Departamento Ñuñoa', 'Cómodo departamento en la tradicional Ñuñoa'),
('depto-santa-lucia-mx', 'venta', 'MX', 'Monterrey', 3500000, 'MXN', 3, 2, 220, 'available', 0, 'Apartamento Santa Lucia', 'Bonito departamento en la moderna Santa Lucia'),
('casa-residencial-mx', 'venta', 'MX', 'Guadalajara', 2800000, 'MXN', 4, 3, 300, 'available', 1, 'Casa Residencial Guadalajara', 'Casa familiar en residencial de Guadalajara'),
('loft-centro-co', 'venta', 'CO', 'Bogotá', 800000000, 'COP', 2, 1, 140, 'available', 0, 'Loft Centro Bogotá', 'Moderno loft en el centro de Bogotá'),
('apto-vitacura-cl', 'venta', 'CL', 'Santiago', 1200000000, 'CLP', 4, 3, 280, 'available', 1, 'Apartamento Vitacura', 'Lujoso apartamento en la avenida Providencia'),
('suite-reforma-mx', 'venta', 'MX', 'CDMX', 6500000, 'MXN', 3, 3, 320, 'available', 0, 'Suite Reforma', 'Elegante suite con terraza en Reforma');

-- Datos de prueba para renta
INSERT IGNORE INTO properties (slug, type, country_code, city, price, currency, bedrooms, bathrooms, sqm, status, featured, meta_title, meta_desc) VALUES
('renta-loft-roma-mx', 'renta', 'MX', 'CDMX', 38000, 'MXN', 2, 2, 110, 'available', 1, 'Loft Roma Norte', 'Loft amueblado con terraza en Roma Norte'),
('renta-condesa-mx', 'renta', 'MX', 'CDMX', 45000, 'MXN', 3, 2, 145, 'available', 0, 'Departamento Condesa', 'Departamento amplio cerca de parques y restaurantes'),
('renta-poblado-co', 'renta', 'CO', 'Medellín', 5200000, 'COP', 2, 2, 130, 'available', 1, 'Suite El Poblado', 'Suite ejecutiva con vistas panorámicas'),
('renta-providencia-cl', 'renta', 'CL', 'Santiago', 1600000, 'CLP', 2, 1, 95, 'available', 0, 'Depto Providencia', 'Departamento moderno en Providencia'),
('renta-zapopan-mx', 'renta', 'MX', 'Guadalajara', 29000, 'MXN', 3, 3, 170, 'available', 0, 'Casa Zapopan', 'Casa familiar con jardín en zona residencial');

-- Datos de prueba para desarrollos
INSERT IGNORE INTO properties (slug, type, country_code, city, price, currency, bedrooms, bathrooms, sqm, status, featured, meta_title, meta_desc) VALUES
('desarrollo-nova-polanco-mx', 'desarrollo', 'MX', 'CDMX', 4200000, 'MXN', 2, 2, 115, 'available', 1, 'Nova Polanco Residences', 'Desarrollo vertical de lujo en Polanco'),
('desarrollo-rio-verde-co', 'desarrollo', 'CO', 'Medellín', 780000000, 'COP', 3, 2, 148, 'available', 0, 'Río Verde Living', 'Proyecto de uso mixto con amenidades premium'),
('desarrollo-andes-view-cl', 'desarrollo', 'CL', 'Santiago', 690000000, 'CLP', 2, 2, 122, 'available', 1, 'Andes View Suites', 'Complejo residencial con vista a la cordillera');
