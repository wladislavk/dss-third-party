# Intro

This guide will cover installation for PHP Storm. I've included a link below for Netbeans.
I know its possible for Sublime Text but you'll have to figure that one out yourself - Brendan.

In general we follow [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) with the following exceptions:

- Opening braces are always on the next line (for functions and control statements)
- space prefix and suffix
- spaces on both sides of bang (e.g. `if ( ! $what)`)

### Tabs or Spaces:
4 spaces.

### Brackets:
Should be placed on a new line.

### Docblocks:
Full docblocks where appropriate, including function description, params and return

# PHP CodeSniffer
### Install PHP CodeSniffer
Install PHP CodeSniffer system-wide via composer: `composer global require 'squizlabs/php_codesniffer=*'`

### Add PHPCS to your system path
Add ~/.composer/vendor/bin/ to your system path. In Ubuntu this can be done by adding  `export PATH=$PATH:~/.composer/vendor/bin/` to your `~/.bashrc` file

### Validate install
Check that PHPCS is installed correctly by typing `phpcs -h` on the command line. You should get a list of all phpcs commands and options

### Install the custom code standards
Clone the custom standards anywhere on your system: `git clone git@github.com:themusicbed/CodeStandard.git`

For the rest of this example, I will assume that you have cloned to `/var/www/CodeStandard/`

### Usage
To check a single file: 
`phpcs /path/to/file.php --standard=/path/to/standard`

Example: 
`phpcs /var/www/tmb.dev/app/controllers/admin/AdminArtistsController.php --standard=/var/www/CodeStandard`

You can check a whole folder (recursively): 
`phpcs /var/www/tmb.dev/app/controllers/admin --standard=/var/www/CodeStandard` 

# Installating PHPCS in PHPStorm

#### Step 1
- Navigate to File -> Settings -> PHP -> CodeSniffer
- Insert the path to phpcs. If you installed via composer, then its something like /home/jon/.composer/vendor/bin/phpcs
- Click validate

#### Step 2
- Navigate to Inspections -> PHP -> PHP Code Sniffer validation
- In the "Coding Standard", choose "Custom" and then browse to the root of your CodeStandard folder (note, you must choose the folder itself). Example: `/var/www/CodeStandard`

#### Step 3: Optional
You can optionally choose how the warnings and errors from PHPCS are displayed in PHPStorm by changing the `Severity` and `Show warnings as..` options. This will depend on your own preferences and IDE editor appearance settings

# Getting PHPStorm to help you
There are a few settings in PHPStorm that can help you format your code (note that this is all based on v8 at the time of writing). Note that SublimeText has options/packages for all of these as well

### Convert Tabs to Spaces
Edit -> Convert Indents -> To Spaces

### Strip trailing spaces on save
Navigate to Settings -> Editor (or search for "trailing" in the settings)

- Enable "Strip trailing spaces on Save: All"
- Also enable "Ensure line feed at file send on Save"

### Automated file templates and docblocks
Navigate to Settings -> Editor -> File and Code Templates

#### Templates -> PHP Class
```
<?php #if (${NAMESPACE}) namespace ${NAMESPACE}; #end


class ${NAME}
{
}
```

#### PHP Includes -> PHP Field Doc Comment
```
/**
 * ${CARET}
 *
@var $${NAME}
 */
```

#### PHP Includes -> PHP Function Doc Comment
```
/**
 * ${CARET}
 *
${PARAM_DOC}
 * @return ${TYPE_HINT}
 */
```

# Integrating with Netbeans
http://subharanjan.com/integrate-php-codesniffer-netbeans-ide-steps/
