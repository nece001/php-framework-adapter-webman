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
     * 处理命令（抽象方法，子类必须实现）
     *
     * @return void
     */
    abstract public function handle();

    /**
     * 获取命令行参数
     *
     * @param string $name
     * @return mixed
     */
    public function getArg($name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * 获取命令行选项
     *
     * @param string $name
     * @return mixed
     */
    public function getOpt($name)
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
    public function showAsk($question, $default = null)
    {
        $helper = $this->getHelper('question');
        $question = new Question($question, $default);
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * 确认用户操作
     *
     * @param string $question
     * @param bool $default
     * @return bool
     */
    public function showConfirm($question, $default = false)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion($question, $default);
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * 选择用户操作
     *
     * @param string $question
     * @param array $choices
     * @param mixed $default
     * @param int|null $attempts
     * @param bool $multiple
     * @return mixed
     */
    public function showChoice($question, array $choices, $default = null, $attempts = null, $multiple = false)
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion($question, $choices, $default);
        $question->setMaxAttempts($attempts);
        $question->setMultiselect($multiple);
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * 输出空行
     *
     * @param int $count
     * @return void
     */
    public function showLine($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->output->writeln('');
        }
    }

    /**
     * 输出信息消息
     *
     * @param string $message
     * @return void
     */
    public function showInfo($message)
    {
        $this->output->writeln('<info>' . $message . '</info>');
    }

    /**
     * 输出注释消息
     *
     * @param string $message
     * @return void
     */
    public function showComment($message)
    {
        $this->output->writeln('<comment>' . $message . '</comment>');
    }

    /**
     * 输出问题消息
     *
     * @param string $question
     * @return void
     */
    public function showQuestion($question)
    {
        $this->output->writeln('<question>' . $question . '</question>');
    }

    /**
     * 输出警告消息
     *
     * @param string $message
     * @return void
     */
    public function showWarn($message)
    {
        $this->output->writeln('<warning>' . $message . '</warning>');
    }

    /**
     * 输出错误消息
     *
     * @param string $message
     * @return void
     */
    public function showError($message)
    {
        $this->output->writeln('<error>' . $message . '</error>');
    }

    /**
     * 添加命令行参数
     *
     * @param string $name 参数名称
     * @param int|null $mode 参数模式（ARGUMENT_REQUIRED/ARGUMENT_OPTIONAL/ARGUMENT_IS_ARRAY）
     * @param string $description 参数描述
     * @param mixed $default 默认值
     * @param array $suggestedValues 输入补全的值
     * @return $this
     */
    public function addArg(string $name, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): self
    {
        $this->addArgument($name, $mode, $description, $default, $suggestedValues);
        return $this;
    }

    /**
     * 添加命令行选项
     *
     * @param string $name 选项名称
     * @param string|null $shortcut 快捷方式
     * @param int|null $mode 选项模式（OPTION_VALUE_NONE/OPTION_VALUE_REQUIRED等）
     * @param string $description 选项描述
     * @param mixed $default 默认值
     * @param array $suggestedValues 输入补全的值
     * @return $this
     */
    public function addOpt(string $name, ?string $shortcut = null, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): self
    {
        $this->addOption($name, $shortcut, $mode, $description, $default, $suggestedValues);
        return $this;
    }
}