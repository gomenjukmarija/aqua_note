<?php
namespace AppBundle\DataFixtures\ORM;
use AppBundle\Entity\Genus;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	/*
    	Столкнулась с ошибкой:
    	 [Symfony\Component\Debug\Exception\
    	 ClassNotFoundException]         
		  Attempted to load class "Fixtures" from namespace "Nelmio\Alice".  
		  Did you forget a "use" statement for another namespace?

		  Решение: composer require --dev nelmio/alice:2.1.4 
    	 */
        Fixtures::load(
        	__DIR__.'/fixtures.yml', 
        	$manager,
        	[
        		'providers' => [$this]
        	]
        );
    }

    public function genus()
    {
        $genera = [
            'Octopus',
            'Balaena',
            'Orcinus',
            'Hippocampus',
            'Asterias',
            'Amphiprion',
            'Carcharodon',
            'Aurelia',
            'Cucumaria',
            'Balistoides',
            'Paralithodes',
            'Chelonia',
            'Trichechus',
            'Eumetopias'
        ];

    	$key = array_rand($genera);

    	return $genera[$key];
    }

    public function family()
    {
        $family = [
            'qqqq',
            'wwwwww',
            'eeeeee',
            'rrrrrrrrr',
            'uuuuuuuuuu',
            'kkkkkkkkk',
            'llllllllll',
            'mmmmmmmmm'
        ];

        $key = array_rand($family);

        return $family[$key];
    }
}