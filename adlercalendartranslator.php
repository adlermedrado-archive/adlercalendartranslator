<?php
/*
 Plugin Name: AdlerCalendarTranslator
 Plugin URI: http://github.com/adlermedrado/adlercalendartranslator
 Description: Convert the current date to hebrew calendar.
 Version: 0.1 beta
 Author: Adler Brediks Medrado
 Author URI: http://adlermedrado.com.br
 
 Copyright (c) 2009, Adler Brediks Medrado
 All rights reserved.

 Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    * Neither the name of the <ORGANIZATION> nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, 
	BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
	IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
	OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
	OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
	OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY 
	OF SUCH DAMAGE.
 */

/**
 * Returns the current date in gregorian and hebrew
 *
 * The $params array can receive the parameters as follows:
 * ['gregorianDate']   -> Timestamped Gregorian Date
 * ['hebrewCaracters'] -> Returns the date in hebrew caracters. The param must be a boolean (true or false)
 *
 * @param array $params
 * @return string
 */
function getDateJewishCalendar( array $params)
{

    $gregorianDate = date('d/m/Y', $params['gregorianDate']);
    list ($gregorianDay, $gregorianMonth, $gregorianYear) = explode('/', $gregorianDate);

    // Converting gregorian to julian date
    $julianDate = gregoriantojd($gregorianMonth, $gregorianDay, $gregorianYear);


    // Getting the Hebrew Month name
    $hebrewMonthName = jdmonthname($julianDate, 4);

    // Converting the date from Julian to Jewish.
    $jewishDate = jdtojewish($julianDate);

    list ($jewishMonth, $jewishDay, $jewishYear) = explode('/', $jewishDate);

    $jewishDateStr = "";
    $jewishDateStr = "{$gregorianDate}&nbsp; - &nbsp;";
    $jewishDateStr .= "{$jewishDay} {$hebrewMonthName} {$jewishYear}";

    if ($params['hebrewCaracters'] === true)
    {
        // Converting the date from Julian to Jewish, but in hebrew caracters
        $hebrewDate = jdtojewish($julianDate, true);
		
        /*
         * This plugin is UTF8 only and the jdtojewish function only return iso,
         * so we need to convert it with mb_string, mb_convert_encoding function.
         */
        $jewishDateStr .= "&nbsp; - &nbsp;".mb_convert_encoding(jdtojewish($julianDate, true), "UTF-8", "ISO-8859-8");
    }

    return $jewishDateStr;
}