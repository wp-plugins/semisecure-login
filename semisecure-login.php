<?php
/*
Plugin Name: Semisecure Login
Plugin URI: http://jamesmallen.net/2007/09/16/semisecure-login/
Description: Semisecure Login increases the security of the login process using client-side MD5 encryption on the password when a user logs in. JavaScript is required to enable encryption.
Version: 1.0.3
Author: James M. Allen
Author URI: http://jamesmallen.net/
*/

/*  Copyright 2007 James M. Allen (email : james.m.allen@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('login_head', array('SemisecureLogin', 'login_head'));
add_action('login_form', array('SemisecureLogin', 'login_form'));
add_action('wp_authenticate', array('SemisecureLogin', 'authenticate'), 1, 2);


if (! class_exists('SemisecureLogin')) {
	class SemisecureLogin {
		/*
		 * Plugin hooks
		 */
		
		/*
		 * Sets the nonce, includes JavaScript for preparing the login form
		 */
		function login_head() {
			@session_start();
			
			// always generate a new nonce
			$_SESSION['login_nonce'] = md5(rand());
			
			
			?>
		<script type="text/javascript" src="<?php echo get_option('siteurl');?>/wp-content/plugins/semisecure-login/md5.js"></script>
		<script type="text/javascript">
		function hashPwd() {
			var formLogin = document.getElementById('loginform');
			
			var userLog = document.getElementById('user_login');
			var userPwd = document.getElementById('user_pass');
			
			var password = userPwd.value;
			
			semisecureMessage.innerHTML = 'Encrypting password and logging in...';
			
			var userMD5Pwd = document.createElement('input');
			userMD5Pwd.setAttribute('type', 'hidden');
			userMD5Pwd.setAttribute('id', 'user_pass_md5');
			userMD5Pwd.setAttribute('name', 'pwd_md5');
			userMD5Pwd.value = hex_md5(hex_md5(password) + '<?php echo $_SESSION['login_nonce']?>');
			formLogin.appendChild(userMD5Pwd);
			
			userPwd.value = '';
			for (var i = 0; i < password.length; i++) {
				userPwd.value += '*';
			}
			
			return true;
		}
		</script>
		<?php
		}
		
		/*
		 * Applies event handlers to the form (DOM needs to be ready before this happens)
		 */
		function login_form() {
			?>
		<p id="semisecure-message">
				<span style="background-color: #ff0; color: #000;">Semisecure Login is not enabled!</span><br />
				Please enable JavaScript and use a modern browser to ensure your password is encrypted.
		</p>
		<script language="javascript" type="text/javascript">
			var formLogin = document.getElementById('loginform');
			formLogin.setAttribute('onsubmit', 'return hashPwd();');
			
			var semisecureMessage = document.getElementById('semisecure-message');
			semisecureMessage.setAttribute('class', '');
			semisecureMessage.innerHTML = 'Semisecure Login is enabled.';
		</script>
		<?php
		}
		
		
		/*
		 * Authenticates users if hashed password is sent.
		 * Does nothing if no hashed password was sent.
		 */
		function authenticate($username, $password) {
			global $using_cookie;
			
			// only do anything if pwd_md5 is set - otherwise degrade gracefully
			if (!empty($_POST['pwd_md5'])) {
				@session_start();
				
				$user = get_userdatabylogin($username);
				
				if ( ($user && $username == $user->user_login) &&
				     (md5($user->user_pass . $_SESSION['login_nonce']) == $_POST['pwd_md5']) ) {
					$password = md5($user->user_pass);
					$using_cookie = true;
					wp_setcookie($user->user_login, $password, $using_cookie);
				}
			}
			
			// expire the nonce
			$_SESSION['login_nonce'] = md5(rand());
			
			// degrades in the absence of JavaScript
		}
	}
}





?>