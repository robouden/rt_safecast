=== Simple History ===
Contributors: eskapism
Donate link: http://eskapism.se/sida/donate/
Tags: history, log, changes, changelog, audit, trail, pages, attachments, users, dashboard, admin, syslog, feed, activity, stream, audit trail, brute-force
Requires at least: 4.5.1
Tested up to: 4.9
Requires PHP: 5.3
Stable tag: 2.19

View changes made by users within WordPress. See who created a page, uploaded an attachment or approved an comment, and more.

== Description ==

Simple History shows recent changes made within WordPress, directly on your dashboard or on a separate page.

The plugin works as a log/history/audit log/version history of the most important events that occur in WordPress.

Out of the box Simple History has support for:

* **Posts and pages**<br>
see who added, updated or deleted a post or page
* **Attachments**<br>
see who added, updated or deleted an attachment
* **Taxonomies (Custom taxonomies, categories, tags)**<br>
see who added, updated or deleted an taxonomy
* **Comments**<br>
see who edited, approved or removed a comment
* **Widgets**<br>
get info when someone adds, updates or removes a widget in a sidebar
* **Plugins**<br>
activation and deactivation
* **User profiles**<br>
info about added, updated or removed users
* **User logins**<br>
see when a user login & logout. Also see when a user fails to login (good way to catch brute-force login attempts).
* **Failed user logins**<br>
see when someone has tried to log in, but failed. The log will then include ip address of the possible hacker.
* **Menu edits**
* **Option screens**<br>
view details about changes made in the differnt settings sections of WordPress. Things like changes to the site title and the permalink structure will be logged.


#### Support for third party plugins

By default Simple History comes with built in support for the following plugins:

