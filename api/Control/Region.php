<?php
namespace Control;

class Region {

    function get() {
        $Region = new \Modelos\Region();
        return json_encode($Region->get());
    }

}
