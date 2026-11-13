-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2026 a las 12:20:57
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `notas` text DEFAULT NULL,
  `favorito` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `biblioteca`
--

INSERT INTO `biblioteca` (`usuario_id`, `contenido_id`, `estado`, `puntuacion`, `fecha_inicio`, `fecha_fin`, `notas`, `favorito`) VALUES
(5, 1, 'pendiente', NULL, NULL, NULL, NULL, 1),
(5, 2, '', NULL, NULL, NULL, NULL, 0),
(5, 3, 'vista', NULL, NULL, NULL, NULL, 0),
(5, 4, 'pausada', NULL, NULL, NULL, NULL, 0),
(5, 5, 'pendiente', NULL, NULL, NULL, NULL, 1),
(5, 6, 'pausada', NULL, NULL, NULL, NULL, 0),
(5, 10, 'pendiente', NULL, NULL, NULL, NULL, 1),
(5, 21, 'abandonada', NULL, NULL, NULL, NULL, 0),
(5, 26, 'vista', NULL, NULL, NULL, NULL, 0),
(5, 30, 'viendo', NULL, NULL, NULL, NULL, 0),
(5, 34, 'abandonada', NULL, NULL, NULL, NULL, 1),
(5, 35, 'pendiente', NULL, NULL, NULL, NULL, 0),
(5, 37, 'pausada', NULL, NULL, NULL, NULL, 1),
(5, 41, 'vista', NULL, NULL, NULL, NULL, 0),
(5, 42, 'vista', NULL, NULL, NULL, NULL, 0),
(5, 43, 'vista', NULL, NULL, NULL, NULL, 0),
(5, 52, 'pendiente', NULL, NULL, NULL, NULL, 0),
(5, 54, 'pendiente', NULL, NULL, NULL, NULL, 0),
(5, 55, 'pendiente', NULL, NULL, NULL, NULL, 1),
(5, 57, 'pendiente', NULL, NULL, NULL, NULL, 0),
(5, 65, 'vista', NULL, NULL, NULL, NULL, 0),
(5, 69, 'pausada', NULL, NULL, NULL, NULL, 0),
(5, 73, 'viendo', NULL, NULL, NULL, NULL, 0),
(6, 18, 'pausada', NULL, NULL, NULL, NULL, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(32, 'Vikingos', 'serie', 'Un guerrero nórdico busca explorar nuevas tierras y conquistar territorios.', '2013-03-03', NULL, 'images/posters/vikingos.jpg', 'images/banners/vikingos.jpg', 'finalizada', '2026-10-09 08:00:24'),
(33, 'El Señor de los Anillos: Las dos torres', 'pelicula', 'La Comunidad se separa mientras continúa la lucha contra Sauron.', '2002-12-18', 179, 'images/posters/las_dos_torres.jpg', 'images/banners/las_dos_torres.jpg', 'desconocido', '2026-10-15 08:42:17'),
(34, 'Arcane Temporada 2', 'serie', 'Dos hermanas quedan atrapadas en el conflicto entre Piltover y Zaun.', '2021-11-06', NULL, 'images/posters/arcane_t2.jpg', 'images/banners/arcane_t2.jpg', 'finalizada', '2026-10-15 08:42:17'),
(35, 'El Señor de los Anillos: El retorno del rey', 'pelicula', 'La batalla final por la Tierra Media se acerca mientras Frodo intenta destruir el Anillo.', '2003-12-17', 201, 'images/posters/el_retorno_del_rey.jpg', 'images/banners/el_retorno_del_rey.jpg', 'desconocido', '2026-10-15 08:42:17'),
(36, 'Dune: Parte dos', 'pelicula', 'Paul Atreides se une a los Fremen y busca vengar la destrucción de su familia.', '2024-03-01', 166, 'images/posters/dune_parte_dos.jpg', 'images/banners/dune_parte_dos.jpg', 'desconocido', '2026-10-15 08:42:17'),
(37, 'Akira', 'pelicula', 'En un Tokio futurista, un joven motorista se ve envuelto en un experimento psíquico.', '1988-07-16', 124, 'images/posters/akira.jpg', 'images/banners/akira.jpg', 'desconocido', '2026-10-15 08:42:17'),
(38, 'Matrix Reloaded', 'pelicula', 'Neo y sus aliados buscan salvar Sion mientras las máquinas se acercan.', '2003-05-15', 138, 'images/posters/matrix_reloaded.jpg', 'images/banners/matrix_reloaded.jpg', 'desconocido', '2026-10-15 08:42:17'),
(39, 'Matrix Revolutions', 'pelicula', 'Neo intenta poner fin a la guerra entre humanos y máquinas.', '2003-11-05', 129, 'images/posters/matrix_revolutions.jpg', 'images/banners/matrix_revolutions.jpg', 'desconocido', '2026-10-15 08:42:17'),
(40, 'Blue Eye Samurai', 'serie', 'Una guerrera mestiza busca venganza en el Japón del periodo Edo.', '2023-11-03', NULL, 'images/posters/blue_eye_samurai.jpg', 'images/banners/blue_eye_samurai.jpg', 'desconocido', '2026-10-15 08:42:17'),
(41, 'El Hobbit: Un viaje inesperado', 'pelicula', 'Bilbo Bolsón acompaña a un grupo de enanos en una aventura para recuperar su hogar.', '2012-12-14', 169, 'images/posters/el_hobbit_un_viaje_inesperado.jpg', 'images/banners/el_hobbit_un_viaje_inesperado.jpg', 'desconocido', '2026-10-15 08:42:17'),
(42, 'El Hobbit: La desolación de Smaug', 'pelicula', 'Bilbo y los enanos continúan su viaje hacia la Montaña Solitaria.', '2013-12-13', 161, 'images/posters/el_hobbit_la_desolacion_de_smaug.jpg', 'images/banners/el_hobbit_la_desolacion_de_smaug.jpg', 'desconocido', '2026-10-15 08:42:17'),
(43, 'El Hobbit: La batalla de los cinco ejércitos', 'pelicula', 'Enanos, elfos, hombres y otras criaturas luchan por el destino de la Montaña Solitaria.', '2014-12-17', 144, 'images/posters/el_hobbit_la_batalla_de_los_cinco_ejercitos.jpg', 'images/banners/el_hobbit_la_batalla_de_los_cinco_ejercitos.jpg', 'desconocido', '2026-10-15 08:42:17'),
(44, 'Toy Story 2', 'pelicula', 'Woody es secuestrado por un coleccionista y descubre su pasado.', '1999-11-24', 92, 'images/posters/toy_story_2.jpg', 'images/banners/toy_story_2.jpg', 'desconocido', '2026-10-15 08:42:17'),
(45, 'Toy Story 3', 'pelicula', 'Los juguetes afrontan la marcha de Andy a la universidad.', '2010-06-18', 103, 'images/posters/toy_story_3.jpg', 'images/banners/toy_story_3.jpg', 'desconocido', '2026-10-15 08:42:17'),
(46, 'Toy Story 4', 'pelicula', 'Woody y sus amigos conocen a un nuevo juguete durante un viaje.', '2019-06-21', 100, 'images/posters/toy_story_4.jpg', 'images/banners/toy_story_4.jpg', 'desconocido', '2026-10-15 08:42:17'),
(47, 'Avatar: El sentido del agua', 'pelicula', 'Jake y Neytiri protegen a su familia y exploran los océanos de Pandora.', '2022-12-16', 192, 'images/posters/avatar_el_sentido_del_agua.jpg', 'images/banners/avatar_el_sentido_del_agua.jpg', 'desconocido', '2026-10-15 08:42:17'),
(48, 'Avatar: Fuego y ceniza', 'pelicula', 'Jake y Neytiri conocen a un nuevo pueblo Na’vi mientras crecen las tensiones en Pandora.', '2025-12-19', 197, 'images/posters/avatar_fuego_y_ceniza.jpg', 'images/banners/avatar_fuego_y_ceniza.jpg', 'desconocido', '2026-10-15 08:42:17'),
(49, 'Perfect Blue', 'pelicula', 'Una cantante que inicia una carrera como actriz pierde el control de los límites entre realidad e ilusión.', '1997-07-25', 81, 'images/posters/perfect_blue.jpg', 'images/banners/perfect_blue.jpg', 'desconocido', '2026-10-15 08:42:17'),
(50, 'Ghost in the Shell', 'pelicula', 'Una agente cibernética investiga a un hacker en un futuro donde humanos y máquinas se mezclan.', '1995-11-18', 83, 'images/posters/ghost_in_the_shell.jpg', 'images/banners/ghost_in_the_shell.jpg', 'desconocido', '2026-10-15 08:42:17'),
(51, 'Paprika', 'pelicula', 'Una psicóloga utiliza una tecnología experimental que permite entrar en los sueños.', '2006-11-25', 90, 'images/posters/paprika.jpg', 'images/banners/paprika.jpg', 'desconocido', '2026-10-15 08:42:17'),
(52, 'La tumba de las luciérnagas', 'pelicula', 'Dos hermanos intentan sobrevivir en Japón durante los últimos meses de la Segunda Guerra Mundial.', '1988-04-16', 89, 'images/posters/la_tumba_de_las_luciernagas.jpg', 'images/banners/la_tumba_de_las_luciernagas.jpg', 'desconocido', '2026-10-15 08:42:17'),
(53, 'Primal', 'serie', 'Un hombre prehistórico y un dinosaurio establecen una alianza para sobrevivir.', '2019-10-08', NULL, 'images/posters/primal.jpg', 'images/banners/primal.jpg', 'desconocido', '2026-10-15 08:42:17'),
(54, 'Castlevania', 'serie', 'Un cazavampiros lucha contra las fuerzas de Drácula en una fantasía oscura.', '2017-07-07', NULL, 'images/posters/castlevania.jpg', 'images/banners/castlevania.jpg', 'finalizada', '2026-10-15 08:42:17'),
(55, 'Cyberpunk: Edgerunners', 'serie', 'Un joven intenta sobrevivir como mercenario en una ciudad dominada por la tecnología y la violencia.', '2022-09-13', NULL, 'images/posters/cyberpunk_edgerunners.jpg', 'images/banners/cyberpunk_edgerunners.jpg', 'finalizada', '2026-10-15 08:42:17'),
(56, 'Scavengers Reign', 'serie', 'Un grupo de supervivientes explora un planeta alienígena lleno de ecosistemas extraños.', '2023-10-19', NULL, 'images/posters/scavengers_reign.jpg', 'images/banners/scavengers_reign.jpg', 'finalizada', '2026-10-15 08:42:17'),
(57, 'Blade Runner 2049', 'pelicula', 'Un agente descubre un secreto que puede cambiar la relación entre humanos y replicantes.', '2017-10-06', 164, 'images/posters/blade_runner_2049.jpg', 'images/banners/blade_runner_2049.jpg', 'desconocido', '2026-10-15 08:42:17'),
(58, 'Spider-Man: Cruzando el multiverso', 'pelicula', 'Miles Morales vuelve a encontrarse con otros Spider-Man y afronta una amenaza multiversal.', '2023-06-02', 140, 'images/posters/spider_man_cruzando_el_multiverso.jpg', 'images/banners/spider_man_cruzando_el_multiverso.jpg', 'desconocido', '2026-10-15 08:42:17'),
(59, 'La llegada', 'pelicula', 'Una lingüista intenta comunicarse con seres extraterrestres que han llegado a la Tierra.', '2016-11-11', 116, 'images/posters/la_llegada.jpg', 'images/banners/la_llegada.jpg', 'desconocido', '2026-10-15 08:42:17'),
(60, 'Ex Machina', 'pelicula', 'Un programador participa en una prueba para evaluar la inteligencia de una androide.', '2015-01-21', 108, 'images/posters/ex_machina.jpg', 'images/banners/ex_machina.jpg', 'desconocido', '2026-10-15 08:42:17'),
(61, 'Mad Max: Furia en la carretera', 'pelicula', 'En un mundo desértico, Max ayuda a un grupo a escapar de un tirano.', '2015-05-15', 120, 'images/posters/mad_max_furia_en_la_carretera.jpg', 'images/banners/mad_max_furia_en_la_carretera.jpg', 'desconocido', '2026-10-15 08:42:17'),
(62, 'John Wick', 'pelicula', 'Un antiguo asesino regresa al mundo criminal en busca de venganza.', '2014-10-24', 101, 'images/posters/john_wick.jpg', 'images/banners/john_wick.jpg', 'desconocido', '2026-10-15 08:42:17'),
(63, 'John Wick: Pacto de sangre', 'pelicula', 'John Wick debe cumplir una deuda que lo enfrenta a una red internacional de asesinos.', '2017-02-10', 122, 'images/posters/john_wick_pacto_de_sangre.jpg', 'images/banners/john_wick_pacto_de_sangre.jpg', 'desconocido', '2026-10-15 08:42:17'),
(64, 'John Wick: Capítulo 3 - Parabellum', 'pelicula', 'John Wick huye mientras una organización mundial pone precio a su cabeza.', '2019-05-17', 130, 'images/posters/john_wick_3.jpg', 'images/banners/john_wick_3.jpg', 'desconocido', '2026-10-15 08:42:17'),
(65, 'John Wick: Capítulo 4', 'pelicula', 'John Wick busca una forma de derrotar definitivamente a la Alta Mesa.', '2023-03-24', 169, 'images/posters/john_wick_4.jpg', 'images/banners/john_wick_4.jpg', 'desconocido', '2026-10-15 08:42:17'),
(66, 'Severance', 'serie', 'Los empleados de una empresa se someten a un procedimiento que separa sus recuerdos laborales y personales.', '2022-02-18', NULL, 'images/posters/severance.jpg', 'images/banners/severance.jpg', 'en_emision', '2026-10-15 08:42:17'),
(67, 'The Bear', 'serie', 'Un chef vuelve a Chicago para dirigir el restaurante familiar y afrontar una cocina caótica.', '2022-06-23', NULL, 'images/posters/the_bear.jpg', 'images/banners/the_bear.jpg', 'en_emision', '2026-10-15 08:42:17'),
(68, 'Succession', 'serie', 'Los miembros de una familia poderosa compiten por el control de un imperio empresarial.', '2018-06-03', NULL, 'images/posters/succession.jpg', 'images/banners/succession.jpg', 'finalizada', '2026-10-15 08:42:17'),
(69, 'Chernobyl', 'serie', 'Una miniserie dramatiza el accidente nuclear de 1986 y sus consecuencias.', '2019-05-06', NULL, 'images/posters/chernobyl.jpg', 'images/banners/chernobyl.jpg', 'finalizada', '2026-10-15 08:42:17'),
(70, 'Invincible', 'serie', 'Un adolescente descubre el coste real de heredar los poderes de su padre superhéroe.', '2021-03-26', NULL, 'images/posters/invincible.jpg', 'images/banners/invincible.jpg', 'en_emision', '2026-10-15 08:42:17'),
(71, 'Love, Death & Robots', 'serie', 'Antología de animación para adultos con historias de ciencia ficción, terror y fantasía.', '2019-03-15', NULL, 'images/posters/love_death_robots.jpg', 'images/banners/love_death_robots.jpg', 'en_emision', '2026-10-15 08:42:17'),
(72, 'The Legend of Vox Machina', 'serie', 'Un grupo de aventureros inadaptados se enfrenta a amenazas mágicas y criaturas peligrosas.', '2022-01-28', NULL, 'images/posters/vox_machina.jpg', 'images/banners/vox_machina.jpg', 'en_emision', '2026-10-15 08:42:17'),
(73, 'Monster', 'serie', 'Un neurocirujano se ve envuelto en una investigación sobre un asesino en serie.', '2004-04-07', NULL, 'images/posters/monster.jpg', 'images/banners/monster.jpg', 'finalizada', '2026-10-15 08:42:17'),
(74, 'Vinland Saga', 'serie', 'Un joven vikingo busca venganza en medio de guerras y luchas por el poder.', '2019-07-08', NULL, 'images/posters/vinland_saga.jpg', 'images/banners/vinland_saga.jpg', 'desconocido', '2026-10-15 08:42:17'),
(75, 'Psycho-Pass', 'serie', 'En una sociedad futurista, la policía evalúa la probabilidad de que una persona cometa delitos.', '2012-10-12', NULL, 'images/posters/psycho_pass.jpg', 'images/banners/psycho_pass.jpg', 'desconocido', '2026-10-15 08:42:17');

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
(32, 15),
(33, 1),
(33, 2),
(33, 8),
(34, 2),
(34, 3),
(34, 4),
(35, 1),
(35, 2),
(35, 8),
(36, 2),
(36, 4),
(36, 7),
(37, 1),
(37, 4),
(37, 20),
(38, 1),
(38, 4),
(38, 20),
(39, 1),
(39, 4),
(39, 20),
(40, 1),
(40, 7),
(40, 8),
(41, 1),
(41, 2),
(41, 8),
(42, 1),
(42, 2),
(42, 8),
(43, 1),
(43, 2),
(43, 8),
(44, 3),
(44, 5),
(44, 8),
(45, 3),
(45, 5),
(45, 7),
(46, 3),
(46, 5),
(46, 8),
(47, 2),
(47, 4),
(47, 8),
(48, 2),
(48, 4),
(48, 8),
(49, 7),
(49, 9),
(49, 20),
(50, 1),
(50, 4),
(50, 20),
(51, 4),
(51, 8),
(51, 9),
(52, 7),
(52, 10),
(53, 1),
(53, 2),
(53, 3),
(54, 1),
(54, 8),
(54, 12),
(55, 1),
(55, 4),
(55, 20),
(56, 2),
(56, 4),
(56, 9),
(57, 4),
(57, 7),
(57, 20),
(58, 1),
(58, 2),
(58, 3),
(59, 4),
(59, 7),
(59, 9),
(60, 4),
(60, 9),
(60, 20),
(61, 1),
(61, 2),
(61, 4),
(62, 1),
(62, 7),
(62, 20),
(63, 1),
(63, 7),
(63, 20),
(64, 1),
(64, 7),
(64, 20),
(65, 1),
(65, 7),
(65, 20),
(66, 4),
(66, 9),
(66, 20),
(67, 5),
(67, 7),
(68, 7),
(68, 20),
(69, 7),
(69, 10),
(70, 1),
(70, 2),
(70, 3),
(71, 4),
(71, 8),
(71, 12),
(72, 2),
(72, 3),
(72, 8),
(73, 7),
(73, 9),
(73, 20),
(74, 1),
(74, 2),
(74, 7),
(75, 4),
(75, 9),
(75, 20);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, 6, 2, 'El banquero ciego', NULL, 89, '2010-08-01'),
(19, 4, 1, 'Episodio 1', NULL, NULL, NULL),
(20, 4, 2, 'Episodio 2', NULL, NULL, NULL),
(21, 4, 3, 'Episodio 3', NULL, NULL, NULL),
(22, 4, 4, 'Episodio 4', NULL, NULL, NULL),
(23, 4, 5, 'Episodio 5', NULL, NULL, NULL),
(24, 4, 6, 'Episodio 6', NULL, NULL, NULL),
(25, 4, 7, 'Episodio 7', NULL, NULL, NULL),
(26, 4, 8, 'Episodio 8', NULL, NULL, NULL),
(27, 4, 9, 'Episodio 9', NULL, NULL, NULL),
(28, 10, 1, 'Episodio 1', NULL, NULL, NULL),
(29, 10, 2, 'Episodio 2', NULL, NULL, NULL),
(30, 10, 3, 'Episodio 3', NULL, NULL, NULL),
(31, 10, 4, 'Episodio 4', NULL, NULL, NULL),
(32, 10, 5, 'Episodio 5', NULL, NULL, NULL),
(33, 10, 6, 'Episodio 6', NULL, NULL, NULL),
(34, 10, 7, 'Episodio 7', NULL, NULL, NULL),
(35, 10, 8, 'Episodio 8', NULL, NULL, NULL),
(36, 10, 9, 'Episodio 9', NULL, NULL, NULL),
(37, 10, 10, 'Episodio 10', NULL, NULL, NULL),
(38, 11, 1, 'Episodio 1', NULL, NULL, NULL),
(39, 11, 2, 'Episodio 2', NULL, NULL, NULL),
(40, 11, 3, 'Episodio 3', NULL, NULL, NULL),
(41, 11, 4, 'Episodio 4', NULL, NULL, NULL),
(42, 11, 5, 'Episodio 5', NULL, NULL, NULL),
(43, 11, 6, 'Episodio 6', NULL, NULL, NULL),
(44, 11, 7, 'Episodio 7', NULL, NULL, NULL),
(45, 11, 8, 'Episodio 8', NULL, NULL, NULL),
(46, 11, 9, 'Episodio 9', NULL, NULL, NULL),
(47, 11, 10, 'Episodio 10', NULL, NULL, NULL),
(48, 12, 1, 'Episodio 1', NULL, NULL, NULL),
(49, 12, 2, 'Episodio 2', NULL, NULL, NULL),
(50, 12, 3, 'Episodio 3', NULL, NULL, NULL),
(51, 12, 4, 'Episodio 4', NULL, NULL, NULL),
(52, 12, 5, 'Episodio 5', NULL, NULL, NULL),
(53, 12, 6, 'Episodio 6', NULL, NULL, NULL),
(54, 12, 7, 'Episodio 7', NULL, NULL, NULL),
(55, 12, 8, 'Episodio 8', NULL, NULL, NULL),
(56, 13, 1, 'Episodio 1', NULL, NULL, NULL),
(57, 13, 2, 'Episodio 2', NULL, NULL, NULL),
(58, 13, 3, 'Episodio 3', NULL, NULL, NULL),
(59, 13, 4, 'Episodio 4', NULL, NULL, NULL),
(60, 13, 5, 'Episodio 5', NULL, NULL, NULL),
(61, 13, 6, 'Episodio 6', NULL, NULL, NULL),
(62, 14, 1, 'Episodio 1', NULL, NULL, NULL),
(63, 14, 2, 'Episodio 2', NULL, NULL, NULL),
(64, 14, 3, 'Episodio 3', NULL, NULL, NULL),
(65, 14, 4, 'Episodio 4', NULL, NULL, NULL),
(66, 14, 5, 'Episodio 5', NULL, NULL, NULL),
(67, 14, 6, 'Episodio 6', NULL, NULL, NULL),
(68, 14, 7, 'Episodio 7', NULL, NULL, NULL),
(69, 14, 8, 'Episodio 8', NULL, NULL, NULL),
(70, 14, 9, 'Episodio 9', NULL, NULL, NULL),
(71, 14, 10, 'Episodio 10', NULL, NULL, NULL),
(72, 15, 1, 'Episodio 1', NULL, NULL, NULL),
(73, 15, 2, 'Episodio 2', NULL, NULL, NULL),
(74, 15, 3, 'Episodio 3', NULL, NULL, NULL),
(75, 15, 4, 'Episodio 4', NULL, NULL, NULL),
(76, 15, 5, 'Episodio 5', NULL, NULL, NULL),
(77, 15, 6, 'Episodio 6', NULL, NULL, NULL),
(78, 15, 7, 'Episodio 7', NULL, NULL, NULL),
(79, 15, 8, 'Episodio 8', NULL, NULL, NULL),
(80, 16, 1, 'Episodio 1', NULL, NULL, NULL),
(81, 16, 2, 'Episodio 2', NULL, NULL, NULL),
(82, 16, 3, 'Episodio 3', NULL, NULL, NULL),
(83, 16, 4, 'Episodio 4', NULL, NULL, NULL),
(84, 16, 5, 'Episodio 5', NULL, NULL, NULL),
(85, 16, 6, 'Episodio 6', NULL, NULL, NULL),
(86, 16, 7, 'Episodio 7', NULL, NULL, NULL),
(87, 16, 8, 'Episodio 8', NULL, NULL, NULL),
(88, 16, 9, 'Episodio 9', NULL, NULL, NULL),
(89, 16, 10, 'Episodio 10', NULL, NULL, NULL),
(90, 16, 11, 'Episodio 11', NULL, NULL, NULL),
(91, 16, 12, 'Episodio 12', NULL, NULL, NULL),
(92, 16, 13, 'Episodio 13', NULL, NULL, NULL),
(93, 16, 14, 'Episodio 14', NULL, NULL, NULL),
(94, 16, 15, 'Episodio 15', NULL, NULL, NULL),
(95, 16, 16, 'Episodio 16', NULL, NULL, NULL),
(96, 16, 17, 'Episodio 17', NULL, NULL, NULL),
(97, 16, 18, 'Episodio 18', NULL, NULL, NULL),
(98, 16, 19, 'Episodio 19', NULL, NULL, NULL),
(99, 16, 20, 'Episodio 20', NULL, NULL, NULL),
(100, 16, 21, 'Episodio 21', NULL, NULL, NULL),
(101, 16, 22, 'Episodio 22', NULL, NULL, NULL),
(102, 16, 23, 'Episodio 23', NULL, NULL, NULL),
(103, 16, 24, 'Episodio 24', NULL, NULL, NULL),
(104, 16, 25, 'Episodio 25', NULL, NULL, NULL),
(105, 17, 1, 'Episodio 1', NULL, NULL, NULL),
(106, 17, 2, 'Episodio 2', NULL, NULL, NULL),
(107, 17, 3, 'Episodio 3', NULL, NULL, NULL),
(108, 18, 1, 'Episodio 1', NULL, NULL, NULL),
(109, 18, 2, 'Episodio 2', NULL, NULL, NULL),
(110, 18, 3, 'Episodio 3', NULL, NULL, NULL),
(111, 18, 4, 'Episodio 4', NULL, NULL, NULL),
(112, 18, 5, 'Episodio 5', NULL, NULL, NULL),
(113, 18, 6, 'Episodio 6', NULL, NULL, NULL),
(114, 18, 7, 'Episodio 7', NULL, NULL, NULL),
(115, 18, 8, 'Episodio 8', NULL, NULL, NULL),
(116, 19, 1, 'Episodio 1', NULL, NULL, NULL),
(117, 19, 2, 'Episodio 2', NULL, NULL, NULL),
(118, 19, 3, 'Episodio 3', NULL, NULL, NULL),
(119, 19, 4, 'Episodio 4', NULL, NULL, NULL),
(120, 19, 5, 'Episodio 5', NULL, NULL, NULL),
(121, 19, 6, 'Episodio 6', NULL, NULL, NULL),
(122, 19, 7, 'Episodio 7', NULL, NULL, NULL),
(123, 19, 8, 'Episodio 8', NULL, NULL, NULL),
(124, 19, 9, 'Episodio 9', NULL, NULL, NULL),
(125, 20, 1, 'Episodio 1', NULL, NULL, NULL),
(126, 20, 2, 'Episodio 2', NULL, NULL, NULL),
(127, 20, 3, 'Episodio 3', NULL, NULL, NULL),
(128, 20, 4, 'Episodio 4', NULL, NULL, NULL),
(129, 20, 5, 'Episodio 5', NULL, NULL, NULL),
(130, 20, 6, 'Episodio 6', NULL, NULL, NULL),
(131, 20, 7, 'Episodio 7', NULL, NULL, NULL),
(132, 20, 8, 'Episodio 8', NULL, NULL, NULL),
(133, 20, 9, 'Episodio 9', NULL, NULL, NULL),
(134, 21, 1, 'Episodio 1', NULL, NULL, NULL),
(135, 21, 2, 'Episodio 2', NULL, NULL, NULL),
(136, 21, 3, 'Episodio 3', NULL, NULL, NULL),
(137, 21, 4, 'Episodio 4', NULL, NULL, NULL),
(138, 21, 5, 'Episodio 5', NULL, NULL, NULL),
(139, 21, 6, 'Episodio 6', NULL, NULL, NULL),
(140, 21, 7, 'Episodio 7', NULL, NULL, NULL),
(141, 21, 8, 'Episodio 8', NULL, NULL, NULL),
(142, 22, 1, 'Episodio 1', NULL, NULL, NULL),
(143, 22, 2, 'Episodio 2', NULL, NULL, NULL),
(144, 22, 3, 'Episodio 3', NULL, NULL, NULL),
(145, 22, 4, 'Episodio 4', NULL, NULL, NULL),
(146, 22, 5, 'Episodio 5', NULL, NULL, NULL),
(147, 22, 6, 'Episodio 6', NULL, NULL, NULL),
(148, 22, 7, 'Episodio 7', NULL, NULL, NULL),
(149, 22, 8, 'Episodio 8', NULL, NULL, NULL),
(150, 22, 9, 'Episodio 9', NULL, NULL, NULL),
(151, 22, 10, 'Episodio 10', NULL, NULL, NULL),
(152, 23, 1, 'Episodio 1', NULL, NULL, NULL),
(153, 23, 2, 'Episodio 2', NULL, NULL, NULL),
(154, 23, 3, 'Episodio 3', NULL, NULL, NULL),
(155, 23, 4, 'Episodio 4', NULL, NULL, NULL),
(156, 24, 1, 'Episodio 1', NULL, NULL, NULL),
(157, 24, 2, 'Episodio 2', NULL, NULL, NULL),
(158, 24, 3, 'Episodio 3', NULL, NULL, NULL),
(159, 24, 4, 'Episodio 4', NULL, NULL, NULL),
(160, 24, 5, 'Episodio 5', NULL, NULL, NULL),
(161, 24, 6, 'Episodio 6', NULL, NULL, NULL),
(162, 24, 7, 'Episodio 7', NULL, NULL, NULL),
(163, 24, 8, 'Episodio 8', NULL, NULL, NULL),
(164, 24, 9, 'Episodio 9', NULL, NULL, NULL),
(165, 24, 10, 'Episodio 10', NULL, NULL, NULL),
(166, 25, 1, 'Episodio 1', NULL, NULL, NULL),
(167, 25, 2, 'Episodio 2', NULL, NULL, NULL),
(168, 25, 3, 'Episodio 3', NULL, NULL, NULL),
(169, 25, 4, 'Episodio 4', NULL, NULL, NULL),
(170, 25, 5, 'Episodio 5', NULL, NULL, NULL),
(171, 25, 6, 'Episodio 6', NULL, NULL, NULL),
(172, 25, 7, 'Episodio 7', NULL, NULL, NULL),
(173, 25, 8, 'Episodio 8', NULL, NULL, NULL),
(174, 25, 9, 'Episodio 9', NULL, NULL, NULL),
(175, 25, 10, 'Episodio 10', NULL, NULL, NULL),
(176, 25, 11, 'Episodio 11', NULL, NULL, NULL),
(177, 25, 12, 'Episodio 12', NULL, NULL, NULL),
(178, 26, 1, 'Episodio 1', NULL, NULL, NULL),
(179, 26, 2, 'Episodio 2', NULL, NULL, NULL),
(180, 26, 3, 'Episodio 3', NULL, NULL, NULL),
(181, 26, 4, 'Episodio 4', NULL, NULL, NULL),
(182, 26, 5, 'Episodio 5', NULL, NULL, NULL),
(183, 26, 6, 'Episodio 6', NULL, NULL, NULL),
(184, 26, 7, 'Episodio 7', NULL, NULL, NULL),
(185, 26, 8, 'Episodio 8', NULL, NULL, NULL),
(186, 26, 9, 'Episodio 9', NULL, NULL, NULL),
(187, 27, 1, 'Episodio 1', NULL, NULL, NULL),
(188, 27, 2, 'Episodio 2', NULL, NULL, NULL),
(189, 27, 3, 'Episodio 3', NULL, NULL, NULL),
(190, 27, 4, 'Episodio 4', NULL, NULL, NULL),
(191, 27, 5, 'Episodio 5', NULL, NULL, NULL),
(192, 27, 6, 'Episodio 6', NULL, NULL, NULL),
(193, 27, 7, 'Episodio 7', NULL, NULL, NULL),
(194, 27, 8, 'Episodio 8', NULL, NULL, NULL),
(195, 28, 1, 'Episodio 1', NULL, NULL, NULL),
(196, 28, 2, 'Episodio 2', NULL, NULL, NULL),
(197, 28, 3, 'Episodio 3', NULL, NULL, NULL),
(198, 28, 4, 'Episodio 4', NULL, NULL, NULL),
(199, 28, 5, 'Episodio 5', NULL, NULL, NULL),
(200, 28, 6, 'Episodio 6', NULL, NULL, NULL),
(201, 28, 7, 'Episodio 7', NULL, NULL, NULL),
(202, 28, 8, 'Episodio 8', NULL, NULL, NULL),
(203, 28, 9, 'Episodio 9', NULL, NULL, NULL),
(204, 28, 10, 'Episodio 10', NULL, NULL, NULL),
(205, 29, 1, 'Episodio 1', NULL, NULL, NULL),
(206, 29, 2, 'Episodio 2', NULL, NULL, NULL),
(207, 29, 3, 'Episodio 3', NULL, NULL, NULL),
(208, 29, 4, 'Episodio 4', NULL, NULL, NULL),
(209, 29, 5, 'Episodio 5', NULL, NULL, NULL),
(210, 29, 6, 'Episodio 6', NULL, NULL, NULL),
(211, 29, 7, 'Episodio 7', NULL, NULL, NULL),
(212, 29, 8, 'Episodio 8', NULL, NULL, NULL),
(213, 30, 1, 'Episodio 1', NULL, NULL, NULL),
(214, 30, 2, 'Episodio 2', NULL, NULL, NULL),
(215, 30, 3, 'Episodio 3', NULL, NULL, NULL),
(216, 30, 4, 'Episodio 4', NULL, NULL, NULL),
(217, 30, 5, 'Episodio 5', NULL, NULL, NULL),
(218, 30, 6, 'Episodio 6', NULL, NULL, NULL),
(219, 30, 7, 'Episodio 7', NULL, NULL, NULL),
(220, 30, 8, 'Episodio 8', NULL, NULL, NULL),
(221, 30, 9, 'Episodio 9', NULL, NULL, NULL),
(222, 30, 10, 'Episodio 10', NULL, NULL, NULL),
(223, 30, 11, 'Episodio 11', NULL, NULL, NULL),
(224, 30, 12, 'Episodio 12', NULL, NULL, NULL),
(225, 30, 13, 'Episodio 13', NULL, NULL, NULL),
(226, 30, 14, 'Episodio 14', NULL, NULL, NULL),
(227, 30, 15, 'Episodio 15', NULL, NULL, NULL),
(228, 30, 16, 'Episodio 16', NULL, NULL, NULL),
(229, 30, 17, 'Episodio 17', NULL, NULL, NULL),
(230, 30, 18, 'Episodio 18', NULL, NULL, NULL),
(231, 31, 1, 'Episodio 1', NULL, NULL, NULL),
(232, 31, 2, 'Episodio 2', NULL, NULL, NULL),
(233, 31, 3, 'Episodio 3', NULL, NULL, NULL),
(234, 31, 4, 'Episodio 4', NULL, NULL, NULL),
(235, 31, 5, 'Episodio 5', NULL, NULL, NULL),
(236, 31, 6, 'Episodio 6', NULL, NULL, NULL),
(237, 31, 7, 'Episodio 7', NULL, NULL, NULL),
(238, 31, 8, 'Episodio 8', NULL, NULL, NULL),
(239, 31, 9, 'Episodio 9', NULL, NULL, NULL),
(240, 31, 10, 'Episodio 10', NULL, NULL, NULL),
(241, 31, 11, 'Episodio 11', NULL, NULL, NULL),
(242, 31, 12, 'Episodio 12', NULL, NULL, NULL),
(243, 32, 1, 'Episodio 1', NULL, NULL, NULL),
(244, 32, 2, 'Episodio 2', NULL, NULL, NULL),
(245, 32, 3, 'Episodio 3', NULL, NULL, NULL),
(246, 32, 4, 'Episodio 4', NULL, NULL, NULL),
(247, 32, 5, 'Episodio 5', NULL, NULL, NULL),
(248, 32, 6, 'Episodio 6', NULL, NULL, NULL),
(249, 32, 7, 'Episodio 7', NULL, NULL, NULL),
(250, 32, 8, 'Episodio 8', NULL, NULL, NULL),
(251, 32, 9, 'Episodio 9', NULL, NULL, NULL),
(252, 32, 10, 'Episodio 10', NULL, NULL, NULL),
(253, 32, 11, 'Episodio 11', NULL, NULL, NULL),
(254, 32, 12, 'Episodio 12', NULL, NULL, NULL),
(255, 32, 13, 'Episodio 13', NULL, NULL, NULL),
(256, 32, 14, 'Episodio 14', NULL, NULL, NULL),
(257, 32, 15, 'Episodio 15', NULL, NULL, NULL),
(258, 32, 16, 'Episodio 16', NULL, NULL, NULL),
(259, 32, 17, 'Episodio 17', NULL, NULL, NULL),
(260, 32, 18, 'Episodio 18', NULL, NULL, NULL),
(261, 32, 19, 'Episodio 19', NULL, NULL, NULL),
(262, 32, 20, 'Episodio 20', NULL, NULL, NULL),
(263, 32, 21, 'Episodio 21', NULL, NULL, NULL),
(264, 32, 22, 'Episodio 22', NULL, NULL, NULL),
(265, 32, 23, 'Episodio 23', NULL, NULL, NULL),
(266, 32, 24, 'Episodio 24', NULL, NULL, NULL),
(267, 32, 25, 'Episodio 25', NULL, NULL, NULL),
(268, 32, 26, 'Episodio 26', NULL, NULL, NULL),
(269, 32, 27, 'Episodio 27', NULL, NULL, NULL),
(270, 32, 28, 'Episodio 28', NULL, NULL, NULL),
(271, 32, 29, 'Episodio 29', NULL, NULL, NULL),
(272, 32, 30, 'Episodio 30', NULL, NULL, NULL),
(273, 32, 31, 'Episodio 31', NULL, NULL, NULL),
(274, 32, 32, 'Episodio 32', NULL, NULL, NULL),
(275, 32, 33, 'Episodio 33', NULL, NULL, NULL),
(276, 32, 34, 'Episodio 34', NULL, NULL, NULL),
(277, 32, 35, 'Episodio 35', NULL, NULL, NULL),
(278, 32, 36, 'Episodio 36', NULL, NULL, NULL),
(279, 32, 37, 'Episodio 37', NULL, NULL, NULL),
(280, 32, 38, 'Episodio 38', NULL, NULL, NULL),
(281, 32, 39, 'Episodio 39', NULL, NULL, NULL),
(282, 32, 40, 'Episodio 40', NULL, NULL, NULL),
(283, 32, 41, 'Episodio 41', NULL, NULL, NULL),
(284, 32, 42, 'Episodio 42', NULL, NULL, NULL),
(285, 32, 43, 'Episodio 43', NULL, NULL, NULL),
(286, 32, 44, 'Episodio 44', NULL, NULL, NULL),
(287, 32, 45, 'Episodio 45', NULL, NULL, NULL),
(288, 32, 46, 'Episodio 46', NULL, NULL, NULL),
(289, 32, 47, 'Episodio 47', NULL, NULL, NULL),
(290, 32, 48, 'Episodio 48', NULL, NULL, NULL),
(291, 32, 49, 'Episodio 49', NULL, NULL, NULL),
(292, 32, 50, 'Episodio 50', NULL, NULL, NULL),
(293, 32, 51, 'Episodio 51', NULL, NULL, NULL),
(294, 32, 52, 'Episodio 52', NULL, NULL, NULL),
(295, 32, 53, 'Episodio 53', NULL, NULL, NULL),
(296, 32, 54, 'Episodio 54', NULL, NULL, NULL),
(297, 32, 55, 'Episodio 55', NULL, NULL, NULL),
(298, 32, 56, 'Episodio 56', NULL, NULL, NULL),
(299, 32, 57, 'Episodio 57', NULL, NULL, NULL),
(300, 32, 58, 'Episodio 58', NULL, NULL, NULL),
(301, 32, 59, 'Episodio 59', NULL, NULL, NULL),
(302, 32, 60, 'Episodio 60', NULL, NULL, NULL),
(303, 32, 61, 'Episodio 61', NULL, NULL, NULL),
(304, 32, 62, 'Episodio 62', NULL, NULL, NULL),
(305, 32, 63, 'Episodio 63', NULL, NULL, NULL),
(306, 32, 64, 'Episodio 64', NULL, NULL, NULL),
(307, 32, 65, 'Episodio 65', NULL, NULL, NULL),
(308, 32, 66, 'Episodio 66', NULL, NULL, NULL),
(309, 32, 67, 'Episodio 67', NULL, NULL, NULL),
(310, 32, 68, 'Episodio 68', NULL, NULL, NULL),
(311, 32, 69, 'Episodio 69', NULL, NULL, NULL),
(312, 32, 70, 'Episodio 70', NULL, NULL, NULL),
(313, 32, 71, 'Episodio 71', NULL, NULL, NULL),
(314, 32, 72, 'Episodio 72', NULL, NULL, NULL),
(315, 32, 73, 'Episodio 73', NULL, NULL, NULL),
(316, 32, 74, 'Episodio 74', NULL, NULL, NULL),
(317, 33, 1, 'Episodio 1', NULL, NULL, NULL),
(318, 33, 2, 'Episodio 2', NULL, NULL, NULL),
(319, 33, 3, 'Episodio 3', NULL, NULL, NULL),
(320, 33, 4, 'Episodio 4', NULL, NULL, NULL),
(321, 33, 5, 'Episodio 5', NULL, NULL, NULL),
(322, 33, 6, 'Episodio 6', NULL, NULL, NULL),
(323, 33, 7, 'Episodio 7', NULL, NULL, NULL),
(324, 33, 8, 'Episodio 8', NULL, NULL, NULL),
(325, 33, 9, 'Episodio 9', NULL, NULL, NULL),
(326, 33, 10, 'Episodio 10', NULL, NULL, NULL),
(327, 33, 11, 'Episodio 11', NULL, NULL, NULL),
(328, 33, 12, 'Episodio 12', NULL, NULL, NULL),
(329, 33, 13, 'Episodio 13', NULL, NULL, NULL),
(330, 33, 14, 'Episodio 14', NULL, NULL, NULL),
(331, 33, 15, 'Episodio 15', NULL, NULL, NULL),
(332, 33, 16, 'Episodio 16', NULL, NULL, NULL),
(333, 33, 17, 'Episodio 17', NULL, NULL, NULL),
(334, 33, 18, 'Episodio 18', NULL, NULL, NULL),
(335, 33, 19, 'Episodio 19', NULL, NULL, NULL),
(336, 33, 20, 'Episodio 20', NULL, NULL, NULL),
(337, 33, 21, 'Episodio 21', NULL, NULL, NULL),
(338, 33, 22, 'Episodio 22', NULL, NULL, NULL),
(339, 33, 23, 'Episodio 23', NULL, NULL, NULL),
(340, 33, 24, 'Episodio 24', NULL, NULL, NULL),
(341, 34, 1, 'Episodio 1', NULL, NULL, NULL),
(342, 34, 2, 'Episodio 2', NULL, NULL, NULL),
(343, 34, 3, 'Episodio 3', NULL, NULL, NULL),
(344, 34, 4, 'Episodio 4', NULL, NULL, NULL),
(345, 34, 5, 'Episodio 5', NULL, NULL, NULL),
(346, 34, 6, 'Episodio 6', NULL, NULL, NULL),
(347, 34, 7, 'Episodio 7', NULL, NULL, NULL),
(348, 34, 8, 'Episodio 8', NULL, NULL, NULL),
(349, 34, 9, 'Episodio 9', NULL, NULL, NULL),
(350, 34, 10, 'Episodio 10', NULL, NULL, NULL),
(351, 34, 11, 'Episodio 11', NULL, NULL, NULL),
(352, 34, 12, 'Episodio 12', NULL, NULL, NULL),
(353, 34, 13, 'Episodio 13', NULL, NULL, NULL),
(354, 34, 14, 'Episodio 14', NULL, NULL, NULL),
(355, 34, 15, 'Episodio 15', NULL, NULL, NULL),
(356, 34, 16, 'Episodio 16', NULL, NULL, NULL),
(357, 34, 17, 'Episodio 17', NULL, NULL, NULL),
(358, 34, 18, 'Episodio 18', NULL, NULL, NULL),
(359, 34, 19, 'Episodio 19', NULL, NULL, NULL),
(360, 34, 20, 'Episodio 20', NULL, NULL, NULL),
(361, 34, 21, 'Episodio 21', NULL, NULL, NULL),
(362, 34, 22, 'Episodio 22', NULL, NULL, NULL);

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
(5, 19, '2026-11-06 10:55:45'),
(5, 20, '2026-11-06 10:55:45'),
(5, 21, '2026-11-06 10:55:45'),
(5, 22, '2026-11-06 10:55:45');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(9, 8, 2, 'Temporada 2', NULL, '2017-10-27'),
(10, 23, 1, 'Temporada 1', NULL, NULL),
(11, 24, 1, 'Temporada 1', NULL, NULL),
(12, 25, 1, 'Temporada 1', NULL, NULL),
(13, 26, 1, 'Temporada 1', NULL, NULL),
(14, 27, 1, 'Temporada 1', NULL, NULL),
(15, 28, 1, 'Temporada 1', NULL, NULL),
(16, 29, 1, 'Temporada 1', NULL, NULL),
(17, 30, 1, 'Temporada 1', NULL, NULL),
(18, 31, 1, 'Temporada 1', NULL, NULL),
(19, 32, 1, 'Temporada 1', NULL, NULL),
(20, 34, 1, 'Temporada 1', NULL, NULL),
(21, 40, 1, 'Temporada 1', NULL, NULL),
(22, 53, 1, 'Temporada 1', NULL, NULL),
(23, 54, 1, 'Temporada 1', NULL, NULL),
(24, 55, 1, 'Temporada 1', NULL, NULL),
(25, 56, 1, 'Temporada 1', NULL, NULL),
(26, 66, 1, 'Temporada 1', NULL, NULL),
(27, 67, 1, 'Temporada 1', NULL, NULL),
(28, 68, 1, 'Temporada 1', NULL, NULL),
(29, 70, 1, 'Temporada 1', NULL, NULL),
(30, 71, 1, 'Temporada 1', NULL, NULL),
(31, 72, 1, 'Temporada 1', NULL, NULL),
(32, 73, 1, 'Temporada 1', NULL, NULL),
(33, 74, 1, 'Temporada 1', NULL, NULL),
(34, 75, 1, 'Temporada 1', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `perfil_publico` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `avatar`, `banner`, `descripcion`, `perfil_publico`, `fecha_registro`) VALUES
(5, 'Álvaro Colmenero Rodríguez', 'acolrod814@g.educaand.es', '$2y$12$0FmDo2kSPDGQXziIUFtof.Rul7ifoO6bkeIVh3sSNX39pvb8ky0qG', 'images/usuario/avatar/5.jpg', 'images/usuario/banner/5.jpg', NULL, 1, '2026-10-16 09:50:15'),
(6, 'Javier Martin Garcia', 'jmargar295w@g.educaand.es', '$2y$12$t4NNKQ1wNv/X9cmsVFHlPuvSVgZm0PvsJqVgseVFRMyhBC9M9X3Hm', NULL, NULL, NULL, 1, '2026-10-19 10:47:41');

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
  ADD UNIQUE KEY `correo` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `episodios`
--
ALTER TABLE `episodios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
