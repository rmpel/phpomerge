# PHPOMerge

### Installation

* clone repo
* symlink pomerge.sh to a location in your $PATH
* OR: add the repo path to your $PATH
* run `composer install` inside the repo path

### Usage

`pomerge.sh nl_NL.po nl_NL-new-translations-from-john.po nl_NL-new-translations-from-claire.po`

In effect; the first argument is the base PO file, all other files are merged in, using their translations, in order or appearance.
