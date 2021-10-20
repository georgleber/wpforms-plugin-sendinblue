# WPForms Plugin SendinBlue

**Contributors:** GeorgHenkel  
**Tags:** form, wpforms, sendinblue, email, marketing  
**Requires at least:** 5.8  
**Tested up to:** 5.8  
**Stable tag:** 1.0.1  
**License:** GPLv3 or later  
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html

Connect WPForms with SendinBlue API

## Description

"WPForms Plugin SendinBlue" connects your WPForms with your SendinBlue email marketing account API.

WPForms' simple drag-and-drop form builder allows you to create new forms with ease and its clean, modern code makes customizations a snap. This integration also works with the free version, [WPForms Lite](https://wordpress.org/plugins/wpforms-lite/), but I highly recommend purchasing the full WPForms for the valuable premium features and support.

If you are having issues with SendinBlue not receiving your submissions, you can enable logging and share that data with SendinBlue support. Go to WPForms > Tools > Logs, check "Enable logging", and enable it for "Providers". Once enabled, any form submission that is processed by this plugin will also store the SendinBlue API response in WPForms > Tools > Logs.

I recommend that you only enable logging for as long as necessary to debug your issue, then disable logging so you don't fill up the database with unnecessary logs.

## Installation

1. Install this plugin, along with WPForms (or [WPForms Lite](https://wordpress.org/plugins/wpforms-lite/)).
2. In the WordPress Dashboard, go to WPForms > Add New and create a form. You can add whatever fields you like, but at a minimum you must include an Email and Name field.
3. Click “Settings” in the left column, then select “SendinBlue”. From the two dropdowns "Name" and "Email Address", select the Name and Email fields you created.
4. With the “Sendinblue Redirect URL“ option, you can define a redirect URL of the web page that user will be redirected to after clicking on the double opt in URL.
5. With the “Sendinblue List IDs“ option, you can define the Lists the user will be added to. If you want to set more than one list ID, just add the ids comma separated.
6. With the “Sendinblue Template ID“ option, you can define the template, that will be used for the double opt in mail.
7. In a separate browser tab, go to SendinBlue, log in, and click [SMTP & API](https://account.sendinblue.com/advanced/api) in the right top corner in the dropdown menu under your account name. Create a new API Key, copy it, go back to the WPForms SendinBlue settings page, and paste it in the field titled “SendinBlue API Key”.
9. Click “Save” in the top right corner, and exit out of the form builder.
10. Insert the form somewhere on your site and test it out! Go to Pages, select a page, and above the content editor click “Add Form”. Select your form and click “Insert” to add it to the page.

## Changelog
See [CHANGELOG.md](https://github.com/GeorgHenkel/wpforms-plugin-sendinblue/blob/main/CHANGELOG.md)
