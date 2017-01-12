![Master branch](https://codeship.com/projects/da0906d0-0f20-0134-9705-3a660a5bed18/status?branch=master) on Master branch

![Staging branch](https://codeship.com/projects/da0906d0-0f20-0134-9705-3a660a5bed18/status?branch=staging) on Staging branch

# AgriLife Extension Unit (WordPress Plugin)

Functionality for AgriLife Extension sites

## WordPress Requirements

1. [AgriFlex3 theme](https://github.com/agrilife/agriflex3)
2. [AgriLife Core plugin](https://github.com/agrilife/agrilife-core)
3. Advanced Custom Fields 5+ plugin (for Landing Page 1 Template)
4. Soliloquy Slider plugin (for Landing Page 1 Template)

## Installation

1. [Download the latest release](https://github.com/AgriLife/agrilife-extension-unit/releases/latest)
2. Upload the plugin to your site

## Features

* Required appearance and information for Extension Units
* Page Template
    * Landing Page 1: This page template provides a Soliloquy slider, a welcome text field, and a way to list the programs provided by your unit. It is typically used on the front page.
* Widget Areas
    * Footer Center: This is the footer widget area. It appears above the required links. This widget area works best with the Simple Social widget.
    * Home Sidebar: This is the Home sidebar widget area. It appears in the right column of the home page. This widget area works best with menus and Genesis Featured Posts.
* Page Layouts:

![Content Sidebar](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/cs.gif)
![Sidebar Content](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/sc.gif)
![Sidebar Content Sidebar](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/scs.gif)
![Content](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/c.gif)

## Development Installation

1. Copy this repo to the desired location.
2. In your terminal, navigate to the plugin location 'cd /path/to/the/plugin'
3. Run 'composer install' to set up the php modules

## Development Notes

1. Release tasks can only be used by the repository's owners

## Development Requirements

* Node: http://nodejs.org/
* NPM: https://npmjs.org/
