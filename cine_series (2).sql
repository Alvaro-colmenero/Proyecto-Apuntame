-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2026 a las 13:36:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cine_series`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amistades`
--

CREATE TABLE `amistades` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `amigo_id` int(11) NOT NULL,
  `estado` enum('pendiente','aceptada','rechazada') NOT NULL DEFAULT 'pendiente',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_respuesta` datetime DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `amistades`
--

INSERT INTO `amistades` (`id`, `usuario_id`, `amigo_id`, `estado`, `fecha`, `fecha_respuesta`) VALUES
(1, 1, 2, 'aceptada', '2026-10-09 10:00:25', '2025-01-05 12:00:00'),
(2, 1, 3, 'pendiente', '2026-10-09 10:00:25', NULL),
(3, 2, 4, 'aceptada', '2026-10-09 10:00:25', '2025-02-01 10:00:00'),
(4, 4, 1, 'rechazada', '2026-10-09 10:00:25', '2025-02-03 09:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca`
--

CREATE TABLE `biblioteca` (
  `usuario_id` int(11) NOT NULL,
  `contenido_id` int(11) NOT NULL,
  `estado` enum('pendiente','viendo','vista','pausada','abandonada') NOT NULL DEFAULT 'pendiente',
  `puntuacion` decimal(3,1) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `notas` text DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `biblioteca`
--

INSERT INTO `biblioteca` (`usuario_id`, `contenido_id`, `estado`, `puntuacion`, `fecha_inicio`, `fecha_fin`, `notas`) VALUES
(1, 1, 'vista', 9.5, '2025-01-10', '2025-01-10', 'Final impresionante'),
(1, 4, 'pendiente', NULL, NULL, NULL, NULL),
(1, 7, 'vista', 10.0, '2025-01-15', '2025-03-20', 'Una de mis favoritas'),
(1, 8, 'viendo', 8.5, '2025-02-01', NULL, 'Voy por la primera temporada'),
(1, 12, 'pausada', 8.0, '2025-02-10', NULL, 'La retomaré'),
(2, 2, 'vista', 8.5, '2025-01-12', '2025-01-12', NULL),
(2, 3, 'vista', 9.0, '2025-01-05', '2025-01-05', 'Un clásico'),
(2, 9, 'viendo', 9.0, '2025-02-15', NULL, 'Ideal para desconectar'),
(2, 11, 'pendiente', NULL, NULL, NULL, NULL),
(3, 5, 'vista', 9.0, '2025-02-02', '2025-02-02', NULL),
(3, 6, 'pendiente', NULL, NULL, NULL, NULL),
(3, 7, 'viendo', 9.0, '2025-03-01', NULL, NULL),
(3, 10, 'vista', 9.5, '2025-01-20', '2025-02-01', 'Gran animación'),
(4, 4, 'vista', 8.0, '2025-01-03', '2025-01-03', 'Me trae recuerdos'),
(4, 8, 'abandonada', 6.0, '2025-01-10', NULL, 'La dejé a medias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `tipo` enum('pelicula','serie') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `banner` varchar(150) DEFAULT NULL,
  `estado_serie` enum('en_emision','finalizada','cancelada','desconocido') NOT NULL DEFAULT 'desconocido',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`id`, `titulo`, `tipo`, `descripcion`, `fecha_estreno`, `duracion`, `poster`, `banner`, `estado_serie`, `fecha_creacion`) VALUES
(1, 'Interstellar', 'pelicula', 'Viaje espacial y supervivencia humana.', '2014-11-07', 169, 'images/posters/interstellar.jpg', 'images/banners/interstellar.jpg', 'desconocido', '2026-10-09 10:00:24'),
(2, 'Origen', 'pelicula', 'Un equipo entra en los sueños de otras personas.', '2010-07-16', 148, 'images/posters/origen.jpg', 'images/banners/origen.jpg', 'desconocido', '2026-10-09 10:00:24'),
(3, 'Matrix', 'pelicula', 'Un hacker descubre que la realidad no es lo que parece.', '1999-03-31', 136, 'images/posters/matrix.jpg', 'images/banners/matrix.jpg', 'desconocido', '2026-10-09 10:00:24'),
(4, 'Toy Story', 'pelicula', 'Los juguetes cobran vida cuando nadie los ve.', '1995-11-22', 81, 'images/posters/toy_story.jpg', 'images/banners/toy_story.jpg', 'desconocido', '2026-10-09 10:00:24'),
(5, 'El viaje de Chihiro', 'pelicula', 'Una niña entra en un mundo mágico.', '2001-07-20', 125, 'images/posters/el_viaje_de_chihiro.jpg', 'images/banners/el_viaje_de_chihiro.jpg', 'desconocido', '2026-10-09 10:00:24'),
(6, 'El Señor de los Anillos: La Comunidad del Anillo', 'pelicula', 'Un grupo emprende una misión para destruir un anillo.', '2001-12-19', 178, 'images/posters/la_comunidad_del_anillo.jpg', 'images/banners/la_comunidad_del_anillo.jpg', 'desconocido', '2026-10-09 10:00:24'),
(7, 'Breaking Bad', 'serie', 'Un profesor de química comienza a fabricar drogas.', '2008-01-20', NULL, 'images/posters/breaking-bad.jpg', 'images/banners/breaking-bad.jpg', 'finalizada', '2026-10-09 10:00:24'),
(8, 'Stranger Things', 'serie', 'Un grupo de amigos investiga sucesos sobrenaturales.', '2016-07-15', NULL, 'images/posters/stranger_things.jpg', 'images/banners/stranger_things.jpg', 'finalizada', '2026-10-09 10:00:24'),
(9, 'The Office', 'serie', 'La vida cotidiana de los empleados de una oficina.', '2005-03-24', NULL, 'images/posters/the_office.jpg', 'images/banners/the_office.jpg', 'finalizada', '2026-10-09 10:00:24'),
(10, 'Arcane', 'serie', 'Dos hermanas viven en ciudades enfrentadas.', '2021-11-06', NULL, 'images/posters/arcane.jpg', 'images/banners/arcane.jpg', 'finalizada', '2026-10-09 10:00:24'),
(11, 'The Last of Us', 'serie', 'Un hombre y una joven atraviesan un mundo devastado.', '2023-01-15', NULL, 'images/posters/the_last_of_us.jpg', 'images/banners/the_last_of_us.jpg', 'desconocido', '2026-10-09 10:00:24'),
(12, 'Sherlock', 'serie', 'Un detective brillante resuelve casos complejos.', '2010-07-25', NULL, 'images/posters/sherlock.jpg', 'images/banners/sherlock.jpg', 'finalizada', '2026-10-09 10:00:24'),
(13, 'Dune', 'pelicula', 'Un joven noble debe sobrevivir en un planeta desértico lleno de peligros.', '2021-10-22', 155, 'images/posters/dune.jpg', 'images/banners/dune.jpg', 'desconocido', '2026-10-09 08:00:24'),
(14, 'Pulp Fiction', 'pelicula', 'Varias historias criminales se entrelazan en Los Ángeles.', '1994-10-14', 154, 'images/posters/pulp_fiction.jpg', 'images/banners/pulp_fiction.jpg', 'desconocido', '2026-10-09 08:00:24'),
(15, 'Gladiator', 'pelicula', 'Un general romano busca venganza tras ser traicionado.', '2000-05-05', 155, 'images/posters/gladiator.jpg', 'images/banners/gladiator.jpg', 'desconocido', '2026-10-09 08:00:24'),
(16, 'Titanic', 'pelicula', 'Dos jóvenes se enamoran durante el viaje inaugural del Titanic.', '1997-12-19', 195, 'images/posters/titanic.jpg', 'images/banners/titanic.jpg', 'desconocido', '2026-10-09 08:00:24'),
(17, 'Jurassic Park', 'pelicula', 'Un parque de dinosaurios clonados se convierte en una amenaza.', '1993-06-11', 127, 'images/posters/jurassic_park.jpg', 'images/banners/jurassic_park.jpg', 'desconocido', '2026-10-09 08:00:24'),
(18, 'Avatar', 'pelicula', 'Un exmarine descubre un mundo alienígena y su pueblo nativo.', '2009-12-18', 162, 'images/posters/avatar.jpg', 'images/banners/avatar.jpg', 'desconocido', '2026-10-09 08:00:24'),
(19, 'Coco', 'pelicula', 'Un niño apasionado por la música descubre el mundo de sus antepasados.', '2017-11-22', 105, 'images/posters/coco.jpg', 'images/banners/coco.jpg', 'desconocido', '2026-10-09 08:00:24'),
(20, 'Whiplash', 'pelicula', 'Un joven batería soporta una exigente formación musical.', '2014-10-10', 106, 'images/posters/whiplash.jpg', 'images/banners/whiplash.jpg', 'desconocido', '2026-10-09 08:00:24'),
(21, 'El caballero oscuro', 'pelicula', 'Batman se enfrenta al Joker, un criminal que amenaza Gotham.', '2008-07-18', 152, 'images/posters/el_caballero_oscuro.jpg', 'images/banners/el_caballero_oscuro.jpg', 'desconocido', '2026-10-09 08:00:24'),
(22, 'Regreso al futuro', 'pelicula', 'Un adolescente viaja al pasado con una máquina del tiempo.', '1985-07-03', 116, 'images/posters/regreso_al_futuro.jpg', 'images/banners/regreso_al_futuro.jpg', 'desconocido', '2026-10-09 08:00:24'),
(23, 'Better Call Saul', 'serie', 'Un abogado intenta abrirse camino en el mundo legal y criminal.', '2015-02-08', NULL, 'images/posters/better_call_saul.jpg', 'images/banners/better_call_saul.jpg', 'finalizada', '2026-10-09 08:00:24'),
(24, 'Dark', 'serie', 'La desaparición de un niño revela secretos entre varias familias.', '2017-12-01', NULL, 'images/posters/dark.jpg', 'images/banners/dark.jpg', 'finalizada', '2026-10-09 08:00:24'),
(25, 'The Mandalorian', 'serie', 'Un cazarrecompensas recorre la galaxia mientras protege a un misterioso niño.', '2019-11-12', NULL, 'images/posters/the_mandalorian.jpg', 'images/banners/the_mandalorian.jpg', 'desconocido', '2026-10-09 08:00:24'),
(26, 'Peaky Blinders', 'serie', 'Una familia criminal gana poder en la Inglaterra de posguerra.', '2013-09-12', NULL, 'images/posters/peaky_blinders.jpg', 'images/banners/peaky_blinders.jpg', 'finalizada', '2026-10-09 08:00:24'),
(27, 'The Crown', 'serie', 'La vida de Isabel II y los acontecimientos de la familia real británica.', '2016-11-04', NULL, 'images/posters/the_crown.jpg', 'images/banners/the_crown.jpg', 'finalizada', '2026-10-09 08:00:24'),
(28, 'The Boys', 'serie', 'Un grupo de vigilantes intenta desenmascarar a superhéroes corruptos.', '2019-07-26', NULL, 'images/posters/the_boys.jpg', 'images/banners/the_boys.jpg', 'desconocido', '2026-10-09 08:00:24'),
(29, 'Lost', 'serie', 'Los supervivientes de un accidente aéreo quedan atrapados en una isla misteriosa.', '2004-09-22', NULL, 'images/posters/lost.jpg', 'images/banners/lost.jpg', 'finalizada', '2026-10-09 08:00:24'),
(30, 'Black Mirror', 'serie', 'Historias independientes exploran los efectos oscuros de la tecnología.', '2011-12-04', NULL, 'images/posters/black_mirror.jpg', 'images/banners/black_mirror.jpg', 'desconocido', '2026-10-09 08:00:24'),
(31, 'The Witcher', 'serie', 'Un cazador de monstruos recorre un mundo de magia y conflictos.', '2019-12-20', NULL, 'images/posters/the_witcher.jpg', 'images/banners/the_witcher.jpg', 'desconocido', '2026-10-09 08:00:24'),
(32, 'Vikingos', 'serie', 'Un guerrero nórdico busca explorar nuevas tierras y conquistar territorios.', '2013-03-03', NULL, 'images/posters/vikingos.jpg', 'images/banners/vikingos.jpg', 'finalizada', '2026-10-09 08:00:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos_generos`
--

CREATE TABLE `contenidos_generos` (
  `contenido_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `contenidos_generos`
--

INSERT INTO `contenidos_generos` (`contenido_id`, `genero_id`) VALUES
(1, 4),
(1, 7),
(2, 1),
(2, 4),
(3, 1),
(3, 4),
(4, 3),
(5, 3),
(5, 8),
(6, 8),
(7, 7),
(7, 14),
(8, 9),
(9, 5),
(10, 3),
(11, 7),
(12, 9),
(12, 14),
(13, 2),
(13, 4),
(14, 7),
(14, 14),
(15, 1),
(15, 7),
(15, 15),
(16, 7),
(16, 10),
(16, 15),
(17, 2),
(17, 4),
(17, 11),
(18, 2),
(18, 4),
(18, 8),
(19, 3),
(19, 13),
(19, 17),
(20, 7),
(20, 13),
(21, 1),
(21, 14),
(21, 20),
(22, 2),
(22, 4),
(22, 5),
(23, 7),
(23, 14),
(24, 4),
(24, 9),
(24, 20),
(25, 2),
(25, 4),
(25, 8),
(26, 7),
(26, 14),
(26, 15),
(27, 7),
(27, 15),
(28, 1),
(28, 4),
(28, 20),
(29, 2),
(29, 7),
(29, 9),
(30, 4),
(30, 9),
(30, 20),
(31, 1),
(31, 2),
(31, 8),
(32, 1),
(32, 7),
(32, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodios`
--

CREATE TABLE `episodios` (
  `id` int(11) NOT NULL,
  `temporada_id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `fecha_estreno` date DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `episodios`
--

INSERT INTO `episodios` (`id`, `temporada_id`, `numero`, `titulo`, `descripcion`, `duracion`, `fecha_estreno`) VALUES
(1, 1, 3, '...Y la bolsa está en el río', NULL, 48, '2008-02-10'),
(2, 1, 2, 'El gato en la bolsa', NULL, 48, '2008-01-27'),
(3, 1, 1, 'Piloto', NULL, 58, '2008-01-20'),
(4, 8, 1, 'Siete treinta y siete', NULL, 47, '2009-03-08'),
(8, 2, 1, 'La desaparición de Will Byers', NULL, 49, '2016-07-15'),
(9, 2, 2, 'La loca de la calle Maple', NULL, 56, '2016-07-15'),
(10, 2, 3, 'Todo está bien', NULL, 52, '2016-07-15'),
(11, 3, 1, 'Bienvenidos a la jungla', NULL, 42, '2005-03-24'),
(12, 3, 2, 'El día de la diversidad', NULL, 22, '2005-03-29'),
(13, 3, 3, 'San Valentín', NULL, 22, '2005-05-03'),
(14, 5, 1, 'Cuando estés perdido en la oscuridad', NULL, 81, '2023-01-15'),
(15, 5, 2, 'Infectados', NULL, 53, '2023-01-22'),
(17, 6, 1, 'Un estudio en rosa', NULL, 89, '2010-07-25'),
(18, 6, 2, 'El banquero ciego', NULL, 89, '2010-08-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodios_vistos`
--

CREATE TABLE `episodios_vistos` (
  `usuario_id` int(11) NOT NULL,
  `episodio_id` int(11) NOT NULL,
  `fecha_visto` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `episodios_vistos`
--

INSERT INTO `episodios_vistos` (`usuario_id`, `episodio_id`, `fecha_visto`) VALUES
(1, 2, '2025-03-01 20:00:00'),
(1, 3, '2025-03-01 20:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(1, 'Acción'),
(3, 'Animación'),
(2, 'Aventura'),
(16, 'Bélico'),
(4, 'Ciencia ficción'),
(5, 'Comedia'),
(14, 'Crimen'),
(18, 'Deportes'),
(6, 'Documental'),
(7, 'Drama'),
(17, 'Familia'),
(8, 'Fantasía'),
(15, 'Histórico'),
(9, 'Misterio'),
(13, 'Musical'),
(10, 'Romance'),
(11, 'Suspense'),
(12, 'Terror'),
(20, 'Thriller'),
(19, 'Western');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporadas`
--

CREATE TABLE `temporadas` (
  `id` int(11) NOT NULL,
  `contenido_id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_estreno` date DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `temporadas`
--

INSERT INTO `temporadas` (`id`, `contenido_id`, `numero`, `titulo`, `descripcion`, `fecha_estreno`) VALUES
(1, 7, 1, 'Temporada 1', NULL, '2008-01-20'),
(2, 8, 1, 'Temporada 1', NULL, '2016-07-15'),
(3, 9, 1, 'Temporada 1', NULL, '2005-03-24'),
(4, 10, 1, 'Temporada 1', NULL, '2021-11-06'),
(5, 11, 1, 'Temporada 1', NULL, '2023-01-15'),
(6, 12, 1, 'Temporada 1', NULL, '2010-07-25'),
(8, 7, 2, 'Temporada 2', NULL, '2009-03-08'),
(9, 8, 2, 'Temporada 2', NULL, '2017-10-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `perfil_publico` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `foto`, `descripcion`, `perfil_publico`, `fecha_registro`) VALUES
(1, 'ana', 'ana@prueba.com', 'HASH_DE_PRUEBA_1', NULL, 'Me encantan la ciencia ficción y el misterio.', 1, '2026-10-09 10:00:24'),
(2, 'carlos', 'carlos@prueba.com', 'HASH_DE_PRUEBA_2', NULL, 'Fan de las películas de acción.', 1, '2026-10-09 10:00:24'),
(3, 'lucia', 'lucia@prueba.com', 'HASH_DE_PRUEBA_3', NULL, 'Veo series todos los fines de semana.', 1, '2026-10-09 10:00:24'),
(4, 'david', 'david@prueba.com', 'HASH_DE_PRUEBA_4', NULL, 'Disfruto de la animación y la fantasía.', 0, '2026-10-09 10:00:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amistades`
--
ALTER TABLE `amistades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_amistad` (`usuario_id`,`amigo_id`),
  ADD KEY `idx_amistades_recibidas` (`amigo_id`,`estado`);

--
-- Indices de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`usuario_id`,`contenido_id`),
  ADD KEY `contenido_id` (`contenido_id`),
  ADD KEY `idx_biblioteca_estado` (`usuario_id`,`estado`);

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contenidos_titulo` (`titulo`),
  ADD KEY `idx_contenidos_tipo` (`tipo`);

--
-- Indices de la tabla `contenidos_generos`
--
ALTER TABLE `contenidos_generos`
  ADD PRIMARY KEY (`contenido_id`,`genero_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_episodio` (`temporada_id`,`numero`);

--
-- Indices de la tabla `episodios_vistos`
--
ALTER TABLE `episodios_vistos`
  ADD PRIMARY KEY (`usuario_id`,`episodio_id`),
  ADD KEY `episodio_id` (`episodio_id`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_temporada` (`contenido_id`,`numero`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amistades`
--
ALTER TABLE `amistades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `episodios`
--
ALTER TABLE `episodios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amistades`
--
ALTER TABLE `amistades`
  ADD CONSTRAINT `amistades_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amistades_ibfk_2` FOREIGN KEY (`amigo_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD CONSTRAINT `biblioteca_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biblioteca_ibfk_2` FOREIGN KEY (`contenido_id`) REFERENCES `contenidos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contenidos_generos`
--
ALTER TABLE `contenidos_generos`
  ADD CONSTRAINT `contenidos_generos_ibfk_1` FOREIGN KEY (`contenido_id`) REFERENCES `contenidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contenidos_generos_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD CONSTRAINT `episodios_ibfk_1` FOREIGN KEY (`temporada_id`) REFERENCES `temporadas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `episodios_vistos`
--
ALTER TABLE `episodios_vistos`
  ADD CONSTRAINT `episodios_vistos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `episodios_vistos_ibfk_2` FOREIGN KEY (`episodio_id`) REFERENCES `episodios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `temporadas`
--
ALTER TABLE `temporadas`
  ADD CONSTRAINT `temporadas_ibfk_1` FOREIGN KEY (`contenido_id`) REFERENCES `contenidos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
