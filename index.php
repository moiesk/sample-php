<?php
require __DIR__ . '/vendor/autoload.php';

use Cowsayphp\Farm;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

header('Content-Type: text/plain');

$output = '[%datetime%] %channel%.%level_name%: %message% %context% %extra%';
$formatter = new LineFormatter($output);

$log = new Logger("CowApp");
$streamhandler = new StreamHandler('php://stdout', Logger::WARNING);
$streamhandler->setFormatter($formatter);
$log->pushHandler($streamhandler);

$text = "Set a message by adding ?message=<message here> to the URL";
if(isset($_GET['message']) && $_GET['message'] != '') {
  $log->warning('User sent message');
  $text = $_GET['message'];
} else {
  $log->warning('No message provided');
}

$cow = Farm::create(\Cowsayphp\Farm\Cow::class);
echo $cow->say($text);
