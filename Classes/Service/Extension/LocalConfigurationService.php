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

namespace CuyZ\Notiz\Service\Extension;

use CuyZ\Notiz\Backend\FormEngine\DataProvider\DefaultEventFromGet;
use CuyZ\Notiz\Backend\FormEngine\DataProvider\DefinitionError;
use CuyZ\Notiz\Backend\FormEngine\DataProvider\HideColumns;
use CuyZ\Notiz\Backend\ToolBarItems\NotificationsToolbarItem;
use CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder;
use CuyZ\Notiz\Core\Notification\TCA\Processor\GracefulProcessorRunner;
use CuyZ\Notiz\Core\Support\NotizConstants;
use CuyZ\Notiz\Domain\Definition\Builder\Component\DefaultDefinitionComponents;
use CuyZ\Notiz\Domain\Event\Blog\Processor\BlogNotificationProcessor;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\ExtensionConfigurationService;
use CuyZ\Notiz\Service\Hook\EventDefinitionRegisterer;
use CuyZ\Notiz\Service\Traits\SelfInstantiateTrait;
use Doctrine\Common\Annotations\AnnotationReader;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseEditRow;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRecordOverrideValues;
use TYPO3\CMS\Backend\Form\FormDataProvider\InitializeProcessedTca;
use TYPO3\CMS\Core\Cache\Backend\FileBackend;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use TYPO3\CMS\Core\Database\TableConfigurationPostProcessingHookInterface;
use TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Scheduler\Scheduler;

use function version_compare;

/**
 * This class replaces the old-school procedural way of handling configuration
 * in `ext_localconf.php` file.
 *
 * @internal
 */
class LocalConfigurationService implements SingletonInterface, TableConfigurationPostProcessingHookInterface
{
    use SelfInstantiateTrait;

    /**
     * @var IconRegistry
     */
    protected $iconRegistry;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var ExtensionConfigurationService
     */
    protected $extensionConfigurationService;

    /**
     * Manual dependency injection.
     */
    public function __construct()
    {
        $this->dispatcher = GeneralUtility::makeInstance(Dispatcher::class);
        $this->iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
    }

    /**
     * Main processing methods that will call every method of this class.
     */
    public function process()
    {
        $this->registerLaterProcessHook();
        $this->registerDefinitionComponents();
        $this->registerEventDefinitionHook();
        $this->registerInternalCache();
        $this->registerIcons();
        $this->registerNotificationProcessorRunner();
        $this->registerFormEngineComponents();
        $this->resetTypeConvertersArray();
        $this->overrideScheduler();
        $this->ignoreDoctrineAnnotation();
        $this->registerBlogNotificationProcessors();
    }

    /**
     * This is the second part of the process.
     *
     * Because the `ExtensionConfigurationService` needs the database to be
     * initialized (Extbase reflection service may need it), we need to hook
     * later in the TYPO3 bootstrap process to ensure everything has been
     * initialized.
     *
     * @see \CuyZ\Notiz\Service\Extension\LocalConfigurationService::registerLaterProcessHook
     */
    public function processData()
    {
        $this->extensionConfigurationService = Container::get(ExtensionConfigurationService::class);

        $this->registerToolBarItem();
    }

