<?php


function eb_generate_ical(){
    /**
     * Get the event ID
     */
    $event_id = 2;
    /**
     * If no event ID or event_id is not an integer, do nothing
     */
    if ( !$event_id || !is_numeric( $event_id ) ) {
        die();
    }
    /**
     * Event information
     */
  //$event = get_event($event_id);
    $event = array(
        'event_name' => 'Test Event',
        'event_description' => 'This is a test event. This is the description.',
        'event_start' => time(),
        'event_end' => time() + 60*60*2,
        'event_venue' => array(
            'venue_name' => 'Test Venue',
            'venue_address' => '123 Test Drive',
            'venue_address_two' => 'Suite 555',
            'venue_city' => 'Some City',
            'venue_state' => 'Iowa',
            'venue_postal_code' => '12345'
        )
    );
    $name = $event['event_name'];
    $venue = $event['event_venue'];
    $location = $venue['venue_name'] . ', ' . $venue['venue_address'] . ', ' . $venue['venue_address_two'] . ', ' . $venue['venue_city'] . ', ' . $venue['venue_state'] . ' ' . $venue['venue_postal_code'];
    $start = date('Ymd', $event['event_start']+18000) . 'T' . date('His', $event['event_start']+18000) . 'Z';
    $end = date('Ymd', $event['event_end']+18000) . 'T' . date('His', $event['event_end']+18000) . 'Z';
    $description = $event['event_description'];
    $slug = strtolower(str_replace(array(' ', "'", '.'), array('_', '', ''), $name));
    header("Content-Type: text/Calendar; charset=utf-8");
    header("Content-Disposition: inline; filename={$slug}.ics");
    echo "BEGIN:VCALENDAR\n";
    echo "VERSION:2.0\n";
    echo "PRODID:-//LearnPHP.co//NONSGML {$name}//EN\n";
    echo "METHOD:REQUEST\n"; // requied by Outlook
    echo "BEGIN:VEVENT\n";
    echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-learnphp.co\n"; // required by Outlok
    echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
    echo "DTSTART:{$start}\n";
    echo "DTEND:{$end}\n";
    echo "LOCATION:{$location}\n";
    echo "SUMMARY:{$name}\n";
    echo "DESCRIPTION: {$description}\n";
    echo "END:VEVENT\n";
    echo "END:VCALENDAR\n";
}



class ICS {
    var $data;
    var $name;
    function ICS($start,$end,$name,$description,$location) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:".date("Ymd\THis\Z",strtotime($start))."\nDTEND:".date("Ymd\THis\Z",strtotime($end))."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:".$name."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
    }
    function save() {
        file_put_contents($this->name.".ics",$this->data);
    }
    function show() {
        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="'.$this->name.'.ics"');
        Header('Content-Length: '.strlen($this->data));
        Header('Connection: close');
        echo $this->data;
    }
}

// Output the ICS file to the browser

$event = new ICS("2009-11-06 09:00","2009-11-06 21:00","Test Event","This is an event made by Jamie Bicknell","GU1 1AA");
$event->show();

//Save the ICS file onto the server in the current working directory
$event = new ICS("2009-11-06 09:00","2009-11-06 21:00","Test Event","This is an event made by Jamie Bicknell","GU1 1AA");
$event->save();
