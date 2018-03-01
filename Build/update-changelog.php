<?php

/*
 * Copyright (C) 2018
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

/**
 * Run the following command in shell:
 *
 * $ php Build/update-changelog.php x.y.z
 *
 * Then update the `CHANGELOG.md` file, do modifications if needed, then commit.
 */
class UpdateChangelog
{
    const CHANGELOG_FILE = 'CHANGELOG.md';

    const LOG_REVISION = '[%h](https://github.com/CuyZ/NotiZ/commit/%H)';
    const LOG_FORMAT_FULL = ' - **%s**%n%n   >*' . self::LOG_REVISION . ' by [%an](mailto:%ae) – %ad*%n%n%w(72, 3, 3)%b';
    const LOG_FORMAT_TINY = ' - [' . self::LOG_REVISION . '] **%s** – *by [%an](mailto:%ae) – %ad*%n';

    protected $version;
    protected $currentDate;
    protected $lastGitTag;

    /**
     * Must have the new version number as parameter.
     *
     * @param string $version
     */
    public function __construct($version)
    {
        $this->version = $version;

        // Format "02 Feb 2018"
        $this->currentDate = date('d M Y');

        // Fetches last tag that was added in git
        $this->lastGitTag = trim(shell_exec('git describe --tags --abbrev=0'));
    }

    /**
     * Will update the changelog file with the latest commits, ordered as
     * follow:
     *
     * - New features
     * - Bugs fixed
     * - Important/breaking changes
     * - Other less important commits
     */
    public function run()
    {
        $features = $this->getLog('FEATURE');
        $bugfix = $this->getLog('BUGFIX');
        $important = $this->getLog('!!!');
        $others = $this->getLogTiny();

        $currentChangelog = file_get_contents(self::CHANGELOG_FILE);

        $changelog = $this->getChangelog($features, $bugfix, $important, $others);
        $changelog = preg_replace('/\n/', "\n$changelog", $currentChangelog, 1);

        file_put_contents(self::CHANGELOG_FILE, $changelog);
    }

    /**
     * @param string $features
     * @param string $bugfix
     * @param string $important
     * @param string $others
     * @return string
     */
    protected function getChangelog($features, $bugfix, $important, $others)
    {
        $changelog = "
v$this->version - $this->currentDate
====================";

        if ($features) {
            $changelog .= "

New features
------------

$features";
        }

        if ($bugfix) {
            $changelog .= "
Bugs fixed
----------

$bugfix";
        }

        if ($important) {
            $changelog .= "
Important
---------

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:** 

$important";
        }

        if ($others) {
            $changelog .= "
Others
------

$others";
        }

        return $changelog;
    }

    /**
     * @param string $type
     * @return string
     */
    protected function getLog($type)
    {
        $script = "git log HEAD...$this->lastGitTag" .
            ' --grep="^\[' . $type . '\]"' .
            ' --date=format:"%d %b %Y"' .
            ' --pretty=tformat:"' . self::LOG_FORMAT_FULL . '"';

        return $this->replaceIssues(shell_exec($script));
    }

    /**
     * @return string
     */
    protected function getLogTiny()
    {
        $script = "git log HEAD...$this->lastGitTag" .
            ' --grep="^\[BUGFIX\\]" --grep="^\[FEATURE\\]" --grep="^\[!!!\\]"' .
            ' --invert-grep' .
            ' --date=format:"%d %b %Y"' .
            ' --pretty=tformat:"' . self::LOG_FORMAT_TINY . '"';

        return $this->replaceIssues(shell_exec($script));
    }

    /**
     * Adds a link to all detected GitHub issues number.
     *
     * @param string $text
     * @return string
     */
    protected function replaceIssues($text)
    {
        return preg_replace('/#([0-9]+)/', '[#$1](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/$1)', $text);
    }
}

unset($argv[0]);
(new UpdateChangelog(...$argv))->run();
