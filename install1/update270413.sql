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

ALTER TABLE `myphpauction_abuses`, `myphpauction_admins`, `myphpauction_admin_notes`, `myphpauction_adverts`, `myphpauction_auctions`, `myphpauction_auction_durations`, `myphpauction_auction_media`, `myphpauction_auction_offers`, `myphpauction_auction_rollbacks`, `myphpauction_auction_watch`, `myphpauction_banned`, `myphpauction_bids`, `myphpauction_bid_increments`, `myphpauction_blocked_domains`, `myphpauction_blocked_users`, `myphpauction_bulktmp`, `myphpauction_categories`, `myphpauction_countries`, `myphpauction_currencies`, `myphpauction_custom_fields`, `myphpauction_custom_fields_boxes`, `myphpauction_custom_fields_data`, `myphpauction_custom_fields_sections`, `myphpauction_custom_fields_special`, `myphpauction_custom_fields_types`, `myphpauction_dateformat`, `myphpauction_favourite_stores`, `myphpauction_fees`, `myphpauction_fees_tiers`, `myphpauction_gc_transactions`, `myphpauction_gen_setts`, `myphpauction_invoices`, `myphpauction_invoice_statuses`, `myphpauction_iphistory`, `myphpauction_layout_setts`, `myphpauction_messaging`, `myphpauction_newsletters`, `myphpauction_newsletter_recipients`, `myphpauction_payment_gateways`, `myphpauction_payment_options`, `myphpauction_proxybid`, `myphpauction_referrals`, `myphpauction_reputation`, `myphpauction_reserve_offers`, `myphpauction_shipping_options`, `myphpauction_stores_accounting`, `myphpauction_suggested_categories`, `myphpauction_swaps`, `myphpauction_tax_settings`, `myphpauction_timesettings`, `myphpauction_users`, `myphpauction_vat_rates`, `myphpauction_vat_setts`, `myphpauction_vouchers`, `myphpauction_wanted_ads`, `myphpauction_wanted_offers`, `myphpauction_winners`, `myphpauction_wordfilter` ENGINE=InnoDB;