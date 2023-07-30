#
# Table structure for table 'tx_sfbooks_domain_model_book'
#
CREATE TABLE tx_sfbooks_domain_model_book
(
    number       tinytext                     NOT NULL,
    title        tinytext                     NOT NULL,
    path_segment varchar(2048),
    subtitle     tinytext                     NOT NULL,
    author       tinytext                     NOT NULL,
    isbn         tinytext                     NOT NULL,
    series       int(11) unsigned DEFAULT '0' NOT NULL,
    category     int(11) unsigned DEFAULT '0' NOT NULL,
    description  text                         NOT NULL,
    extras       int(11) unsigned DEFAULT '0' NOT NULL,
    cover        int(11) unsigned DEFAULT '0' NOT NULL,
    cover_large  int(11) unsigned DEFAULT '0' NOT NULL,
    sample_pdf   int(11) unsigned DEFAULT '0' NOT NULL,
    year         varchar(4)       DEFAULT ''  NOT NULL,
    location1    int(11) unsigned DEFAULT '0' NOT NULL,
    location2    int(11) unsigned DEFAULT '0' NOT NULL,
    location3    int(11) unsigned DEFAULT '0' NOT NULL
);



#
# Table structure for table 'tx_sfbooks_domain_model_book_author_mm'
# medium is local table
# author is foreign table
#
CREATE TABLE tx_sfbooks_domain_model_book_author_mm
(
    uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
    sorting         int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_sfbooks_domain_model_author'
#
CREATE TABLE tx_sfbooks_domain_model_author
(
    lastname     tinytext NOT NULL,
    firstname    tinytext NOT NULL,
    path_segment varchar(2048),
    description  text     NOT NULL,
    books        tinytext NOT NULL
);



#
# Table structure for table 'tx_sfbooks_domain_model_book_series_mm'
# medium is local table
# author is foreign table
#
CREATE TABLE tx_sfbooks_domain_model_book_series_mm
(
    uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
    sorting         int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_sfbooks_domain_model_series'
#
CREATE TABLE tx_sfbooks_domain_model_series
(
    title        tinytext NOT NULL,
    path_segment varchar(2048),
    info         text     NOT NULL,
    description  text     NOT NULL,
    books        tinytext NOT NULL
);



#
# Table structure for table 'tx_sfbooks_domain_model_book_category_mm'
# medium is local table
# author is foreign table
#
CREATE TABLE tx_sfbooks_domain_model_book_category_mm
(
    uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
    sorting         int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_sfbooks_domain_model_category'
#
CREATE TABLE tx_sfbooks_domain_model_category
(
    title        tinytext                     NOT NULL,
    path_segment varchar(2048),
    parent       int(11) unsigned DEFAULT '0' NOT NULL,
    children     int(11) unsigned DEFAULT '0' NOT NULL,
    description  text                         NOT NULL,
    books        tinytext                     NOT NULL
);



#
# Table structure for table 'tx_sfbooks_domain_model_extras'
#
CREATE TABLE tx_sfbooks_domain_model_extras
(
    parent  int(11)          DEFAULT '0' NOT NULL,
    type    int(11)          DEFAULT '0' NOT NULL,
    label   int(11) unsigned DEFAULT '0' NOT NULL,
    content text                         NOT NULL
);



#
# Table structure for table 'tx_sfbooks_domain_model_extraslabels'
#
CREATE TABLE tx_sfbooks_domain_model_extraslabels
(
    label tinytext NOT NULL
);
