# Silverstripe Subsites: CMS on own domain

To prevent confusion for editors, let them edit the SiteTree only on the domain the page should be.

## Installation
Add custom repository to composer.json
```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/hamaka/silverstripe-subsite-switch-own-domain.git"
        }
    ],
```
And then install via composer:

```
composer require "hamaka/silverstripe-subsite-switch-own-domain"
```

## License
See [License](license.md)

## Maintainers
 * Bauke Zwaan <bauke@hamaka.nl>
