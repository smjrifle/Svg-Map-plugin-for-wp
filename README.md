=== Plugin Name ===
Contributors:
Donate link: https://smjrifle.net
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds the svg map with point animation

== Description ==

This plugin adds the svg map with points selection
//To Do: Color Selection | Customization Addition | Animation Enable Disable | Onhover Popup | Animation Size | Circle radius

== Installation ==

1. Upload `svg-map-by-saedi.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php echo do_shortcode( '[display_svg_map]') ?>` in your templates


***PHP LINTING:: WITH PHPCS & WPCS***

**Note: This composer.json file is to be saved in `wp-plugins/Svg-Map-plugin-for-wp` folder.

- Add `composer.json` file in your repo with following json.
- run `Composer update` to instantiate composer
- run `composer run-phpcs:plugin` to check standard check for all php files
- run `composer fix-phpcs:plugin` to automatically fix coding standard.

```
{
    "repositories": [{
      "type" : "package",
      "package" : {
        "name" : "wpcs",
        "version" : "0.11.0",
        "type" : "wpcs",
        "source" : {
          "url" : "git@github.com:WordPress-Coding-Standards/WordPress-Coding-Standards.git",
          "type" : "git",
          "reference" : "master"
        }
      }
    }],
    "require": {
        "wpcs":"*",
        "squizlabs/php_codesniffer": "2.9"
    },
    "extra": {
        "installer-paths": {
            "{$name}/" : ["type:wpcs"]
        }
    },
    "scripts" : {
      "post-install-cmd": [
        "@phpcs-configset"
      ],
      "post-update-cmd": [
        "@phpcs-configset"
      ],
      "phpcs-configset" : [
        "\"vendor/bin/phpcs\" --config-set installed_paths vendor/wpcs"
      ],
      "run-phpcs": [
        "@run-phpcs:plugin"
      ],
      "run-phpcs:plugin": [
        "\"vendor/bin/phpcs\" --standard=WordPress-Core --extensions=php -p -n -s --colors ."
      ],
      "fix-phpcs": [
        "@fix-phpcs:plugin"
      ],
      "fix-phpcs:plugin": [
        "\"vendor/bin/phpcbf\" --standard=WordPress-Core --extensions=php -n ."
      ]
    }
}
```
