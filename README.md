# WordPress LESS Editor

This plugin creates a simple GUI for editing LESS variables to overwrite the defaults.

## Dependencies

This plugin requires Advanced Custom Fields and is built on top of [lessphp](https://github.com/leafo/lessphp).

## Usage

Currently, the file in which to store custom values, the master LESS file, and the target CSS file are hardcoded in `admin/class.wpless_admin.inc.php` and in `frontend/class.wpless_admin.inc.php`.

In order to use, add the custom LESS file for inclusion below your variables in the master LESS file:

    @import "variables.less";
    @import "custom.less";

    // Styling rules go here...

Add custom fields to the ACF definitions in `admin/class.wpless_admin.inc.php` to overwrite more variables.
