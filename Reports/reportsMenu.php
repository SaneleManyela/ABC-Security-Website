<?php
require_once(dirname(__DIR__)."/header.php");

echo <<<_MAIN
    <body>
        <div data-role='page'>
            <div data-role='header'>
                <div id='logo'><img id='secLogo' src='/ABCSecurity/logo.jpeg'>       
                    ABC Security Company</div>
                <div class='username'>$userstr</div>
            </div>
        <div data-role='content'>
_MAIN;

echo <<<_REPORTS
   <body>
   <div id='wrapper'>
        <div id='menu'>
            <ul>
                <li><a class="item" href="/ABCSecurity/index.php">Home</a></li>
                <li><a class="item" href="reports.php?report=staffReport">Staff Report</a></li>
                <li><a class="item" href="reports.php?report=complaintsReport">Complaints Report</a></li>
            </ul>
        </div>
    </div>
_REPORTS;