**User Switching**<br>
The [User Switching plugin](https://wordpress.org/plugins/user-switching/) allows you to quickly swap between user accounts in WordPress at the click of a button.
Simple History will log each user switch being made.

**Enable Media Replace**<br>
The [Enable Media Replace plugin](https://wordpress.org/plugins/enable-media-replace/) allows you to replace a file in your media library by uploading a new file in its place.
Simple history will log details about the file being replaced and details about the new file.

**Limit Login Attempts**<br>
The plugin [Limit Login Attempts](https://sv.wordpress.org/plugins/limit-login-attempts/) is old
and has not been updated for 4 years. However it still has +1 million installs, so many users will benefit from
Simple History logging login attempts, lockouts, and configuration changes made in the plugin Limit Login Attempts.

**Redirection**
The [redirection plugin](https://sv.wordpress.org/plugins/redirection/) manages url redirections, using a nice GUI.
Simple History will log redirects and groups that are created, changed, enabled or disabled and also when the global plugin settings have been modified.

**Duplicate Post**
The plugin [Duplicate Post](https://wordpress.org/plugins/duplicate-post/) allows users to
clone posts of any type.
Simple History will log when a clone of a post or page is done.

#### RSS feed available

There is also a **RSS feed of changes** available, so you can keep track of the changes made via your favorite RSS reader on your phone, on your iPad, or on your computer.

It???s a plugin that is good to have on websites where several people are
involved in editing the content.

The plugin works fine on [multisite installations of WordPress](http://codex.wordpress.org/Glossary#Multisite) too.

#### Example scenarios

Keep track of what other people are doing:
_"Has someone done anything today? Ah, Sarah uploaded
the new press release and created an article for it. Great! Now I don't have to do that."_

Or for debug purposes:
_"The site feels slow since yesterday. Has anyone done anything special? ... Ah, Steven activated 'naughy-plugin-x',
that must be it."_

#### See it in action

See the plugin in action with this short screencast:
[youtube http://www.youtube.com/watch?v=4cu4kooJBzs]

#### API so you can add your own events to Simple History

If you are a theme or plugin developer and would like to add your own things/events to Simple History you can do that by using the function `SimpleLogger()` like this:

`
<?php

if ( function_exists("SimpleLogger") ) {

		// Most basic example: just add some information to the log
		SimpleLogger()->info("This is a message sent to the log");

		// A bit more advanced: log events with different severities
		SimpleLogger()->info("User admin edited page 'About our company'");
		SimpleLogger()->warning("User 'Jessie' deleted user 'Kim'");
		SimpleLogger()->debug("Ok, cron job is running!");

}
?>
`

Check out the [examples-folder](https://github.com/bonny/WordPress-Simple-History/tree/master/examples) for more examples.

#### Translations/Languages

So far Simple History is translated to:

* Swedish
* German
* Polish
* Danish
* Dutch
* Finnish
* French
* Russian

I'm looking for translations of Simple History in more languages! If you want to translate Simple History
to your language then read about how this is done over at the [Polyglots handbook](https://make.wordpress.org/polyglots/handbook/rosetta/theme-plugin-directories/#translating-themes-plugins).

#### Contribute at GitHub

Development of this plugin takes place at GitHub. Please join in with feature requests, bug reports, or even pull requests!
https://github.com/bonny/WordPress-Simple-History

#### Donation & more plugins

* If you like this plugin don't forget to [donate to support further development](http://eskapism.se/sida/donate/).
* More [WordPress CMS plugins](https://profiles.wordpress.org/eskapism#content-plugins) by the same author.


== Screenshots ==

1. The log view + it also shows the filter function in use - the log only shows event that
are of type post and pages and media (i.e. images & other uploads), and only events
initiated by a specific user.

2. The __Post Quick Diff__ feature will make it quick and easy for a user of a site to see what updates other users have done to posts and pages.

3. When users are created or changed you can see details on what have changed.

4. Events have context with extra details - Each logged event can include useful rich formatted extra information. For example: a plugin install can contain author info and a the url to the plugin, and an uploaded image can contain a thumbnail of the image.

5. Click on the IP address of an entry to view the location of for example a failed login attempt.

6. See even more details about a logged event (by clicking on the date and time of the event).

7. A chart with some quick statistics is available, so you can see the number of events that has been logged each day.
A simple way to see any uncommon activity, for example an increased number of logins or similar.

==
 ==

## Changelog

= 2.19 (November 2017) =

- Add filter `simple_history/user_can_clear_log`. Return `false` from this filter to disable the "Clear blog" button.
- Remove static keyword from some methods in SimpleLogger, so now calls like `SimpleLogger()->critical('Doh!');` works.
- Don't show link to WordPress updates if user is not allowed to view the updates page.
- Fix notice error in SimpleOptionsLogger.
- Fix for fatal errors when using the lost password form in [Membership 2](https://wordpress.org/plugins/membership/). Fixes https://wordpress.org/support/topic/conflict-with-simple-history-plugin-and-php-7/.
- Code (a little bit) better formatted according to [WordPress coding standard](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards).

= 2.18 (August 2017) =

- Set from_term_description correctly, fixes https://github.com/bonny/WordPress-Simple-History/issues/127.
- Add filter `simple_history/post_logger/skip_posttypes`.
- Don't log post type `jetpack_migation` because for some users that post type filled the log. Fixes https://wordpress.org/support/topic/updated-jetpack_migration-sidebars_widgets/.

= 2.17 (June 2017) =

- Fix search date range inputs not showing correctly.
- Change the message for when a plugin is deactivated due to an error. Now the plugin slug is included, so you know exactly what plugin has been deactivated. Also the reason for the deactivation is included (one of "Invalid plugin path", "Plugin file does not exist", or "The plugin does not have a valid header.").
- Added more filters to log message. Now filter `simple_history_log_debug` exists, together with filters for all other 7 log levels. So you can use `simple_history_log_{loglevel}` where {loglevel} is any of emergency, alert, critical, error, warning, notice, info or debug.
- Add support for logging the changing of "locale" on a user profile, something that was added in WordPress 4.7.
- Add sidebar box with link to the settings page.
- Don't log when old posts are deleted from the trash during cron job wp_scheduled_delete.
- HHVM is not used for any tests any longer because PHP 7 and Travis not supporting it or something. I dunno. Something like that.
- When "development debug mode" is activated also log current filters.
- Show an admin warning if a logger slug is longer than 30 chars.
- Fix fatal error when calling log() method with null as context argument.

= 2.16 (May 2017) =

- Added [WP-CLI](https://wp-cli.org) command for Simple History. Now you can write `wp simple-history list` to see the latest entries from the history log. For now `list` is the only available command. Let me know if you need more commands!
- Added support for logging edits to theme files and plugin files. When a file is edited you will also get a quick diff on the changes,
so you can see what CSS styles a client changed or what PHP changes they made in a plugin file.
- Removed the edit file logger from the plugin logger, because it did not always work (checked wrong wp path). Intead the new Theme and plugins logger mentioned above will take care of this.

= 2.15 (May 2017) =

- Use thumbnail version of PDF preview instead of full size image.
- Remove Google Maps image when clicking IP address of failed login and similar, because Google Maps must be used with API key.
	Hostname, Network, City, Region and Country is still shown.
- Fix notice in available updates logger.
- Fix notice in redirection logger.

= 2.14.1 (April 2017) =

- Fix for users running on older PHP versions.

= 2.14 (April 2017) =

- Added support for plugin [Duplicate Post](https://wordpress.org/plugins/duplicate-post/).
	Now when a user clones a post or page you will se this in the history log, with links to both the original post and the new copy.
- Removed log level info from title in RSS feed
- Make date dropdown less "jumpy" when loading page (due to select element switching to Select2)
- Only add filters for plugin Limit Login Attempts if plugin is active. This fixes problem with Limit Login Attempts Reloaded and possibly other forks of the plugin.
- Debug page now displays installed plugins.

= 2.13 (November 2016) =

- Added filter `simple_history_log` that is a simplified way to add message to the log, without the need to check for the existance of Simple History or its SimpleLogger function. Use it like this: `apply_filters("simple_history_log", "This is a logged message");` See the [examples file](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php) for more examples.
- IP info now displays a popup with map + geolocation info for users using HTTPS again. Thanks to the great https://twitter.com/ipinfoio for letting all users use their service :)
- Fix notice warning for missing `$data_parent_row`

= 2.12 (September 2016) =

- You can show a different number of log items in the log on the dashboard and on the dedicated history page. By default the dashboard will show 5 items and the page will show 30.
- On multisites the user search filter now only search users in the current site.
- The statistics chart using Chart.js now uses the namespace window.Simple_History_Chart instead of window.Chart, decreasing the risk that two versions of the Chart.js library overwriting each others. Fixes https://wordpress.org/support/topic/comet-cache-breaks-simple-history/. (Note to future me: this was fixed by renaming the `window.chart` variable to `window.chart.Simple_history_chart` in the line `window.Chart = module.exports = Chart;`)
- If spam comments are logged they are now included in the log. Change made to make sql query shorter and easier. Should not actually show any spam comments anyway because we don't log them since version 2.5.5 anyway. If you want to revert this behavior for some reason you can use the filter `simple_history/comments_logger/include_spam`.

= 2.11 (September 2016) =

- Added support for plugin [Redirection](https://wordpress.org/plugins/redirection/).
	Redirects and groups that are created, changed, enabled and disabled will be logged. Also when the plugin global settings are changed that will be logged.
- Fix possible notice error from User logger.
- "View changelog" link now works on multisite.

= 2.10 (September 2016) =

- Available updates to plugins, themes, and WordPress itself is now logged.
	Pretty great if you subscribe to the RSS feed to get the changes on a site. No need to manually check the updates-page to see if there are any updates.
- Changed to logic used to determine if a post edit should be logged or not. Version 2.9 used a version that started to log a bit to much for some plugins. This should fix the problems with the Nextgen Gallery, All-In-One Events Calendar, and Membership 2 plugins. If you still have problems with a plugin that is causing to many events to be logged, please let me know!

= 2.9.1 (August 2016) =

- Fixed an issue where the logged time was off by some hours, due to timezone being manually set elsewhere.
	Should fix https://wordpress.org/support/topic/logged-time-off-by-2-hours and https://wordpress.org/support/topic/different-time-between-dashboard-and-logger.
- Fixed Nextgen Gallery and Nextgen Gallery Plus logging lots and lots of event when viewing posts with galleries. The posts was actually updated, so this plugin did nothing wrong. But it was indeed a bit annoying and most likely something you didn't want in your log. Fixes https://wordpress.org/support/topic/non-stop-logging-nextgen-gallery-items.

= 2.9 (August 2016) =

- Added custom date ranges to the dates filter. Just select "Custom date range..." in the dates dropdown and you can choose to see the log between any two exact dates.
- The values in the statistics graph can now be clicked and when clicked the log is filtered to only show logged events from that day. Very convenient if you have a larger number of events logged for one day and quickly want to find out what exactly was logged that day.
- Dates filter no longer accepts multi values. It was indeed a bit confusing that you could select both "Last 7 days" and "Last 3 days".
- Fix for empty previous plugin version (the `{plugin_prev_version}` placeholder) when updating plugins.
- Post and pages updates done in the WordPress apps for Ios and Android should be logged again.

= 2.8 (August 2016) =

- Theme installs are now logged
- ...and so are theme updates
- ...and theme deletions. Awesome!
- Support for plugin [Limit Login Attempts](https://wordpress.org/plugins/limit-login-attempts/).
	Failed login attempts, lockouts and configuration changes will be logged.
- Correct message is now used when a plugin update fails, i.e. the message for key `plugin_update_failed`.
- The original untranslated strings for plugin name and so on are stored when storing info for plugin installs and updates and similar.
- Default number of events to show is now 10 instead of 5.

= 2.7.5 (August 2016) =

- User logins using e-mail are now logged correctly. Previously the user would be logged in successfully but the log said that they failed.
- Security fix: only users with [`list_users`](https://codex.wordpress.org/Roles_and_Capabilities#list_users) capability can view the users filter and use the autocomplete api for users.
	Previously the autocomplete function could be used by all logged in users.
- Add labels to search filters. (I do really hate label-less forms so it's kinda very strange that this was not in place before.)
- Misc other internal fixes

= 2.7.4 (July 2016) =

- Log a warning message if a plugin gets disabled automatically by WordPress because of any of these errors: "Plugin file does not exist.", "Invalid plugin path.", "The plugin does not have a valid header."
- Fix warning error if `on_wp_login()` was called without second argument.
- Fix options diff not being shown correctly.
- Fix notice if no message key did exist for a log message.

= 2.7.3 (June 2016) =

- Removed the usage of the mb_* functions and mbstring is no longer a requirement.
- Added a new debug tab to the settings page. On the debug page you can see stuff like how large your database is and how many rows that are stored in the database. Also, a list of all loggers are listed there together with some useful (for developers anyway) information.

= 2.7.2 (June 2016) =

- Fixed message about mbstring required not being echo'ed.
- Fixed notice errors for users not allowed to view the log.

= 2.7.1 (June 2016) =

- Added: Add shortcut to history in Admin bar for current site and in Network Admin Bar for each site where plugin is installed. Can be disabled using filters `simple_history/add_admin_bar_menu_item` and `simple_history/add_admin_bar_network_menu_item`.
- Added: Add check that [??mbstring??](http://php.net/manual/en/book.mbstring.php) is enabled and show a warning if it's not.
- Changed: Changes to "Front Page Displays" in "Reading Settings" now show the name of the old and new page (before only id was logged).
- Changed: Changes to "Default Post Category" and "Default Mail Category" in "Writing Settings" now show the name of the old and new category (before only id was logged).
- Fixed: When changing "Front Page Displays" in "Reading Settings" the option "rewrite_rules" also got logged.
- Fixed: Changes in Permalink Settings were not logged correctly.
- Fixed: Actions done with [WP-CLI](https://wp-cli.org/) was not correctly attributed. Now the log should say "WP-CLI" intead of "Other" for actions done in WP CLI.

= 2.7 (May 2016) =

- Added: When a user is created or edited the log now shows what fields have changed and from what old value to what new value. A much requested feature!
- Fixed: If you edited your own profile the log would say that you edited "their profile". Now it says that you edited "your profile" instead.
- Changed: Post diffs could get very tall. Now they are max approx 8 rows by default, but if you hover the diff (or give it focus with your keyboard) you get a scrollbar and can scroll the contents. Fixes https://wordpress.org/support/topic/dashboard-max-length-of-content and https://wordpress.org/support/topic/feature-request-make-content-diff-report-expandable-and-closed-by-default.
- Fixed: Maybe fix a notice varning if a transient was missing a name or value.

= 2.6 (May 2016) =

- Added: A nice little graph in the sidebar that displays the number of logged events per day the last 28 days. Graph is powered by [Chart.js](http://www.chartjs.org/).
- Added: Function `get_num_events_last_n_days()`
- Added: Function `get_num_events_per_day_last_n_days()`
- Changed: Switched to transients from cache at some places, because more people will benefit from transients instead of cache (that requires object cache to be installed).
- Changed: New constant `SETTINGS_GENERAL_OPTION_GROUP`. Fixes https://wordpress.org/support/topic/constant-for-settings-option-group-name-option_group.
- Fixed: Long log messages with no spaces would get cut of. Now all the message is shown, but with one or several line breaks. Fixes https://github.com/bonny/WordPress-Simple-History/pull/112.
- Fixed: Some small CSS modification to make the page less "jumpy" while loading (for example setting a default height to the select2 input box).

= 2.5.5 (April 2016) =

- Changed: The logger for Enable Media Replace required the capability `edit_files` to view the logged events, but since this also made it impossible to view events if the constant `DISALLOW_FILE_EDIT` was true. Now Enable Media Replace requires the capability `upload_files` instead. Makes more sense. Fixes https://wordpress.org/support/topic/simple-history-and-disallow_file_edit.
- Changed: No longer log spam trackbacks or comments. Before this version these where logged, but not shown.
- Fixed: Translations was not loaded for Select2. Fixes https://wordpress.org/support/topic/found-a-string-thats-not-translatable-v-254.
- Fixed: LogQuery `date_to`-argument was using `date_from`.
- Changed: The changelog for 2015 and earlier are now moved to [CHANGELOG.md](https://github.com/bonny/WordPress-Simple-History/blob/master/CHANGELOG.md).

= 2.5.4 (March 2016) =

- Added: Support for new key in info array from logger: "name_via". Set this value in a logger and the string will be shown next to the date of the logged event. Useful when logging actions from third party plugins, or any kind of other logging that is not from WordPress core.
- Added: Method `getInfoValueByKey` added to the SimpleLogger class, for easier retrieval of values from the info array of a logger.
- Fixed: Themes could no be deleted. Fixes https://github.com/bonny/WordPress-Simple-History/issues/98 and https://wordpress.org/support/topic/deleting-theme-1.
- Fixed: Notice error when generating permalink for event.
- Fixed: Removed a `console.log()`.
- Changed: Check that array key is integer or string. Hopefully fixes https://wordpress.org/support/topic/error-in-wp-adminerror_log.

= 2.5.3 (February 2016) =

- Fixed: Old entries was not correctly removed. Fixes https://github.com/bonny/WordPress-Simple-History/issues/108.

= 2.5.2 (February 2016) =

- Added: The GUI log now updates the relative "fuzzy" timestamps in real time. This means that if you keep the log opened, the relative date for each event, for example "2 minutes ago" or "2 hours ago", will always be up to date (hah!). Keep the log opened for 5 minutes and you will see that the event that previously said "2 minutes ago" now says "7 minutes ago". Fixes https://github.com/bonny/WordPress-Simple-History/issues/88 and is implemented using the great [timeago jquery plugin](http://timeago.yarp.com/).
- Added: Filter `simple_history/user_logger/plain_text_output_use_you`. Works the same way as the `simple_history/header_initiator_use_you` filter, but for the rich text part when a user has edited their profile.
- Fixed: Logger slugs that contained for example backslashes (becuase they where namespaced) would not show up in the log. Now logger slugs are escaped. Fixes https://github.com/bonny/WordPress-Simple-History/issues/103.
- Changed: Actions and things that only is needed in admin area are now only called if `is_admin()`. Fixes https://github.com/bonny/WordPress-Simple-History/issues/105.

= 2.5.1 (February 2016) =

- Fixed: No longer assume that the ajaxurl don't already contains query params. Should fix problems with third party plugins like [WPML](https://wpml.org/).
- Fixed: Notice if context key did not exist. Should fix https://github.com/bonny/WordPress-Simple-History/issues/100.
- Fixed: Name and title on dashboard and settings page were not translateable. Fixes https://wordpress.org/support/topic/dashboard-max-length-of-content.
- Fixed: Typo when user resets password.
- Added: Filter `simple_history/row_header_date_output`.
- Added: Filter `simple_history/log/inserted`.
- Added: Filter `simple_history/row_header_date_output`.
