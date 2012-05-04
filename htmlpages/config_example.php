<?php
$config['pswin_username'] = '';
$config['pswin_password'] = '';
// Sender number is the number (or string) the service will pretend to be
$config['pswin_sendernumber'] = '2077';
// Service number is the actual number the service receives messages at
$config['pswin_servicenumber'] = '2077';
// Tariff is the cost pr. message
$config['pswin_tariff'] = 0; // øre

$config['keywords_enabled'] = false;
$config['keywords_default'] = 'STF';

// Most of these are SMS related. Avoid messages with a length higher than 160 characters, as that will cause the message to be sent over two SMS
$config['lang_no_invalidkeyword'] = 'Stavanger Turistforening har for øyeblikket ingen aktive quiz. Hvis du mener dette er feil kan du ta kontakt med Geir Olsen på telefon 97 15 73 32.';
$config['lang_no_noteamnamegiven'] = 'Du må angi et lagnavn for å lage et nytt lag, eller melde deg på et eksisterende.';
$config['lang_no_signedupforteam'] = 'Du er nå påmeldt laget "$teamname$"! Svar på flere spørsmål for å øke dine vinnersjanser.';
$config['lang_no_createdandsignedupforteam'] = 'Laget "$teamname$" er nå opprettet og du er påmeldt dette laget! Svar på flere spørsmål for å øke dine vinnersjanser.';
$config['lang_no_invalidansweralternativeprovided'] = 'Du må angi et gyldig svaralternativ!';
$config['lang_no_invalidquestionnumberoranswer'] = 'Du har oppgitt et ugyldig spørsmål- eller svaralternativ!';
$config['lang_no_registeredanswer'] = 'Ditt svar ($answer$) på spørsmål $questionnumber$ er registrert! Svar på flere spørsmål for å øke dine vinnersjanser.';
$config['lang_no_registeredanswerbutnoteam'] = 'Ditt svar ($answer$) på spm. $questionnumber$ er registrert. Du må være påmeldt et lag for å delta. For å melde deg på et lag eller opprette nytt, send STF lag <lagnavn> til '.$config['pswin_servicenumber'].'.';
$config['lang_no_unknownformat'] = 'For å melde deg på et lag, send STF lag <lagnavn> til '.$config['pswin_servicenumber'].'. For å svare på et spørsmål, send STF <spørsmålsnummer> <svaralternativ> til '.$config['pswin_servicenumber'].'.';