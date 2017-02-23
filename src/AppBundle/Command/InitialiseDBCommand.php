<?php
namespace AppBundle\Command;

use AppBundle\Entity\CharacterTrait;
use AppBundle\Entity\Event;
use AppBundle\Entity\Maid;
use AppBundle\Entity\Rank;
use AppBundle\Entity\Restaurant;
use AppBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Tests\A;

class InitialiseDBCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:initialise:db')
            ->setDescription('Allows tou to create a new Maid')
            ->setHelp("Give the parameters and let the app create a new Maid");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dropCommand = $this->getApplication()->find('doctrine:schema:drop');
        $createCommand = $this->getApplication()->find('doctrine:schema:create');
        $createUserCommand = $this->getApplication()->find('fos:user:create');
        $promoteUserCommand = $this->getApplication()->find('fos:user:promote');

        $dropArguments = array(
            'command' => 'doctrine:schema:drop',
            '--force'  => true,
        );
        $createArguments = array(
            'command' => 'doctrine:schema:create',
        );
        $userCreateArguments = array(
            'command' => 'fos:user:create',
            'username' => 'testUser',
            'email' => 'test@user.com',
            'password'=> 'testpass'
        );
        $userCreateArguments2 = array(
            'command' => 'fos:user:create',
            'username' => 'adminUser',
            'email' => 'admin@user.com',
            'password'=> 'adminpass'
        );
        $userPromoteArguments = array(
            'command' => 'fos:user:promote',
            'username' => 'adminUser',
            'role' => 'ROLE_ADMIN'
        );

        $dropInput = new ArrayInput($dropArguments);
        $createInput = new ArrayInput($createArguments);
        $createUserInput = new ArrayInput($userCreateArguments);
        $createUserInput2 = new ArrayInput($userCreateArguments2);
        $promoteUserInput = new ArrayInput($userPromoteArguments);

        $dropReturnCode = $dropCommand->run($dropInput, $output);
        $createReturnCode = $createCommand->run($createInput, $output);
        $userCreateReturnCode = $createUserCommand->run($createUserInput, $output);
        $userCreateReturnCode2 = $createUserCommand->run($createUserInput2, $output);
        $userPromoteArguments = $promoteUserCommand->run($promoteUserInput, $output);

        $restaurant = new Restaurant();
        $restaurant->setName('athome 1');
        $restaurant->setAddress('7765 rue de Osaka');
        $restaurant->setBirthDate(date_create_from_format('j-M-Y', '20-Jan-2010'));
        $restaurant->setDescription('Little restaurant just near your favorite neighborhood');
        $restaurant->setEmail('athome1@othome.com');
        $restaurant->setPhone('+8765670877');
        $restaurant->setProfilePicture('resto.jpg');

        $restaurant1 = new Restaurant();
        $restaurant1->setName('athome 2');
        $restaurant1->setAddress('7765 rue de Hanoi');
        $restaurant1->setBirthDate(date_create_from_format('j-M-Y', '1-Jan-2005'));
        $restaurant1->setDescription('Little restaurant near your favorite neighborhood');
        $restaurant1->setEmail('athome2@athome.com');
        $restaurant1->setPhone('+66789097542');
        $restaurant1->setProfilePicture('resto.jpg');

        $review = new Review();
        $review->setRate(5);
        $review->setComment('This was great !');
        $review->setRestaurant($restaurant);
//        $review->setUser(1);

        $review1 = new Review();
        $review1->setRate(1);
        $review1->setComment('This restaurant sucks !');
        $review1->setRestaurant($restaurant1);
//        $review1->setUser(2);

        $characterTrait = new CharacterTrait();
        $characterTrait->setName('Shy');

        $characterTrait1 = new CharacterTrait();
        $characterTrait1->setName('Joyful');

        $rank = new Rank();
        $rank->setName('Super Premium');
        $rank->setValue('1');

        $rank1 = new Rank();
        $rank1->setName('First Maid');
        $rank1->setValue('2');

        $maid = new Maid();
        $maid->setName('Saesenthessis');
        $maid->setLastName('Dragonborn');
        $maid->setAddress('88 abbey road, Vergen');
        $maid->setPhone('+333667887644');
        $maid->setEmail('saskia@dragonslayer.com');
        $maid->setBirthDate(date_create_from_format('j-M-Y', '12-Feb-1990'));
        $maid->setDescription('I hate everybody');
        $maid->setMaidName('Saskia');
        $maid->setBloodType('A+');
        $maid->setFavoriteThings('Dwarves mostly');
        $maid->setBlogUrl('www.sakia.com');
        $maid->setTwitterUrl('wwww.twitter.com/saskia');
        $maid->setProfilePicture('Chimu480.jpg');
        $maid->setRestaurant($restaurant);
        $maid->setCharacterTrait($characterTrait);
        $maid->setRank($rank);

        $maid1 = new Maid();
        $maid1->setName('Katy');
        $maid1->setLastName('MoshiMoshi');
        $maid1->setAddress('66 Kanto street, Kanto');
        $maid1->setPhone('+6789986532');
        $maid1->setEmail('katy@supermaid.com');
        $maid1->setBirthDate(date_create_from_format('j-M-Y', '15-Jan-1997'));
        $maid1->setDescription('I love cats and dogs and food');
        $maid1->setMaidName('KawaiiKAT');
        $maid1->setBloodType('AB');
        $maid1->setFavoriteThings('Cats, dogs, food');
        $maid1->setBlogUrl('wwww.kawaiikat.overblog');
        $maid1->setTwitterUrl('wwww.twitter.com/kawaiikat');
        $maid1->setProfilePicture('Chimu480.jpg');
        $maid1->setRestaurant($restaurant);
        $maid1->setCharacterTrait($characterTrait1);
        $maid1->setRank($rank1);

        $review2 = new Review();
        $review2->setRate(1);
        $review2->setComment('Shineeee !');
        $review2->setMaid($maid1);
//        $review2->setUser(1);

        $review3 = new Review();
        $review3->setRate(5);
        $review3->setComment('Daisuki desuuuu');
        $review3->setMaid($maid1);
//        $review3->setUser(2);

        $event = new Event();
        $event->setName('Miku Hastune Concert');
        $event->setDescription('Miku finally in your favorite Maid cafe !');
        $event->setStart(date_create_from_format('Y-m-d H:i:s', '2017-02-28 15:00:00'));
        $event->setEnd(date_create_from_format('Y-m-d H:i:s', '2017-02-28 18:00:00'));
        $event->setRestaurant($restaurant);
        $event->setProfilePicture('event.jpg');

        $event1 = new Event();
        $event1->setName('Miku Hastune Concert 2');
        $event1->setDescription('Miku comes again in your favorite Maid cafe !');
        $event1->setStart(date_create_from_format('Y-m-d H:i:s', '2017-03-28 15:00:00'));
        $event1->setEnd(date_create_from_format('Y-m-d H:i:s', '2017-03-28 18:00:00'));
        $event1->setRestaurant($restaurant);
        $event1->setProfilePicture('event.jpg');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->persist($restaurant);
        $em->persist($restaurant1);
        $em->persist($event);
        $em->persist($event1);
        $em->persist($review);
        $em->persist($review1);
        $em->persist($characterTrait);
        $em->persist($characterTrait1);
        $em->persist($rank);
        $em->persist($rank1);
        $em->persist($maid);
        $em->persist($maid1);
        $em->persist($review2);
        $em->persist($review3);
        $em->flush();

        $output->writeln('<info> Database successfully generated!</info>');
    }
}

