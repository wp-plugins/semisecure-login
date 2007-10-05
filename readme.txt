=== Semisecure Login ===
Contributors: slthytove
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=james%2em%2eallen%40gmail%2ecom&item_name=Semisecure%20Login%20Donation%20%2d%20Please%20feel%20free%20to%20donate%20any%20amount%2e%20Your%20contributions%20are%20appreciated%21&currency_code=USD&bn=PP%2dDonationsBF
Tags: admin, login, md5, hash, encryption, security, password
Requires at least: 2.1
Tested up to: 2.3
Stable tag: 1.0.3

Semisecure Login increases the security of the login process using client-side MD5 encryption on the password when a user logs in.

== Description ==

Semisecure Login increases the security of the login process using client-side MD5 encryption on the password when a user logs in. JavaScript is required to enable encryption. It is most useful for situations where SSL is not available, but the administrator wishes to have some additional security measures in place without sacrificing convenience.

== Installation ==

1. Upload the entire `semisecure-login/` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How does this work? =

A user attempts to log in via the login page. If JavaScript is enabled, the password along with a nonce is MD5-hashed, and the original (unencrypted) password is not sent. The server compares the received version with the expected version.

If JavaScript is not enabled, the password is sent in cleartext just like normal. This is inherently insecure over plaintext channels, but it is the default behavior of WordPress.

= How do I know this plugin is working? =

When the login form is displayed, the message "Semisecure Login is enabled" will appear underneath the Username and Password fields. If for some reason it isn't working (i.e., if JavaScript is not enabled, or you're running a browser that doesn't support certain necessary JavaScript functions), the message "Semisecure Login is not enabled! Please enable JavaScript and use a modern browser to ensure your password is encrypted.

= Is this really secure? =

Short answer: No, but it's better than nothing.

Without SSL, you're going to be susceptible to replay attacks/session hijacking no matter what. What this means is that if someone is able to guess or learn the session ID of a logged-in user (which would be trivial to do in an unprotected wireless network), then essentially they could do anything to your WordPress site by masquerading as that user.

= So what's the point? =

The point of this is to prevent your password from being transmitted in the "clear." If someone is in a position where they can learn your session ID, under normal circumstances, they'd also be able to learn your password. The proper use of this plugin removes that possibility.

= How can I make my site REALLY secure? =

Use SSL. This means you'll have to have a dedicated IP (which usually costs additional money) and an SSL certificate (which is expensive for a "real" one, but if you're just using this for your own administration purposes, a "self-signed" certificate would probably suffice). Any more detail on these two things is beyond the scope of this document.

== Changelog ==

= 1.0.3 =
* *Bug:* Fixed "headers already sent" warning when starting sessions.

= 1.0.2 =
* *Enhancement:* Added messages to the login window to indicate whether Semisecure Login is enabled and functional.
* Clarified documentation.

= 1.0.1 =
* *Enhancement:* Forced expiration of the login nonce after its one potential use. Previously, this could stick around and thus would be vulnerable to a replay attack if a session was hijacked.

= 1.0 =
* Initial Release