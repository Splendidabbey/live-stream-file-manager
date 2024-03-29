<?php
function convertToUserTimezone($liveOn, $userTimezone, $newUserTimezone) {
    if($userTimezone == $newUserTimezone) {
        // Create DateTime object for the original time in the user's timezone
        $userDateTime = new DateTime($liveOn, new DateTimeZone($userTimezone));

        // Convert the DateTime object to the new timezone
        // $userDateTime->setTimezone(new DateTimeZone($userTimezone));
    
        // Format the current time in the new timezone
        return $userDateTime->format('Y-m-d g:i:s A');
    } else {
        // Create DateTime object for the original time in the user's timezone
        $userDateTime = new DateTime($liveOn, new DateTimeZone($userTimezone));
    
        // Convert the DateTime object to the new timezone
        $userDateTime->setTimezone(new DateTimeZone($newUserTimezone));
    
        // Format the current time in the new timezone
        return $userDateTime->format('Y-m-d g:i:s A');
    }
}

function isLiveOn($liveOn, $userTimezone) {
    if(empty($liveOn) || empty($userTimezone)){
        return false;
    }
    // Create DateTime objects for the liveOn datetime and current time in the user's timezone
    $liveOnDateTime = new DateTime($liveOn, new DateTimeZone($userTimezone));
    $currentDateTime = new DateTime('now', new DateTimeZone($userTimezone));

    // Compare the DateTime objects to check if liveOn is in the past
    if($liveOnDateTime < $currentDateTime) {
        return true;
    } else {
        return false;
    }
}

function queryVideo($mysqli, $videoName) {
    $query = "SELECT * FROM scheduled_videos WHERE videoName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $videoName);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array(); // Initialize an array to store the query result

    while ($row = $result->fetch_assoc()) {
        // Append each row to the result array
        $rows[] = $row;
    }

    return $rows; // Return the array containing the query result
}

function hasBeenScheduled($mysqli, $videoName) {
    $query = "SELECT * FROM scheduled_videos WHERE videoName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $videoName);
    $stmt->execute();
    $result = $stmt->get_result();
    $output = $result->num_rows > 0 ? true : false;
    return $output;
}

function queryVideoById($mysqli, $id) {
    $query = "SELECT * FROM scheduled_videos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id); // Assuming $id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array(); // Initialize an array to store the query result

    while ($row = $result->fetch_assoc()) {
        // Append each row to the result array
        $rows[] = $row;
    }

    return $rows; // Return the array containing the query result
}

function queryVideoByIdAfterWatch($mysqli, $id) {
    $query = "SELECT * FROM after_watch WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id); // Assuming $id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array(); // Initialize an array to store the query result

    while ($row = $result->fetch_assoc()) {
        // Append each row to the result array
        $rows[] = $row;
    }

    return $rows; // Return the array containing the query result
}

function hasBeenScheduleBydId($mysqli, $id) {
    $query = "SELECT * FROM scheduled_videos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id); // Assuming $id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $output = $result->num_rows > 0 ? true : false;
    return $output;
}

function getVideoIdByName($mysqli, $videoName) {
    $query = "SELECT id FROM scheduled_videos WHERE videoName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $videoName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If a row is found, fetch the ID and return it
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        // If no matching video is found, return false or an error message
        return 0;
    }
}
