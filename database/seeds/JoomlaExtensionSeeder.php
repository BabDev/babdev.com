<?php

use BabDev\Models\JoomlaExtension;
use Illuminate\Database\Seeder;

class JoomlaExtensionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $podcastManager = new JoomlaExtension();
        $podcastManager->name = 'Podcast Manager';
        $podcastManager->logo = 'podcast-manager.svg';
        $podcastManager->description = '<p>Podcast Manager is a suite of extensions for Joomla! designed to allow users to manage and host podcast feeds from their Joomla! website.</p>';
        $podcastManager->supported = false;

        $podcastManager->save();

        $tweetDisplayBack = new JoomlaExtension();
        $tweetDisplayBack->name = 'Tweet Display Back';
        $tweetDisplayBack->logo = 'tweet-display-back.svg';
        $tweetDisplayBack->description = '<p>The Tweet Display Back module is a simple module that allows you to display either your Twitter feed or a Twitter list on your Joomla! website.  Though simple in nature, there are numerous display options to allow you to fully customize the module to your site.  Use the built in templates to quickly display your feed or customize your display using the unstyled template.</p>';
        $tweetDisplayBack->supported = false;

        $tweetDisplayBack->save();

        $yetAnotherSocialPlugin = new JoomlaExtension();
        $yetAnotherSocialPlugin->name = 'Yet Another Social Plugin';
        $yetAnotherSocialPlugin->logo = 'yet-another-social-plugin.svg';
        $yetAnotherSocialPlugin->description = '<p>Yet Another Social Plugin is a plugin for Joomla! to display a variety of social networking plugins.</p>';
        $yetAnotherSocialPlugin->supported = false;

        $yetAnotherSocialPlugin->save();
    }
}
