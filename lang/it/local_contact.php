<?php
// This file is part of the Contact Form plugin for Moodle - http://moodle.org/
//
// Contact Form is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Contact Form is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Contact Form.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin for Moodle is used to send emails through a web form.
 *
 * @package    local_contact
 * @copyright  2016-2017 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @lang IT    Davide Mannarelli
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Contact Form';
$string['globalhelp'] = 'Contact Form è un plugin per Moodle che permette al tuo sito di processare le informazioni inviate tramite form HTML alla mail di supporto del sito stesso.';
$string['configure'] = 'Configura questo plugin';

$string['field-name'] = 'nome';
$string['field-email'] = 'email';
$string['field-subject'] = 'oggetto';
$string['field-message'] = 'messaggio';

$string['confirmationmessage'] = 'Grazie per averci contattato. Se necessario, risponderemo al più presto.';
$string['confirmationsent'] = 'Una email è stata inviata al tuo indirizzo presso {$a}.';
$string['forbidden'] = 'Non accessibile';
$string['errorsendingtitle'] = 'Invio email fallito';
$string['errorsending'] = 'È avvenuto un errore mentra il messaggio veniva inviato. si prega di riprovare più tardi.';

$string['defaultsubject'] = 'Nuovo messaggio';
$string['extrainfo'] = '<hr>
<p><strong>Informazioni utente addizionali</strong></p>
<ul>
    <li><strong>Utente del sito:</strong> [userstatus]</li>
    <li><strong>Lingua prefrita:</strong> [lang]</li>
    <li><strong>Da indirizzo IP:</strong> [userip]</li>
    <li><strong>Browser web:</strong> [http_user_agent]</li>
    <li><strong>Modulo web:</strong> <a href="[http_referer]">[http_referer]</a></li>
</ul>
';
$string['confirmationemail'] = '
<p>Caro [fromname],</p>
<p>Grazie per averci contattato. Se necessario, risponderemo al più presto.</p>
<p>A presto,</p>
<p>[supportname]<br>
[sitefullname]<br>
<a href="[siteurl]">[siteurl]</a></p>
';
$string['lockedout'] = 'BLOCCATO';
$string['notconfirmed'] = 'NON CONFERMATO';

$string['recipient_list'] = 'Lista di contatti disponibili';
$string['recipient_list_description'] = 'È possibile configurare un elenco di potenziali destinatari. Ognuno dei quali può essere utilizzato in un modulo di contatto: per specificare il destinatario di posta elettronica utilizzando un campo di testo nascosto o in un elenco a discesa selezionato; per consentire agli utenti di selezionare il destinatario senza divulgare  l'indirizzo email effettivo. Se l'elenco è vuoto, le email verranno inviate all'indirizzo di posta elettronica di Moodle (all'indirizzo email di supporto o all'amministratore principale di Moodle).
Ogni riga deve essere composta da un alias/etichetta di testo univoco, un indirizzo e-mail e un nome singolo, separati dal carattere 'pipe'. Per esempio:
<pre>
tech support|support@example.com|Joe Fixit
webmaster|admin@example.com|Mr. Moodle
electrical|nikola.tesla@example.com|Nikola
history|charles.darwin@example.com|Mr. Darwin
law|issac.newton@example.com|Isaac Newton
math|galileo.galilei@example.com|Galileo
english|mark.twain@example.com|Mark Twain
physics|albert.einstein@example.com|Albert
science|thomas.edison@example.com|Mr. Edison
philosophy|aristotle@example.com|Aristotle
</pre>';
