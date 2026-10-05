<?php

/**
 * Keep PHP exceptions and startup diagnostics in server logs in production.
 * CodeIgniter uses display_errors to decide whether to render its debug page.
 */
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');
