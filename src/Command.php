<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Command as ContractCommand;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

abstract class Command extends SymfonyCommand implements ContractCommand
{
    /**
     * 默认命令名称
     *
     * @var string
     */
    protected static $defaultName = '';

    /**
     * 默认命令描述
     *
     * @var string
     */
    protected static $defaultDescription = '';

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * 执行命令
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $this->handle();
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function argument(string $name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * @inheritDoc
     */
    public function option(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * @inheritDoc
     */
    public function ask(string $question, $default = null)
    {
        $helper = $this->getHelper('question');
        $questionObj = new Question($question, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * @inheritDoc
     */
    public function confirm(string $question, bool $default = false): bool
    {
        $helper = $this->getHelper('question');
        $questionObj = new ConfirmationQuestion($question, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * @inheritDoc
     */
    public function choice(string $question, array $choices, $default = null)
    {
        $helper = $this->getHelper('question');
        $questionObj = new ChoiceQuestion($question, $choices, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * @inheritDoc
     */
    public function newLine(int $count = 1): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->output->writeln('');
        }
    }

    /**
     * @inheritDoc
     */
    public function writeln(string $message): void
    {
        $this->output->writeln($message);
    }

    /**
     * @inheritDoc
     */
    public function write(string $message): void
    {
        $this->output->write($message);
    }

    /**
     * @inheritDoc
     */
    public function info(string $message): void
    {
        $style = new OutputFormatterStyle('green');
        $this->output->getFormatter()->setStyle('info', $style);
        $this->output->writeln('<info>' . $message . '</info>');
    }

    /**
     * @inheritDoc
     */
    public function comment(string $message): void
    {
        $style = new OutputFormatterStyle('blue');
        $this->output->getFormatter()->setStyle('comment', $style);
        $this->output->writeln('<comment>' . $message . '</comment>');
    }

    /**
     * @inheritDoc
     */
    public function question(string $question): void
    {
        $style = new OutputFormatterStyle('cyan');
        $this->output->getFormatter()->setStyle('question', $style);
        $this->output->writeln('<question>' . $question . '</question>');
    }

    /**
     * @inheritDoc
     */
    public function warn(string $message): void
    {
        $style = new OutputFormatterStyle('yellow');
        $this->output->getFormatter()->setStyle('warning', $style);
        $this->output->writeln('<warning>' . $message . '</warning>');
    }

    /**
     * @inheritDoc
     */
    public function error(string $message): void
    {
        $style = new OutputFormatterStyle('red');
        $this->output->getFormatter()->setStyle('error', $style);
        $this->output->writeln('<error>' . $message . '</error>');
    }

    /**
     * @inheritDoc
     */
    public function addArgument(string $name, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): self
    {
        parent::addArgument($name, $mode, $description, $default, $suggestedValues);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addOption(string $name, ?string $shortcut = null, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): self
    {
        parent::addOption($name, $shortcut, $mode, $description, $default, $suggestedValues);
        return $this;
    }
}