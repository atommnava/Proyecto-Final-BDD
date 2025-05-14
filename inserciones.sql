INSERT INTO eventos_pf (nombre, fechaInicio, fechaFinal, ubicacion, descripcion) VALUES
('Conferencia de Tecnología', '2025-11-15', '2025-11-17', 'Centro de Convenciones CDMX', 'Evento anual sobre las últimas tendencias tecnológicas'),
('Festival de Cine', '2025-12-01', '2025-12-10', 'Cineteca Nacional', 'Exhibición de películas internacionales'),
('Congreso de Medicina', '2025-02-20', '2025-02-23', 'Hotel Sheraton', 'Avances en investigación médica'),
('Feria del Libro', '2025-04-05', '2025-04-15', 'Palacio de Minería', 'Presentación de nuevos libros y autores'),
('Seminario de Marketing', '2025-05-10', '2025-05-12', 'Centro Banamex', 'Estrategias de marketing digital');


—---------------------------------------------------------------------------------------------------------------------


INSERT INTO actividades_pf (idEvento, nombre, hora, fecha, sala) VALUES
(1, 'Inteligencia Artificial', '10:00:00', '2025-11-15', 101),
(1, 'Blockchain', '14:00:00', '2025-11-15', 102),
(1, 'Realidad Virtual', '16:00:00', '2025-11-16', 103),
(2, 'Proyección: El viaje', '18:00:00', '2025-12-03', 5),
(2, 'Q&A con directores', '20:00:00', '2025-12-05', 3),
(3, 'Avances en Oncología', '09:00:00', '2025-02-21', 201),
(4, 'Firma de libros', '12:00:00', '2025-04-08', 10),
(5, 'Redes Sociales', '11:00:00', '2025-05-11', 301);


—-------------------------------------------------------------------------------------------------------


INSERT INTO presentadores_pf (nombre, especializacion, ocupacion) VALUES
('Dr. Alejandro Ruiz', 'Inteligencia Artificial', 'Investigador en Google'),
('Dra. Sofía Mendoza', 'Blockchain', 'CEO de CryptoMex'),
('Lic. Roberto Jiménez', 'Realidad Virtual', 'Desarrollador en Meta'),
('Cineasta Luis Torres', 'Cine', 'Director de cine independiente'),
('Dr. Patricia Navarro', 'Oncología', 'Oncóloga en Hospital ABC'),
('Escritor Jorge Cruz', 'Literatura', 'Autor bestseller'),
('Lic. Adriana Gómez', 'Marketing Digital', 'Consultora en SocialMediaPro');


—-----------------------------------------------------------


INSERT INTO inscripciones_pf (idUsuario, idEvento, fechaInscripcion) VALUES
(9, 2, '2025-11-28');


—------------------------------------------------


INSERT INTO asistencias_pf (idUsuario, idActividad, fechaAsistencia) VALUES
(7, 2, '2025-11-15');




—-----------------------------------------------------------------------


INSERT INTO usuarios_pf (nombre, correo, contrasenia, tipo) VALUES
('Laura Fernández', 'laura@example.com', 'laura2025', 'u'),
('Diego Ramírez', 'diego@example.com', 'diego456', 'u'),
('Admin Secundario', 'admin2@example.com', 'admin2025', 'a'),
('Mónica Vázquez', 'monica@example.com', 'monica789', 'u');


—---------------------------------------------------------


INSERT INTO asistentes_pf (idUsuario, matricula, carrera) VALUES
(1, 'TISC2025001', 'Tecnologías de la Información'),
(2, 'MEDC2025002', 'Medicina'),
(4, 'LITC2025003', 'Literatura Creativa'),
(5, 'CINM2025004', 'Cine y Medios Digitales'),
(7, 'MARK2025005', 'Mercadotecnia Digital'),
(8, 'ARQD2025006', 'Arquitectura Digital');


—-------------------------------------------------------------


INSERT INTO actividades_presentadores_pf (idActividad, idPresentador) VALUES
(1, 1),   
(2, 2),  
(3, 3),   
(4, 4),   
(5, 4),   
(6, 5),  
(7, 6),   
(8, 7);
