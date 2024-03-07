<?php

namespace App\Tests;

use Facebook\WebDriver\WebDriverBy;
use Zenstruck\Browser\PantherBrowser;

class AppBrowser extends PantherBrowser
{
    public function waitForPageLoad(): self
    {
        $this->client()->waitFor('html[aria-busy="true"]');
        $this->client()->waitFor('html:not([aria-busy])');

        return $this;
    }

    public function waitForDialog(): self
    {
        $this->client()->wait()->until(function() {
            return $this->crawler()->filter('dialog[open]')->count() > 0;
        });

        if ($this->crawler()->filter('dialog[open] turbo-frame')->count() > 0) {
            $this->waitForTurboFrameLoad();
        }

        return $this;
    }

    public function waitForTurboFrameLoad(): self
    {
        $this->client()->wait()->until(function() {
            return $this->crawler()->filter('turbo-frame[aria-busy="true"]')->count() === 0;
        });

        return $this;
    }
}
