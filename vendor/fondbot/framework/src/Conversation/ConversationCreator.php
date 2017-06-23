<?php

declare(strict_types=1);

namespace FondBot\Conversation;

use FondBot\Helpers\Str;
use League\Flysystem\MountManager;

class ConversationCreator
{
    private $filesystem;

    public function __construct(MountManager $manager)
    {
        $this->filesystem = $manager->getFilesystem('local');
    }

    /**
     * Create new intent.
     *
     * @param string $directory
     * @param string $namespace
     * @param string $name
     *
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FileExistsException
     */
    public function createIntent(string $directory, string $namespace, string $name): void
    {
        $contents = $this->filesystem->read('vendor/fondbot/framework/resources/stubs/Intent.stub');

        $className = $this->className($name, 'Intent');

        // Replace stub placeholders
        $this->replacePlaceholder($contents, 'namespace', $this->namespace($namespace, 'Intents'));
        $this->replacePlaceholder($contents, 'className', $className);
        $this->replacePlaceholder($contents, 'name', $this->formatName($name));

        $path = $directory.'/Intents/'.$this->filename($className);

        $this->filesystem->write($path, $contents);
    }

    /**
     * Create new interaction.
     *
     * @param string $directory
     * @param string $namespace
     * @param string $name
     *
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FileExistsException
     */
    public function createInteraction(string $directory, string $namespace, string $name): void
    {
        $contents = $this->filesystem->read('vendor/fondbot/framework/resources/stubs/Interaction.stub');

        $className = $this->className($name, 'Interaction');

        // Replace stub placeholders
        $this->replacePlaceholder($contents, 'namespace', $this->namespace($namespace, 'Interactions'));
        $this->replacePlaceholder($contents, 'className', $className);

        $path = $directory.'/Interactions/'.$this->filename($className);

        $this->filesystem->write($path, $contents);
    }

    /**
     * Replace placeholder.
     *
     * @param string $input
     * @param string $key
     * @param string $value
     */
    private function replacePlaceholder(string &$input, string $key, string $value): void
    {
        $key = mb_strtoupper($key);
        $input = str_replace('___'.$key.'___', $value, $input);
    }

    /**
     * Get filename.
     *
     * @param string $name
     *
     * @return string
     */
    private function filename(string $name): string
    {
        return $name.'.php';
    }

    /**
     * Get formatted name.
     *
     * @param string $name
     *
     * @return string
     */
    private function formatName(string $name): string
    {
        return mb_strtolower(trim($name));
    }

    /**
     * Get formatted namespace.
     *
     * @param string      $value
     *
     * @param string|null $postfix
     *
     * @return string
     */
    private function namespace(string $value, string $postfix = null): string
    {
        if (Str::endsWith($value, '\\')) {
            $value = mb_substr($value, 0, -1);
        }

        if ($postfix !== null) {
            $value .= '\\'.$postfix;
        }

        return $value;
    }

    /**
     * Get name of class.
     *
     * @param string $name
     * @param string $postfix
     *
     * @return string
     */
    private function className(string $name, string $postfix): string
    {
        $name = trim($name);
        if (!Str::endsWith($name, $postfix)) {
            $name .= $postfix;
        }

        return $name;
    }
}