    /**
     * @see \CuyZ\Notiz\Service\Extension\LocalConfigurationService::processData
     */
    protected function registerLaterProcessHook()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] = static::class;
    }

    /**
     * Connects a slot on the definition components customization signal.
     */
    protected function registerDefinitionComponents()
    {
        $this->dispatcher->connect(
            DefinitionBuilder::class,
            DefinitionBuilder::COMPONENTS_SIGNAL,
            DefaultDefinitionComponents::class,
            'register'
        );
    }

    /**
     * Hooking in TYPO3 early process to register all hooks/signals added to the
     * event definition.
     */
    protected function registerEventDefinitionHook()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] = EventDefinitionRegisterer::class;
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc'][] = EventDefinitionRegisterer::class . '->processData';
    }

    /**
     * Internal cache used by the extension.
     */
    protected function registerInternalCache()
    {
        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][NotizConstants::CACHE_ID])) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][NotizConstants::CACHE_ID] = [
                'backend' => FileBackend::class,
                'frontend' => VariableFrontend::class,
                'groups' => ['all', 'system', 'pages'],
            ];
        }
    }

    /**
     * Registers icons that can then be used wherever in TYPO3 with the icon
     * API.
     */
    protected function registerIcons()
    {
        $iconsList = [
            SvgIconProvider::class => [
                'tx-notiz-icon' => ['source' => NotizConstants::EXTENSION_ICON_DEFAULT],
                'tx-notiz-icon-toolbar' => ['source' => NotizConstants::EXTENSION_ICON_PATH . 'notiz-icon-toolbar.svg'],
                'tx-notiz-icon-main-module' => ['source' => NotizConstants::EXTENSION_ICON_MAIN_MODULE_PATH],
            ],
            FontawesomeIconProvider::class => [
                'info-circle' => ['name' => 'info-circle'],
                'envelope' => ['name' => 'envelope'],
                'twitter' => ['name' => 'twitter'],
                'slack' => ['name' => 'slack'],
                'github' => ['name' => 'github'],
            ],
        ];

        foreach ($iconsList as $provider => $icons) {
            foreach ($icons as $name => $configuration) {
                $this->iconRegistry->registerIcon($name, $provider, $configuration);
            }
        }
    }

    /**
     * Registers the tool bar item shown on the header of the TYPO3 backend.
     */
    protected function registerToolBarItem()
    {
        $enableToolbar = $this->extensionConfigurationService->getConfigurationValue('toolbar.enable');

        if ($enableToolbar) {
            $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1505997677] = NotificationsToolbarItem::class;
        }
    }

    /**
     * Because of some core issue concerning the type converters registration,
     * we need to make sure the array containing the entries is valid.
     *
     * See the ticket below for more information:
     *
     * @link https://forge.typo3.org/issues/82651
     *
     * @deprecated Must be removed when TYPO3 v8 is not supported anymore.
     */
    protected function resetTypeConvertersArray()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['typeConverters'] = array_unique($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['typeConverters']);
    }

    /**
     * Registering a xClass that overrides core scheduler, to have access to
     * signals for when tasks are executed.
     *
     * @see \CuyZ\Notiz\Service\Scheduler\Scheduler
     */
    protected function overrideScheduler()
    {
        if (ExtensionManagementUtility::isLoaded('scheduler')) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][Scheduler::class] = ['className' => \CuyZ\Notiz\Service\Scheduler\Scheduler::class];
        }
    }

    /**
     * Registers the notification processor runner.
     *
     * @see \CuyZ\Notiz\Core\Notification\TCA\Processor\GracefulProcessorRunner
     */
    protected function registerNotificationProcessorRunner()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] = GracefulProcessorRunner::class;
    }

    /**
     * Registers components for TYPO3 form engine.
     */
    protected function registerFormEngineComponents()
    {
        /*
         * A new data provider is registered for the form engine.
         *
         * It will be used to select a default value for the field `event` of a
         * notification record, if an argument `selectedEvent` exists in the
         * request and matches a valid event identifier.
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][DefaultEventFromGet::class] = ['depends' => [DatabaseEditRow::class]];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][DatabaseRecordOverrideValues::class]['depends'][] = DefaultEventFromGet::class;

        /*
         * A data provider will be used to detect any definition error, in which
         * case an error message is shown to the user trying to create/edit an
         * entity notification.
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][DefinitionError::class] = [];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][InitializeProcessedTca::class]['depends'][] = DefinitionError::class;

        /*
         * A data provider is used to hide all columns when no event has been
         * selected for a notification entity.
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][HideColumns::class] = [];
    }

    /**
     * Some annotations are used by this extension and can be confusing for
     * Doctrine.
     */
    protected function ignoreDoctrineAnnotation()
    {
        if (class_exists(AnnotationReader::class)) {
            AnnotationReader::addGlobalIgnoredName('label');
            AnnotationReader::addGlobalIgnoredName('marker');
            AnnotationReader::addGlobalIgnoredName('email');
        }
    }

    /**
     * Registering a blog processor for each notification it provides.
     */
    protected function registerBlogNotificationProcessors()
    {
        if (ExtensionManagementUtility::isLoaded('blog')
            && version_compare(ExtensionManagementUtility::getExtensionVersion('blog'), '9.0.0', '>')
        ) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][CommentAddedNotification::class][] = BlogNotificationProcessor::class;
        }
    }
}
