<?
// TODO: Move messages to seperate config file, or get a spec

require_once ('sms.php');
$smsReact = new smsReaction();

// TODO: Temporary input data until we know exactly what input we will receive
$smstext = 'stf 1 1';
$phonenumber = '12345678';

if (is_null( $phonenumber )) {
	echo 'Phone number missing';
	die();
}
if (is_null( $smstext )) {
	echo 'SMS text missing';
	die();
}

// Account for and remove any accidental double (or more) spaces in message
$smstext = preg_replace( '/\s{2,}/', ' ', $smstext );

// Split SMS message into array for easier handling
$smsparam = explode( ' ', $smstext, 3 );
if (count( $smsparam ) <= 1) {
	// TODO: Should we send message to sender about this?
	echo 'Too few parameters';
	die();
}
$keyword = $smsparam[0];

// Get the quiz id based on keyword
$quizid = $smsReact->getQuizIdByKeyword( $keyword );
if ($quizid < 0) {
	// TODO: Should we send message to sender about this?
	echo 'Invalid keyword.';
	die();
}

$teamid = $smsReact->getTeamIdByPhoneNumberAndQuizId( $phonenumber, $quizid );
// TeamId < 0	no member found
// TeamId == 0	member found, but not member of any team
// TeamId > 0	member found and member of team
if ($teamid < 0) {
	// Create quiz participant (team member with no team)
	$smsReact->createParticipant( $phonenumber, $quizid );
	$teamid = 0;
}

// Expected SMS text formats (we will act differently based on the format):
// -> Format: <keyword> lag <teamname> || <keyword> lagnavn <teamname>
if ($smsparam[1] == 'lag' || $smsparam[1] == 'lagnavn') {
	if (is_null( $smsparam[2] ) || empty( $smsparam[2] )) {
		$smsReact->sendMessage( 'Du m� angi et lagnavn!', $phonenumber );
		echo 'No team name given';
		die();
	}
	$teamname = $smsparam[2];
	
	$teamid = $smsReact->getTeamIdByTeamName( $teamname );
	// TeamId < 0	no team found with this name
	// TeamId > 0	team found
	if ($teamid < 0) {
		$teamid = $smsReact->createTeam( $teamname );
		$smsReact->sendMessage( 'Laget "' . $teamname . '" er n� opprettet!', $phonenumber );
	}
	// Associate phone number with team (connects all current answers by this phone number with team)
	$smsReact->addParticipantToTeam( $phonenumber, $quizid, $teamid );
	$smsReact->sendMessage( 'Du er n� p�meldt laget "' . $teamname . '"!', $phonenumber );
}
// -> Format: <keyword> <question number> <answer number>
else if (is_numeric( $smsparam[1] )) {
	if (is_null( $smsparam[2] ) || empty( $smsparam[2] ) || !is_numeric( $smsparam[2] )) {
		$smsReact->sendMessage( 'Du m� angi et svarnummer!', $phonenumber );
		echo 'No answer number provided';
		die();
	}
	$questionnumber = $smsparam[1];
	$answernumber = $smsparam[2];
	
	// Add answer to participant
	$smsReact->addAnswerToParticipant( $answernumber, $questionnumber, $phonenumber, $quizid );
	
	if ($teamid == 0) {
		// Team member not member of any team
		$smsReact->sendMessage( 'Ditt svar er registrert, men du er ikke p�meldt noe lag. For � melde deg p� et lag eller etablere nytt send SMS til...', $phonenumber );
	}
	else {
		// Team member of team
		$smsReact->sendMessage( 'Ditt svar er registrert!', $phonenumber );
	}
}
// Unknown format (unknown command)
else {
	echo 'Unknown format!';
	die();
}

?>