-- 
-- BroadAPI DATABASE STRUCTURE
-- v0.1 BETA
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Table structure for table `episodes`
--

CREATE TABLE IF NOT EXISTS `episodes` (
  `serie_id` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `ep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
`id` int(11) NOT NULL,
  `id_msg` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL,
  `msg_alt` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE IF NOT EXISTS `series` (
`id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `codec` varchar(255) NOT NULL,
  `resolution` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `container` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
 ADD UNIQUE KEY `serie_id` (`serie_id`,`season`,`ep`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`), ADD KEY `id_2` (`id`), ADD KEY `id_3` (`id`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
