SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sqlgrey`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `parameter` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `connect`
--

CREATE TABLE `connect` (
  `sender_name` varchar(64) NOT NULL,
  `sender_domain` varchar(255) NOT NULL,
  `src` varchar(39) NOT NULL,
  `rcpt` varchar(255) NOT NULL,
  `first_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `domain_awl`
--

CREATE TABLE `domain_awl` (
  `sender_domain` varchar(255) NOT NULL,
  `src` varchar(39) NOT NULL,
  `first_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_seen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `from_awl`
--

CREATE TABLE `from_awl` (
  `sender_name` varchar(64) NOT NULL,
  `sender_domain` varchar(255) NOT NULL,
  `src` varchar(39) NOT NULL,
  `first_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_seen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `optin_domain`
--

CREATE TABLE `optin_domain` (
  `domain` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `optin_email`
--

CREATE TABLE `optin_email` (
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `optout_domain`
--

CREATE TABLE `optout_domain` (
  `domain` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `optout_email`
--

CREATE TABLE `optout_email` (
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`parameter`);

--
-- Indexes for table `connect`
--
ALTER TABLE `connect`
  ADD KEY `connect_idx` (`src`,`sender_domain`,`sender_name`),
  ADD KEY `connect_fseen` (`first_seen`);

--
-- Indexes for table `domain_awl`
--
ALTER TABLE `domain_awl`
  ADD PRIMARY KEY (`src`,`sender_domain`),
  ADD KEY `domain_awl_lseen` (`last_seen`);

--
-- Indexes for table `from_awl`
--
ALTER TABLE `from_awl`
  ADD PRIMARY KEY (`src`,`sender_domain`,`sender_name`),
  ADD KEY `from_awl_lseen` (`last_seen`);

--
-- Indexes for table `optin_domain`
--
ALTER TABLE `optin_domain`
  ADD PRIMARY KEY (`domain`);

--
-- Indexes for table `optin_email`
--
ALTER TABLE `optin_email`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `optout_domain`
--
ALTER TABLE `optout_domain`
  ADD PRIMARY KEY (`domain`);

--
-- Indexes for table `optout_email`
--
ALTER TABLE `optout_email`
  ADD PRIMARY KEY (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;