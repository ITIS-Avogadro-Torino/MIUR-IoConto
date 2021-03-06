<?php
# Formazione MIUR content management system
# Copyright (C) 2017 ITIS Avogadro, Ivan Bertotto, Valerio Bozzolan
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published
# by the Free Software Foundation, either version 3 of the License,
# or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

require_once(SENDGRID_PATH);

class Email {
	static function send($to, $subject, $msg) {
		$from = new SendGrid\Email( _("FormazioneMiur.it") , ADMIN_EMAIL);
		$to   = new SendGrid\Email( _("Gentile utente")    , $to);
		$msg .= sprintf(
			"\n\n ".
			"_____________\n ".
			"FormazioneMiur\n ".
			"%s",
			URL
		);
		$msg = str_replace("\n", "\r\n", $msg);
		$content = new SendGrid\Content("text/plain", $msg);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$apiKey = getenv(SENDGRID_API_KEY);
		$sg = new \SendGrid($apiKey=SENDGRID_API_KEY);
		$response = $sg->client->mail()->send()->post($mail);
		DEBUG && var_dump($response);
	}
}
