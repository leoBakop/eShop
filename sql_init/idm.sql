-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: Jan 12, 2023 at 03:24 PM
-- Server version: 5.7.40
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE USER 'keyrock'@'localhost' IDENTIFIED BY 'keyrock';
GRANT ALL PRIVILEGES ON *.* TO 'keyrock'@'localhost' WITH GRANT OPTION;
CREATE USER 'keyrock'@'%' IDENTIFIED BY 'keyrock';
GRANT ALL PRIVILEGES ON *.* TO 'keyrock'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

--
-- Database: `idm`
--

-- --------------------------------------------------------

--
-- Table structure for table `authzforce`
--

CREATE TABLE `authzforce` (
  `az_domain` varchar(255) NOT NULL,
  `policy` char(36) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token`
--

CREATE TABLE `auth_token` (
  `access_token` varchar(255) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `pep_proxy_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_token`
--

INSERT INTO `auth_token` (`access_token`, `expires`, `valid`, `user_id`, `pep_proxy_id`) VALUES
('00d0ceb4-1a3b-4370-ae92-431ec39f7ad4', '2022-12-18 08:39:29', 1, 'admin', NULL);

--
-- Table structure for table `eidas_credentials`
--

CREATE TABLE `eidas_credentials` (
  `id` varchar(36) NOT NULL,
  `support_contact_person_name` varchar(255) DEFAULT NULL,
  `support_contact_person_surname` varchar(255) DEFAULT NULL,
  `support_contact_person_email` varchar(255) DEFAULT NULL,
  `support_contact_person_telephone_number` varchar(255) DEFAULT NULL,
  `support_contact_person_company` varchar(255) DEFAULT NULL,
  `technical_contact_person_name` varchar(255) DEFAULT NULL,
  `technical_contact_person_surname` varchar(255) DEFAULT NULL,
  `technical_contact_person_email` varchar(255) DEFAULT NULL,
  `technical_contact_person_telephone_number` varchar(255) DEFAULT NULL,
  `technical_contact_person_company` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `organization_url` varchar(255) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `organization_nif` varchar(255) DEFAULT NULL,
  `sp_type` varchar(255) DEFAULT 'private',
  `attributes_list` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `iot`
--

CREATE TABLE `iot` (
  `id` varchar(255) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_token`
--

CREATE TABLE `oauth_access_token` (
  `access_token` varchar(255) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `refresh_token` varchar(255) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `iot_id` varchar(255) DEFAULT NULL,
  `authorization_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_access_token`
--

INSERT INTO `oauth_access_token` (`access_token`, `expires`, `scope`, `refresh_token`, `valid`, `extra`, `oauth_client_id`, `user_id`, `iot_id`, `authorization_code`) VALUES
('fef980201858974c21b63907bed9ecb426ceaadb', '2023-01-07 18:40:45', 'bearer', 'faa31880ca14723128aed3830312a0a7acc65faf', 1, NULL, 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e', 'f60db722-c387-4615-bf8d-8c5c3c84098b', NULL, NULL),
('ffdd9052ee6fa976dca4a79f0d1aac217d2887fe', '2022-12-21 14:20:15', 'bearer', '7fa00683208db4d9177b7313f207e63b3500c343', 1, NULL, 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e', '76fab939-dc95-4fd6-bcca-e469ad42edd8', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_code`
--

CREATE TABLE `oauth_authorization_code` (
  `authorization_code` varchar(256) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_client`
--

CREATE TABLE `oauth_client` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `secret` char(36) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `url` varchar(2000) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default',
  `grant_type` varchar(255) DEFAULT NULL,
  `response_type` varchar(255) DEFAULT NULL,
  `client_type` varchar(15) DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `token_types` varchar(2000) DEFAULT NULL,
  `jwt_secret` varchar(255) DEFAULT NULL,
  `redirect_sign_out_uri` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_client`
--

INSERT INTO `oauth_client` (`id`, `name`, `description`, `secret`, `url`, `redirect_uri`, `image`, `grant_type`, `response_type`, `client_type`, `scope`, `extra`, `token_types`, `jwt_secret`, `redirect_sign_out_uri`) VALUES
('d6e57ccf-9261-4ec7-a8da-bd9494871e4e', 'e_shop', 'An dockerized eshop web application', '1bf79773-d516-4f04-a9ac-7547f5c3b7aa', 'http://localhost/:80', 'http://localhost/:80/welcome.php', 'default', 'authorization_code,implicit,password,client_credentials,refresh_token', 'code,token', NULL, NULL, NULL, NULL, NULL, 'http://localhost/:80'),
('idm_admin_app', 'idm', 'idm', NULL, '', '', 'default', '', '', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_token`
--

CREATE TABLE `oauth_refresh_token` (
  `refresh_token` varchar(256) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `iot_id` varchar(255) DEFAULT NULL,
  `authorization_code` varchar(255) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_refresh_token`
--

INSERT INTO `oauth_refresh_token` (`refresh_token`, `expires`, `scope`, `oauth_client_id`, `user_id`, `iot_id`, `authorization_code`, `valid`) VALUES
('00bf01acaa8d7a5cab9ad41f2a5faefcdf4824dd', '2023-01-21 16:26:41', 'bearer', 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e', '76fab939-dc95-4fd6-bcca-e469ad42edd8', NULL, NULL, 1),
('ffe10c6648da73b33ace41f1d2a15ebb1f804ecb', '2023-01-08 09:25:20', 'bearer', 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e', '76fab939-dc95-4fd6-bcca-e469ad42edd8', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scope`
--

CREATE TABLE `oauth_scope` (
  `id` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` varchar(36) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` text,
  `website` varchar(2000) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `name`, `description`, `website`, `image`) VALUES
('51881a60-0f2e-44a7-ad5f-9f063d68d6d6', 'test_org', 'a test organization', NULL, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `pep_proxy`
--

CREATE TABLE `pep_proxy` (
  `id` varchar(255) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pep_proxy`
--

INSERT INTO `pep_proxy` (`id`, `password`, `oauth_client_id`, `salt`) VALUES
('pep_proxy_6b7a2797-000c-4690-b583-4975aa1046d7', 'e82742c54b27ba95823a4c8849deabb89073909e', 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e', '92ee0ff8f4645ae3');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `is_internal` tinyint(1) DEFAULT '0',
  `action` varchar(255) DEFAULT NULL,
  `resource` varchar(255) DEFAULT NULL,
  `xml` text,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `is_regex` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `description`, `is_internal`, `action`, `resource`, `xml`, `oauth_client_id`, `is_regex`) VALUES
('1', 'Get and assign all internal application roles', NULL, 1, NULL, NULL, NULL, 'idm_admin_app', 0),
('2', 'Manage the application', NULL, 1, NULL, NULL, NULL, 'idm_admin_app', 0),
('3', 'Manage roles', NULL, 1, NULL, NULL, NULL, 'idm_admin_app', 0),
('4', 'Manage authorizations', NULL, 1, NULL, NULL, NULL, 'idm_admin_app', 0),
('5', 'Get and assign all public application roles', NULL, 1, NULL, NULL, NULL, 'idm_admin_app', 0),
('6', 'Get and assign only public owned roles', NULL, 1, NULL, NULL, NULL, 'idm_admin_app', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ptp`
--

CREATE TABLE `ptp` (
  `id` int(11) NOT NULL,
  `previous_job_id` varchar(255) NOT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` varchar(36) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `is_internal` tinyint(1) DEFAULT '0',
  `oauth_client_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `is_internal`, `oauth_client_id`) VALUES
('108d3638-fe2f-48e8-b2fa-321a2ed5e63a', 'User', 0, 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e'),
('440d957b-fcef-4f40-a068-d4d12bf759ba', 'ProductSeller', 0, 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e'),
('49b68996-5710-44b7-a69a-790d78b46e81', 'Admin', 0, 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e'),
('provider', 'Provider', 1, 'idm_admin_app'),
('purchaser', 'Purchaser', 1, 'idm_admin_app');

-- --------------------------------------------------------

--
-- Table structure for table `role_assignment`
--

CREATE TABLE `role_assignment` (
  `id` int(11) NOT NULL,
  `role_organization` varchar(255) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `role_id` varchar(36) DEFAULT NULL,
  `organization_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_assignment`
--

INSERT INTO `role_assignment` (`id`, `role_organization`, `oauth_client_id`, `role_id`, `organization_id`, `user_id`) VALUES
(4, NULL, 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e', 'provider', NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL,
  `role_id` varchar(36) DEFAULT NULL,
  `permission_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(1, 'provider', '1'),
(2, 'provider', '2'),
(3, 'provider', '3'),
(4, 'provider', '4'),
(5, 'provider', '5'),
(6, 'provider', '6'),
(7, 'purchaser', '5');

-- --------------------------------------------------------

--
-- Table structure for table `role_usage_policy`
--

CREATE TABLE `role_usage_policy` (
  `id` int(11) NOT NULL,
  `role_id` varchar(36) DEFAULT NULL,
  `usage_policy_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SequelizeMeta`
--

CREATE TABLE `SequelizeMeta` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `SequelizeMeta`
--

INSERT INTO `SequelizeMeta` (`name`) VALUES
('201802190000-CreateUserTable.js'),
('201802190003-CreateUserRegistrationProfileTable.js'),
('201802190005-CreateOrganizationTable.js'),
('201802190008-CreateOAuthClientTable.js'),
('201802190009-CreateUserAuthorizedApplicationTable.js'),
('201802190010-CreateRoleTable.js'),
('201802190015-CreatePermissionTable.js'),
('201802190020-CreateRoleAssignmentTable.js'),
('201802190025-CreateRolePermissionTable.js'),
('201802190030-CreateUserOrganizationTable.js'),
('201802190035-CreateIotTable.js'),
('201802190040-CreatePepProxyTable.js'),
('201802190045-CreateAuthZForceTable.js'),
('201802190050-CreateAuthTokenTable.js'),
('201802190060-CreateOAuthAuthorizationCodeTable.js'),
('201802190065-CreateOAuthAccessTokenTable.js'),
('201802190070-CreateOAuthRefreshTokenTable.js'),
('201802190075-CreateOAuthScopeTable.js'),
('20180405125424-CreateUserTourAttribute.js'),
('20180612134640-CreateEidasTable.js'),
('20180727101745-CreateUserEidasIdAttribute.js'),
('20180730094347-CreateTrustedApplicationsTable.js'),
('20180828133454-CreatePasswordSalt.js'),
('20180921104653-CreateEidasNifColumn.js'),
('20180922140934-CreateOauthTokenType.js'),
('20181022103002-CreateEidasTypeAndAttributes.js'),
('20181108144720-RevokeToken.js'),
('20181113121450-FixExtraAndScopeAttribute.js'),
('20181203120316-FixTokenTypesLength.js'),
('20190116101526-CreateSignOutUrl.js'),
('20190316203230-CreatePermissionIsRegex.js'),
('20190429164755-CreateUsagePolicyTable.js'),
('20190507112246-CreateRoleUsagePolicyTable.js'),
('20190507112259-CreatePtpTable.js');

-- --------------------------------------------------------

--
-- Table structure for table `trusted_application`
--

CREATE TABLE `trusted_application` (
  `id` int(11) NOT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL,
  `trusted_oauth_client_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usage_policy`
--

CREATE TABLE `usage_policy` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('COUNT_POLICY','AGGREGATION_POLICY','CUSTOM_POLICY') DEFAULT NULL,
  `parameters` json DEFAULT NULL,
  `punishment` enum('KILL_JOB','UNSUBSCRIBE','MONETIZE') DEFAULT NULL,
  `from` time DEFAULT NULL,
  `to` time DEFAULT NULL,
  `odrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `oauth_client_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `description` text,
  `website` varchar(2000) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default',
  `gravatar` tinyint(1) DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `date_password` datetime DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  `extra` json DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `starters_tour_ended` tinyint(1) DEFAULT '0',
  `eidas_id` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `description`, `website`, `image`, `gravatar`, `email`, `password`, `date_password`, `enabled`, `admin`, `extra`, `scope`, `starters_tour_ended`, `eidas_id`, `salt`) VALUES
('01df6d2a-2136-4344-82b7-192b0a9670bf', 'KT', 'ProductSeller', NULL, 'default', 0, 'KT@tuc.gr', 'edb54faaebc833745629c2da8128df35744cc6b3', '2022-12-29 15:02:07', 1, 0, NULL, NULL, 0, NULL, '7e5e99ea9f6182be'),
('76fab939-dc95-4fd6-bcca-e469ad42edd8', 'fku', 'ProductSeller', NULL, 'default', 0, 'fku@tuc.gr', 'f774e1da8f2716173cf2d0297502c5c538f78d50', '2022-12-21 12:39:04', 1, 0, NULL, NULL, 0, NULL, 'ecbdb9c448c8e46d'),
('admin', 'admin', NULL, NULL, 'default', 0, 'l@tuc.gr', '83529d1644f1f9de6bc9836a7d47f5ae7b615e31', '2022-12-15 17:48:59', 1, 1, NULL, NULL, 0, NULL, 'dda550e7d6ae8193'),
('f60db722-c387-4615-bf8d-8c5c3c84098b', 'sku', 'User', NULL, 'default', 0, 'sku@tuc.gr', '8aad9f5fb37a7583ba5e34135d5a5128807ec7f1', '2022-12-21 12:40:50', 1, 0, NULL, NULL, 0, NULL, '26e34065ae25b657');

-- --------------------------------------------------------

--
-- Table structure for table `user_authorized_application`
--

CREATE TABLE `user_authorized_application` (
  `id` int(11) NOT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `oauth_client_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_authorized_application`
--

INSERT INTO `user_authorized_application` (`id`, `user_id`, `oauth_client_id`) VALUES
(4, '76fab939-dc95-4fd6-bcca-e469ad42edd8', 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e'),
(5, 'f60db722-c387-4615-bf8d-8c5c3c84098b', 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e'),
(6, '01df6d2a-2136-4344-82b7-192b0a9670bf', 'd6e57ccf-9261-4ec7-a8da-bd9494871e4e');

-- --------------------------------------------------------

--
-- Table structure for table `user_organization`
--

CREATE TABLE `user_organization` (
  `id` int(11) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `organization_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_organization`
--

INSERT INTO `user_organization` (`id`, `role`, `user_id`, `organization_id`) VALUES
(1, 'owner', 'admin', '51881a60-0f2e-44a7-ad5f-9f063d68d6d6');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration_profile`
--

CREATE TABLE `user_registration_profile` (
  `id` int(11) NOT NULL,
  `activation_key` varchar(255) DEFAULT NULL,
  `activation_expires` datetime DEFAULT NULL,
  `reset_key` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `verification_key` varchar(255) DEFAULT NULL,
  `verification_expires` datetime DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authzforce`
--
ALTER TABLE `authzforce`
  ADD PRIMARY KEY (`az_domain`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `auth_token`
--
ALTER TABLE `auth_token`
  ADD PRIMARY KEY (`access_token`),
  ADD UNIQUE KEY `access_token` (`access_token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pep_proxy_id` (`pep_proxy_id`);

--
-- Indexes for table `eidas_credentials`
--
ALTER TABLE `eidas_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `iot`
--
ALTER TABLE `iot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `oauth_access_token`
--
ALTER TABLE `oauth_access_token`
  ADD PRIMARY KEY (`access_token`),
  ADD UNIQUE KEY `access_token` (`access_token`),
  ADD KEY `oauth_client_id` (`oauth_client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `iot_id` (`iot_id`),
  ADD KEY `refresh_token` (`refresh_token`),
  ADD KEY `authorization_code_at` (`authorization_code`);

--
-- Indexes for table `oauth_authorization_code`
--
ALTER TABLE `oauth_authorization_code`
  ADD PRIMARY KEY (`authorization_code`),
  ADD UNIQUE KEY `authorization_code` (`authorization_code`),
  ADD KEY `oauth_client_id` (`oauth_client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `oauth_client`
--
ALTER TABLE `oauth_client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `oauth_refresh_token`
--
ALTER TABLE `oauth_refresh_token`
  ADD PRIMARY KEY (`refresh_token`),
  ADD UNIQUE KEY `refresh_token` (`refresh_token`),
  ADD KEY `oauth_client_id` (`oauth_client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `iot_id` (`iot_id`),
  ADD KEY `authorization_code_rt` (`authorization_code`);

--
-- Indexes for table `oauth_scope`
--
ALTER TABLE `oauth_scope`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `pep_proxy`
--
ALTER TABLE `pep_proxy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `ptp`
--
ALTER TABLE `ptp`
  ADD PRIMARY KEY (`id`,`previous_job_id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `role_assignment`
--
ALTER TABLE `role_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `role_usage_policy`
--
ALTER TABLE `role_usage_policy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `usage_policy_id` (`usage_policy_id`);

--
-- Indexes for table `SequelizeMeta`
--
ALTER TABLE `SequelizeMeta`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `trusted_application`
--
ALTER TABLE `trusted_application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`),
  ADD KEY `trusted_oauth_client_id` (`trusted_oauth_client_id`);

--
-- Indexes for table `usage_policy`
--
ALTER TABLE `usage_policy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_authorized_application`
--
ALTER TABLE `user_authorized_application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `oauth_client_id` (`oauth_client_id`);

--
-- Indexes for table `user_organization`
--
ALTER TABLE `user_organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `user_registration_profile`
--
ALTER TABLE `user_registration_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth_scope`
--
ALTER TABLE `oauth_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptp`
--
ALTER TABLE `ptp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_assignment`
--
ALTER TABLE `role_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_usage_policy`
--
ALTER TABLE `role_usage_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trusted_application`
--
ALTER TABLE `trusted_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_authorized_application`
--
ALTER TABLE `user_authorized_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_organization`
--
ALTER TABLE `user_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_registration_profile`
--
ALTER TABLE `user_registration_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authzforce`
--
ALTER TABLE `authzforce`
  ADD CONSTRAINT `authzforce_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_token`
--
ALTER TABLE `auth_token`
  ADD CONSTRAINT `auth_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_token_ibfk_2` FOREIGN KEY (`pep_proxy_id`) REFERENCES `pep_proxy` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eidas_credentials`
--
ALTER TABLE `eidas_credentials`
  ADD CONSTRAINT `eidas_credentials_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `iot`
--
ALTER TABLE `iot`
  ADD CONSTRAINT `iot_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_access_token`
--
ALTER TABLE `oauth_access_token`
  ADD CONSTRAINT `authorization_code_at` FOREIGN KEY (`authorization_code`) REFERENCES `oauth_authorization_code` (`authorization_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_access_token_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_access_token_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_access_token_ibfk_3` FOREIGN KEY (`iot_id`) REFERENCES `iot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refresh_token` FOREIGN KEY (`refresh_token`) REFERENCES `oauth_refresh_token` (`refresh_token`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_authorization_code`
--
ALTER TABLE `oauth_authorization_code`
  ADD CONSTRAINT `oauth_authorization_code_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_authorization_code_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_refresh_token`
--
ALTER TABLE `oauth_refresh_token`
  ADD CONSTRAINT `authorization_code_rt` FOREIGN KEY (`authorization_code`) REFERENCES `oauth_authorization_code` (`authorization_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_refresh_token_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_refresh_token_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_refresh_token_ibfk_3` FOREIGN KEY (`iot_id`) REFERENCES `iot` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pep_proxy`
--
ALTER TABLE `pep_proxy`
  ADD CONSTRAINT `pep_proxy_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ptp`
--
ALTER TABLE `ptp`
  ADD CONSTRAINT `ptp_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_assignment`
--
ALTER TABLE `role_assignment`
  ADD CONSTRAINT `role_assignment_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_assignment_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_assignment_ibfk_3` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_assignment_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_usage_policy`
--
ALTER TABLE `role_usage_policy`
  ADD CONSTRAINT `role_usage_policy_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_usage_policy_ibfk_2` FOREIGN KEY (`usage_policy_id`) REFERENCES `usage_policy` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trusted_application`
--
ALTER TABLE `trusted_application`
  ADD CONSTRAINT `trusted_application_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trusted_application_ibfk_2` FOREIGN KEY (`trusted_oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usage_policy`
--
ALTER TABLE `usage_policy`
  ADD CONSTRAINT `usage_policy_ibfk_1` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_authorized_application`
--
ALTER TABLE `user_authorized_application`
  ADD CONSTRAINT `user_authorized_application_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_authorized_application_ibfk_2` FOREIGN KEY (`oauth_client_id`) REFERENCES `oauth_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_organization`
--
ALTER TABLE `user_organization`
  ADD CONSTRAINT `user_organization_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_organization_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_registration_profile`
--
ALTER TABLE `user_registration_profile`
  ADD CONSTRAINT `user_registration_profile_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
