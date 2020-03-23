<?php

namespace App\Command;

use App\Entity\Plateau;
use App\Entity\Rover;
use App\Service\RoverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class MarsExplorerCommand extends Command
{
    protected static $defaultName = 'app:explore-mars-plateau';

    private RoverManager $roverManager;

    /**
     * MarsExplorerCommand constructor.
     * @param RoverManager $roverManager
     */
    public function __construct(RoverManager $roverManager)
    {
        $this->roverManager = $roverManager;

        parent::__construct();
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($plateauWidth, $plateauHeight) = $this->askForPlateau($input, $output);

        $plateau = new Plateau($plateauWidth, $plateauHeight);

        $numberOfRovers = $this->askForNumberOfRovers($input, $output);

        while ($numberOfRovers) {
            list($xCoordinate, $yCoordinate, $direction) = $this->askForRover($input, $output);
            $rover = new Rover($xCoordinate, $yCoordinate, $direction);
            $plateau->addRover($rover);

            $commands = $this->askForCommands($input, $output);
            $this->executeCommandOnRover($rover, $commands);

            --$numberOfRovers;
        }

        foreach ($plateau->getRovers() as $rover) {
            $output->writeln(sprintf('%d %d %s', $rover->getXCoordinate(), $rover->getYCoordinate(), $rover->getDirection()));
        }

        return 0;
    }

    private function executeCommandOnRover(Rover $rover, array $commands)
    {
        foreach ($commands as $command) {
            $this->roverManager->moveByCommand($rover, $command);
        }
    }

    private function askForPlateau(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter the upper-right coordinates of the plateau (eg.: "5 5"): ');

        $question->setNormalizer(function ($value) {
            return explode(' ', $value);
        });

        $question->setValidator(function ($answer) {
            if (!is_array($answer) || count($answer) !== 2) {
                throw new \RuntimeException(
                    'Please make sure you provided the upper-right coordinates of the plateau in the right format!'
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        return $helper->ask($input, $output, $question);
    }

    private function askForNumberOfRovers(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter the number of rover that you want to place on the plateau: ', 2);

        $question->setNormalizer(function ($value) {
            return (int) $value;
        });

        $question->setMaxAttempts(2);

        return $helper->ask($input, $output, $question);
    }

    private function askForRover(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter the coordinates of the rover and it\'s direction (eg.: "1 2 N"): ');

        $question->setNormalizer(function ($value) {
            return explode(' ', $value);
        });

        $question->setValidator(function ($answer) {
            if (!is_array($answer) || count($answer) !== 3) {
                throw new \RuntimeException(
                    'Please make sure you provided the details of the rover in the right format!'
                );
            }

            $directions = Rover::getDirections();
            if (!in_array($answer[2], $directions)) {
                throw new \RuntimeException(
                    sprintf('Direction is incorrect! Please choose one of these directions: %s', implode(", ", $directions))
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        return $helper->ask($input, $output, $question);
    }

    private function askForCommands(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please provide commands to control the rover (eg.: "L M R M L M L M M"): ');

        $question->setNormalizer(function ($value) {
            return explode(' ', $value);
        });

        $question->setValidator(function ($answer) {
            if (!is_array($answer)) {
                throw new \RuntimeException(
                    'Please make sure you provided the commands in the right format!'
                );
            }

            $commands = Rover::getCommands();
            if (!in_array($answer[2], $commands)) {
                throw new \RuntimeException(
                    sprintf('Commands are incorrect! Please use only these commands: %s', implode(", ", $commands))
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        return $helper->ask($input, $output, $question);
    }
}