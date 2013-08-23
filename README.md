# Nudge

A simple [Markdown](http://daringfireball.net/projects/markdown/syntax)-powered blogging platform written in PHP using [Silex](http://silex.sensiolabs.org).

## Installation

Installation is fantastically easy!

    $ git clone https://github.com/mrkrstphr/nudge.git
    $ cd nudge
    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ mkdir -p data/articles data/pages

## Writing Pages

To create a new page, simply create a markdown (`blah.md`) file in the `data/pages` directory. To view it, navigate to `http://yoursite/page/blah`. Simple!

## Writing Articles

To create a new article, simply create a markdown (`2013-07-04-Happy-America-Day.md`) file in the `data/articles` directory. To view it, navigate to `http://yoursite/article/happy-america-day`. Simple!

## Modifying Your Layout

Edit the twig templates in `web/views`. Simple!

## Publishing Content

TODO: Use some kind of deployment tool, like PHP Grunt.
