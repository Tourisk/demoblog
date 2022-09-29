<?php

namespace App\DataFixtures;

use App\Entity\Voiture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VoitureFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 15; $i++)
        {
            $voiture=new Voiture;

            $voiture   ->setMarque("Voiture n°$i")
                            ->setModele("<p>Contenu de l'article n°$i</p>")
                            ->setPrix(50000)
                            ->setDescription("voiture");
            $manager->persist($voiture);
        }
        $manager->flush(); //permet d'exetuter la requête SQL préparée grace à persist()
    }
}
