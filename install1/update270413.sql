ALTER TABLE `myphpauction_invoices` ADD `invoice_status` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' AFTER `amount`;
-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_invoice_statuses`
--

CREATE TABLE IF NOT EXISTS `myphpauction_invoice_statuses` (
  `invoice_status_id` varchar(32) NOT NULL DEFAULT '' COMMENT 'Primary key: the invoice status ID.',
  `title` varchar(48) NOT NULL DEFAULT '' COMMENT 'The status title.',
  `state` varchar(32) NOT NULL DEFAULT '' COMMENT 'The base invoice state with which the status is associated.',
  `weight` smallint(6) NOT NULL DEFAULT '0' COMMENT 'The sort criteria for statuses.',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'A flag indicating whether users can delete the status. 0 => Yes. 1 => No.',
  PRIMARY KEY (`invoice_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Statuses the invoice can have during its lifecycle';

--
-- Dumping data for table `myphpauction_invoice_statuses`
--

INSERT INTO `myphpauction_invoice_statuses` (`invoice_status_id`, `title`, `state`, `weight`, `locked`) VALUES
('abandoned', 'Abandoned', 'canceled', -30, 0),
('account_charge', 'Account Balance Credit', 'completed', 0, 0),
('account_setup', 'Account Setup Completed', 'completed', 0, 0),
('auction_end', 'Auction Closed', 'pending', 0, 0),
('auction_setup', 'Auction Setup', 'pending', 0, 1),
('canceled', 'Canceled', 'canceled', -20, 0),
('completed', 'Completed', 'completed', 20, 0),
('in_checkout', 'In checkout', 'in_checkout', -10, 0),
('payment_received', 'Payment received', 'payment_received', 10, 0),
('paypal_pending', 'PayPal pending', 'payment_received', 7, 0),
('pending', 'Pending', 'post_checkout', 0, 0),
('processing', 'Processing', 'post_checkout', 5, 0);