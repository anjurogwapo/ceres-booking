<?php
class LocationTracker
{
    public function getLocation()
    {
        $location = array();

        if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
            $location['latitude'] = $_POST['latitude'];
            $location['longitude'] = $_POST['longitude'];
        } else {
            $location['error'] = "Latitude and longitude not provided.";
        }

        return $location;
    }
}
