-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2019 a las 22:47:23
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cms`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administrators`
--

INSERT INTO `administrators` (`id`, `name`, `email`, `password`, `status`, `create_at`, `updated_at`) VALUES
(10, 'Juan Iriart', 'jeiriart@gmail.com', '$2y$10$58Rd/gCW0UDR0CgSOMVSIOS1IqfHiYcy/lS7ZKSNT2gh3.JkEsYUm', 1, '2019-08-18 20:18:09', '0000-00-00 00:00:00'),
(11, 'Juan Melo', 'juanimelo2507@gmail.com', '$2y$10$gcRHwVRZafvV0m0prhVAnuOyUny2SiAoGYkA5yDfYt2E3.z4hG8by', 1, '2019-08-18 20:20:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id_category` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cover` varchar(255) DEFAULT NULL,
  `seo_title` text,
  `seo_description` text,
  `seo_tags` text,
  `link_rewrite` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `blog_categories`
--

INSERT INTO `blog_categories` (`id_category`, `id_parent`, `status`, `name`, `description`, `cover`, `seo_title`, `seo_description`, `seo_tags`, `link_rewrite`, `create_at`, `update_at`) VALUES
(1, 0, 1, 'Noticias', NULL, NULL, NULL, NULL, NULL, 'noticias', '2019-08-08 19:50:11', '0000-00-00 00:00:00'),
(2, 0, 1, 'Tenencia responsable', NULL, NULL, NULL, NULL, NULL, 'tenencia-responsable', '2019-08-08 19:49:49', '0000-00-00 00:00:00'),
(3, 0, 1, 'Consejos', NULL, NULL, NULL, NULL, NULL, 'consejos', '2019-08-08 19:49:56', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_files`
--

CREATE TABLE `blog_files` (
  `id_file` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `file` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_gallery`
--

CREATE TABLE `blog_gallery` (
  `id_img` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `alt` varchar(150) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `img` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_post`
--

CREATE TABLE `blog_post` (
  `id_post` int(11) NOT NULL,
  `id_blog_category` int(11) NOT NULL,
  `title` text NOT NULL,
  `summary` text,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `seo_title` text,
  `seo_description` text,
  `seo_tags` text,
  `link_rewrite` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `blog_post`
--

INSERT INTO `blog_post` (`id_post`, `id_blog_category`, `title`, `summary`, `content`, `date`, `id_user`, `status`, `cover`, `seo_title`, `seo_description`, `seo_tags`, `link_rewrite`, `create_at`, `update_at`) VALUES
(1, 1, 'What are the most nutritious cat foods?', 'Aliquam erat volutpat In id fermentum augue, ut pellentesque leo. Maecenas at arcu risus. Donec commodo sodales ex, scelerisque laoreet nibh hendrerit id. In aliquet magna nec lobortis...', 'Aliquam erat volutpat In id fermentum augue, ut pellentesque leo. Maecenas at arcu risus. Donec commodo sodales ex, scelerisque laoreet nibh hendrerit id. In aliquet magna nec lobortis...', '2019-08-02', 7, '1', 'Olivia2.jpg', NULL, NULL, NULL, 'food-uno', '2019-08-09 13:32:38', '0000-00-00 00:00:00'),
(29, 3, 'POST method uploads', 'How many Bytes in a Megabyte\r\n1 Megabyte is equal to 1000000 bytes (decimal).\r\n1 MB = 106 B in base 10 (SI).\r\n\r\n1 Megabyte is equal to 1048576 bytes (binary).\r\n1 MB = 220 B in base 2.', '<p>How many Bytes in a Megabyte</p><p><strong>1 Megabyte is equal to 1000000 bytes</strong>&nbsp;(decimal).<br />1 MB = 106&nbsp;B in base 10 (SI).</p><p><strong>1 Megabyte is equal to 1048576 bytes</strong>&nbsp;(binary).<br />1 MB = 220&nbsp;B in base 2.</p>', '2019-08-12', 7, '1', 'cover_2019081217084374.jpg', NULL, NULL, NULL, 'post-method-uploads', '2019-08-12 20:35:28', '0000-00-00 00:00:00'),
(30, 2, 'POfasfsafasd', 'lass.upload.php samples, a files uploading and images manipulation PHP class', '<p>lass.upload.php samples, a files uploading and images manipulation PHP classlass.upload.php samples, a files uploading and images manipulation PHP class</p>\r\n', '2019-08-12', 7, '1', 'cover_2019081217082487.jpg', NULL, NULL, NULL, 'pofasfsafasd', '2019-08-20 18:35:44', '0000-00-00 00:00:00'),
(31, 1, 'Tarja \"DEAD PROMISES\" Official Lyric Video - From the album \"In The Raw\"', 'lass.upload.php samples, a files uploading and images manipulation PHP class', '<p>lass.upload.php samples, a files uploading and images manipulation PHP class</p>\r\n', '2019-08-12', 7, '1', 'cover_201908141808109.jpg', NULL, NULL, NULL, 'tarja-quot-dead-promises-quot-official-lyric-video-from-the-album-quot-in-the-raw-quot', '2019-08-16 13:10:09', '0000-00-00 00:00:00'),
(32, 2, 'hay un cos', 'We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the Slim 4 Release Feedback Thread. The new docs are located here.', '<p>We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the&nbsp;<a href=\"https://github.com/slimphp/Slim/issues/2770\">Slim 4 Release Feedback Thread</a>. The new docs are located&nbsp;<a href=\"http://www.slimframework.com/docs/v4\">here</a>.We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the&nbsp;<a href=\"https://github.com/slimphp/Slim/issues/2770\">Slim 4 Release Feedback Thread</a>. The new docs are located&nbsp;<a href=\"http://www.slimframework.com/docs/v4\">here</a>.We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the&nbsp;<a href=\"https://github.com/slimphp/Slim/issues/2770\">Slim 4 Release Feedback Thread</a>. The new docs are located&nbsp;<a href=\"http://www.slimframework.com/docs/v4\">here</a>.We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the&nbsp;<a href=\"https://github.com/slimphp/Slim/issues/2770\">Slim 4 Release Feedback Thread</a>. The new docs are located&nbsp;<a href=\"http://www.slimframework.com/docs/v4\">here</a>.We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the&nbsp;<a href=\"https://github.com/slimphp/Slim/issues/2770\">Slim 4 Release Feedback Thread</a>. The new docs are located&nbsp;<a href=\"http://www.slimframework.com/docs/v4\">here</a>.We are excited to announce the Slim 4.1.0 release. Please direct all your feedback for this release to the&nbsp;<a href=\"https://github.com/slimphp/Slim/issues/2770\">Slim 4 Release Feedback Thread</a>. The new docs are located&nbsp;<a href=\"http://www.slimframework.com/docs/v4\">here</a>.</p>\r\n', '2019-08-12', 7, '1', 'cover_2019081218082694.jpg', NULL, NULL, NULL, 'hay-un-cos', '2019-08-20 18:35:55', '0000-00-00 00:00:00'),
(33, 3, 'Unaddressed BC Break From 4.0.0', 'Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0', '<p>Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0Unaddressed BC Break From 4.0.0</p>\r\n', '2019-08-12', 7, '0', 'cover_2019081218082357.jpg', NULL, NULL, NULL, 'unaddressed-bc-break-from-4-0-0', '2019-08-20 19:09:21', '0000-00-00 00:00:00'),
(34, 1, '¿No encuentras la respuesta? Pregunta en Stack Overflow en español.', '¿No encuentras la respuesta? Pregunta en Stack Overflow en español.¿No encuentras la respuesta? Pregunta en Stack Overflow en español.¿No encuentras la respuesta? Pregunta en Stack Overflow en español.¿No encuentras la respuesta? Pregunta en Stack Overflow en español.', '<p>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a>&iquest;No encuentras la respuesta?&nbsp;<a href=\"http://es.stackoverflow.com/questions/ask?fromen=1a951f101b102\">Pregunta en Stack Overflow en espa&ntilde;ol.</a></p>\r\n', '2019-08-16', 7, '1', 'cover_2019081613083693.jpg', NULL, NULL, NULL, 'iquest-no-encuentras-la-respuesta-pregunta-en-stack-overflow-en-espanol', '2019-08-20 20:47:00', '0000-00-00 00:00:00'),
(35, 1, 'Una Prueba', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', '<p>.</p>\r\n\r\n<h2>Why do we use it?</h2>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\r\n\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n\r\n<h2>Where can I get some?</h2>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\r\n\r\n<p><br />\r\nparagraphswordsbyteslists<br />\r\nStart with &#39;Lorem<br />\r\nipsum dolor sit amet...&#39;</p>\r\n', '2019-08-20', 7, '1', 'cover_2019082016082454.jpg', NULL, NULL, NULL, 'una-prueba', '2019-08-20 19:17:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bog_comments`
--

CREATE TABLE `bog_comments` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id_page` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `seo_title` text,
  `seo_description` text,
  `seo_tags` text,
  `link_rewrite` text NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id_page`, `title`, `content`, `status`, `seo_title`, `seo_description`, `seo_tags`, `link_rewrite`, `date_add`, `date_upd`) VALUES
(1, 'Sobre Mi Perro & Yo', ' <!-- ==== Page Content ==== -->\r\n   <div class=\"page\">\r\n      <div class=\"container about-section block-padding no-bg-small\">\r\n         <!--row -->\r\n         <div class=\"row pb-3\">\r\n            <div class=\"col-lg-6\">\r\n               <h2>Un perro es AMOR pero también...</h2>\r\n               <p class=\"mt-3 res-margin\">Tiempo, paciencia, economía, responsabilidad, espacio...</p>\r\n               <h5 class=\"mt-2\">Lorem ipsum dolor</h5>\r\n               <p>Maecenas at arcu risus. Donec commodo sodales ex, scelerisque laoreet nibh hendrerit id. In aliquet magna nec lobortis maximus. Etiam rhoncus leo a dolor placerat, nec elementum ipsum convall.</p>\r\n               <!-- Buttons -->	 \r\n               <a href=\"../contacto/\" class=\"btn btn-primary mt-4\">Contactame</a>\r\n               <a href=\"../tenencia-responsable/\" class=\"btn btn-secondary mt-4 ml-1\">Responsabilidad</a>\r\n            </div>\r\n            <!-- /col-lg-6-->\r\n         </div>\r\n         <!-- /row -->\r\n      </div>\r\n      <!-- /container-->\r\n      <!-- Section  -->\r\n      <section id=\"counter-section\" class=\"container-fluid counter-calltoaction bg-fixed overlay\">\r\n         <div id=\"counter\" class=\"container\">\r\n            <div  class=\"row col-lg-10 offset-lg-1\">\r\n               <!-- Counter -->\r\n               <div class=\"col-xl-3 col-md-6\">\r\n                  <div class=\"counter\">\r\n                     <i class=\"counter-icon flaticon-dog-in-front-of-a-man\"></i>\r\n                     <!-- insert your final value on data-count= -->\r\n                     <div class=\"counter-value\" data-count=\"14\">0</div>\r\n                     <h3 class=\"title\">Lorem</h3>\r\n                  </div>\r\n                  <!-- /counter -->\r\n               </div>\r\n               <!-- /col-lg -->		\r\n               <!-- Counter -->\r\n               <div class=\"col-xl-3 col-md-6\">\r\n                  <div class=\"counter\">\r\n                     <i class=\"counter-icon flaticon-dog-2\"></i>\r\n                     <!-- insert your final value on data-count= -->\r\n                     <div class=\"counter-value\" data-count=\"100\">0</div>\r\n                     <h3 class=\"title\">Lorem</h3>\r\n                  </div>\r\n                  <!-- /counter -->\r\n               </div>\r\n               <!-- /col-lg -->\r\n               <!-- Counter -->\r\n               <div class=\"col-xl-3 col-md-6\">\r\n                  <div class=\"counter\">\r\n                     <i class=\"counter-icon flaticon-prize-badge-with-paw-print\"></i>\r\n                     <!-- insert your final value on data-count= -->\r\n                     <div class=\"counter-value\" data-count=\"12\">0</div>\r\n                     <h3 class=\"title\">Lorem</h3>\r\n                  </div>\r\n                  <!-- /counter -->\r\n               </div>\r\n               <!-- /col-lg -->\r\n               <!-- Counter -->\r\n               <div class=\"col-xl-3 col-md-6\">\r\n                  <div class=\"counter\">\r\n                     <i class=\"counter-icon flaticon-dog-18\"></i>\r\n                     <!-- insert your final value on data-count= -->\r\n                     <div class=\"counter-value\" data-count=\"1200\">0</div>\r\n                     <h3 class=\"title\">Lorem</h3>\r\n                  </div>\r\n                  <!-- /counter -->\r\n               </div>\r\n               <!-- /col-lg -->\r\n            </div>\r\n            <!-- /row -->\r\n         </div>\r\n         <!-- /container -->\r\n      </section>\r\n      <!-- /section ends-->\r\n\r\n       <!-- ==== Page Content ==== -->\r\n       <div class=\"page container\">\r\n         <div class=\"row\">\r\n            <!-- page with sidebar starts -->\r\n            <div class=\"col-xl-6\">\r\n               <h2>Quiero tener un perro</h2>\r\n               <!-- divider -->\r\n               <hr class=\"small-divider left\">\r\n               <div class=\"row\">\r\n                  <div class=\"col-xl-12\">\r\n                     <p class=\"mt-4 res-margin\">Es lo que muchos dicen ó piensan cuando ven a estas mascotas de cuatro patas tan tiernas, divertidas y fieles al pasear con su dueño.\r\n                        Cuando yo decidí tener un perro, sabía que con el sólo deseo no era suficiente. Un perro, es un ser vivo, que desde el momento que decidimos integrarlo a nuestra vida, NADA será como antes.</p>\r\n                  </div>\r\n                  <!-- /col-xl -->\r\n               </div>\r\n               <!-- /row -->\r\n               <!-- /container -->\r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n               <!-- image -->\r\n               <img class=\"img-fluid rounded\" src=\"../assets/img/background/about1.jpg\" alt=\"\">\r\n            </div>\r\n            <!-- /page-with-sidebar --> \r\n         </div>\r\n         <!-- /row -->\r\n      </div>\r\n      <div class=\"container\">\r\n         <div class=\"row\">\r\n            <div class=\"col-xl-12\">\r\n               <div class=\"title-about\">\r\n                  <h2>Así que previo a dar el gran paso, me hice las siguientes preguntas:</h2>\r\n               </div>\r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-imagen-pregunta\" data-aos=\"slide-right\">\r\n                        <img src=\"../assets/img/background/olivia1.jpg\" alt=\"\">\r\n                     </div>\r\n              \r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-pregunta\">\r\n                     <div class=\"contenido-pregunta-title\">\r\n                        <h3>Tiempo</h3>\r\n                     </div>\r\n                     <div class=\"contenido-pregunta-desc\">\r\n                        <p>¿Voy a tener el tiempo suficiente para pasear con mi perro?</p>\r\n                     </div>\r\n                  </div>\r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-pregunta\">\r\n                     <div class=\"contenido-pregunta-title\">\r\n                        <h3>Paciencia</h3>\r\n                     </div>\r\n                     <div class=\"contenido-pregunta-desc\">\r\n                        <p>¿Tendré la paciencia necesaria para educarlo?</p>\r\n                     </div>\r\n                  </div>\r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-imagen-pregunta\" data-aos=\"slide-left\">\r\n                        <img src=\"../assets/img/background/olivia2.jpg\" alt=\"\">\r\n                     </div>\r\n              \r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-imagen-pregunta\" data-aos=\"slide-right\">\r\n                        <img src=\"../assets/img/background/olivia3.jpg\" alt=\"\">\r\n                     </div>\r\n              \r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-pregunta\">\r\n                     <div class=\"contenido-pregunta-title\">\r\n                        <h3>Economía</h3>\r\n                     </div>\r\n                     <div class=\"contenido-pregunta-desc\">\r\n                        <p>¿Cuento con los recursos económicos para cubrir gastos de veterinaria, alimento, accesorios que le brinden placer (juguetes) ó bienestar (camitas y abrigo)?</p>\r\n                     </div>\r\n                  </div>\r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-pregunta\">\r\n                     <div class=\"contenido-pregunta-title\">\r\n                        <h3>¿Y en vacaciones?</h3>\r\n                     </div>\r\n                     <div class=\"contenido-pregunta-desc\">\r\n                        <p>¿Sabré qué hacer con mi perro cuando me vaya de vacaciones?</p>\r\n                     </div>\r\n                  </div>\r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-imagen-pregunta\" data-aos=\"slide-left\">\r\n                        <img src=\"../assets/img/background/olivia4.jpg\" alt=\"\">\r\n                     </div>\r\n              \r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-imagen-pregunta\" data-aos=\"slide-right\">\r\n                        <img src=\"../assets/img/background/olivia5.jpg\" alt=\"\">\r\n                     </div>\r\n              \r\n            </div>\r\n            <div class=\"col-xl-6\">\r\n                  <div class=\"contenido-pregunta\">\r\n                     <div class=\"contenido-pregunta-title\">\r\n                        <h3>Espacio</h3>\r\n                     </div>\r\n                     <div class=\"contenido-pregunta-desc\">\r\n                        <p>¿Tengo el espacio en mi casa que le permita adaptarse cómodamente?</p>\r\n                     </div>\r\n                  </div>\r\n            </div>\r\n         </div>\r\n      </div>  \r\n      <div class=\"container\">\r\n         <div class=\"row\">\r\n            <div class=\"col-xl-12\">\r\n               <div class=\"separador\">\r\n                  <hr>\r\n               </div>\r\n            </div>\r\n            <div class=\"col-xl-12 bg-nota\">\r\n               <div class=\"nota-title\">\r\n                  <h3>Un perro, es AMOR, el más puro e incondicional que yo conocí. Pero un perro, también es RESPONSABILIDAD Y COMPROMISO.</h3>\r\n               </div>\r\n               <div class=\"nota-desc\">\r\n                  <p>Olivia, llegó a mi vida en Mayo del 2016. Ella es mi amiga, mi compañera.  Para mi perra, quiero lo mejor. Mi compromiso es cuidarla y compartir tiempo de calidad con ella.</p>\r\n                  <p>En <b>Mi Perro & Yo</b>, vas a poder encontrar consejos sobre <b>Tenencia Responsable</b>, como así también <b>buscar productos y servicios vinculados al mundo canino</b>.</p>\r\n                  <p>Ojalá puedas ayudarnos a compartir más experiencias con y de tu perro en este maravilloso espacio que creamos para ti.<br><br><br>Gracias por visitarnos.</p>\r\n               </div>\r\n               <div class=\"nota-firma\"> \r\n                  <p>Verónica Fernández Russo</p>\r\n                  <p><b>Mi Perro & Yo</b></p>\r\n               </div>\r\n            </div>\r\n         </div>\r\n      </div>\r\n   </div>\r\n   <!-- /page -->', '', NULL, NULL, NULL, 'sobre-nosotros', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Términos y condiciones', '<div class=\"contenido-institucional\">    <div class=\"container\">        <div class=\"row\">          <div class=\"info-institucional\">             <div class=\"info-institucional-title\">                <h2>This is a title</h2>             </div>             <div class=\"info-institucional-desc\">                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit, dapibus magnis eu cum porta placerat risus mattis, suspendisse ac hac fringilla malesuada iaculis. Senectus metus hendrerit tempus mauris malesuada tortor, eget condimentum porta sem neque ultrices, ultricies augue venenatis tellus blandit. Ultrices donec maecenas egestas taciti neque sollicitudin arcu libero senectus nibh, cum leo nulla massa felis facilisis duis nostra varius, pellentesque habitasse urna posuere scelerisque eu laoreet nisl euismod.                </br></br>                Lorem ipsum dolor sit amet consectetur adipiscing elit, dapibus magnis eu cum porta placerat risus mattis, suspendisse ac hac fringilla malesuada iaculis. Senectus metus hendrerit tempus mauris malesuada tortor, eget condimentum porta sem neque ultrices, ultricies augue venenatis tellus blandit. Ultrices donec maecenas egestas taciti neque sollicitudin arcu libero senectus nibh, cum leo nulla massa felis facilisis duis nostra varius, pellentesque habitasse urna posuere scelerisque eu laoreet nisl euismod.                </p>             </div>          </div>       </div>    </div> </div>', '', NULL, NULL, NULL, 'terminos-y-condiciones', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Políticas de cookies', '<div class=\"contenido-institucional\">    <div class=\"container\">        <div class=\"row\">          <div class=\"info-institucional\">             <div class=\"info-institucional-title\">                <h2>This is a title</h2>             </div>             <div class=\"info-institucional-desc\">                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit, dapibus magnis eu cum porta placerat risus mattis, suspendisse ac hac fringilla malesuada iaculis. Senectus metus hendrerit tempus mauris malesuada tortor, eget condimentum porta sem neque ultrices, ultricies augue venenatis tellus blandit. Ultrices donec maecenas egestas taciti neque sollicitudin arcu libero senectus nibh, cum leo nulla massa felis facilisis duis nostra varius, pellentesque habitasse urna posuere scelerisque eu laoreet nisl euismod.                </br></br>                Lorem ipsum dolor sit amet consectetur adipiscing elit, dapibus magnis eu cum porta placerat risus mattis, suspendisse ac hac fringilla malesuada iaculis. Senectus metus hendrerit tempus mauris malesuada tortor, eget condimentum porta sem neque ultrices, ultricies augue venenatis tellus blandit. Ultrices donec maecenas egestas taciti neque sollicitudin arcu libero senectus nibh, cum leo nulla massa felis facilisis duis nostra varius, pellentesque habitasse urna posuere scelerisque eu laoreet nisl euismod.                </p>             </div>          </div>       </div>    </div> </div>', '', NULL, NULL, NULL, 'politica-de-cookies', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Políticas de privacidad', '<div class=\"contenido-institucional\">    <div class=\"container\">        <div class=\"row\">          <div class=\"info-institucional\">             <div class=\"info-institucional-title\">                <h2>This is a title</h2>             </div>             <div class=\"info-institucional-desc\">                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit, dapibus magnis eu cum porta placerat risus mattis, suspendisse ac hac fringilla malesuada iaculis. Senectus metus hendrerit tempus mauris malesuada tortor, eget condimentum porta sem neque ultrices, ultricies augue venenatis tellus blandit. Ultrices donec maecenas egestas taciti neque sollicitudin arcu libero senectus nibh, cum leo nulla massa felis facilisis duis nostra varius, pellentesque habitasse urna posuere scelerisque eu laoreet nisl euismod.                </br></br>                Lorem ipsum dolor sit amet consectetur adipiscing elit, dapibus magnis eu cum porta placerat risus mattis, suspendisse ac hac fringilla malesuada iaculis. Senectus metus hendrerit tempus mauris malesuada tortor, eget condimentum porta sem neque ultrices, ultricies augue venenatis tellus blandit. Ultrices donec maecenas egestas taciti neque sollicitudin arcu libero senectus nibh, cum leo nulla massa felis facilisis duis nostra varius, pellentesque habitasse urna posuere scelerisque eu laoreet nisl euismod.                </p>             </div>          </div>       </div>    </div> </div>', '', NULL, NULL, NULL, 'politica-de-privacidad', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL,
  `is_admin` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `phone`, `email`, `password`, `status`, `is_admin`) VALUES
(7, 'JOni', 'Iriart', '+543456483117', 'jeiriart@gmail.com', '$2y$10$lsZ6IcktsN87vK.sr6ECP.1d/4Cw7u6hT/uMnpTt1SKVNXPZ.ogPS', 1, 1),
(18, 'Juan', 'Melo', '', 'juanimelo2507@gmail.com', '$2y$10$StDMtDOae2Wb12O73wyS9OaGKfVvGc8mvn5oJTCkXrLK3qrE8AviG', 1, 1),
(19, 'Mi Perro', 'y Yo', '', 'info@miperroyyo.com.ar', '$2y$10$LHeY7vr1K/fh6NrhSKaBZetKRNBfK3SRAJ3ik0c9qK00oUldVf6x.', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `blog_files`
--
ALTER TABLE `blog_files`
  ADD PRIMARY KEY (`id_file`);

--
-- Indices de la tabla `blog_gallery`
--
ALTER TABLE `blog_gallery`
  ADD PRIMARY KEY (`id_img`);

--
-- Indices de la tabla `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`id_post`);

--
-- Indices de la tabla `bog_comments`
--
ALTER TABLE `bog_comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id_page`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `blog_files`
--
ALTER TABLE `blog_files`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blog_gallery`
--
ALTER TABLE `blog_gallery`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `bog_comments`
--
ALTER TABLE `bog_comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
