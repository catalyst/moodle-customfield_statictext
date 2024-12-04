![GitHub Workflow Status (branch)](https://img.shields.io/github/actions/workflow/status/catalyst/moodle-customfield_statictext/ci.yml?branch=MOODLE_401_STABLE)

# Custom field "Static text"

Allows to configure a static text as a custom field. 

## Branches

| Moodle version | Branch |
|----------------|--------|
| Moodle 4.1+    | MOODLE_401_STABLE   |

# Installation

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration > Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/customfield/field/statictext

Afterwards, log in to your Moodle site as an admin and go to _Site administration > Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

# Warm thanks #

Thanks to **Monash University** (https://www.monash.edu) for funding the development of this plugin.

## License ##

2024 Catalyst IT

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.
