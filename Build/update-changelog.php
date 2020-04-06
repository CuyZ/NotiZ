<?php

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

        // Format "02 February 2018"
        $this->currentDate = date('d F Y');

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
        $features = $this->getLogs('FEATURE');
        $bugfix = $this->getLogs('BUGFIX');
        $important = $this->getLogs('!!!');
        $others = $this->getInvertedLogs('FEATURE', 'BUGFIX', '!!!');

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
## v$this->version - $this->currentDate

> ℹ️ *Click on a changelog entry to see more details.*";

        if ($features) {
            $changelog .= "

### New features
$features";
        }

        if ($bugfix) {
            $changelog .= "
### Bugs fixed
$bugfix";
        }

        if ($important) {
            $changelog .= "
### Important

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:**
$important";
        }

        if ($others) {
            $changelog .= "
### Others
$others";
        }

        return $changelog;
    }

    /**
     * @param string[] $types
     * @return string
     */
    protected function getLogs(...$types)
    {
        $command = $this->getLogsCommand(...$types);

        return $this->formatLogs($command);
    }

    /**
     * @param string[] $types
     * @return string
     */
    protected function getInvertedLogs(...$types)
    {
        $command = $this->getLogsCommand(...$types);
        $command .= ' --invert-grep';

        return $this->formatLogs($command);
    }

    /**
     * @param string[] $types
     * @return string
     */
    protected function getLogsCommand(...$types)
    {
        $command = "git log HEAD...$this->lastGitTag" .
            ' --date=format:"%d %b %Y"';

        foreach ($types as $type) {
            $command .= ' --grep="^\[' . $type . '\]"';
        }

        return $command;
    }

    /**
     * @param $command
     * @return string
     */
    protected function formatLogs($command)
    {
        $title = $this->getGitLog($command, '%s');
        $revisionShort = $this->getGitLog($command, '%h');
        $revision = $this->getGitLog($command, '%H');
        $body = $this->getGitLog($command, '%b');
        $author = $this->getGitLog($command, '%an');
        $authorEmail = $this->getGitLog($command, '%ae');
        $date = $this->getGitLog($command, '%ad');

        $count = count($title);

        if ($count === 0) {
            return '';
        }

        $result = '';

        for ($i = 0; $i < count($title); $i++) {
            $detailedTitle = $this->replaceCodeSections($title[$i]);
            $pullRequest = null;

            $detailedBody = preg_replace('/\n/', "\n> ", $body[$i]);
            $detailedBody = $this->addLinkToGitHubIssues($detailedBody);

            // Add a link to detected GitHub issues number.
            if (preg_match('/#([0-9]+)/', $title[$i], $pullRequestResult)) {
                $detailedTitle = preg_replace('/ *\(#([0-9]+)\)/', '', $detailedTitle);
                $detailedTitle = preg_replace('/ *#([0-9]+)/', '', $detailedTitle);
                $pullRequest = ' / [#' . $pullRequestResult[1] . '](https://github.com/CuyZ/NotiZ/issues/' . $pullRequestResult[1] . ')';
            }

            $result .= <<<HTML

<details>
<summary>$detailedTitle</summary>

> *by [$author[$i]](mailto:$authorEmail[$i])* on *$date[$i] / [$revisionShort[$i]](https://github.com/CuyZ/NotiZ/commit/$revision[$i])$pullRequest*

> $detailedBody
</details>

HTML;
        }

        return $result;
    }

    /**
     * @param string $command
     * @param string $format
     * @return array
     */
    protected function getGitLog($command, $format)
    {
        $result = shell_exec($command . '  --pretty=tformat:"' . $format . '>>>NEXT<<<"');
        $result = explode('>>>NEXT<<<', $result);
        $result = array_map('trim', $result);
        array_pop($result);
        $result = array_map([$this, 'sanitizeLog'], $result);

        return $result;
    }

    /**
     * @param string $text
     * @return string
     */
    protected function sanitizeLog($text)
    {
        // Replace redundant line breaks.
        $text = preg_replace('/\n\n\n+/m', "\n\n", $text);

        // Removes the commit prefix.
        $text = preg_replace('/^\[!!!\](.*)$/', '$1', $text);
        $text = preg_replace('/^\[[^ \]]+\] (.*)$/', '$1', $text);

        return $text;
    }

    /**
     * Add a link to all detected GitHub issues number.
     *
     * @param string $text
     * @return string
     */
    protected function addLinkToGitHubIssues($text)
    {
        return preg_replace('/#([0-9]+)/', '[#$1](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/$1)', $text);
    }

    /**
     * @param string $text
     * @return string
     */
    protected function replaceCodeSections($text)
    {
        return preg_replace('/`([^`]*)`/', '<code>$1</code>', $text);
    }
}

unset($argv[0]);
(new UpdateChangelog(...$argv))->run();
