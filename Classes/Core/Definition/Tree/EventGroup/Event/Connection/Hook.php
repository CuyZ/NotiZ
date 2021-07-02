<?php
declare(strict_types=1);

/*
 * Copyright (C)
 * Nathan Boiron <nathan.boiron@gmail.com>
 * Romain Canon <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 NotiZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection;

use Closure;
use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Event\Runner\EventRunner;
use CuyZ\Notiz\Core\Event\Runner\EventRunnerContainer;
use CuyZ\Notiz\Core\Exception\ClassNotFoundException;
use CuyZ\Notiz\Core\Exception\WrongFormatException;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class Hook extends AbstractDefinitionComponent implements Connection
{
    const INTERNAL_HOOK_KEY = '__notiz';

    /**
     * @var string
     *
     * @Extbase\Validate("NotEmpty")
     */
    protected $path;

    /**
     * @var string
     *
     * @Extbase\Validate("Romm\ConfigurationObject\Validation\Validator\ClassExistsValidator")
     */
    protected $interface;

    /**
     * @var string
     *
     * @Extbase\Validate("RegularExpression", options={"regularExpression": "/^[_a-zA-Z]+\w*$/"})
     */
    protected $method;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Registers the hook in TYPO3.
     *
     * Two registration methods exist. The first one is pretty clean, the other
     * probably already killed dozens of puppies.
     *
     * @param EventRunner $eventRunner
     */
    public function register(EventDefinition $definition)
    {
        if ($this->hookIsRegistered()) {
            return;
        }

        $eventRunner = GeneralUtility::makeInstance(EventRunner::class);

        if (!empty($this->interface)
            || !empty($this->method)
        ) {
            $closure = $this->preventEvalNeverIdealStuff($definition);
        } else {
            $closure = function () use ($eventRunner, $definition) {
                return call_user_func_array($eventRunner->getClosure($definition), func_get_args());
            };
        }

        $this->injectHookInGlobalArray($closure);
    }

    /**
     * @param Closure|string $closure
     */
    protected function injectHookInGlobalArray($closure)
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'] = ArrayUtility::setValueByPath(
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'],
            $this->getFullPath(),
            $closure,
            '|'
        );
    }

    /**
     * This method is called when a hook is bound to a class that must implement
     * an interface.
     *
     * In this case, to keep the handling we need to dynamically create some
     * proxy class that will call the internal API itself.
     *
     * If you don't want to lose your faith in humanity, you probably should not
     * read the code below. Really.
     *
     * @param EventRunner $eventRunner
     * @return string
     *
     * @throws ClassNotFoundException
     * @throws WrongFormatException
     */
    protected function preventEvalNeverIdealStuff(EventDefinition $definition): string
    {
        $className = 'notiz_hook_' . sha1($definition->getFullIdentifier());

        $implements = $this->interface
            ? 'implements ' . $this->interface
            : '';

        $method = $this->method ?: 'run';

        if ($this->interface
            && !interface_exists($this->interface)
        ) {
            throw ClassNotFoundException::eventHookInterfaceNotFound($this->interface, $this);
        }

        if (!preg_match('/^[_a-zA-Z]+\w*$/', $method)) {
            throw WrongFormatException::eventHookMethodNameWrongFormat($method, $this);
        }

        $classPhpCode = $this->anotherNonUsefulSystem($className, $implements, $method, $definition);

        // Please lord, forgive me.
        eval($classPhpCode);

        return $className;
    }

    /**
     * @see \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection\Hook::preventEvalNeverIdealStuff
     *
     * @param string $className
     * @param string $implements
     * @param string $method
     * @param EventRunner $eventRunner
     * @return string
     */
    protected function anotherNonUsefulSystem(string $className, string $implements, string $method, EventDefinition $eventDefinition): string
    {
        $eventRunnerContainerClass = EventRunnerContainer::class;

        return <<<PHP
class $className $implements
{
    public function $method(...\$arguments)
    {
        \$eventRunner = $eventRunnerContainerClass::getInstance()->get('{$eventDefinition->getFullIdentifier()}');

        call_user_func_array(\$eventRunner->getCallable(), \$arguments);
    }
}
PHP;
    }

    /**
     * @return bool
     */
    protected function hookIsRegistered(): bool
    {
        return ArrayUtility::isValidPath($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'], $this->getFullPath(), '|');
    }

    /**
     * @return string
     */
    protected function getFullPath(): string
    {
        return $this->path . '|' . self::INTERNAL_HOOK_KEY;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
