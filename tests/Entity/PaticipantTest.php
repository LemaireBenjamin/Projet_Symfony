<?php

namespace App\Tests\Entity;

use App\Entity\Activity;
use App\Entity\Participant;
use PHPUnit\Framework\TestCase;

class PaticipantTest extends TestCase
{
    public function testActivities()
    {
        $activity= new Activity();
        $art="Test";

        $activity->setName("$art");
        $this->assertEquals("Test",$activity->getName());
        //$activity->setName("sortie plage");
        //$this->assertEquals("sortie plage",$activity->getName());
    }

    public function testInscriptionAvantDateCloture()
    {
        $dateCloture = new \DateTime('+7 days'); // Date de clôture dans une semaine
        $sortie = new Activity($dateCloture);
        $participant = new Participant();

        $result = $sortie->addParticipant($participant);

        $this->assertTrue((bool)$result, "L'inscription devrait être réussie");
        $this->assertContains($participant, $sortie->getParticipants(), "Le participant devrait être ajouté à la liste des participants");
    }


}