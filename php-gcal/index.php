<?php
require_once 'google-api-php-client/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secrets.json');
$client->setAccessType("offline");
$client->addScope(Google_Service_Calendar::CALENDAR);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']); // HL
  $cal_service = new Google_Service_Calendar($client);
  $list = $cal_service->calendars->get('xxxxxx')->getItems();
  echo json_encode($list);
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
