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

class Command extends SymfonyCommand implements ContractCommand
{
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
     * 处理命令
     *
     * @return void
     */
    public function handle(): void
    {
        // 子类实现
    }

    /**
     * 获取命令行参数
     *
     * @param string $name
     * @return mixed
     */
    public function argument(string $name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * 获取命令行选项
     *
     * @param string $name
     * @return mixed
     */
    public function option(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * 询问用户
     *
     * @param string $question
     * @param mixed $default
     * @return mixed
     */
    public function ask(string $question, $default = null)
    {
        $helper = $this->getHelper('question');
        $questionObj = new Question($question, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * 确认用户操作
     *
     * @param string $question
     * @param bool $default
     * @return bool
     */
    public function confirm(string $question, bool $default = false): bool
    {
        $helper = $this->getHelper('question');
        $questionObj = new ConfirmationQuestion($question, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * 选择用户操作
     *
     * @param string $question
     * @param array $choices
     * @param mixed $default
     * @return mixed
     */
    public function choice(string $question, array $choices, $default = null)
    {
        $helper = $this->getHelper('question');
        $questionObj = new ChoiceQuestion($question, $choices, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * 输出空行
     *
     * @param int $count
     * @return void
     */
    public function newLine(int $count = 1): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->output->writeln('');
        }
    }

    /**
     * 输出消息（带换行）
     *
     * @param string $message
     * @return void
     */
    public function writeln(string $message): void
    {
        $this->output->writeln($message);
    }

    /**
     * 输出消息（不带换行）
     *
     * @param string $message
     * @return void
     */
    public function write(string $message): void
    {
        $this->output->write($message);
    }

    /**
     * 输出信息消息
     *
     * @param string $message
     * @return void
     */
    public function info(string $message): void
    {
        $style = new OutputFormatterStyle('green');
        $this->output->getFormatter()->setStyle('info', $style);
        $this->output->writeln('<info>' . $message . '</info>');
    }

    /**
     * 输出注释消息
     *
     * @param string $message
     * @return void
     */
    public function comment(string $message): void
    {
        $style = new OutputFormatterStyle('blue');
        $this->output->getFormatter()->setStyle('comment', $style);
        $this->output->writeln('<comment>' . $message . '</comment>');
    }

    /**
     * 输出问题消息
     *
     * @param string $question
     * @return void
     */
    public function question(string $question): void
    {
        $style = new OutputFormatterStyle('cyan');
        $this->output->getFormatter()->setStyle('question', $style);
        $this->output->writeln('<question>' . $question . '</question>');
    }

    /**
     * 输出警告消息
     *
     * @param string $message
     * @return void
     */
    public function warn(string $message): void
    {
        $style = new OutputFormatterStyle('yellow');
        $this->output->getFormatter()->setStyle('warning', $style);
        $this->output->writeln('<warning>' . $message . '</warning>');
    }

    /**
     * 输出错误消息
     *
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        $style = new OutputFormatterStyle('red');
        $this->output->getFormatter()->setStyle('error', $style);
        $this->output->writeln('<error>' . $message . '</error>');
    }
}