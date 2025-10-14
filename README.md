moodle-local_enrolkeycreator
============================

[![Moodle Plugin CI](https://github.com/ssystems-de/moodle-local_enrolkeycreator/actions/workflows/moodle-plugin-ci.yml/badge.svg?branch=main)](https://github.com/ssystems-de/moodle-local_enrolkeycreator/actions?query=workflow%3A%22Moodle+Plugin+CI%22+branch%3Amain)

Moodle plugin which will automatically generate and set an enrolment key when a new self-enrolment instance is created without preventing enrolment keys from being removed again.


Requirements
------------

This plugin requires Moodle 4.5+


Motivation for this plugin
--------------------------

Moodle core's self-enrolment method has the global `enrol_self | requirepassword` setting which automatically generates and sets an enrolment key when a new self-enrolment instance is created. However, this setting also prevents the enrolment key from being removed from the enrolment instance again. The result is that enrolment keys are not only auto-generated but also enforced in self-enroment instances.

If you just want to have enrolment keys set automatically – to avoid that teachers forget to set them themselves - but still want to allow that the teacher removes the enrolment key consciously to open his course to all users, this plugin is for you.


Installation
------------

Install the plugin like any other plugin to folder
/local/enrolkeycreator

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

After installing the plugin, it does not do anything to Moodle yet.

To configure the plugin and its behaviour, please visit:
Site administration -> Local plugins -> Automatic enrolment key creator

There, you find just one setting:

### Enable automatic enrollment key creation

When enabled, the plugin will automatically generate and set an enrolment key when a new self-enrolment instance is created.

Note: This setting has no effect if the aforementioned Moodle core setting "enrol_self | requirepassword" is enabled, as Moodle core will already handle password generation in that case and will also enforce the existence of an enrolment key in self-enrolment instances.


Capabilities
------------

This plugin does not add any additional capabilities.


Scheduled Tasks
---------------

This plugin does not add any additional scheduled tasks.


How this plugin works
---------------------

This plugin uses Moodle's event system to automatically generate enrolment keys for self-enrolment instances. It registers an event observer for the `\core\enrol\enrol_instance_created` event and whenever a new enrolment instance is created in any course, the plugin's observer method is triggered.

When the event is triggered, the plugin performs the following checks and actions:

1. **Plugin Status Check**: Verifies that the plugin is enabled in the admin settings
2. **Enrolment Type Filter**: Only processes self-enrolment instances (`enrol = 'self'`), ignoring all other enrolment methods
3. **Core Setting Compatibility**: Checks if Moodle's core `enrol_self/requirepassword` setting is enabled - if so, the plugin does nothing as core already handles password generation
4. **Existing Password Check**: Verifies that no enrolment key is already set for the instance
5. **Key Generation**: Uses Moodle's built-in `generate_password()` function to create a secure, random enrolment key
6. **Database Update**: Saves the generated key to the enrolment instance in the database

The plugin is designed to be non-intrusive:

- It never overwrites existing enrolment keys
- It respects Moodle core's own password requirements and generation
- It only activates when explicitly enabled by administrators
- Teachers can still manually remove or change the generated keys after creation

This approach ensures that self-enrolment instances automatically get security keys without forcing their permanent presence, giving educators the flexibility they need while providing automatic security by default.


Theme support
-------------

This plugin acts behind the scenes, therefore it should work with all Moodle themes.
This plugin is developed and tested on Moodle Core's Boost theme.
It should also work with Boost child themes, including Moodle Core's Classic theme. However, we can't support any other theme than Boost.


Plugin repositories
-------------------

This plugin is published and regularly updated in the Moodle plugins repository:
http://moodle.org/plugins/view/local_enrolkeycreator

The latest development version can be found on Github:
https://github.com/ssystems-de/moodle-local_enrolkeycreator


Bug and problem reports
-----------------------

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.

Please report bugs and problems on Github:
https://github.com/ssystems-de/moodle-local_enrolkeycreator/issues


Community feature proposals
---------------------------

The functionality of this plugin is primarily implemented for the needs of our clients and published as-is to the community. We are aware that members of the community will have other needs and would love to see them solved by this plugin.

Please issue feature proposals on Github:
https://github.com/ssystems-de/moodle-local_enrolkeycreator/issues

Please create pull requests on Github:
https://github.com/ssystems-de/moodle-local_enrolkeycreator/pulls


Paid support
------------

We are always interested to read about your issues and feature proposals or even get a pull request from you on Github. However, please note that our time for working on community Github issues is limited.

As solution provider, we also offer paid support for this plugin. If you are interested, please have a look at our services on [ssystems.de](https://www.ssystems.de/) or get in touch with us directly via vertrieb@ssystems.de.


Moodle release support
----------------------

This plugin is only maintained for the most recent major release of Moodle as well as the most recent LTS release of Moodle. Bugfixes are backported to the LTS release. However, new features and improvements are not necessarily backported to the LTS release.

Apart from these maintained releases, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major release - please let us know on Github.

If you are running a legacy version of Moodle, but want or need to run the latest version of this plugin, you can get the latest version of the plugin, remove the line starting with $plugin->requires from version.php and use this latest plugin version then on your legacy Moodle. However, please note that you will run this setup completely at your own risk. We can't support this approach in any way and there is an undeniable risk for erratic behavior.


Translating this plugin
-----------------------

This Moodle plugin is shipped with an english language pack only. All translations into other languages must be managed through AMOS (https://lang.moodle.org) by what they will become part of Moodle's official language pack.

As the plugin creator, we manage the translation into german for our own local needs on AMOS. Please contribute your translation into all other languages in AMOS where they will be reviewed by the official language pack maintainers for Moodle.


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


Maintainers
-----------

The plugin is maintained by\
ssystems GmbH


Copyright
---------

The copyright of this plugin is held by\
ssystems GmbH

Individual copyrights of individual developers are tracked in PHPDoc comments and Git commits.
