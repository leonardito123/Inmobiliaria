-- Seed: 003_testimonials.sql

INSERT IGNORE INTO `testimonials`
  (`author_name`, `author_title`, `body`, `rating`, `country_code`, `active`)
VALUES
('Ricardo Montoya',  'Director de Inversiones · CDMX',        'HAVRE ESTATES nos ayudó a encontrar el penthouse perfecto en Reforma. Proceso impecable y atención de primer nivel.',                         5, 'MX', 1),
('Ana Lucía Torres', 'Empresaria · Guadalajara',              'La calculadora de hipoteca me permitió planificar mi inversión con total claridad. Encontré mi casa en menos de dos semanas.',               5, 'MX', 1),
('Camilo Ospina',    'Arquitecto · Medellín',                 'El equipo de HAVRE en Medellín conoce el mercado como nadie. Vendí mi loft en Laureles al precio justo en tiempo récord.',                  5, 'CO', 1),
('Isabella Vargas',  'Consultora Financiera · Bogotá',        'Excelente plataforma. Los filtros de búsqueda y el mapa interactivo me ahorraron horas de búsqueda. Muy recomendable.',                     5, 'CO', 1),
('Matías Sánchez',   'Emprendedor · Santiago',                'El departamento en Vitacura superó todas mis expectativas. La atención personalizada y el seguimiento post-compra fueron extraordinarios.',  5, 'CL', 1),
('Francisca Riquelme','Diseñadora Interior · Las Condes',     'Rápido, transparente y con propiedades de altísima calidad. Definitivamente la mejor opción para inversión inmobiliaria en Chile.',         5, 'CL', 1);
