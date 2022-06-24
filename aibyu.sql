-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Ven 24 Juin 2022 à 10:48
-- Version du serveur :  10.3.31-MariaDB-0+deb10u1
-- Version de PHP :  7.3.31-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `aibyu`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `title`, `color`) VALUES
(0, 'Par défaut', '#ffffff'),
(15, 'Soirée', '#db0000'),
(16, 'Sortie montagne', '#31c214'),
(17, 'sortie été', '#f0c800'),
(18, 'Sortie neige', '#00b4f0'),
(19, 'Sortie jeux', '#e809ec');

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float DEFAULT NULL,
  `date` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id`, `title`, `description`, `price`, `date`, `image`, `id_category`, `id_users`) VALUES
(45, 'Boom fin d\'année 2022', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor.', 10, '2022-06-27 22:00:00', '62b58e6d15707-1656065645.jpeg', 15, 40),
(46, 'Boom fin d\'année 2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet.', 10, '2021-06-24 22:00:00', '62b58ee47f98b-1656065764.jpeg', 15, 40),
(47, 'Balade en montagne', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi.', 25, '2022-06-29 08:00:00', '62b58f48950bf-1656065864.jpeg', 16, 40),
(48, 'Fête foraine', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi.', 30, '2022-06-24 14:00:00', '62b58f931d6d5-1656065939.jpeg', 17, 40),
(49, 'Ski et snowboard', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi.', 1000, '2021-12-09 12:20:00', '62b58ff64fb53-1656066038.jpeg', 18, 40),
(50, 'Bataille contre les boss', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam.', 0, '2022-06-29 16:00:00', '62b590ef0b3d7-1656066287.jpeg', 19, 40),
(51, 'Snowboard', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor.', 100, '2020-01-24 05:25:00', '62b592da99eba-1656066778.jpeg', 18, 40),
(52, 'Japan touch', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna.', 50, '2020-05-07 15:30:00', '62b591b6dc84e-1656066486.jpeg', 17, 40),
(53, 'Randonnée', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio.', 25, '2022-03-10 10:30:00', '62b591f4edcf1-1656066548.jpeg', 16, 40),
(54, 'Festival jeux rétro', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem.', 25, '2022-06-30 18:30:00', '62b592b45f673-1656066740.jpeg', 19, 40),
(55, 'Soirée d\'intégration', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna. Phasellus condimentum, lorem pulvinar pulvinar porttitor, metus diam feugiat nisi, sit amet aliquet nibh augue sit amet odio. Suspendisse et nulla ac mauris condimentum auctor id ut nisi. Suspendisse rutrum enim a nulla consequat, ut elementum odio facilisis. Aliquam finibus ullamcorper dolor, non tincidunt eros tempus sit amet. Suspendisse potenti. Phasellus eu urna lacinia nibh condimentum tristique. Pellentesque eget neque in tellus scelerisque porttitor.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan aliquet ex, ut hendrerit lorem tempus ac. Duis viverra, leo eget iaculis elementum, mauris massa iaculis dolor, ut porttitor metus massa a magna.', 20, '2022-09-01 20:00:00', '62b5933e17592-1656066878.jpeg', 15, 40);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`id`, `name`, `description`, `date`, `link`) VALUES
(18, 'Journée Portes Ouvertes de l\'ESGI Paris ', 'Journée portes ouvertes le 28/06/2022 à l\'ESGI de paris', '2022-06-28', 'https://www.defi-metiers.fr/evenements/journee-portes-ouvertes-de-lesgi-paris'),
(19, 'Fin du monde', 'Fin du monde demain a 8h !', '2022-06-25', 'https://www.sortiraparis.com/loisirs/insolite/articles/241220-l-horloge-de-l-apocalypse-2022-indique-encore-100-secondes-avant-la-fin-du-monde'),
(20, 'Mettez nous 20', 'Nous méritons 20 sur le projet', '2022-06-24', 'https://ejd2izp9e9t.exactdn.com/wp-content/uploads/2021/02/20-sur-20.jpg?strip=all&lossy=1&ssl=1');

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

CREATE TABLE `participer` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `participer`
--

INSERT INTO `participer` (`id`, `id_users`) VALUES
(45, 50),
(45, 53),
(45, 54),
(47, 47),
(47, 48),
(47, 50),
(48, 46),
(48, 49),
(48, 50),
(48, 51),
(48, 52),
(48, 53),
(48, 54),
(50, 40),
(50, 46),
(50, 47),
(50, 48),
(50, 49),
(50, 50),
(50, 51),
(50, 52),
(50, 53),
(50, 54),
(54, 46);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(8, 'Admin'),
(9, 'BDE'),
(10, 'User');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `id_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `mail`, `password`, `image`, `birthdate`, `id_role`) VALUES
(0, 'BDE', 'Admin', 'admin@myges.fr', '$2y$10$07zdVkq4gXG0QHbmy9lJk.LOJDOQpLOlW2nFHq.hF9R2p29yQrbQO', '', '2222-02-22', 8),
(40, 'Admin', 'Admin', 'wyvin@myges.fr', '$2y$10$BaC85z4ycEH.Bh5S1qeUVuvGMOB7m/t1ciibdXlmqNBlW2Hn.69oe', '62b583c3c1847-1656062915.png', '1993-12-18', 8),
(41, 'BDE', 'BDE', 'nadia@myges.fr', '$2y$10$7FeSYClM3E.7Oif6EC1nnOkQix3E8mcXpRl7K0jBvSqEEVn98U4g6', '', '2000-03-21', 9),
(42, 'Sofia', 'Chaudhry', 'sofia@myges.fr', '$2y$10$rWsNYdXVBUtiYVV71WyZ4.a3OvV.4vESajw02BglbiXR97pOJlO.2', '', '2001-06-26', 10),
(46, 'Alex', 'Robbrecht', 'Robbrecht@myges.fr', '$2y$10$Cud53a0VL/xdmo93xaILreqpxq05xcTeKFNHDBdo89lSYRvx7QS7y', '', '2001-02-12', 10),
(47, 'Bilal', 'Bouterbiat', 'Bouterbiat@myges.fr', '$2y$10$kJYJdoYsqWgbwt35VdZO6.WQCb7nCl7LdppyVbJ1ApDgqzyx0qf.2', '', '2001-02-21', 10),
(48, 'Clément', 'Martinet', 'Martinet@myges.fr', '$2y$10$/aGR.J3o2QFS8Ssb5CFE9.3npHEox/BtgC2vaugBMaollusrOJidK', '', '2001-02-12', 10),
(49, 'Erica', 'Grace', 'Grace@myges.fr', '$2y$10$f4D1TX/.j51GrbYSRNtYVOvuYY6IS2yAovL5q1naUU8GKNd3axnAC', '', '2001-04-05', 10),
(50, 'Audrey', 'Hossepian', 'Hossepian@myges.fr', '$2y$10$hAqfBC7OA/Thc6Ke.FmRbOcqxHBAkBSLLUjXu4w9ukx07J6h0HYZ.', '', '2001-05-06', 10),
(51, 'Basile', 'Regnault', 'Regnault@myges.fr', '$2y$10$iNzicT5K4D.a3S2LJUDO7uQBGKPsl4XdEYNv5I.p9Dku9Bt9ysvDG', '', '2001-06-05', 10),
(52, 'Coline', 'Salvi', 'Salvi@myges.fr', '$2y$10$UfS0/nY0ZQV/mBuTnHwlNe8fQDFkgxQGoY7rxneB9/FMMpas2Jo0i', '', '2001-06-05', 10),
(53, 'Laura', 'Fauvet', 'Fauvet@myges.fr', '$2y$10$1cczFEx2WQ8J9GNFLwhKz.aLk.baWTEWkC6KZ6W5ZIbR8S1RVnARy', '', '2011-08-09', 10),
(54, 'Rédouane', 'Remili', 'Remili@myges.fr', '$2y$10$Kg..i.b89a.JCCty8e3AVeIf12jLLJsI9LeKnvf146/ypc6xQMk7W', '', '2001-05-06', 10);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_category_FK` (`id_category`),
  ADD KEY `event_users0_FK` (`id_users`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_event_FK` (`id_event`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `participer`
--
ALTER TABLE `participer`
  ADD PRIMARY KEY (`id`,`id_users`),
  ADD KEY `participer_users0_FK` (`id_users`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_FK` (`id_role`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_category_FK` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `event_users0_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_event_FK` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`);

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `participer_event_FK` FOREIGN KEY (`id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `participer_users0_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_FK` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
