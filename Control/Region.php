<?php
namespace Control;

class Region {

    function get() {
        $Region = new \Modelos\Region();
        echo json_encode($Region->get());
    }

}
