moodle-local_enrolkeycreator
============================

Changes
-------

### Unreleased

* 2026-10-24 - Cleanup: Remove unneeded includes from the event observer.
* 2026-10-24 - Improvement: Trigger the enrol_instance_updated event and update the modification time when the enrolment key is set.
* 2026-10-24 - Bugfix: Fix namespace of the privacy provider, so that the plugin's null provider is detected properly.

### v5.3-r1

* 2026-10-22 - Upgrade: Adopt changes from MDL-88580 and use new \core\authentication\password class.
* 2026-10-05 - Prepare compatibility for Moodle 5.3.

### v5.2-r1

* 2026-04-20 - Prepare compatibility for Moodle 5.2.

### v5.1-r1

* 2026-09-24 - Prepare compatibility for Moodle 5.1.

### v5.0-r1

* 2026-09-24 - Prepare compatibility for Moodle 5.0.

### v4.5-r3

* 2026-09-14 - Update CI integration.
               Please note: Due to this change, the Git history of the plugin has to be rewritten in Github. Existing Git tags will not be changed. If you deploy directly from Github, you should be aware of that one-time hickup.

### v4.5-r2

* 2025-10-14 - Release: Prepare codebase for release on moodle.org/plugins

### v4.5-r1

* 2025-05-22 - Initial release
