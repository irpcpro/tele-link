<?php

// database config
const DATABASE_HOST = 'localhost';
const DATABASE_PORT = '3306';
const DATABASE_USERNAME = 'root';
const DATABASE_NAME = 'telelink';
const DATABASE_PASSWORD = '';

// variables
define("SITE_URL", (stripos(($_SERVER['SERVER_PROTOCOL']?? ''),'https') === 0 ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . '/');
const LIMIT_LIST_SIZE = 10;
// TODO - generate automatically
const SITE_SECRET_KEY = 'base64:aQpMXQdp9ZzYAfR0OrKRfuBDY3NpwJT4zafxCSQJZOM=';
const TOKEN_EXPIRATION_TIME = 3600; // second - 1 hour
const LINK_SHORTENER_PREFIX = "r";
