=== Semisecure Login ===
Contributors: slthytove
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=james%2em%2eallen%40gmail%2ecom&item_name=Semisecure%20Login%20Donation%20%2d%20Please%20feel%20free%20to%20donate%20any%20amount%2e%20Your%20contributions%20are%20appreciated%21&currency_code=USD&bn=PP%2dDonationsBF
Tags: admin, login, md5, hash, encryption, security, password
Requires at least: 2.1
Tested up to: 2.2
Stable tag: 1.0.1

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

= Is this really secure? =

It is not as secure as SSL, but it should prevent a large number of potential hijackings, as long as users are using modern browsers with JavaScript enabled. I obviously make no guarantees.

== Changelog ==

= 1.0.1 =
* *Enhancement:* Forced expiration of the login nonce after its one potential use. Previously, this could stick around and thus would be vulnerable to a replay attack if a session was hijacked.

= 1.0 =
* Initial Release