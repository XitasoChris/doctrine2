<?php
/**
 * Welcome to Doctrine 2.
 *
 * This is the index file of the sandbox. The first section of this file
 * demonstrates the bootstrapping and configuration procedure of Doctrine 2.
 * Below that section you can place your test code and experiment.
 */

namespace Sandbox;

use Entities\Address;
use Entities\User;

$em = require_once __DIR__ . '/bootstrap.php';

## PUT YOUR TEST CODE BELOW

$user = new User;

$date = \DateTime::createFromFormat("!Y-m-d", "2015-03-01");
$user->setLastLoggedIn($date);
$user->setName("user");

$em->persist($user);
$em->flush();

$builder = $em->createQueryBuilder()->select("u")->from("Entities\User", "u")->where("u.lastLoggedIn = :date")->setParameter("date", $date);

$result = $builder->getQuery()->getResult();

echo "Found " . count($result) . " users, should have found at least 1!\n";

echo "Check whether our condition matches for all (including not-found) users:\n";

$result = $em->createQuery("SELECT u FROM Entities\User u")->getResult();

foreach ($result as $user) {
    echo "user #" . $user->getId() . " matches our condition: " . ($user->getLastLoggedIn() == $date ? "Yes" : "No") . "\n";
}
