<?php
/**
*  Connection file to MySQL, using local and external server
*/
$n = -1;
// Define servers and settings for each connection
$n++;
$MySQL[$n]['domain']  = array('127.0.0.1', 'localhost'); // Possible domain
$MySQL[$n]['server']  = '127.0.0.1'; // MySQL Server
$MySQL[$n]['user']   = 'root'; // MySQL User
$MySQL[$n]['password']     = ''; // MySQL Password
$MySQL[$n]['db']     = 'my_db'; // Database
$MySQL[$n]['persis']    = false; // Persistent connection?
$n++;
$MySQL[$n]['domain']  = array('devleonardodutra.net', 'devleonardodutra.com.br');
$MySQL[$n]['server']  = '127.0.0.1'; // MySQL Server
$MySQL[$n]['user']   = 'my_user'; // MySQL User
$MySQL[$n]['password']     = 'my_password'; // MySQL Password
$MySQL[$n]['db']     = 'my_db'; // Database
$MySQL[$n]['persis']    = false; // Persistent connection?
// Decide which connection must use
foreach ($MySQL as $key=>$server) {
    if (!isset($_SERVER['HTTP_HOST'])) {
        $use = $key;
        break;
    } else {
        $found = false;
        foreach ($server['domain'] as $domain) {
            if (strpos($_SERVER['HTTP_HOST'], $domain) !== false) {
              $use = $key;
              $found = true;
              break;
            }
        }
        if ($found)
            break;
    }
}
// Decide the type of connection
$MySQL['connection'] = ($MySQL[$use]['persis']) ? 'mysql_pconnect' : 'mysql_connect';
// Connects to the server using the connection type set
$MySQL['link'] = $MySQL['connection']($MySQL[$use]['server'], $MySQL[$use]['user'], $MySQL[$use]['password']) or die("Could not connect to MySQL server address [".$MySQL[$use]['server']."]");
// Connects to database
mysql_select_db($MySQL[$use]['db'], $MySQL['link']) or die("Unable to connect to database [".$MySQL[$use]['db']."] on server [".$MySQL[$use]['server']."]");