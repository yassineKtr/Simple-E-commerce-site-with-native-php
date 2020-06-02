<?php

//to be included at the end of the php pages of the site 
    session_unset();
    session_destroy();
    header("location:?page=login");