# Tables Field for Sprout Forms (Craft CMS 3)

Tables Field for Sprout Forms

![Screenshot](resources/img/plugin-logo.png)

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

       cd /path/to/project

2. Then tell Composer to load the plugin:

       composer require "mblode/sprout-forms-tables"

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Tables Field for Sprout Forms.

## Custom Notification Email

If you would like to output the table nicely in the notification email, you will have to create a custom `email.html` template. Here is my basic [custom email template](email.html) that more nicely formats the table values. For example you could add this file to `site-name/web/_emails/email.html`.

Once you have created the `email.html`, update the Sprout Forms notification's general settings to point the templates at your own template. Following the exmaple, you would set the template to `_emails`.

Lastly, update the "Tables field for Sprout Forms" plugin settings by changing the `JSON Decode Table Values` to true. If all goes well, you can test the notification by clicking on the eye icon under the Sprout Forms Notifications page in the Craft back-end.

-----

Brought to you by [Matthew Blode](https://matthewblode.com/)
