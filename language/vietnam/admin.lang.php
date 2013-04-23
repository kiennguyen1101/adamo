<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  define('AMSG_SITE_SETUP', 'Site Setup');
  define('AMSG_LOGIN_ADMIN_AREA', 'PLEASE LOGIN TO THE ADMIN AREA');
  define('AMSG_USERNAME', 'Username');
  define('AMSG_PASSWORD', 'Password');
  define('AMSG_PIN_CODE', 'PIN Code');
  define('AMSG_ENTER_PIN_CODE', 'Enter PIN');
  define('AMSG_ADMIN_AREA', 'Admin Area');
  define('AMSG_SYSTEM_STATUS', 'Site Status');
  define('AMSG_OPEN_ALL', 'Open All');
  define('AMSG_CLOSE_ALL', 'Close All');
  define('AMSG_ADMIN_HOME', 'Admin Home');
  define('AMSG_GEN_SETTS', 'General Settings');
  define('AMSG_TEST_MENU', 'Test Menu Item');
  define('AMSG_USERS_MANAGEMENT', 'Users Management');
  define('AMSG_CUSTOM_REG_FIELDS', 'Custom Registration Fields Setup');
  define('AMSG_CUSTOM_PAGE_SEL_ERROR', 'Error: Invalid custom page selected.');
  define('AMSG_SAVE_CHANGES', 'Save Changes');
  define('AMSG_ORDER_ID', 'Order ID');
  define('AMSG_ADD_SECTION', 'Add Section');
  define('AMSG_DELETE', 'Delete');
  define('AMSG_NO_SECTION', 'Fields without Section');
  define('AMSG_SECTION_NAME', 'Section Name');
  define('AMSG_CHANGES_SAVED', 'The changes have been saved successfully.');
  define('AMSG_DELETE_CONFIRM', 'Are you sure you want to remove this record?');
  define('AMSG_EDIT', 'Edit');
  define('AMSG_EDIT_SECTION', 'Edit Section');
  define('AMSG_ADD_FIELD', 'Add Field');
  define('AMSG_FIELD_NAME', 'Field Name');
  define('AMSG_FIELD_DESC', 'Field Description');
  define('AMSG_CATEGORY', 'Category');
  define('AMSG_SECTION', 'Section');
  define('AMSG_EDIT_FIELD', 'Edit Field');
  define('AMSG_ADD_BOX', 'Add Box');
  define('AMSG_OPTIONAL_FIELD', 'Note: Optional Field');
  define('AMSG_BOX_NAME', 'Box Name');
  define('AMSG_ACTIVE', 'Active');
  define('AMSG_BOX_VALUE', 'Box Value(s)');
  define('AMSG_BOX_TYPE', 'Box Type');
  define('AMSG_BOX_ORDER', 'Box Order');
  define('AMSG_MANDATORY', 'Mandatory');
  define('AMSG_BOX_VALUES_EXPLANATION', '<strong>Note:</strong> The box values will be the text that will appear in the boxes, or in case of a checkbox
or a radio button, near the boxes. In the case of a textfield or a textarea, it will be the initially preselected value, which then
the user will be able to edit. Please leave the field empty in case you dont want the field to be prefilled.');
  define('AMSG_EDIT_BOX', 'Edit Box');
  define('AMSG_CUSTOM_FIELDS_SETUP', 'Custom Fields Setup');
  define('AMSG_SETUP_FIELD_TYPES', 'Set Up Box Types');
  define('AMSG_TABLES_MANAGEMENT', 'Tables Management');
  define('AMSG_EDIT_COUNTRIES', 'Edit Countries Table');
  define('AMSG_ADD_COUNTRY', 'Add Country');
  define('AMSG_COUNTRY_NAME', 'Country Name');

  define('AMSG_LINK_TABLE_CUSTOMFLD', 'Link this table so that custom boxes can be created from it?');
  define('AMSG_DEFAULT_BOX_TYPES', 'Default Box Types');
  define('AMSG_SPECIAL_BOX_TYPES', 'Special Box Types');
  define('AMSG_MAXFIELDS', 'Maximum Number of Fields');
  define('AMSG_ADD_FIELD_TYPE', 'Add Field Type');
  define('AMSG_OPTIONS', 'Options');
  define('AMSG_BOX_HANDLE', 'Box Handle');
  define('AMSG_LINKED_TABLE', 'Linked Table');
  define('AMSG_READONLY_FIELD', 'The field is read only');
  define('AMSG_NOTES', 'Notes');
  define('AMSG_LINK_TO_TABLE', 'Link to Table');
  define('AMSG_TABLE_FIELDS', 'Linked Table Fields');
  define('AMSG_BOX_VALUE_CODE', 'Box Value Code');
  define('AMSG_BOX_VALUE_CODE_EXPLANATION', '<strong>NOTE</strong>: You will have to enter a code that will display the value of each individual box,
and it will be related with the linked table&#039;s fields.<br>
For example, a country field will have the following value: {name}.');
  define('AMSG_EDIT_FIELD_TYPE', 'Edit Field Type');
  define('AMSG_FORMCHECK_FUNCTIONS', 'Formchecker Functions');

  define('AMSG_CATEGORIES', 'Categories');
  define('AMSG_EDIT_CATEGORIES', 'Edit Categories');
  define('AMSG_CATEGORIES_MANAGEMENT', 'Categories Management');
  define('AMSG_NAME', 'Name');
  define('AMSG_INDIVIDUAL_FEES', 'Individual Fees');
  define('AMSG_HIDDEN', 'Hidden');
  define('AMSG_ADD_CATEGORY', 'Add New Categories');
  define('AMSG_GENERATE_CATEGORIES', 'Generate Categories');
  define('AMSG_CATEGORIES_GENERATE_NOTE', '<b>NOTE:</b> The subcategories generator must be run only when categories are added or deleted, and not when they are updated.');
  define('AMSG_VIEW_SUBCATEGORIES', 'View Subcategories');
  define('AMSG_OWNER_ID', 'Owner ID');
  define('AMSG_EDIT_CATEGORY_OPTIONS', 'Edit Options for this Category');

  define('AMSG_FEES', 'Fees');
  define('AMSG_MAIN_SETTINGS', 'Main Settings');
  define('AMSG_SETUP_PAYMENT_GATEWAYS', 'Payment Gateways Setup');
  define('AMSG_FEES_MANAGEMENT', 'Fees Management');
  define('AMSG_FEES_AND_ACCMODE_SETTS', 'Fees and Account Mode Settings');
  define('AMSG_FEES_MAIN_MESSAGE', 'You can run your site either in live payment mode, or in account mode.');
  define('AMSG_CHOOSE_PAYMENT_OPTION', 'Choose Payment Option');
  define('AMSG_ACCOUNT_MODE', 'Account Mode');
  define('AMSG_LIVE_PAYMENT_MODE', 'Live Payment Mode');

  define('AMSG_ACC_MODE_TYPE', 'User Account Type');
  define('AMSG_GLOBAL', 'Global');
  define('AMSG_PERSONAL', 'Personal');
  define('AMSG_DEFAULT_ACC_MODE', 'Accounts for new users will be defaulted to<br>
(Personal account type only) ');
  define('AMSG_ACC_INIT_MAIN_MSG', 'If you choose to run the site in Account Mode, please set up the variables below ');
  define('AMSG_SIGNUP_CREDIT', 'Signup Credit');
  define('AMSG_MAXIMUM_DEBIT', 'Maximum Debit');
  define('AMSG_MIN_INVOICE_VALUES', 'Minimum Invoice Value');
  define('AMSG_SUSPEND_OVER_BAL_USERS', 'Suspend Accounts that are over the Debit Limit');
  define('AMSG_SUSPEND_ACCOUNTS', 'Suspend Accounts');
  define('AMSG_SUSPEND_OVER_BAL_USERS_NOTE', 'Note: This setting only applies if the site runs in account mode.');
  define('AMSG_PAYPAL_EMAIL_ADDRESS', 'PayPal Email Address');
  define('AMSG_NOCHEX_EMAIL_ADDRESS', 'Nochex Email Address');
  define('AMSG_ENABLED', 'Enabled');
  define('AMSG_DP_ENABLED', 'Direct Payment Enabled');
  define('AMSG_USER_ACCOUNTS_SETUP', 'User Accounts Setup');
  define('AMSG_AD_TYPES_MANAGEMENT', 'Ad Types Management');
  define('AMSG_SETUP_AD_TYPES', 'Set Up Ad Types');

  define('AMSG_ENABLE_PROFILE_ADS', 'Enable Profile Ads');
  define('AMSG_PROFILE_ADS_DESC', '<strong>Description:</strong> Profile ads are created from the users table. Only one profile
ad is allowed per registered user. <br />
<strong>Note:</strong> Profile ads can only be enabled if all other ad types are disabled.
Enabling any of the other ad types will automatically disable profile ads. ');
  define('AMSG_ENABLE_STANDARD_ADS', 'Enable Standard Ads');
  define('AMSG_STANDARD_ADS_DESC', '<strong>Description:</strong> Standard ads are the standard items that can be placed on the
site. Price and ad duration are mandatory for this ad type. ');
  define('AMSG_ENABLE_TRADE_ADS', 'Enable Trade Lead Ads');
  define('AMSG_TRADE_ADS_DESC', '<strong>Description:</strong> Trade leads are ads with no expiration date and no price.');
  define('AMSG_ENABLE_WANTED_ADS', 'Enable Wanted Ads');
  define('AMSG_WANTED_ADS_DESC', '<strong>Description:</strong> Wanted ads are placed by users interested in services/products
available for offering by other site users. Sellers can respond by offering standard ads or trade leads they have placed on the
site. Only active items/trade leads can be offered. ');

  define('AMSG_DESCRIPTION', 'Description');
  define('AMSG_EDIT_USER_ACCOUNT', 'Edit User Account Type');
  define('AMSG_RECURRING_DESC', 'Enter the interval in days the subscription needs to be renewed. Enter 0 if you don\'t want to create a recurring subscription ');
  define('AMSG_STANDARDS_ADS_SETTS', 'Standard Ads Settings');
  define('AMSG_SA_ENABLED_DESC', 'If enabled, the user can post standard ads on the site. ');
  define('AMSG_SA_UPL_PIC_DESC', 'If enabled, the user will be able to add images to standard ads');
  define('AMSG_SA_HTML_DESC', 'If enabled, the user will be able to enter html content to textarea standard ads fields');
  define('AMSG_SA_FREE_ADS_DESC', 'If there is a standard ad item setup fee, the user will be able to submit the above entered number of free ads per each subscription interval');
  define('AMSG_TRADE_ADS_SETTS', 'Trade Ads Settings');
  define('AMSG_TA_ENABLED_DESC', 'If enabled, the user can post trade ads on the site. ');
  define('AMSG_TA_UPL_PIC_DESC', 'If enabled, the user will be able to add images to trade ads');
  define('AMSG_TA_HTML_DESC', 'If enabled, the user will be able to enter html content to textarea trade ads fields');
  define('AMSG_TA_FREE_ADS_DESC', 'If there is a trade ad item setup fee, the user will be able to submit the above entered number of free ads per each subscription interval');
  define('AMSG_WANTED_ADS_SETTS', 'Wanted Ads Settings');
  define('AMSG_WA_ENABLED_DESC', 'If enabled, the user can post wanted ads on the site. ');
  define('AMSG_WA_UPL_PIC_DESC', 'If enabled, the user will be able to add images to wanted ads');
  define('AMSG_WA_HTML_DESC', 'If enabled, the user will be able to enter html content to textarea wanted ads fields');
  define('AMSG_WA_FREE_ADS_DESC', 'If there is a wanted ad item setup fee, the user will be able to submit the above entered number of free ads per each subscription interval');
  define('AMSG_REDUCTION_DESC', 'The fees reduction entered will apply to all default fees');
  define('AMSG_CUSTOM_FEES_DESC', 'You can set up custom fees for this account type. Please note that if custom fees are enabled,
the fees reduction field will be reset to 0.');
  define('AMSG_CURRENT_ACC_TYPES', 'Current Account Types');
  define('AMSG_ACCOUNT_NAME', 'Account Name');
  define('AMSG_USER_SIGNUP_FEE_DESC', 'You can set a flat signup fee.');
  define('AMSG_ACC_VERIFICATION_FEE_DESC', 'You can set a verification fee if you want to give users a verified/trusted status.');
  define('AMSG_PA_SEND_MSG_FEE_DESC', 'You can set up a messaging fee for profile ads.');
  define('AMSG_PA_IMG_UPL_FEE_DESC', 'You can set up an images upload fee that will apply to profile ads.');
  define('AMSG_SA_UPL_PIC_FEE_DESC', 'You can set up an images upload fee that will apply to standard ads.');
  define('AMSG_SA_HPFEAT_FEE_DESC', 'You can set up a home page featured fee for standard ads.');
  define('AMSG_SA_CATFEAT_FEE_DESC', 'You can set up a category page featured fee for standard ads.');
  define('AMSG_SA_HL_FEE_DESC', 'You can set up a highlighted item fee for standard ads.');
  define('AMSG_SA_BOLD_FEE_DESC', 'You can set up a bold item fee for standard ads.');
  define('AMSG_SA_ADDLCAT_FEE_DESC', 'You can set up an additional category listing fee for standard ads.');

  define('AMSG_TA_SETUP_FEE_DESC', 'You can create an item setup fee for trade ads. This is a flat fee');
  define('AMSG_TA_UPL_PIC_FEE_DESC', 'You can set up an images upload fee that will apply to trade ads.');
  define('AMSG_TA_HPFEAT_FEE_DESC', 'You can set up a home page featured fee for trade ads.');
  define('AMSG_TA_CATFEAT_FEE_DESC', 'You can set up a category page featured fee for trade ads.');
  define('AMSG_TA_HL_FEE_DESC', 'You can set up a highlighted item fee for trade ads.');
  define('AMSG_TA_BOLD_FEE_DESC', 'You can set up a bold item fee for trade ads.');
  define('AMSG_TA_ADDLCAT_FEE_DESC', 'You can set up an additional category listing fee for trade ads.');

  define('AMSG_WA_UPL_PIC_FEE_DESC', 'You can set up an images upload fee that will apply to wanted ads.');
  define('AMSG_WA_HPFEAT_FEE_DESC', 'You can set up a home page featured fee for wanted ads.');
  define('AMSG_WA_CATFEAT_FEE_DESC', 'You can set up a category page featured fee for wanted ads.');
  define('AMSG_WA_HL_FEE_DESC', 'You can set up a highlighted item fee for wanted ads.');
  define('AMSG_WA_BOLD_FEE_DESC', 'You can set up a bold item fee for wanted ads.');
  define('AMSG_WA_ADDLCAT_FEE_DESC', 'You can set up an additional category listing fee for wanted ads.');
  define('AMSG_ADD_TIER', 'Add Tier');
  define('AMSG_USER_SIGNUP_SETTS', 'User Signup Confirmation Settings');
  define('AMSG_NO_CONF_REQ', 'No Confirmation Required');
  define('AMSG_NO_CONF_REQ_DESC', 'Check the above box if you wish for the user\'s account to be activated immediately, with no confirmation required.');
  define('AMSG_EMAIL_ADDR_CONF', 'Email Address Confirmation');
  define('AMSG_EMAIL_ADDR_CONF_DESC', 'Check the above box if you wish to enable email address confirmation. In this case, users will need to click the link
from the registration confirmation email they receive when registering in order to activate their account.');
  define('AMSG_ADMIN_APPROVAL', 'Admin Approval');
  define('AMSG_ADMIN_APPROVAL_DESC', 'Check the above box if you wish for the admin to manually activate each user from the users management page.');
  define('AMSG_SIGNUP_SETTS_NOTE', 'Important: These settings are enabled only if there is no signup fee.');
  define('AMSG_ENABLE_REGISTRATION_DESC', 'Check the above box if you wish to enable registration. Please note that if you want to enable profile ads, registration
will be enabled by default. If registration is disabled, profile ads cannot be created.');
  define('AMSG_ONLY_REG_USERS_CAN_POST', 'Only Registered Users can Post Items');
  define('AMSG_ONLY_REG_USERS_CAN_POST_DESC', 'If the above option is checked, site users will first need to register in order to post items. This setting applies for standard ads,
trade leads and wanted ads.');
  define('AMSG_CURRENCY_SETTINGS', 'Currency Settings');
  define('AMSG_CURRENCY_SYMBOL', 'Currency Symbol');
  define('AMSG_CURRENCY_CAPTION', 'Caption');
  define('AMSG_LAST_UPDATE', 'Last Update');
  define('AMSG_ADD_CURRENCY', 'Add Currency');
  define('AMSG_DEFAULT_CURRENCY', 'Default Currency');
  define('AMSG_DEFAULT_CURRENCY_DESC', 'Choose the site\'s default currency. All conversion rates will relate to the default currency ');
  define('AMSG_EDIT_STATES', 'Edit states for this country');
  define('ADD_STATE', 'Add State/County');
  define('AMSG_EDIT_STATES_FOR', 'Edit states/counties for');
  define('AMSG_STATES_NOTE', 'Note: The states/counties you add for each country are only used in case you have enabled tax throughout the site,
in case you wish to apply different tax settings by individual state.');
  define('AMSG_TAX_SETTINGS', 'Tax Settings');
  define('AMSG_ENABLE_TAX', 'Enable Tax');
  define('AMSG_TAX_CONFIGURATION', 'Tax Configuration');
  define('AMSG_ENABLE_TAX_DESC', 'Check the option above if you wish to enable tax on your site.<br>
Tax will apply to site fees and can be applied to auction prices at the seller\'s choice.');
  define('AMSG_TAX_NAME', 'Tax Name');
  define('AMSG_TAX_RATE', 'Tax Rate');
  define('AMSG_APPLIES_TO', 'Applies To Users From');
  define('AMSG_ADD_TAX', 'Add Tax');
  define('AMSG_USERS_ALLOWED_TO_CHARGE_TAX', 'Users allowed to charge Tax');
  define('AMSG_ALL_COUNTRIES', 'All Countries/States');
  define('AMSG_SELECTED_COUNTRIES', 'Selected Countries/States');
  define('AMSG_TAX_BUSINESS_WITH_TAX_NB', 'A Business with a Tax registration number specified');
  define('AMSG_TAX_BUSINESS_WITHOUT_TAX_NB', 'A Business without a Tax registration number specified');
  define('AMSG_TAX_INDIVIDUAL_WITH_TAX_NB', 'An Individual with a Tax registration number specified');
  define('AMSG_TAX_INDIVIDUAL_WITHOUT_TAX_NB', 'An Individual without a Tax registration number specified');
  define('AMSG_EDIT_TAX', 'Edit Tax');
  define('AMSG_TAX_SETTINGS_NOTE', '<b>Important:</b> Only one tax type can be enabled to work with the site fees. The other tax types you create
can only be used by site users to apply on their item prices.');
  define('AMSG_SITE_TAX', 'Site Tax');
  define('AMSG_ADMIN_USERS', 'Admin Users');
  define('AMSG_ADD_ADMIN_USER', 'Add Admin User');
  define('AMSG_EDIT_ADMIN_USER', 'Edit Admin User');
  define('AMSG_LAST_LOGIN', 'Last Login');
  define('AMSG_CREATED', 'Created');
  define('AMSG_ADMIN_USER_DELETE_ERROR', 'Error: Cannot delete the last admin user account from the database.');
  define('AMSG_ENTER_CURRENT_PASSWORD', 'Enter Current Password');
  define('AMSG_REPEAT_PASSWORD', 'Repeat Password');
  define('AMSG_ADMIN_LEVEL_EXPLANATION', '<b>Admin Levels:</b><br>
1. Super Admin -> Full access<br>
2. Administrator -> Limited access, can only manage users and ads.');
  define('AMSG_FRMCHK_CURRENT_PASSWORD_MISMATCH', 'The "Current Password" field must match the password for this user that is currently submitted in the database');
  define('AMSG_ADD_SITE_USER', 'Add Site User');
  define('AMSG_USER_DETAILS', 'User Details');
  define('AMSG_ACCOUNT_DETAILS', 'Account Details');
  define('AMSG_EDIT_SITE_USER', 'Edit Site User');
  define('AMSG_EMAIL_ADDR', 'Email Address');
  define('AMSG_REG_DATE', 'Reg. Date');
  define('AMSG_APPLIED_FOR_TAX_EXEMPT', 'Applied for Tax Exempt');
  define('AMSG_COMPANY_NAME', 'Company Name');
  define('AMSG_TAX_REG_NUMBER', 'Tax Reg. Number');
  define('AMSG_TAX_EXEMPTED', 'Tax Exempted');
  define('AMSG_ACCOUNT_TYPE', 'Account Type');
  define('AMSG_FILTER_USERS', 'Show');
  define('AMSG_SUSPEND', 'Suspend');
  define('AMSG_APPROVE', 'Approve');
  define('AMSG_ACTIVATE', 'Activate');
  define('AMSG_REGISTERED_AS', 'Registered As');
  define('AMSG_EDIT_ITEM_DURATIONS', 'Edit Auction Durations Table');
  define('AMSG_ADD_DURATION', 'Add Duration');
  define('AMSG_DAYS', 'Days');
  define('AMSG_CUSTOM_STANDARD_AD_FIELDS', 'Custom Standard Ads Fields Setup');
  define('AMSG_STANDARD_ADS_MANAGEMENT', 'Standard Ads Management');
  define('AMSG_EDIT_PAYMENT_OPTIONS', 'Edit Payment Options Table');
  define('AMSG_EDIT_SHIPPING_OPTIONS', 'Edit Shipping Options Table');
  define('AMSG_ADD_SHIPPING_OPTION', 'Add New Shipping Option');
  define('AMSG_ADD_PAYMENT_OPTION', 'Add New Payment Option');
  define('AMSG_LOGO', 'Logo');
  define('AMSG_EDIT_PAYMENT_OPTION', 'Edit Payment Option');
  define('AMSG_CURRENT_PAYMENT_OPTIONS', 'Current Payment Options');
  define('AMSG_PAYMENT_MODE', 'Payment Mode');
  define('AMSG_MAXIMUM_DEBIT_EXPL', 'If you modify the maximum debit value, it will be only apply to newly registered users. If you wish to reset
this value for your existing users, you will need to check the "Reset Sitewide" checkbox next to the box above, then save your settings.
All users will then have their maximum debit amount reset to the value set in the box above.');
  define('AMSG_RESET_SITEWIDE', 'Reset Sitewide');

// index.tpl.php related lang definitions
  define('AMSG_SITE_NAME', 'Site Name');
  define('AMSG_SITE_URL', 'Site URL');
  define('AMSG_ADMIN_EMAIL', 'Admin Email Address');
  define('AMSG_CHOOSE_SITE_SKIN', 'Choose Site Skin');
  define('AMSG_CHOOSE_SITE_LOGO', 'Choose Site Logo');
  define('AMSG_CHOOSE_DEFAULT_LANG', 'Choose Default Language');
  define('AMSG_MAINTENANCE_MODE', 'Maintenance Mode');
  define('AMSG_INITIALIZE_COUNTERS', 'Initialize Auction Counters');
  define('AMSG_GENERAL_SETTINGS', 'General Settings');
  define('AMSG_CLOSED_AUCT_DEL', 'Closed Auctions Deletion');
  define('AMSG_HPFEAT_ITEMS', 'Home Page Featured Items');
  define('AMSG_CATFEAT_ITEMS', 'Category Pages Featured Items');
  define('AMSG_RECENT_AUCTIONS', 'Recently Listed Auctions');
  define('AMSG_POPULAR_AUCTIONS', 'Popular Auctions');
  define('AMSG_ENDING_SOON_AUCTIONS', 'Ending Soon Auctions');
  define('AMSG_AUCTION_IMAGES_SETTS', 'Auction Images Settings');
  define('AMSG_CURRENCY_SETTS', 'Currency Settings');
  define('AMSG_TIME_DATE_SETTS', 'Time and Date Settings');
  define('AMSG_SETUP_SSL_SUPPORT', 'Setup SSL Support');
  define('AMSG_META_TAGS_SETTS', 'Meta Tags Settings (sitewide)');
  define('AMSG_CRON_JOBS_SETTS', 'Cron Jobs Settings');
  define('AMSG_MIN_REG_AGE_SETTS', 'Minimum Registration Age Settings');
  define('AMSG_RECENT_WANTED_ADS', 'Recently Listed Wanted Ads');
  define('AMSG_MEDIA_UPLOAD_SETTS', 'Media Upload Settings');
  define('AMSG_SEL_BUY_OUT_METHOD', 'Select Buy Out Method');
  define('AMSG_SELLING_PROCESS_NAV_BTNS', 'Selling Process Navigation Buttons Positioning');
  define('AMSG_MAX_NB_AUTORELISTS', 'Maximum Number of Auto Relists Allowed');
  define('AMSG_ENABLE_DISABLE', 'Enable/Disable');
  define('AMSG_SHIPPING_COSTS', 'Shipping Costs');
  define('AMSG_HP_LOGIN_BOX', 'Home Page Login Box');
  define('AMSG_HP_NEWS_BOX', 'Home Page News Box');
  define('AMSG_BUY_OUT_METHOD', 'Buy Out/Make Offer');
  define('AMSG_REGISTRATION_TERMS', 'Registration Page Terms and Conditions Box');
  define('AMSG_SELLITEM_TERMS', 'Selling Process Terms and Conditions Box');
  define('AMSG_SWAPPING', 'Items Swapping Feature');
  define('AMSG_HP_COUNTER', 'Home Page Users and Auctions Counter');
  define('AMSG_ADDL_CATEGORY_LISTING', 'Additional Category Listing');
  define('AMSG_USER_LANGUAGES', 'User Defined Languages');
  define('AMSG_AUCTION_SNIPING', 'Auctions Sniping Feature');
  define('AMSG_PRIVATE_SITE', 'Private Site');
  define('AMSG_PREFERRED_SELLERS', 'Preferred Sellers Feature');
  define('AMSG_BCC_EMAILS', 'BCC Emailing to the Site Admin');
  define('AMSG_SELLER_QUESTIONS', 'Ask Seller a Question Feature');
  define('AMSG_REGISTRATION_APPROVAL', 'Registration Approval');
  define('AMSG_WANTED_ADS', 'Wanted Ads');
  define('AMSG_BID_RETRACTION', 'Bid Retraction');
  define('AMSG_SELLER_OTHER_ITEMS', 'Other Items from Seller on Auction Details Page');
  define('AMSG_BULK_LISTER', 'Bulk Lister');
  define('AMSG_CATEGORY_COUNTERS', 'Category Counters');
  define('AMSG_PHONE_NB_SALE', 'Users Phone Numbers on Successful Sales');
  define('AMSG_MOD_REWRITE', 'Search Engine Friendly Links (mod rewrite)');
  define('AMSG_SITE_CONTENT', 'Site Content');
  define('AMSG_VOUCHERS_MANAGEMENT', 'Vouchers Management');
  define('AMSG_EDIT_HELP_SECTION', 'Edit Help Section');
  define('AMSG_EDIT_NEWS_SECTION', 'Edit News Section');
  define('AMSG_EDIT_ABOUT_US_PAGE', 'Edit About Us Page');
  define('AMSG_EDIT_CONTACT_US_PAGE', 'Edit Contact Us Page');
  define('AMSG_EDIT_TERMS_PAGE', 'Edit Terms and Conditions Page');
  define('AMSG_EDIT_PRIVACY_PAGE', 'Edit Privacy Policy Page');
  define('AMSG_CUSTOM_PAGES_MANAGEMENT', 'Custom Pages Management');
  define('AMSG_EDIT_SYSTEM_EMAILS', 'Edit System Emails');
  define('AMSG_SITE_BANNERS_MANAGEMENT', 'Site Banners Management');
  define('AMSG_EDIT_SITE_LANGUAGE_FILES', 'Edit Site Language Files');
  define('AMSG_EDIT_MEMBERS_ANNOUNCEMENTS', 'Edit Members Announcements');
  define('AMSG_LOGIN_AS_SITE_USER', 'Login as Site User');
  define('AMSG_USERS_REP_MANAGEMENT', 'Users Reputation Management');
  define('AMSG_CUSTOM_REP_FIELDS_MANAGEMENT', 'Custom Reputation Fields Setup');
  define('AMSG_REG_ACTIVATION_EMAILS', 'Send Registration Activation Emails');
  define('AMSG_SEND_NEWSLETTER', 'Send Newsletter');
  define('AMSG_ABUSE_REPORTS', 'View Abuse Reports');
  define('AMSG_BAN_USERS', 'Ban Users');
  define('AMSG_BLOCKED_USERS', 'Blocked Users');
  define('AMSG_AUCTIONS_MANAGEMENT', 'Auctions Management');
  define('AMSG_OPEN_AUCTIONS', 'Open Auctions');
  define('AMSG_CLOSED_AUCTIONS', 'Closed Auctions');
  define('AMSG_UNSTARTED_AUCTIONS', 'Unstarted Auctions');
  define('AMSG_SUSPENDED_AUCTIONS', 'Suspended Auctions');
  define('AMSG_AUCTIONS_AWAITING_APPROVAL', 'Auctions Awaiting Approval');
  define('AMSG_CUSTOM_AUCT_FIELDS_MANAGEMENT', 'Custom Auction Fields Management');
  define('AMSG_WANTED_ADS_MANAGEMENT', 'Wanted Ads Management');
  define('AMSG_CUSTOM_WANTED_ADS_MANAGEMENT', 'Custom Wanted Ad Fields Management');
  define('AMSG_PUBLIC_QUESTIONS_MANAGEMENT', 'Public Questions Management');
  define('AMSG_STORES_MANAGEMENT', 'Stores Management');
  define('AMSG_ENABLE_STORES', 'Enable Stores');
  define('AMSG_STORE_SUBSCRIPTIONS_MANAGEMENT', 'Store Subscriptions Management');
  define('AMSG_ACCOUNTING', 'Accounting');
  define('AMSG_OVERVIEW', 'Overview');
  define('AMSG_OVERDUE_CLIENTS', 'Overdue Clients (Account Mode Only)');
  define('AMSG_TOOLS', 'Tools');
  define('AMSG_WORD_FILTER', 'Word Filter');
  define('AMSG_BLOCK_FREE_EMAILS', 'Block Free Email Accounts on Registration');
  define('AMSG_CURRENCY_CONVERTER', 'Currency Converter');
  define('AMSG_SUPPORT', 'Support');
  define('AMSG_SUPPORT_DESK', 'Support Desk');
  define('AMSG_PPB_MANUAL', 'MyPHPAuction Manual');
  define('AMSG_SITE_NAME_EXPL', 'Enter your site\'s name. This value will also appear in all the emails sent by and through the site.');
  define('AMSG_SITE_URL_EXPL', 'Enter your site\'s URL.<br>
<b>Important</b>: The URL must have the following format: <b>http://www.yoursite.com/</b>');
  define('AMSG_ADMIN_EMAIL_EXPL', 'Enter your admin email address. This address will be used in the "From" field by all system emails.');
  define('AMSG_CHOOSE_MAILER', 'Choose Mailer');
  define('AMSG_MAILER_EXPL', 'You can choose mails to be sent through the standard PHP <b>mail()</b> function, or through the UNIX <b>Sendmail</b> program.
If you choose to send mails through Sendmail, you have to enter the Sendmail path in the textfield below.');
  define('AMSG_SENDMAIL_PATH', 'Sendmail Path');
  define('AMSG_SENDMAIL_PATH_EXPL', 'Enter the sendmail path in case you choose to use Sendmail as the system emails handler.');
  define('AMSG_CURRENT_SKIN', 'Current skin');
  define('AMSG_HPFEAT_DESC_EXPL', 'Enable home page featured short description (might not be available on all skins)');
  define('AMSG_CHOOSE_SITE_SKIN_EXPL', 'Choose your site\'s skin.');
  define('AMSG_CURRENT_LOGO', 'Current site logo');
  define('AMSG_CHOOSE_SITE_LOGO_EXPL', 'Choose your site\'s logo.');
  define('AMSG_CURRENT_LANG', 'Current language');
  define('AMSG_MAINTENANCE_MODE_EXPL', 'Choose "Yes" if you wish to enable maintenance mode. If maintenance mode is enabled, the
front end area of the site is disabled, only the admin being accessible.');
  define('AMSG_CHOOSE_DEFAULT_LANG_EXPL', 'Choose your site\'s default language.');
  define('AMSG_CLOSED_AUCT_DEL_EXPL', 'Enter a duration in days after which closed auctions should be deleted from the database. ');
  define('AMSG_ITEMS_PER_ROW', 'Number of items per row');
  define('AMSG_ITEMS_PER_ROW_EXPL', 'Enter the number of featured items you want to be displayed on one row. <br>
Enter 0 if you want no featured items to be displayed.');
  define('AMSG_FEAT_BOX_WIDTH', 'Item box width');
  define('AMSG_FEAT_BOX_WIDTH_EXPL', 'Enter the width of the featured item box, leave empty to use a default value. <br>
Note: this setting might not apply to all skins.');
  define('AMSG_MAX_ITEMS', 'Maximum items displayed');
  define('AMSG_RECENT_AUCTIONS_EXPL', 'Enter the number of recently listed auctions you want to be displayed on the main page.<br>
Enter 0 if you want to disable this feature.');
  define('AMSG_POPULAR_AUCTIONS_EXPL', 'Enter the number of popular auctions you want to be displayed on the main page.<br>
Popular auctions are those items with the highest bid amounts placed on them.<br>
Enter 0 if you want to disable this feature.');
  define('AMSG_ENDING_SOON_AUCTIONS_EXPL', 'Enter the number of ending soon auctions you want to be displayed on the main page.<br>
Enter 0 if you want to disable this feature.');
  define('AMSG_NB_IMAGES', 'Number of images');
  define('AMSG_NB_IMAGES_EXPL', 'Enter the number of images that can be uploaded with an auction. <br>
By entering 0, no images can be uploaded.');
  define('AMSG_MAX_FILE_SIZE', 'Maximum file size');
  define('AMSG_IMAGE_MAX_SIZE_EXPL', 'Enter the maximum size in KB an uploaded image can have.');
  define('AMSG_SELECT_SITE_CURRENCY', 'Select site currency');
  define('AMSG_SELECT_SITE_CURRENCY_EXPL', 'Select the site\'s default currency from the drop down menu above.');
  define('AMSG_AMOUNT_DISPLAY_FORMAT', 'Amount display format');
  define('AMSG_US_STYLE', 'U.S. style');
  define('AMSG_EURO_STYLE', 'European style');
  define('AMSG_AMOUNT_DIGITS', 'Decimal digits');
  define('AMSG_AMOUNT_DIGITS_EXPL', 'Enter the amount of decimal digits you want to be shown when displaying an amount.');
  define('AMSG_CURRENCY_SYMBOL_POSITION', 'Currency symbol position');
  define('AMSG_SYMBOL_BEFORE_AMOUNT', 'Symbol before amount');
  define('AMSG_SYMBOL_AFTER_AMOUNT', 'Symbol after amount');
  define('AMSG_TIME_OFFSET', 'Time Offset');
  define('AMSG_SELECT_TIME_OFFSET', 'Select time offset');
  define('AMSG_SELECT_TIME_OFFSET_EXPL', 'Select the time difference between your local time and the server\'s time. This setting will
apply to all instances where dates are displayed.');
  define('AMSG_FORMAT', 'format');
  define('AMSG_DATE_FORMAT', 'Date Display Format');
  define('AMSG_ACTIVATE_SSL', 'Activate SSL');
  define('AMSG_ACTIVATE_SSL_EXPL', 'Choose if you want to activate SSL on your site. You need an SSL certificate enabled on your
site in order for this setting to work properly. <br>
The login and registration processes will be handled through SSL if this feature is enabled.');
  define('AMSG_ENTER_SSL_ADDRESS', 'Enter SSL address');
  define('AMSG_ADD_META_TAGS', 'Add meta tags');
  define('AMSG_CRON_JOB_CPANEL', 'Run cron jobs from your server\'s control panel');
  define('AMSG_CRON_JOB_PPB', 'Run cron jobs from MyPHPAuction');
  define('AMSG_MIN_AGE', 'Minimum registration age');
  define('AMSG_MIN_AGE_EXPL', 'Enter the minimum age required for users to be able to reigster to your site.');
  define('AMSG_DATE_OF_BIRTH_TYPE', 'Date of birth format');
  define('AMSG_DOB_FULL_FORMAT', 'Full format (day / month / year)');
  define('AMSG_DOB_YEAR_ONLY', 'Short format (year only)');
  define('AMSG_RECENT_WANTED_ADS_EXPL', 'Enter the number of recently listed wanted ads that will be displayed on the home page of your site.');
  define('AMSG_NB_MEDIA', 'Number of media uploads');
  define('AMSG_NB_MEDIA_EXPL', 'Enter the number of media files that can be uploaded with an auction. <br>
By entering 0 in this field, you will disable media upload throughout the site.');
  define('AMSG_MEDIA_MAX_SIZE_EXPL', 'Enter the maximum size in KB an uploaded image can have.<br><br>
<strong>IMPORTANT NOTE:</strong> The maximum size for uploading files on your server is
<b>' . ini_get('upload_max_filesize') . 'Bytes</b>.
If you want for the users to be able to upload larger files you will need to modify the <strong>upload_max_filesize</strong>
setting from php.ini.<br><br>Please ask your hosting provider for more details on this.');
  define('AMSG_BUY_OUT_BUYOUT', 'Use standard <b>Buy Out</b> method');
  define('AMSG_BUY_OUT_MAKEOFFER', 'Use <b>Make Offer</b> method');
  define('AMSG_BUY_OUT_ALTER_WARNING', '<b>Warning:</b> By changing this setting, all live auctions that have Buy Out/Make Offer
enabled will have the setting changed to disabled. The offers that were placed will however not be deleted. ');
  define('AMSG_CHOOSE_METHOD', 'Choose method');
  define('AMSG_CHOOSE_POSITION', 'Choose position');
  define('AMSG_SELLNAV_POS_1', '<b>Previous Step</b> button first, <b>Next Step</b> button after');
  define('AMSG_SELLNAV_POS_2', '<b>Next Step</b> button first, <b>Previous Step</b> button after');
  define('AMSG_ENTER_NUMBER', 'Enter number');
  define('AMSG_NB_AUTORELISTS_EXPL', 'Enter the maximum number of auto-relists a user is allowed to enter when creating an auction.');
  define('AMSG_CLICK_TO_ENABLE_FEATURE', 'Check the checkbox above to enable this feature.');
  define('AMSG_NB_NEWS_DISPLAYED', 'Number of news displayed');
  define('AMSG_NB_NEWS_DISPLAYED_EXPL', 'Enter the maximum number of news articles that will be displayed on the home page news box.');
  define('AMSG_ALWAYS_SHOW_BUYOUT', 'Always show Buy Out');
  define('AMSG_ALWAYS_SHOW_BUYOUT_EXPL', 'By enabling this option, Buy Out/Make Offer will be available even if the item has active bids and
the reserve has been met.');
  define('AMSG_REG_TERMS_CONTENT', 'Registration terms content');
  define('AMSG_SELLITEM_TERMS_CONTENT', 'Selling process terms content');
  define('AMSG_SNIPING_DURATION', 'Sniping time');
  define('AMSG_SNIPING_DURATION_EXPL', 'Enter the duration in minutes for which the sniping feature is activated.');
  define('AMSG_ADD_VOUCHER', 'Add Voucher');
  define('AMSG_EDIT_VOUCHER', 'Edit Voucher');
  define('AMSG_ADD_SIGNUP_VOUCHER', 'Add Signup Voucher');
  define('AMSG_ADD_SETUP_VOUCHER', 'Add Auction Setup Voucher');
  define('AMSG_SIGNUP_VOUCHERS', 'Signup Vouchers');
  define('AMSG_SETUP_VOUCHERS', 'Auction Setup Vouchers');
  define('AMSG_VOUCHER_NAME', 'Voucher Name');
  define('AMSG_VOUCHER_TYPE', 'Voucher Type');
  define('AMSG_VOUCHER_REDUCTION', 'Fees Reduction');
  define('AMSG_VOUCHER_REDUCTION_EXPL', 'Enter a percentage reduction that will apply to the fees in question when this voucher is used.');
  define('AMSG_START_DATE', 'Start Date');
  define('AMSG_VOUCHER_DURATION_EXPL', 'Enter the duration in days until this voucher expires. Leave empty or enter 0 if you wish to apply an unlimited duration.');
  define('AMSG_NB_OF_USES', 'Number of Uses');
  define('AMSG_NB_OF_USES_EXPL', 'Enter the number of times this voucher can be used. Leave empty or enter 0 if you wish for users to be able to use this voucher an
unlimited number of times.');
  define('AMSG_ASSIGNED_FEES', 'Assign to Fees');
  define('AMSG_ALL_FEES', 'All Fees');
  define('AMSG_VOUCHER_CODE', 'Voucher Code');
  define('AMSG_VOUCHER_DETAILS', 'Voucher Details');
  define('AMSG_USES_LEFT', 'Uses Left');
  define('AMSG_EDIT_FAQ_SECTION', 'Edit FAQ Section');
  define('AMSG_ADD_TOPIC', 'Add Topic');
  define('AMSG_EDIT_TOPIC', 'Edit Topic');
  define('AMSG_TOPIC_CONTENT', 'Topic Content');
  define('AMSG_DATE_ADDED', 'Date Added');
  define('AMSG_LANGUAGE_FILES_EDIT_NOTE', '<b>Note:</b> For best results, please copy the code from the textarea above in your favorite php/html editor, make the
changes there, and then paste the code back into the textarea.');
  define('AMSG_SELECTED_FILE', 'Selected File');
  define('AMSG_ENTER_CONTENT', 'Enter Content');
  define('AMSG_ENABLE_PAGE', 'Enable this Page');
  define('AMSG_ADD_BANNER', 'Add Banner');
  define('AMSG_DETAILS', 'Details');
  define('AMSG_BANNER_PREVIEW', 'Banner Preview');
  define('AMSG_CUSTOM_ADVERT', 'Custom Advert');
  define('AMSG_CODE_ADVERT', 'Code Advert');
  define('AMSG_BANNER_TYPE', 'Banner Type');
  define('AMSG_BANNER_TYPE_EXPL', 'Choose the banner type you want to create.<br>
<b>Code Advert:</b> banners for which you only need to enter specific code in order for the banner to work.<br>
<b>Custom Advert:</b> banners created directly by you. You will need to enter at least an image and a redirect url for this banner type.');
  define('AMSG_ADVERT_CODE', 'Banner Code');
  define('AMSG_VIEWS_PURCHASED', 'Views Purchased');
  define('AMSG_VIEWS_PURCHASED_EXPL', 'Optional field. Enter the maximum number of times this banner will be displayed on the site or leave empty if the
banner will displayed an unlimited number of times.');
  define('AMSG_CLICKS_PURCHASED', 'Clicks Purchased');
  define('AMSG_CLICKS_PURCHASED_EXPL', 'Optional field. Enter the maximum number of click-throughs this banner will accept or leave empty if
an unlimited number of clicks was purchased.');
  define('AMSG_BANNER_IMAGE', 'Upload Banner Image');
  define('AMSG_BANNER_URL', 'Banner URL');
  define('AMSG_TEXT_UNDER', 'Text Under');
  define('AMSG_ALT_TEXT', 'Alt Text');
  define('AMSG_DISPLAY_IN_CATEGORIES', 'Display in Categories');
  define('AMSG_DISPLAY_IN_CATEGORIES_EXPL', 'Optional field. Select the categories from the list below for which you want this banner to display or leave
empty if you want this banner to be displayed sitewide.');
  define('AMSG_ALL_CATEGORIES', 'All Categories');
  define('AMSG_SELECTED_CATEGORIES', 'Selected Categories');
  define('AMSG_SELECT_BANNER_TYPE', 'Select Banner Type ->');
  define('AMSG_EDIT_BANNER', 'Edit Banner');
  define('AMSG_HPFEAT_FEE_DESC', 'Enter a fee for home page featured items. This is a flat fee.');
  define('AMSG_CATFEAT_FEE_DESC', 'Enter a fee for category page featured items. This is a flat fee.');
  define('AMSG_HL_FEE_DESC', 'Enter a fee for highlighted items. This is a flat fee.');
  define('AMSG_BOLD_FEE_DESC', 'Enter a fee for bold items. This is a flat fee.');
  define('AMSG_IMG_UPL_FEE_DESC', 'Enter a fee for uploading images to be included with auctions. This is a flat fee.');
  define('AMSG_MEDIA_UPL_FEE_DESC', 'Enter a fee for uploading media to be included with auctions. This is a flat fee.');
  define('AMSG_ADDLCAT_FEE_DESC', 'Enter a fee for inserting the auction in an additional category. This is a flat fee.');
  define('AMSG_CUSTOM_START_FEE_DESC', 'Enter a fee for setting up custom start time for an auction. This is a flat fee');
  define('AMSG_BUYOUT_FEE_DESC', 'Enter a fee for enabling Buy Out on an auction. This is a flat fee.');
  define('AMSG_RP_FEE_DESC', 'Enter a fee for enabling reserve price on an auction. This is a flat fee.');
  define('AMSG_REL_FEES_RED_FEE_DESC', 'Enter a reduction percentage in case an auction is relisted. This is a percentage amount.');
  define('AMSG_WA_SETUP_FEE_DESC', 'Enter a fee for setting up a wanted ad. This is a flat fee.');
  define('AMSG_COUNTRY', 'Country');
  define('AMSG_ACCOUNT_STATUS', 'Account Status');
  define('AMSG_ENABLE_AUCT_APPROVAL', 'Enable Auctions Approval');
  define('AMSG_AUCT_APPROVAL_NOTE', 'Note: By checking the checkbox above, all auctions will require admin approval.<br>
If the global approval is disabled, you will still be able to select particular users and categories to which auction approval
will apply.');
  define('AMSG_USERS', 'Users');
  define('AMSG_VIEW_BIDS', 'View Bids');
  define('AMSG_VIEW_OPEN_AUCTIONS', 'View Open Auctions');
  define('AMSG_SELLING_CAPABILITIES', 'Selling Capabilities');
  define('AMSG_PREF_SELLER', 'Preferred Seller');
  define('AMSG_REQUIRE_AUCT_APPROVAL', 'Auction Approval Required');
  define('AMSG_PAYMENT_SETTINGS', 'Payment Settings');
  define('AMSG_PAYMENT_MODE_EXPL', 'Live: all fees are paid when a service is ordered.<br>
Account: fees are paid periodically');
  define('AMSG_ACCOUNT_BALANCE', 'Account Balance');
  define('AMSG_ACCOUNT_BALANCE_EXPL', 'You can modify the user\'s balance using the field above. An invoice will also be generated in order for the user to view why his balance has been modified.');
  define('AMSG_MAX_DEBIT_EXPL', 'You can set up a custom debit limit for this account. This value is defaulted to the global Maximum Debit value set on the Fees -> Main Settings page.');
  define('AMSG_REDUCTION', 'Reduction');
  define('AMSG_INVALID_PAGE_SELECTED', 'ERROR: You are trying to access a page that doesnt exist.');
  define('AMSG_BY_KEYWORDS', 'By Keywords');
  define('AMSG_BY_AUCTION_ID', 'By Auction ID');
  define('AMSG_ITEM_DETAILS', 'Item Details');
  define('AMSG_OWNER', 'Owner');
  define('AMSG_ACTIVATE_ALL', 'Activate All');
  define('AMSG_SUSPEND_ALL', 'Suspend All');
  define('AMSG_ENDAUCTION_FEE_APPLIES', 'Applies To');
  define('AMSG_INVOICES_SETTINGS', 'Site Invoices Settings');
  define('AMSG_INVOICE_HEADER', 'Invoice Header');
  define('AMSG_VAT_NUMBER', 'Tax Registration Number');
  define('AMSG_VAT_NUMBER_DESC', 'Enter your company\'s tax registration number if available. <br>
If Tax is enabled, the tax registration number will appear at the bottom of each site invoice generated.');
  define('AMSG_INVOICE_HEADER_DESC', 'Optional. Submit a custom header for your site\'s invoices.');
  define('AMSG_INVOICE_FOOTER', 'Invoice Footer');
  define('AMSG_INVOICE_FOOTER_DESC', 'Optional. Submit a custom footer for your site\'s invoices.');
  define('AMSG_INVOICE_COMMENTS', 'Invoice Comments');
  define('AMSG_INVOICE_COMMENTS_DESC', 'Optional. The invoice comments will appear at the bottom of each site invoice generated.');
  define('AMSG_MCRYPT_SETTINGS', 'Mcrypt Callback Encryption Settings');
  define('AMSG_ENABLE_MCRYPT', 'Enable Mcrypt');
  define('AMSG_ENABLE_MCRYPT_EXPL', 'Click to enable the Mcrypt encryption feature for the callback process, for additional security
for payment callbacks. This feature will apply to all payment gateways used.<br>
<b>Important</b>: PHP must be compiled on your server with the "mcrypt" module. The minimum version required is 2.4.x ');
  define('AMSG_MCRYPT_KEY', 'Mcrypt Key');
  define('AMSG_MCRYPT_KEY_EXPL', 'Enter a unique key that the mcrypt module will use to encrypt the callback data.');
  define('AMSG_AUCTION_FEES', 'Auction Fees');
  define('AMSG_WANTED_AD_FEES', 'Wanted Ad Fees');
  define('AMSG_MAKEOFFER_FEE_DESC', 'Enter a fee for enabling Make Offer on an auction. This is a flat fee.');
  define('AMSG_ITEMS', 'items');
  define('AMSG_DELETE_MARKED_DELETED_ITEMS', 'Remove Marked Deleted Items');
  define('AMSG_MARKED_DELETED_REMOVED', 'All marked deleted auctions have been successfully removed.');
  define('AMSG_INSUFFICIENT_LVL_MSG', 'Sorry, You have not a high enough admin priviledge level
to access the page you have requested.');
  define('AMSG_CAT_CHANGE_EXPL_MSG', 'You have made changes to your category structure,
please update those changes by clicking <a href="update_categories.php"><font size="+2" color="yellow">HERE</font></a>
when you have finished');
  define('AMSG_VIEW_BIDS_PLACED_BY', 'View bids placed by');
  define('AMSG_MB_USERNAME_LOGIN', 'Enter the Member Username to Login as');
  define('AMSG_ENTER_ADMIN_USERNAME', 'Enter your Admin Username');
  define('AMSG_ENTER_ADMIN_PASSWORD', 'Enter your Admin Password');
  define('AMSG_INVALID_ADMIN_LOGIN', '<b>Error</b>: The admin login details you have submitted are invalid or<br>
you don\'t have enough priviledges to login as a site user.');
  define('AMSG_INVALID_USERNAME', '<b>Error</b>: The user you are trying to login as doesn\'t exist.');
  define('AMSG_SPOOFER_LOGIN_SUCCESS_A', 'You have now Successfully Logged in as');
  define('AMSG_CLICK_TO_PROCEED', 'Click here to Proceed');
  define('AMSG_RECORD_DELETED', 'The record has been deleted successfully.');
  define('AMSG_FILTER_REPUTATIONS', 'Filter Reputations');
  define('AMSG_REP_RATE', 'Reputation Rate');
  define('AMSG_REP_COMMENTS', 'Reputation Comments');
  define('AMSG_REPUTATION_SEARCH', 'Reputation Search');
  define('AMSG_RATING', 'Rating');
  define('AMSG_SUBMITTED', 'Submitted');
  define('AMSG_NOT_SUBMITTED', 'Not Submitted');
  define('AMSG_BLOCK_REASON', 'Block Reason');
  define('AMSG_BID_STATUS', 'Bid Status');
  define('AMSG_AUCTION_STATUS', 'Auction Status');
  define('AMSG_SHOW_REASON', 'Show Reason');
  define('AMSG_BLOCKER', 'Blocker');
  define('AMSG_BLOCKED_USER', 'Blocked User');
  define('AMSG_REPORT_DETAILS', 'Report Details');
  define('AMSG_REPORTER', 'Reporter');
  define('AMSG_REPORTED_USER', 'Reported User');
  define('AMSG_EMAIL_REPORTER', 'Email Reporter');
  define('AMSG_ADD_BANNED', 'Add Banned IP/Email');
  define('AMSG_EDIT_BANNED', 'Edit Banned IP/Email');
  define('AMSG_IP_BAN', 'IP Ban');
  define('AMSG_EMAIL_BAN', 'Email Ban');
  define('AMSG_BANNED_ADDRESS', 'Banned Address');
  define('AMSG_ADDRESS_TYPE', 'Address Type');
  define('AMSG_SELECT_ADDRESS_TYPE', 'Select Address Type ->');
  define('AMSG_BANNED_ADDRESS_EXPL_IP', 'IP Format: 123.231.145.45');
  define('AMSG_BANNED_ADDRESS_EXPL_EMAIL', 'Email Address Format: email@domain.com');
  define('AMSG_WORD', 'Word');
  define('AMSG_ADD_WORD', 'Add New Word');
  define('AMSG_DOMAIN', 'Domain');
  define('AMSG_ADD_DOMAIN', 'Add New Domain');
  define('AMSG_USER_MESSAGES_MANAGEMENT', 'User Messages Management');
  define('AMSG_TOPIC_ID', 'Topic ID');
  define('AMSG_TOPIC_NAME', 'Topic Name');
  define('AMSG_NB_MESSAGES', 'Nb. Messages');
  define('AMSG_TOPIC_DELETED', 'The topic has been deleted successfully.');
  define('AMSG_VIEW_TOPIC', 'View Messages');
  define('AMSG_BY_WA_ID', 'By Wanted Ad ID');
  define('AMSG_SUBSCRIPTION_NAME', 'Subscription Name');
  define('AMSG_ITEMS_IN_STORE', 'Items in Store');
  define('AMSG_RECURRING_FEE_DAYS', 'Recurring Fee [days]');
  define('AMSG_ADD_SUBSCRIPTION', 'Add Subscription');
  define('AMSG_STORE_SUBSCR_NOTE_A', 'If you dont set up any store types, a default store will be available for all
users with the following characteristics: [ <b>Items in Store</b>: Unlimited ] [ <b>Store Fee</b>: Free ] ');
  define('AMSG_STORE_SUBSCR_NOTE_B', '<b>IMPORTANT</b>: Deleting a store type will automatically inactivate all stores that were subscribed to the respective account type. 
Inactivating all store fees and types will automatically activate all stores.
If you want to alter subscriptions you should edit them rather than creating new ones.');
  define('AMSG_STORE_SUBSCR_NOTE_C', '<b>NOTE</b>: If you want a fee to be a one time fee, enter 0 in the "Recurring" field.<br>
The "Items in Store" field represents the maximum number of open auctions that can be listed at one time in the member\'s store.');
  define('AMSG_CHOOSE_VIEW', 'Choose View');
  define('AMSG_SELECT_PERIOD', 'Select Period');
  define('AMSG_DAILY', 'Daily');
  define('AMSG_WEEKLY', 'Weekly');
  define('AMSG_MONTHLY', 'Monthly');
  define('AMSG_TOTAL_INVOICED', 'Total Invoiced');
  define('AMSG_TOTAL_PAID', 'Total Paid');
  define('AMSG_TIME_PERIOD', 'Time Period');
  define('AMSG_STORE_DETAILS', 'Store Details');
  define('AMSG_DEFAULT_ACCOUNT', 'Default Account');
  define('AMSG_REMOVE_DEFAULT_ACCOUNT', 'Remove Default Account');
  define('AMSG_ASSIGN_DEFAULT_ACCOUNT', 'Assign Default Account');
  define('AMSG_RENEW_SUBSCRIPTION', 'Renew/Activate Subscription');
  define('AMSG_SUSPEND_STORE', 'Suspend Store');
  define('AMSG_ASSIGN_DEFAULT_STORE_ACCOUNT', 'Assign Default Store Account');
  define('AMSG_SEARCHABLE', 'Searchable');
  define('AMSG_NUMBER_OF_AUCTIONS', 'Number of Auctions');
  define('AMSG_FEATURED_AUCTIONS', 'Featured Auctions');
  define('AMSG_NUMBER_OF_USERS', 'Number of Users');
  define('AMSG_ACTIVE_USERS', 'Active Users');
  define('AMSG_SUSPENDED_USERS', 'Suspended Users');
  define('AMSG_ADMIN_AREA_LANGUAGE', 'Admin Area Language');
  define('AMSG_AUCTIONS_MARKED_DELETED', 'Marked Deleted Auctions');
  define('AMSG_ACCOUNTING_OVERDUE', 'Accounting Overdue');
  define('AMSG_HOVER_TITLE', 'Hover Title');
  define('AMSG_META_DESCRIPTION', 'Meta Description');
  define('AMSG_META_KEYWORDS', 'Meta Keywords');
  define('AMSG_MIN_AGE_YEARS', 'Min. age<br>(years)');
  define('AMSG_CHG_DURATION_ON_BID_PLACED', 'Change Auction Duration when a Bid is Placed');
  define('AMSG_NEW_DURATION', 'New Duration');
  define('AMSG_NEW_DURATION_DESC', 'If the duration left of the auction is over the value above, then it will be automatically reset 
to the value above.');
  define('AMSG_ACT_EMAILS_MSG', 'Click on the "Proceed" button below to resend the proper activation emails to all unverified 
users that are registered to the site.<br>');
  define('AMSG_ACT_EMAILS_IMPOSSIBLE_MSG', 'The activation emails cannot be sent because the registration activation is disabled or a signup fee is set.');
  define('AMSG_ACT_EMAILS_SENT_MSG', 'The registration activation emails have been re-sent successfully.');
  define('AMSG_SEND_EMAIL_TO', 'Send Email To');
  define('AMSG_EMAIL_SUBJECT', 'Email Subject');
  define('AMSG_SEND_NEWSLETTER_TO', 'Send Newsletter To');
  define('AMSG_ALL_USERS', 'All Users');
  define('AMSG_NEWSLETTER_SUBSCRIBERS', 'Newsletter Subscribers');
  define('AMSG_EMAIL_USER', 'Send Message to User');
  define('AMSG_EMAIL_SENT_SUCCESS', 'The email has been sent successfully.');
  define('AMSG_CONTENT', 'Content');
  define('AMSG_EMAILS_SENT_SUCCESS', 'The emails have been sent successfully');
  define('AMSG_EDIT_CAT_LANG_FILES', 'Edit Category Language Files');
  define('AMSG_CHOOSE_LANGUAGE', 'Choose Language');
  define('AMSG_AUCT_MARKED_DELETED', 'Marked Deleted Auction');
  define('AMSG_FEATURED', 'Featured');
  define('AMSG_STORE_SUBSCR_NOTE_D', '<b>NOTE</b>: Users which will create their store from an account with the "Featured" option enabled 
will have their store featured on the "Stores" page.');
  define('AMSG_PRINT_VIEW', 'Print View');
  define('AMSG_PRINT_THIS_PAGE', 'Print this Page');
  define('AMSG_CLOSE_WINDOW', 'Close Window');
  define('AMSG_ENABLE_SELLER_VERIFICATION', 'Enable Seller Verification');
  define('AMSG_VERIFICATION_FEE', 'Verification Fee');
  define('AMSG_VERIFICATION_FEE_EXPL', 'You can set up a one time or recurring verification fee. If you wish the verification fee 
to be a one time fee enter 0 in the recurring field.<br>
<b>Note</b>: Even if you disable seller verification, you will still be able to set the status of your users to verified sellers 
from the Users Management page. Users will however not be able to verify their accounts themselves.');
  define('AMSG_RECURRING_EVERY', 'recurring every');
  define('AMSG_VERIFIED_SELLER', 'Verified Seller');
  define('AMSG_SWAP_FEE_DESC', 'Enter a fee that will be charged when an item is swapped. This is a flat fee.');
  define('AMSG_SHOW_MAKEOFFER_RANGE', 'Show Make Offer Price Ranges');
  define('AMSG_SHOW_MAKEOFFER_RANGE_EXPL', 'If you enable this feature, the minimum and maximum offer range accepted on an auction 
are shown to the potential buyers. Otherwise these values are hidden.');
  define('AMSG_SELLER_VERIF_MANDATORY', 'Mandatory Verification');
  define('AMSG_SELLER_VERIF_MANDATORY_EXPL', 'If the mandatory verification is enabled, all sellers will need to get verified in order to be able to sell. <br>
Otherwise sellers will be able to post items even if they aren\'t verified.');
  define('AMSG_SOLD_ITEMS', 'Sold Items');
  define('AMSG_WINNING_BID_DETAILS', 'Winning Bid Details');
  define('AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_SALE', 'Custom Reputation Fields Setup (sale)');
  define('AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_PURCHASE', 'Custom Reputation Fields Setup (purchase)');
  define('AMSG_EMAILS_QUEUED_SUCCESS', 'The newsletter has been saved.<br>
The emails will be sent to the recipients using the <b>cron_jobs/newsletter_cron.php</b> file,<br>
please make sure you have added the file to your server\'s cron.<br>
The newsletter will be sent to 50 users at a time to avoid server load.');
  define('AMSG_SELLER_OTHER_ITEMS_EXPL', '<b>Important</b>: It is recommended to disable this option in case your site has many live items.');

## v6.01
  define('AMSG_EDIT_BID_INCREMENTS', 'Edit Bid Increments Table');
  define('AMSG_INCREMENT_AMOUNT', 'Increment Amount');
  define('AMSG_ADD_INCREMENT', 'Add New Bid Increment');

  define('AMSG_VIEW_ACCOUNT_HISTORY', 'View Account History');
  define('AMSG_ACCOUNT_HISTORY_FOR', 'Account History For');
  define('AMSG_SEND_PAYMENT_REMINDER', 'Send Payment Reminder');
  define('AMSG_INVOICE_SENT_SUCCESS', 'The payment reminder has been sent to the user successfully.');

  define('AMSG_ENABLE_PROFILE_PAGE', 'Enable Profile Page');

  define('AMSG_USER_HASNT_LOGGED_IPS', 'This user hasn\'t logged on since you started logging IPs!');
  define('AMSG_IP_ADDRESS_HISTORY', 'IP Address History');
  define('AMSG_IP_ADDRESS', 'IP Address');
  define('AMSG_VIEW_SUGGESTED_CATEGORIES', 'View Suggested Categories');
  define('AMSG_ENABLE_STORE_ONLY_MODE', 'Enable Store Only Mode');
  define('AMSG_ENABLE_STORE_ONLY_MODE_EXPL', 'If you choose to enable this option, users will need to open a store in order to 
be able to list items. Users that will not have a store opened will only able to bid on items.<br>
<b>Important:</b> The <b>Buy Out</b> feature will be automatically enabled when you enable <b>Store Only</b> mode, and all 
items will need to have a <b>Buy Out</b> price set.');
  define('AMSG_ACTIVATE_EHANCED_SSL', 'Enable Enhanced SSL');
  define('AMSG_ACTIVATE_EHANCED_SSL_EXPL', 'By enabling enhanced SSL support, your site\'s <b>Members Area</b>, the selling process and 
several other pages will run through SSL.<br>
Some servers however might not support the same session variables on both the SSL and normal sites, that is why this feature is 
optional. If you choose to run the site in SSL but with this option disabled, only the login and register pages will run in SSL.');

  define('AMSG_WATERMARK_TEXT', 'Watermark Text');
  define('AMSG_WATERMARK_TEXT_EXPL', 'This would be the text you would like to use as a watermark.');
  define('AMSG_MAX_RESIZE', 'Maximum Resize');
  define('AMSG_MAX_RESIZE_EXPL', 'This would be the maximum width to resize to (500 is recommended)');
  define('AMSG_DEBIT_BALANCE_LIMIT', 'Debit Balance > 1.00');
  define('AMSG_PAYMENT_REMINDER_ALL', 'Send a payment reminder to all the users in the list below');
  define('AMSG_INVOICES_SENT_SUCCESS', 'The payment reminders have been sent to the users successfully.');
  define('AMSG_OLD_IMAGES_REMOVAL_TOOL', 'Old Images Removal Tool');
  define('AMSG_IMG_REMOVAL_TOOL_DESC', 'This tool will delete the old images from your <b>uplimg/</b> folder.<br>Only images which dont correspond to any auction 
(active/closed/suspended or marked deleted) will be removed');
  define('AMSG_CLEANUP_SUCCESS', 'Cleanup Successful');
  define('AMSG_IMGS_HAVE_BEEN_DELETED_TOTALING', ' images have been deleted totalling ');
  define('AMSG_OPERATION_LASTED', 'Operation lasted');
  define('AMSG_IMPORTANT', 'Important');
  define('AMSG_IMAGES_STALL_NOTICE', 'There are more than 100 files to be removed, please click proceed to resume the deletion. Deletion is capped at 100 files per click to avoid server stall.');
  define('AMSG_PROCESSING', 'Processing');
  define('AMSG_DELETED', 'Deleted');
  define('AMSG_NOT_DELETED', 'NOT Deleted');
  define('AMSG_AUTO_RELIST_SETTINGS', 'Auto Relist Settings');
  define('AMSG_ENABLE_AUTO_RELIST', 'Enable Auto Relist');
  define('AMSG_ENABLE_AUTO_RELIST_EXPL', 'Check the checkbox above to enable users to use the auto-relisting feature for their auctions.');
  define('AMSG_SENDING_OPTIONS', 'Sending Method');
  define('AMSG_USE_CRON_JOB', 'Use Newsletter Cron Job');
  define('AMSG_SEND_DIRECTLY', 'Send Directly');
  define('AMSG_NEWSLETTER_SEND_SUCCESS', 'The newsletter has been successfully sent.');
  define('AMSG_ENABLE_SKIN_CHANGE', 'Enable Skin Change on User End');
  define('AMSG_FREE_IMAGES', 'Free Images');
  define('AMSG_FREE_IMAGES_EXPL', 'Enter in the text field above how many images the user will be able to upload for free before being filled the Images Upload Fee.');
  define('AMSG_FREE_MEDIA', 'Free Media');
  define('AMSG_FREE_MEDIA_EXPL', 'Enter in the text field above how many media files the user will be able to upload for free before being filled the Media Upload Fee.');
  define('AMSG_PREF_SELLER_EXP_DATE', 'Expires in');
  define('AMSG_PREF_SELLER_EXP_DATE_EXPL', 'Enter the number of days after which time the preferred seller status of a user will expire.<br>If you will set the number of days, all preferred sellers which dont have 
an expiration date on their status set will be automatically set this expiration date.');
  define('AMSG_SEND_MSG_TO', 'Send Message To');
  define('AMSG_SUBJECT', 'Subject');
  define('AMSG_BY_EMAIL', 'by email');
  define('AMSG_INTERNAL_MESSAGING', 'using the internal messaging system');
  define('AMSG_MSG_SENT_SUCCESS', 'The message has been sent successfully.');
  define('AMSG_ENABLE_SECOND_CHANCE', 'Enable Second Chance Purchasing');
  define('AMSG_SELECT_INTERVAL', 'Select Interval');
  define('AMSG_SECOND_CHANCE_EXPL', 'With second chance purchasing, sellers will be able to manually select a winner if the automatically appointed winner didn\'t go through with the purchase.<br> 
You can set a number of days after which the "Second Chance" feature will become available for sold items, or enter 0 if you wish for this feature to be available right away. <br><br>
<b>Important</b>: This feature will be available for standard auctions not marked as paid only.');
  define('AMSG_REPORTED_AUCTION', 'Reported Auction');
  define('AMSG_DELETE_REPORT', 'Delete Report');
  define('AMSG_DELETE_AUCTION', 'Delete Auction');
  define('AMSG_DELETE_AUCTION_CONFIRM', 'Are you sure you want to delete this auction?');
  define('AMSG_AUCTION_DELETED', 'The auction has been deleted successfully.');
  define('AMSG_SERVER_LOAD', 'Server Load');
  define('AMSG_APPLIED_BY', 'Applied By Sellers From');
  define('', '');
  define('', '');
  define('', '');
?>