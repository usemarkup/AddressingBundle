<?php

namespace Markup\AddressingBundle\Command;

use Markup\Addressing\Address;
use Markup\Addressing\Renderer\AddressRendererInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * A console command that allows entering an address in order to see how it will be formatted.
 */
class TestFormattingCommand extends Command
{
    protected static $defaultName = 'addressing:format:test';

    /**
     * @var AddressRendererInterface
     */
    private $addressRenderer;

    public function __construct(AddressRendererInterface $addressRenderer)
    {
        $this->addressRenderer = $addressRenderer;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Allows entering an address to see how it will be formatted.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');
        $ask = function (Question $question) use ($input, $output, $questionHelper) {
            return $questionHelper->ask($input, $output, $question);
        };

        $output->writeln('<info>This command takes address information and formats the resulting address.');

        $country = $ask(new Question('What is the two letter ISO3166 code for the country? (e.g. \'US\', \'GB\') '));

        $addressLines = [];
        $lineCount = 1;
        while ($lineCount <= 8) {
            $line = $ask(new Question(sprintf('Line %u of the address? (Press Return to complete entering address.) ', $lineCount)));
            if (!empty($line)) {
                $addressLines[] = $line;
            } else {
                break;
            }
            $lineCount++;
        }

        $locality = $ask(new Question('What is the town/ city of the address? '));

        $postalCode = $ask(new Question('What is the postal code of the address? (Press Return to leave blank.) '));

        $region = $ask(
            new Question(
                'What is the region (i.e. state, county or province) of the address? (Press Return to leave blank.) '
            )
        );

        $address = new Address(
            $country,
            $addressLines,
            $locality,
            $postalCode,
            $region ?: null
        );

        $renderedLines = explode(
            "\n",
            $this->addressRenderer->render($address, ['format' => 'plaintext'])
        );

        $output->writeln('<info>Formatted address:</info>');
        foreach ($renderedLines as $line) {
            $output->writeln($line);
        }
    }
}
