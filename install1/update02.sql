ALTER TABLE `myphpauction_auctions` DROP INDEX `name`;
ALTER TABLE `myphpauction_auctions` DROP INDEX `description`;
ALTER TABLE `myphpauction_auctions` DROP INDEX `zip_code`;
ALTER TABLE `myphpauction_banned` DROP INDEX `banned_address`;
/* ALTER TABLE `` DROP INDEX `topic_lang`; */
ALTER TABLE `myphpauction_countries` DROP INDEX `name`;
ALTER TABLE `myphpauction_custom_fields_data` DROP INDEX `box_value`;
/* ALTER TABLE `` DROP INDEX `keyword`; */
ALTER TABLE `myphpauction_users` DROP INDEX `shop_name`;
ALTER TABLE `myphpauction_wanted_ads` DROP INDEX `wa_keywords`;
ALTER TABLE `myphpauction_wordfilter` DROP INDEX `word`;


/* ALTER TABLE `myphpauction_content_pages` ENGINE = InnoDB; */
ALTER TABLE `myphpauction_abuses` ENGINE = InnoDB;
ALTER TABLE `myphpauction_admins` ENGINE = InnoDB;
ALTER TABLE `myphpauction_admin_notes` ENGINE = InnoDB;
ALTER TABLE `myphpauction_adverts` ENGINE = InnoDB;
ALTER TABLE `myphpauction_auctions` ENGINE = InnoDB;
ALTER TABLE `myphpauction_auction_durations` ENGINE = InnoDB;
ALTER TABLE `myphpauction_auction_media` ENGINE = InnoDB;
ALTER TABLE `myphpauction_auction_offers` ENGINE = InnoDB;
ALTER TABLE `myphpauction_auction_rollbacks` ENGINE = InnoDB;
ALTER TABLE `myphpauction_auction_watch` ENGINE = InnoDB;
ALTER TABLE `myphpauction_banned` ENGINE = InnoDB;
ALTER TABLE `myphpauction_bids` ENGINE = InnoDB;
ALTER TABLE `myphpauction_bid_increments` ENGINE = InnoDB;
ALTER TABLE `myphpauction_blocked_domains` ENGINE = InnoDB;
ALTER TABLE `myphpauction_blocked_users` ENGINE = InnoDB;
ALTER TABLE `myphpauction_bulktmp` ENGINE = InnoDB;
ALTER TABLE `myphpauction_categories` ENGINE = InnoDB;
/* ALTER TABLE `myphpauction_content_pages` ENGINE = InnoDB; */
ALTER TABLE `myphpauction_countries` ENGINE = InnoDB;
ALTER TABLE `myphpauction_currencies` ENGINE = InnoDB;
ALTER TABLE `myphpauction_custom_fields` ENGINE = InnoDB;
ALTER TABLE `myphpauction_custom_fields_boxes` ENGINE = InnoDB;
ALTER TABLE `myphpauction_custom_fields_data` ENGINE = InnoDB;
ALTER TABLE `myphpauction_custom_fields_sections` ENGINE = InnoDB;
ALTER TABLE `myphpauction_custom_fields_special` ENGINE = InnoDB;
ALTER TABLE `myphpauction_custom_fields_types` ENGINE = InnoDB;
ALTER TABLE `myphpauction_dateformat` ENGINE = InnoDB;
ALTER TABLE `myphpauction_favourite_stores` ENGINE = InnoDB;
ALTER TABLE `myphpauction_fees` ENGINE = InnoDB;
ALTER TABLE `myphpauction_fees_tiers` ENGINE = InnoDB;
ALTER TABLE `myphpauction_gc_transactions` ENGINE = InnoDB;
ALTER TABLE `myphpauction_gen_setts` ENGINE = InnoDB;
ALTER TABLE `myphpauction_invoices` ENGINE = InnoDB;
ALTER TABLE `myphpauction_invoice_statuses` ENGINE = InnoDB;
ALTER TABLE `myphpauction_iphistory` ENGINE = InnoDB;
/* ALTER TABLE `myphpauction_keywords_watch` ENGINE = InnoDB; */
ALTER TABLE `myphpauction_layout_setts` ENGINE = InnoDB;
ALTER TABLE `myphpauction_messaging` ENGINE = InnoDB;
ALTER TABLE `myphpauction_newsletters` ENGINE = InnoDB;
ALTER TABLE `myphpauction_newsletter_recipients` ENGINE = InnoDB;
ALTER TABLE `myphpauction_payment_gateways` ENGINE = InnoDB;
ALTER TABLE `myphpauction_payment_options` ENGINE = InnoDB;
ALTER TABLE `myphpauction_proxybid` ENGINE = InnoDB;
ALTER TABLE `myphpauction_referrals` ENGINE = InnoDB;
ALTER TABLE `myphpauction_reputation` ENGINE = InnoDB;
ALTER TABLE `myphpauction_reserve_offers` ENGINE = InnoDB;
ALTER TABLE `myphpauction_shipping_options` ENGINE = InnoDB;
ALTER TABLE `myphpauction_stores_accounting` ENGINE = InnoDB;
ALTER TABLE `myphpauction_suggested_categories` ENGINE = InnoDB;
ALTER TABLE `myphpauction_swaps` ENGINE = InnoDB;
ALTER TABLE `myphpauction_tax_settings` ENGINE = InnoDB;
ALTER TABLE `myphpauction_timesettings` ENGINE = InnoDB;
ALTER TABLE `myphpauction_users` ENGINE = InnoDB;
ALTER TABLE `myphpauction_vat_rates` ENGINE = InnoDB;
ALTER TABLE `myphpauction_vat_setts` ENGINE = InnoDB;
ALTER TABLE `myphpauction_vouchers` ENGINE = InnoDB;
ALTER TABLE `myphpauction_wanted_ads` ENGINE = InnoDB;
ALTER TABLE `myphpauction_wanted_offers` ENGINE = InnoDB;
ALTER TABLE `myphpauction_winners` ENGINE = InnoDB;
ALTER TABLE `myphpauction_wordfilter` ENGINE = InnoDB;