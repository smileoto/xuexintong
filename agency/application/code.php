<?php

define('ERR_NOT_LOGIN', -10000);
define('ERR_NOT_RIGHT', -10001);
define('ERR_NEW_PASSWORD', -10002);
define('ERR_USER_PASS', -10003);
define('ERR_NOT_PARAMS', -10004);

define('ERR_DB_SELECT', -20001);
define('ERR_DB_INSERT', -20002);
define('ERR_DB_UPDATE', -20003);
define('ERR_DB_DELETE', -20004);

define('STATUS_NORMAL',  0);
define('STATUS_ENABLED', 1);
define('STATUS_DISABLED', 2);
define('STATUS_DELETED', -1);

define('GUEST_STATUS_AUDIT',   1);
define('GUEST_STATUS_ENABLED', 2);

define('ARTICLE_TYPE_NEWS',       'news');
define('ARTICLE_TYPE_DAILY_NEWS', 'daily-news');
define('ARTICLE_TYPE_KNOWLEDGE',  'knowledge');
define('ARTICLE_TYPE_CLASSES',    'classes');
define('ARTICLE_TYPE_HOMEWORK',   'homework');
define('ARTICLE_TYPE_WORKS',      'works');
define('ARTICLE_TYPE_RANKING',    'ranking');
define('ARTICLE_TYPE_AGENCY',     'agency');
define('ARTICLE_TYPE_TEACHERS',   'teachers');
define('ARTICLE_TYPE_CONTACTS',   'contacts');
define('ARTICLE_TYPE_SHOW',       'show');

define('IMAGE_TYPE_SHOW',   0);
define('IMAGE_TYPE_TITLE',  1);
define('IMAGE_TYPE_NEWS',   2);
define('IMAGE_TYPE_NEWS_PLUS', 3);

define('SUPER_ADMIN', 6);
define('ADMIN', 5);
define('AGENCY_ADMIN', 4);
define('TEACHER', 3);
define('PARENTS', 2);
define('STUDENT', 1);

define('REGISTER_ROLE_STUDENT', 0);
define('REGISTER_ROLE_FATHER',  1);
define('REGISTER_ROLE_MOTHER',  2);
define('REGISTER_ROLE_ADULT',   3);
